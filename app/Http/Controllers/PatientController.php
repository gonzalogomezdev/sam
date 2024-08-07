<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\User;
use App\Models\SocialWork;

use Illuminate\Support\Facades\Mail;
use App\Mail\ApproveUser;
use App\Mail\RejectUser;

class PatientController extends Controller
{
    public function showRequests()
	{
    	$patients = Patient::where('Roles_idRol', 1) // Solicitante
        ->where('Estados_Pacientes_idEstado', 2) // No habilitado
        ->whereHas('user', function ($query) {
            $query->where('Email_verified', 1); // Email verificado
        })
        ->get();

        return view('dashboards.patients.requests', compact('patients'));
	}

	public function approveUserRequest(Request $request)
	{
		$idPatient = $request->input('id');

		$patient = Patient::with('user')->find($idPatient); //Busca al paciente con ese id

		if ($patient) {
			$patient->Roles_idRol = 2; // Paciente
			$patient->Estados_Pacientes_idEstado = 1; // Habilitado
			
			$patient->save();

            Mail::to($patient->user->Email)->send(new ApproveUser($patient));

			return response()->json(['message' => 'Dado de alta correctamente']);
		} else {
			return response()->json(['message' => 'No se encontró al paciente.'], 404);
		}
	}

	public function rejectUserRequest($id) 
	{
		$patient = Patient::find($id);

		if ($patient) {
			
			$user = User::find($patient->Usuarios_idUsuario);

			if ($user) {
				Mail::to($user->Email)->send(new RejectUser($patient));
				$patient->delete();
				$user->delete();
			}

			return response()->json(['message' => $patient->Nombre]);
		}
	}

	public function newPatient(Request $request)
    {
        try {
            $idUser = session('UserId');
            $professional = session('Professional_' . $idUser);

            // Verificar si el paciente ya existe por el DNI
            $existingPatient = Patient::where('DNI', $request->dni)->first();
            if ($existingPatient) {
                return response()->json(['success' => false, 'message' => 'El paciente ya está registrado.']);
            }

            // Si no existe, crea un nuevo registro
            $patient = Patient::create([
                'Apellido' => $request->apellido,
                'Nombre' => $request->nombre,
                'DNI' => $request->dni,
                'Telefono' => null,
                'Fecha_Nacimiento' => null,
                'Domicilio' => null,
                'created_at' => now(),
                // 'matriculaObraSocial' => ..., Poner aqui la matricula
                'Localidades_idLocalidad' => 1,
                'Generos_idGenero' => 1,
                'Estados_Civiles_idEstado_Civil' => 1,
                'Roles_idRol' => 2, // Paciente
                'Estados_Pacientes_idEstado' => 2, // No Habilitado (false)
                'Usuarios_idUsuario' => 36, // Usuario sin cuenta
                'idObraSocial' => 1, // Sin obra social (modificar segun sea necesario)
            ]);

            return response()->json(['success' => true, 'patient' => $patient]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

	public function showPatients()
	{
        $patients = Patient::all();

		$activePatients = Patient::where('Roles_idRol', 2) // Paciente
        ->where('Estados_Pacientes_idEstado', 1) // Habilitado
        ->whereHas('user', function ($query) {
			$query->where('Email_verified', 1); // Email verificado
		})
        ->with(['user', 'socialWork'])
        ->orderBy('idPaciente', 'desc') // Ordenar por ID descendente
        ->get();

    	$inactivePatients = Patient::where('Roles_idRol', 2) // Paciente
        ->where('Estados_Pacientes_idEstado', 2) // No Habilitado
        ->whereHas('user', function ($query) {
			$query->where('Email_verified', 1); // Email verificado
		})
        ->with(['user', 'socialWork'])
        ->orderBy('idPaciente', 'desc') // Ordenar por ID descendente
        ->get();

        $noAccountPatients = Patient::where('Roles_idRol', 2) // Paciente
        ->where('Estados_Pacientes_idEstado', 2) // No Habilitado
        ->where('Usuarios_idUsuario', 36) // Usuario sin cuenta
        ->orderBy('idPaciente', 'desc') // Ordenar por ID descendente
        ->get();

        $socialWorks = SocialWork::all();

        return view('dashboards.patients.patients', compact('patients', 'activePatients', 'inactivePatients', 'noAccountPatients', 'socialWorks'));
    }

	public function deactivatePatient(Request $request)
    {
        $patient = Patient::find($request->id);
        if ($patient) {
            $patient->Estados_Pacientes_idEstado = 2; 
            $patient->save();
            return response()->json(['message' => 'El paciente ha sido dado de baja.']);
        }
        return response()->json(['message' => 'Paciente no encontrado.'], 404);
    }

    public function activatePatient(Request $request)
    {
        $patient = Patient::find($request->id);
        if ($patient) {
            $patient->Estados_Pacientes_idEstado = 1;
            $patient->save();
            return response()->json(['message' => 'El paciente ha sido dado de alta.']);
        }
        return response()->json(['message' => 'Paciente no encontrado.'], 404);
    }

    public function updateSocialWork(Request $request)
    {
        $patient = Patient::find($request->idPaciente);
        if ($patient) {
            $patient->idObraSocial = $request->idObraSocial;
            $patient->matriculaObraSocial = $request->matricula;
            $patient->save();

            $socialWorkName = SocialWork::find($request->idObraSocial)->Nombre;

            return response()->json(['success' => true, 'socialWorkName' => $socialWorkName, 'matricula' => $patient->matriculaObraSocial]);
        }

        return response()->json(['success' => false]);
    }

}
