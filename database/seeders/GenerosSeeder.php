<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class GenerosSeeder extends Seeder
{
    public function run()
    {
        DB::table('generos')->insert([
            ['idGenero' => 1, 'Desc_Genero' => 'Hombre'],
            ['idGenero' => 2, 'Desc_Genero' => 'Mujer'],
        ]);
    }
}
