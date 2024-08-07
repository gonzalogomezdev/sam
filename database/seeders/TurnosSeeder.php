<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class TurnosSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Obtener IDs de Horarios existentes
        $horariosIds = DB::table('Horarios')->pluck('idHorario')->toArray();

        // Obtener IDs de Pacientes que cumplen con las condiciones: rol 2, estado habilitado o Usuarios_idUsuario = 36
        $pacientesIds = DB::table('Pacientes')
            ->where('Roles_idRol', 2)
            ->where(function($query) {
                $query->where('Estados_Pacientes_idEstado', 1)
                ->orWhere('Usuarios_idUsuario', 36);
            })
            ->pluck('idPaciente')
            ->toArray();

        // Verificar que hay IDs disponibles
        if (empty($horariosIds) || empty($pacientesIds)) {
            $this->command->info('No hay registros en las tablas Horarios o Pacientes para relacionar con Turnos.');
            return;
        }

        // Definir el rango de fechas
        $startDate = '2024-01-01';
        $endDate = '2024-08-02';

        foreach (range(1, 400) as $index) {
            // Generar una fecha aleatoria dentro del rango
            $fecha = $faker->dateTimeBetween($startDate, $endDate)->format('Y-m-d');

            DB::table('Turnos')->insert([
                'Fecha' => $fecha,
                'Estado_Turno' => 1,
                'Horarios_idHorario' => $faker->randomElement($horariosIds),
                'Pacientes_idPaciente' => $faker->randomElement($pacientesIds),
            ]);
        }
    }
}