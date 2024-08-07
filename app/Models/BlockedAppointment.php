<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlockedAppointment extends Model
{
    use HasFactory;

    protected $table = 'Turnos_Bloqueados';
    public $timestamps = false; // Deshabilitar las marcas de tiempo
    protected $primaryKey = 'idTurnoBloqueado'; 

    protected $fillable = [
        'idTurnoBloqueado', 'Fecha', 'Hora'
    ];
}
