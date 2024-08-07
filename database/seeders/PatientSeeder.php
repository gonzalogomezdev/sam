<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Patient;

class PatientSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $userIds = range(2, 399);

        $startDate = '2024-01-01';
        $endDate = '2024-08-02';

        foreach (range(1, 20) as $index) {
            $idObraSocial = $faker->numberBetween(1, 3);

            Patient::create([
                'Nombre' => $faker->firstName(),
                'Apellido' => $faker->lastName(),
                'DNI' => $faker->unique()->numerify('##########'),
                'Telefono' => $faker->numerify('#####'),
                'Fecha_Nacimiento' => $faker->date(),
                'Domicilio' => $faker->streetAddress(),
                'Localidades_idLocalidad' => $faker->numberBetween(1, 4), // Asegúrate de que el valor existe
                'Generos_idGenero' => $faker->numberBetween(1, 2), // Asegúrate de que el valor existe
                'Estados_Civiles_idEstado_Civil' => $faker->numberBetween(1, 2), // Asegúrate de que el valor existe
                'Roles_idRol' => 1, // Solicitantes
                'Estados_Pacientes_idEstado' => 2, // No habilitados
                'Usuarios_idUsuario' => $index,
                'created_at' => $faker->dateTimeBetween($startDate, $endDate)->format('Y-m-d'),
                'idObraSocial' => $idObraSocial,
                'matriculaObraSocial' => ($idObraSocial == 1) ? '' : $faker->numerify('#####')
            ]);
        }

        // Total de usuarios que quieres crear
        $totalPatient = 400;
        // Porcentaje de usuarios activos
        $activePercentage = 0.8;
        // Porcentaje de usuarios inactivos
        $inactivePercentage = 1 - $activePercentage;

        $activeCount = (int) ($totalPatient * $activePercentage);
        $inactiveCount = $totalPatient - $activeCount;

        foreach (range(21, $totalPatient) as $index) {
            $idObraSocial = $faker->numberBetween(1, 3);

            Patient::create([
                'Nombre' => $faker->firstName(),
                'Apellido' => $faker->lastName(),
                'DNI' => $faker->unique()->numerify('##########'),
                'Telefono' => $faker->numerify('#####'),
                'Fecha_Nacimiento' => $faker->date(),
                'Domicilio' => $faker->streetAddress(),
                'Localidades_idLocalidad' => $faker->numberBetween(1, 4), // Asegúrate de que el valor existe
                'Generos_idGenero' => $faker->numberBetween(1, 2), // Asegúrate de que el valor existe
                'Estados_Civiles_idEstado_Civil' => $faker->numberBetween(1, 2), // Asegúrate de que el valor existe
                'Roles_idRol' => 2, // Pacientes
                'Estados_Pacientes_idEstado' => ($index <= $activeCount) ? 1 : 2, // Estado de los pacientes
                'Usuarios_idUsuario' => $index,
                'created_at' => $faker->dateTimeBetween($startDate, $endDate)->format('Y-m-d'),
                'idObraSocial' => $idObraSocial,
                'matriculaObraSocial' => ($idObraSocial == 1) ? '' : $faker->numerify('#####')
            ]);
        }

        foreach (range(1, 30) as $index) {
            $idObraSocial = $faker->numberBetween(1, 3);

            Patient::create([
                'Nombre' => $faker->firstName(),
                'Apellido' => $faker->lastName(),
                'DNI' => $faker->unique()->numerify('##########'),
                'Telefono' => $faker->numerify('#####'),
                'Fecha_Nacimiento' => $faker->date(),
                'Domicilio' => $faker->streetAddress(),
                'Localidades_idLocalidad' => $faker->numberBetween(1, 4), // Asegúrate de que el valor existe
                'Generos_idGenero' => $faker->numberBetween(1, 2), // Asegúrate de que el valor existe
                'Estados_Civiles_idEstado_Civil' => $faker->numberBetween(1, 2), // Asegúrate de que el valor existe
                'Roles_idRol' => 2, // Pacientes
                'Estados_Pacientes_idEstado' => 2, // No habilitados
                'Usuarios_idUsuario' => 36, // Sin cuenta
                'created_at' => $faker->dateTimeBetween($startDate, $endDate)->format('Y-m-d'),
                'idObraSocial' => $idObraSocial,
                'matriculaObraSocial' => ''
            ]);
        }
    }
}