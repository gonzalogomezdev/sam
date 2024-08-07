<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professional extends Person
{
    use HasFactory;

    protected $table = 'Profesional';
    public $timestamps = false; // Deshabilitar las marcas de tiempo
    protected $primaryKey = 'idProfesional'; 

    protected $fillable = [
        'Nombre', 'Apellido', 'DNI', 'Telefono', 'Fecha_Nacimiento', 'Domicilio', 'Localidades_idLocalidad', 'Generos_idGenero', 'Estados_Civiles_idEstado_Civil', 'Usuarios_idUsuario'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'Usuarios_idUsuario', 'idUsuario'); // Pertenece a ...
    }
}
