<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model 
{
    use HasFactory;
    
    protected $table = 'Usuarios';
    public $timestamps = false; // Deshabilitar las marcas de tiempo
    protected $primaryKey = 'idUsuario'; 

    protected $fillable = [
        'idUsuario', 'Email', 'Password', 'Token', 'Email_verified'
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['Password'] = bcrypt($value);
    }
    
    public function getPatient()
    {
        return $this->hasOne(Patient::class, 'Usuarios_idUsuario', 'idUsuario'); // Tiene un ...
    }

    public function getProfessional()
    {
        return $this->hasOne(Professional::class, 'Usuarios_idUsuario', 'idUsuario');
    }

}