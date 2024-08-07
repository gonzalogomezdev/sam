<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $table = 'Localidades';
    public $timestamps = false; // Deshabilitar las marcas de tiempo
    protected $primaryKey = 'idLocalidad'; 

    protected $fillable = [
        'idLocalidad', 'Desc_Localidad'
    ];

    public function province()
    {
        return $this->belongsTo(Province::class, 'Provincias_idProvincia', 'idProvincia');
    }

    public function patient()
    {
        return $this->hasMany(Patient::class, 'Localidades_idLocalidad', 'idLocalidad');
    }

    public function professional()
    {
        return $this->hasMany(Professional::class, 'Localidades_idLocalidad', 'idLocalidad');
    }
}
