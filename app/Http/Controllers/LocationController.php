<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;

class LocationController extends Controller
{
    public function obtenerLocalidades($idProvincia)
    {
        $localidades = City::where('Provincias_idProvincia', $idProvincia)->get();
        return response()->json($localidades);
    }
}
