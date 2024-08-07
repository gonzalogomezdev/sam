<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use App\Models\MedicalHistory;
use Carbon\Carbon;

class CheckNoShows extends Command
{
    protected $signature = 'check:no-shows'; // define cómo se llama el comando
    protected $description = 'Mark appointments as no-shows if no medical history record exists'; // descripción del propósito del comando.

    public function handle()
    {
        $today = Carbon::today()->toDateString();

        // Obtener todos los turnos anteriores a hoy con estado "Pendiente"
        $turnosPendientes = Appointment::where('Fecha', '<', $today)
        ->where('Estado_turno', 1) // 1 = Pendiente
        ->get();

        foreach ($turnosPendientes as $turno) {
            // Verificar si hay un historial clínico para este turno y paciente
            $historial = MedicalHistory::where('Pacientes_idPaciente', $turno->Pacientes_idPaciente)
            ->whereDate('Fecha', $turno->Fecha)
            ->first();

            if (!$historial) {
                // Si no hay historial, marcar el turno como "No asistido"
                $turno->Estado_turno = 2; // 2 = No asistido
                $turno->save();
            }
        }

        $this->info('Turnos no asistidos han sido marcados.');
    }
}