<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadosPacientesSeeder extends Seeder
{
    public function run()
    {
        DB::table('estados_pacientes')->insert([
            ['idEstado' => 1, 'Habilitado' => 1],
            ['idEstado' => 2, 'No Habilitado' => 2],
        ]);
    }
}
