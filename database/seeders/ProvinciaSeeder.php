<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProvinciaSeeder extends Seeder
{
    public function run()
    {
        DB::table('provincias')->insert([
            ['idProvincia' => 1, 'Desc_Prov' => 'Misiones'],
            ['idProvincia' => 2, 'Desc_Prov' => 'Buenos Aires'],
            ['idProvincia' => 3, 'Desc_Prov' => 'Corrientes'],
        ]);
    }
}
