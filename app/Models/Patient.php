<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Person
{
    use HasFactory;

    protected $table = 'Pacientes';
    public $timestamps = false; // Deshabilitar las marcas de tiempo
    protected $primaryKey = 'idPaciente'; 

    // Combinar los atributos $fillable del modelo base con los del modelo derivado
    protected $fillable = [
        'Nombre', 'Apellido', 'DNI', 'Telefono', 'Fecha_Nacimiento', 'Domicilio', 'created_at','matriculaObraSocial', 'Localidades_idLocalidad', 'Generos_idGenero', 'Estados_Civiles_idEstado_Civil', 'Roles_idRol', 'Estados_Pacientes_idEstado', 'Usuarios_idUsuario', 'idObraSocial'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'Usuarios_idUsuario', 'idUsuario');
    }

    public function appointment()
    {
        return $this->hasMany(Appointment::class, 'Pacientes_idPaciente', 'idPaciente');
    }

    public function medicalHistory()
    {
        return $this->hasMany(MedicalHistory::class, 'Pacientes_idPaciente');
    }

    public function socialWork()
    {
        return $this->belongsTo(SocialWork::class, 'idObraSocial', 'idObraSocial');
    }
}
