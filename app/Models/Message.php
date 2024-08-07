<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $table = 'Mensajes';
    public $timestamps = false; // Deshabilitar las marcas de tiempo
    protected $primaryKey = 'idMensaje'; 

    protected $fillable = [
        'idMensaje', 'Mensaje', 'Fecha_Hora', 'Remitente_id', 'Destinatario_id'
    ];
}
