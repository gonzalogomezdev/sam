<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    use HasFactory;

    protected $table = 'Generos';
    public $timestamps = false; // Deshabilitar las marcas de tiempo
    protected $primaryKey = 'idGenero'; 

    protected $fillable = [
        'idGenero', 'Desc_Genero'
    ];

    public function patient()
    {
        return $this->hasMany(Patient::class, 'Generos_idGenero', 'idGenero');
    }

    public function professional()
    {
        return $this->hasMany(Professional::class, 'Generos_idGenero', 'idGenero');
    }
}
