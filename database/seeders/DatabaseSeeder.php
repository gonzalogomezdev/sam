<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            EstadosCivilesSeeder::class,
            EstadosHistorialesSeeder::class,
            EstadosPacientesSeeder::class,
            GenerosSeeder::class,
            ObraSocialSeeder::class,
            HorariosSeeder::class,
            ProvinciaSeeder::class,
            LocalidadesSeeder::class,
            RolesSeeder::class,
            UserSeeder::class,
            PatientSeeder::class,
            ProfesionalSeeder::class,
            TurnosSeeder::class,
            MedicalConsultationRecordSeeder::class
        ]);
    }
}
