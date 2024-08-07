<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfesionalSeeder extends Seeder
{
    public function run()
    {
    
        DB::table('profesional')->insert([
            [
                'idProfesional' => 1,
                'Nombre' => 'Fabio Hernan',
                'Apellido' => 'Canteros',
                'DNI' => '27495385',
                'Telefono' => '3765...',
                'Fecha_Nacimiento' => '1994-02-04',
                'Domicilio' => null,
                'Localidades_idLocalidad' => 1,
                'Generos_idGenero' => 1,
                'Estados_Civiles_idEstado_Civil' => 1,
                'Usuarios_idUsuario' => 1,
            ]
        ]);
    }
}