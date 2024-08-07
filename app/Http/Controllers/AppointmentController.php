<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Professional;
use App\Models\Patient;
use App\Models\Timetable;
use App\Models\Appointment;
use App\Models\BlockedAppointment;

use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentConfirmation;
use App\Mail\AppointmentCancel;

use Illuminate\Support\Facades\DB; 

use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function showCalendar()
    {
        $idUser = Session('UserId');
        
        $professional = Session('Professional_' . $idUser);
        $patient = Session('Patient_' . $idUser);

        $listPatients = [];

        if ($professional) {
            // Pacientes activos y pacientes sin cuenta
            $listPatients = Patient::where('Roles_idRol', 2) // Paciente
            ->where(function ($query) {
                $query->where('Estados_Pacientes_idEstado', 1) // Habilitado
                    ->whereHas('user', function ($query) {
                        $query->where('Email_verified', 1); // Email verificado
                    })
                    ->orWhere('Usuarios_idUsuario', 36); // Usuario sin cuenta
            })
            ->orderBy('idPaciente', 'desc') // Ordenar por ID descendente
            ->get();
        } else if ($patient) {
            $listPatients = null;
        } 

        return view('dashboards.calendar.calendar', compact('patient', 'professional', 'listPatients'));
    }

    public function getTimetables(Request $request) 
    {
        $date = $request->date;
    
        // Obtener los horarios disponibles para la fecha seleccionada
        $horariosDisponibles = Timetable::where('Fecha', $date)->orderBy('Hora')->get();
        
        if ($horariosDisponibles->isEmpty()) {
            $horariosDisponibles = Timetable::whereNull('Fecha')->orderBy('Hora')->get();
        } 

        // Array para almacenar los resultados
        $availableSlots = [];
        
        // Iterar sobre cada horario y verificar si existe un turno asociado en la fecha seleccionada
        foreach ($horariosDisponibles as $horario) {
            // Verificar si hay algún turno asociado con este horario para la fecha seleccionada
            $turnoAsociado = Appointment::where('Horarios_idHorario', $horario->idHorario)
            ->whereDate('Fecha', $date)
            ->with('patient')
            ->first();
            
            // Verificar si existen horarios bloqueados para esa fecha
            $horariosBloqueados = BlockedAppointment::whereDate('Fecha', $date)
            ->where('Hora', $horario->Hora)
            ->exists();

            $isBlocked = $horariosBloqueados; // Puede ser true o false
    
            // Si no hay un turno asociado, agregamos este horario como disponible
            if (!$turnoAsociado) {
                // Agregamos los datos del horario y también la fecha del turno si está disponible
                $availableSlots[] = [
                    'idTurno' => null,
                    'Fecha' => $date,
                    'Hora' => $horario->Hora,
                    'Franja_Horaria' => $horario->Franja_Horaria,
                    'Disponibilidad' => 'Disponible',
                    'idPaciente' => null,
                    'Paciente' => 'Sin asignar',
                    'Estado' => '-',
                    'isBlocked' => $isBlocked,
                ];
            } else {
                // Si hay un turno asociado, lo agregamos junto con su estado
                $availableSlots[] = [
                    'idTurno' => $turnoAsociado->idTurno,
                    'Fecha' => $date,
                    'Hora' => $horario->Hora,
                    'Franja_Horaria' => $horario->Franja_Horaria,
                    'Disponibilidad' => 'No disponible',
                    'idPaciente' => $turnoAsociado->Pacientes_idPaciente,
                    'Paciente' => $turnoAsociado->patient ? $turnoAsociado->patient->Nombre . ' ' . $turnoAsociado->patient->Apellido : 'Sin asignar',
                    'Estado' => $turnoAsociado->Estado_Turno == 1 ? 'Pendiente' : ($turnoAsociado->Estado_Turno == 2 ? 'No asistido' : ($turnoAsociado->Estado_Turno == 3 ? 'Asistido' : '-')),
                    'isBlocked' => $isBlocked,
                ];
            }
        }
        // Devolver la respuesta JSON con los horarios y el mensaje si existe
        return response()->json([
            'availableSlots' => $availableSlots,
        ], 200);
    }

    public function saveAppointment(Request $request)
    {
        $Fecha = $request->input('Fecha');
        $Hora = $request->input('Hora');
        $Pacientes_idPaciente = $request->input('Pacientes_idPaciente'); //57
        $Estado_Turno = 1; // Pendiente
        
        $Horarios_idHorarios = Timetable::where('Hora', $Hora)
        ->where('Fecha', $Fecha)
        ->value('idHorario');

        $patient = Patient::where('idPaciente', $Pacientes_idPaciente)->with('user')
        ->first();

        // Si no se encuentra un idHorario para la Fecha específica, buscar el horario predeterminado
        if (!$Horarios_idHorarios) {
            $Horarios_idHorarios = Timetable::where('Hora', $Hora)
                ->whereNull('Fecha') // Buscar horarios predeterminados sin Fecha asignada
                ->value('idHorario');
            
            // Si aún así no se encuentra ningún horario, devolver un error
            if (!$Horarios_idHorarios) {
                return response()->json(['error' => 'No se encontró ningún horario para la hora proporcionada'], 404);
            }
        }

        // Verificar si el paciente ya tiene un turno reservado para el día dado
        $existeTurno = Appointment::where('Fecha', $Fecha)
        ->where('Pacientes_idPaciente', $Pacientes_idPaciente)
        ->where('Estado_Turno', '=', 1)
        ->exists();

        if ($existeTurno) {
            // Si ya tiene un turno reservado
            return response()->json(['error' => 'Ya has reservado un turno para este día'], 400);
        } else {
            // Si no tiene un turno reservado, permite que reserve el turno
            $turno = Appointment::create([
                'Fecha' => $Fecha,
                'Estado_Turno' => $Estado_Turno,
                'Pacientes_idPaciente' => $Pacientes_idPaciente,
                'Horarios_idHorario' => $Horarios_idHorarios
            ]);

            // Enviar correo electrónico de confirmación al paciente
            Mail::to($patient->user->Email)->send(new AppointmentConfirmation($patient, $Fecha, $Hora));
        }
    }

    public function cancelAppointment(Request $request)
    {
        $turnoId = $request->input('turnoId'); // Obtener el ID del turno a cancelar desde la solicitud

        $turno = Appointment::with('timetable')->find($turnoId);

        if (!$turno) {
            return response()->json(['error' => 'El turno no existe'], 404);
        } else if ($turno) {
            $patient = Patient::with('user')->find($turno->Pacientes_idPaciente);

            if (!$patient) {
                return response()->json(['error' => 'El paciente no existe'], 404);
            }

            $date = $turno->Fecha;
            $time = $turno->timetable->Hora;

            $turno->delete();

            // Enviar correo electrónico de cancelación al paciente
            Mail::to($patient->user->Email)->send(new AppointmentCancel($patient, $date, $time));

            return response()->json(['message' => 'El turno ha sido cancelado exitosamente'], 200);
        }
    }

    public function unblockAppointment(Request $request) 
    {
        $fecha = $request->input('Fecha');

        $blockedDate = BlockedAppointment::where('Fecha', $fecha)->get();

        if ($blockedDate->isNotEmpty()) {
            BlockedAppointment::where('Fecha', $fecha)->delete();
            return response()->json(['message' => 'Turnos desbloqueados correctamente'], 200);
        } else {
            return response()->json(['message' => 'La fecha no se encontró en la base de datos'], 404);
        }
    }

    public function blockTime(Request $request)
    {
        $data = $request->json()->all();
        $blocked = 0; // Contador para los turnos bloqueados

        foreach ($data as $turno) {
            $exists = BlockedAppointment::where('Fecha', $turno['Fecha'])
            ->where('Hora', $turno['Hora'])
            ->exists();

            if ($exists) { // Si el turno ya existe, salta a la siguiente iteración del bucle
                continue;
            } else {
                $newAppointmentBlocked = new BlockedAppointment(); // Se crea una nueva instancia del modelo `BlockedAppointment`, que representa un registro en la base de datos. 

                $newAppointmentBlocked->Fecha = $turno['Fecha'];
                $newAppointmentBlocked->Hora = $turno['Hora'];
                $newAppointmentBlocked->save();

                $blocked++;
            }
        }

        if ($blocked > 0) {
            return response()->json([
                'message' => 'Turnos bloqueados correctamente',
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se bloquearon nuevos turnos',
            ], 200);
        }
    }

    public function appointments()
    {
        $idUser = Session('UserId');
        $professional = Session('Professional_' . $idUser);
        $patient = Session('Patient_' . $idUser);

        // Construir la consulta base
        $query = DB::table('turnos')
            ->select(
                'pacientes.Usuarios_idUsuario',
                'pacientes.Nombre',
                'pacientes.Apellido',
                'turnos.Fecha',
                'horarios.Hora',
                'Franja_Horaria',
                'turnos.Estado_Turno'
            )
            ->join('horarios', 'horarios.idHorario', '=', 'turnos.Horarios_idHorario')
            ->join('pacientes', 'pacientes.idPaciente', '=', 'turnos.Pacientes_idPaciente');

        if ($professional) {
            // Si es un profesional, obtener todos los turnos registrados de los pacientes
            $appointments = $query->orderBy('turnos.Fecha', 'desc')->get();
        } else if ($patient) {
            // Si es un paciente, obtener solamente sus propios turnos
            $appointments = $query
                ->where('pacientes.Usuarios_idUsuario', '=', $idUser)
                ->orderBy('turnos.Fecha', 'desc')
                ->get();
        } else {
            // Manejar el caso donde no se detecta si es profesional o paciente
            return response()->json(['error' => 'No se puede determinar si es profesional o paciente'], 400);
        }

        // Formatear la fecha usando Carbon
        $appointments = $appointments->map(function ($appointment) {
            // $appointment->Fecha = Carbon::parse($appointment->Fecha)->format('d/m/Y');
            $appointment->Estado_Turno = $this->mapearEstado($appointment->Estado_Turno);
            return $appointment;
        });
        
        // Pasar los datos a la vista
        return view('dashboards.history.historyAppointments', [
            'appointments' => $appointments,
            'professional' => $professional
        ]);
    }

    private function mapearEstado($estado)
    {
        switch ($estado) {
            case 1:
                return 'Pendiente';
            case 2:
                return 'No asistido';
            case 3:
                return 'Asistido';
            default:
                return 'Desconocido';
        }
    }
}

