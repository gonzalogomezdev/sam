<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadosCivilesSeeder extends Seeder
{
    public function run()
    {
        DB::table('estados_civiles')->insert([
            ['idEstado_Civil' => 1, 'Desc_Estado' => 'Soltero'],
            ['idEstado_Civil' => 2, 'Desc_Estado' => 'Casado'],
        ]);
    }
}
