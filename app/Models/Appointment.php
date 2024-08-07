<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'Turnos';
    public $timestamps = false; // Deshabilitar las marcas de tiempo
    protected $primaryKey = 'idTurno'; 

    protected $fillable = [
        'idTurno', 'Fecha', 'Estado_Turno', 'Horarios_idHorario', 'Pacientes_idPaciente'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'Pacientes_idPaciente', 'idPaciente'); // Pertenece a ...
    }

    public function timetable()
    {
        return $this->belongsTo(Timetable::class, 'Horarios_idHorario', 'idHorario');
    }
}
