<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ObraSocialSeeder extends Seeder
{
    public function run()
    {
        DB::table('Obras_sociales')->insert([
            ['idObraSocial' => 1, 'nombre' => 'Sin obra social'],
            ['idObraSocial' => 2, 'nombre' => 'IPS'],
            ['idObraSocial' => 3, 'nombre' => 'Osde'],
        ]);
    }
}
