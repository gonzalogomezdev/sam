<?php

namespace App\Http\Controllers;

use App\Models\ObraSocial;
use Illuminate\Http\Request;

class SocialWorkController extends Controller
{
    public function socialWorks()
    {
        $obrasSociales = ObraSocial::where('estado', 1)->get();
        return view('dashboards.patients.social', compact('obrasSociales'));
    }

    public function addSocialWork(Request $request)
    {
        $request->validate([
            'Nombre' => 'required|string|max:255',
        ]);

        ObraSocial::create([
            'Nombre' => $request->Nombre,
            'estado' => 1,
        ]);

        return response()->json(['success' => 'Obra Social agregada exitosamente.']);
    }

    public function updateSocialWork(Request $request, $id)
    {
        $request->validate([
            'Nombre' => 'required|string|max:255',
        ]);

        $obraSocial = ObraSocial::findOrFail($id);
        $obraSocial->update([
            'Nombre' => $request->Nombre,
        ]);

        return response()->json(['success' => 'Obra Social actualizada exitosamente.']);
    }

    public function deleteSocialWork($id)
    {
        $obraSocial = ObraSocial::findOrFail($id);
        $obraSocial->update(['estado' => 0]);

        return response()->json(['success' => 'Obra Social eliminada exitosamente.']);
    }
    static public function getNameSocialWork($id)
    {
        $obraSocial = ObraSocial::findOrFail($id);

        return $obraSocial;
    }
}
