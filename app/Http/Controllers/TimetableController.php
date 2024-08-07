<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Timetable;
use App\Models\Appointment;

class TimetableController extends Controller
{
    public function store(Request $request)
    {
        $interval = $request->input('interval'); 
        $morningStart = $request->input('morningStart'); // Recibo como cadena de texto hh:mm:ss
        $morningEnd = $request->input('morningEnd');

        $afternoonStart = $request->input('afternoonStart');
        $afternoonEnd = $request->input('afternoonEnd');
        $date = $request->input('date');
        $selectedDays = $request->input('selectedDays');

        // Verificar si hay turnos reservados para las fechas seleccionadas
        foreach ($selectedDays as $date) {
            $appointmentExists = Appointment::where('Fecha', $date)->exists();
            if ($appointmentExists) {
                return response()->json(['error' => 'Existen turnos reservados para la fecha ' . $date . '.'], 400);
            }
        }

        foreach ($selectedDays as $date) {
            // Eliminar horarios existentes para la fecha seleccionada
            Timetable::where('Fecha', $date)->delete();
    
            if ($morningStart && $morningEnd) {
                $this->newHorarios($morningStart, $morningEnd, 'Mañana', $interval, $date);
            }
    
            if ($afternoonStart && $afternoonEnd) {
                $this->newHorarios($afternoonStart, $afternoonEnd, 'Tarde', $interval, $date);
            }
        }
        return response()->json(['message' => 'Horarios actualizados correctamente'], 200);
    }

    private function newHorarios($start, $end, $franja, $interval, $date)
    {
        $startTime = strtotime($start);
        $endTime = strtotime($end);

        // Generar y añadir nuevos horarios según el nuevo intervalo
        while ($startTime <= $endTime) {
            $hora = date('H:i:s', $startTime);
            Timetable::create([
                'Hora' => $hora,
                'Franja_Horaria' => $franja,
                'Fecha' => $date
            ]);

            $startTime = strtotime("+$interval minutes", $startTime);
        }
    }
}