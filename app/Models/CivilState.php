<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CivilState extends Model
{
    use HasFactory;

    protected $table = 'Estados_Civiles';
    public $timestamps = false; // Deshabilitar las marcas de tiempo
    protected $primaryKey = 'idEstado_Civil'; 

    protected $fillable = [
        'idEstado_Civil', 'Desc_Estado'
    ];

    public function patient()
    {
        return $this->hasMany(Patient::class, 'Estados_Civiles_idEstado_Civil', 'idEstado_Civil');
    }

    public function professional()
    {
        return $this->hasMany(Professional::class, 'Estados_Civiles_idEstado_Civil', 'idEstado_Civil');
    }
}
