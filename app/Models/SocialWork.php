<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialWork extends Model
{
    use HasFactory;

    protected $table = 'obras_sociales';
    // public $timestamps = false; // Deshabilitar las marcas de tiempo
    protected $primaryKey = 'idObraSocial'; 

    protected $fillable = [
        'idObraSocial', 'Nombre'
    ];

    public function patient()
    {
        return $this->hasMany(Patient::class, 'idObraSocial', 'idObraSocial');
    }
}
