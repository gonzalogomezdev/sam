<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadosHistorialesSeeder extends Seeder
{
    public function run()
    {
        DB::table('estados_historiales')->insert([
            ['idEstado_Historial' => 1, 'Desc_Historial' => 'En curso'],
            ['idEstado_Historial' => 2, 'Desc_Historial' => 'Concluido'],
            ['idEstado_Historial' => 3, 'Desc_Historial' => 'No Concluido'],
        ]);
    }
}
