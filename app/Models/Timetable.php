<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    use HasFactory;

    protected $table = 'Horarios';
    public $timestamps = false; // Deshabilitar las marcas de tiempo
    protected $primaryKey = 'idHorario'; 

    protected $fillable = [
        'idHorario', 'Hora', 'Franja_Horaria', 'Fecha'
    ];

    public function appointment()
    {
        return $this->hasMany(Appointment::class, 'Horarios_idHorario', 'idHorario');
    }
}
