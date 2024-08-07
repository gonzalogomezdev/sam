<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class RolesSeeder extends Seeder
{
    public function run()
    {
        DB::table('roles')->insert([
            ['idRol' => 1, 'Desc_Rol' => 'Solicitante'],
            ['idRol' => 2, 'Desc_Rol' => 'Paciente'],
        ]);
    }
}
