<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

abstract class Person extends Model
{
    use HasFactory;

    public $timestamps = false; 

    protected $fillable = [
        'Nombre', 'Apellido', 'DNI', 'Telefono', 'Fecha_Nacimiento', 'Domicilio',
        'Localidades_idLocalidad', 'Generos_idGenero', 'Estados_Civiles_idEstado_Civil'
    ];

    public function city()
    {
        return $this->belongsTo(City::class, 'Localidades_idLocalidad', 'idLocalidad');
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class, 'Generos_idGenero', 'idGenero');
    }

    public function civilState()
    {
        return $this->belongsTo(CivilState::class, 'Estados_Civiles_idEstado_Civil', 'idEstado_Civil');
    }
}