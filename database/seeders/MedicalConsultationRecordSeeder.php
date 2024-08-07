<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;

class MedicalConsultationRecordSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        // Número total de registros
        $totalRecords = 400;

        // Porcentajes
        $completed = 0.50;
        $inProgress = 0.20;
        $notCompleted = 0.30;

        // Cantidades basadas en porcentajes
        $completedCount = $totalRecords * $completed;
        $inProgressCount = $totalRecords * $inProgress;
        $notCompletedCount = $totalRecords * $notCompleted;

        // Obtener IDs de pacientes que tienen roles_idrol = 2
        $validPatientIds = DB::table('pacientes')
            ->where('Roles_idRol', 2)
            ->pluck('idPaciente')
            ->toArray(); 
        
        // Verificar que se obtuvieron IDs válidos
        if (empty($validPatientIds)) {
            $this->command->info('No se encontraron pacientes con Roles_idRol = 2.');
            return;
        }

        $now = Carbon::now();
        $currentYear = $now->year;

        // Crear registros
        for ($i = 1; $i <= $totalRecords; $i++) {
            $status = $this->getStatus($completedCount, $inProgressCount, $notCompletedCount);
            $pacienteId = $faker->randomElement($validPatientIds);
            $randomDate = Carbon::create($currentYear, $faker->numberBetween(1, 12), $faker->numberBetween(1, 28))
                ->subDays($faker->numberBetween(0, $now->dayOfYear - 1))
                ->format('Y-m-d');

            DB::table('Historiales_Clinicos')->insert([
                'Diagnostico' => Crypt::encryptString($faker->sentence()),
                'Tratamiento' => Crypt::encryptString($faker->sentence()),
                'Fecha' => $randomDate,
                'Medicamento' => Crypt::encryptString($faker->word()),
                'Pacientes_idPaciente' => $pacienteId,
                'Historiales_idEstado_Historial' => $status,
            ]);
        }
    }

    /**
     * Obtiene el estado para un registro basado en las cantidades restantes.
     *
     * @param int $completedCount
     * @param int $inProgressCount
     * @param int $notCompletedCount
     * @return int
     */
    private function getStatus(&$completedCount, &$inProgressCount, &$notCompletedCount)
    {
        $status = 1; // Estado por defecto: "concluido"
        $random = rand(1, 100);

        if ($completedCount > 0 && $random <= 50) {
            $status = 1; // "concluido"
            $completedCount--;
        } elseif ($inProgressCount > 0 && $random <= 70) {
            $status = 2; // "en curso"
            $inProgressCount--;
        } elseif ($notCompletedCount > 0) {
            $status = 3; // "no concluido"
            $notCompletedCount--;
        }

        return $status;
    }
}