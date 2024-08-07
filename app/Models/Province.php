<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    protected $table = 'Provincias';
    public $timestamps = false; // Deshabilitar las marcas de tiempo
    protected $primaryKey = 'idProvincia'; 

    protected $fillable = [
        'idProvincia', 'Desc_Prov'
    ];

    public function city()
    {
        return $this->hasMany(City::class, 'Provincias_idProvincia', 'idProvincia');
    }
}
