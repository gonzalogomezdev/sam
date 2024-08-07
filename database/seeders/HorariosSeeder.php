<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HorariosSeeder extends Seeder
{
    public function run()
    {
        DB::table('horarios')->insert([
            ['hora' => '08:00:00', 'Franja_Horaria' => 'Mañana', 'fecha' => null],
            ['hora' => '08:20:00', 'Franja_Horaria' => 'Mañana', 'fecha' => null],
            ['hora' => '08:40:00', 'Franja_Horaria' => 'Mañana', 'fecha' => null],
            ['hora' => '09:00:00', 'Franja_Horaria' => 'Mañana', 'fecha' => null],
            ['hora' => '09:20:00', 'Franja_Horaria' => 'Mañana', 'fecha' => null],
            ['hora' => '09:40:00', 'Franja_Horaria' => 'Mañana', 'fecha' => null],
            ['hora' => '10:00:00', 'Franja_Horaria' => 'Mañana', 'fecha' => null],
            ['hora' => '10:20:00', 'Franja_Horaria' => 'Mañana', 'fecha' => null],
            ['hora' => '10:40:00', 'Franja_Horaria' => 'Mañana', 'fecha' => null],
            ['hora' => '11:00:00', 'Franja_Horaria' => 'Mañana', 'fecha' => null],
            ['hora' => '11:20:00', 'Franja_Horaria' => 'Mañana', 'fecha' => null],
            ['hora' => '11:40:00', 'Franja_Horaria' => 'Mañana', 'fecha' => null],
            ['hora' => '15:00:00', 'Franja_Horaria' => 'Tarde', 'fecha' => null],
            ['hora' => '15:20:00', 'Franja_Horaria' => 'Tarde', 'fecha' => null],
            ['hora' => '15:40:00', 'Franja_Horaria' => 'Tarde', 'fecha' => null],
            ['hora' => '16:00:00', 'Franja_Horaria' => 'Tarde', 'fecha' => null],
            ['hora' => '16:20:00', 'Franja_Horaria' => 'Tarde', 'fecha' => null],
            ['hora' => '16:40:00', 'Franja_Horaria' => 'Tarde', 'fecha' => null],
            ['hora' => '17:00:00', 'Franja_Horaria' => 'Tarde', 'fecha' => null],
            ['hora' => '17:20:00', 'Franja_Horaria' => 'Tarde', 'fecha' => null],
            ['hora' => '17:40:00', 'Franja_Horaria' => 'Tarde', 'fecha' => null],
            ['hora' => '18:00:00', 'Franja_Horaria' => 'Tarde', 'fecha' => null],
            ['hora' => '18:20:00', 'Franja_Horaria' => 'Tarde', 'fecha' => null],
            ['hora' => '18:40:00', 'Franja_Horaria' => 'Tarde', 'fecha' => null],
        ]);
    }
}