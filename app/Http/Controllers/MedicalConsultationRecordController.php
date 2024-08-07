<?php

namespace App\Http\Controllers;

use App\Models\MedicalConsultationRecord;
use Illuminate\Http\Request;

use App\Models\Patient;
use App\Models\Appointment;
use App\Models\SocialWork;
use Carbon\Carbon;
use App\Models\MedicalHistory;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\DB;

class MedicalConsultationRecordController extends Controller
{
    public function index()
    {
        $patients = Patient::all();
        $socialWorks = SocialWork::all();

        return view('dashboards.medical.medicalConsultationRecord', ['pacientes' => $patients, 'socialWorks' => $socialWorks]);
    }

    public function store(Request $request)
    {   
        $request->validate([
            'paciente' => 'required',
            'Diagnostico' => 'required|string',
            'Tratamiento' => 'required|string',
            'Medicamento' => 'required|string',
            'obra_social' => 'nullable',
            'matricula' => 'nullable|string'
        ]);
    
        $idPaciente = $request->input('paciente');
    
        // Obtener el paciente
        $paciente = Patient::findOrFail($idPaciente);
    
        // Actualizar obra social y matrícula del paciente
        $paciente->idObraSocial = $request->input('obra_social');
        $paciente->matriculaObraSocial = $request->input('matricula');
        $paciente->save();
    
        $date = Carbon::now();
    
        try {
            // Cifrar los datos
            $diagnostico = Crypt::encryptString($request->input('Diagnostico'));
            $tratamiento = Crypt::encryptString($request->input('Tratamiento'));
            $medicamento = Crypt::encryptString($request->input('Medicamento'));
    
            $historialClinico = MedicalHistory::create([
                'Pacientes_idPaciente' => $paciente->idPaciente,
                'Diagnostico' => $diagnostico,
                'Tratamiento' => $tratamiento,
                'Medicamento' => $medicamento,
                'Historiales_idEstado_Historial' => 1,
                'Fecha' => $date,
            ]);
    
            // Actualizar el estado del turno correspondiente
            $turno = Appointment::where('Pacientes_idPaciente', $idPaciente)
                ->whereDate('Fecha', $date)
                ->first();
    
            if ($turno) {
                $turno->Estado_turno = 3; // 'Asistido'
                $turno->save();
            }
    
            return response()->json(['success' => true]);
    
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al guardar el historial clínico: ' . $e->getMessage()], 500);
        }
    }
    
    public function getPatientDetails($id) {
        $patient = Patient::find($id);
    
        if ($patient) {
            // Obtener la obra social del paciente
            $obraSocial = $patient->socialWork; // Suponiendo que `obraSocial` es una relación en el modelo `Patient`
    
            return response()->json([
                'success' => true,
                'patient' => [
                    'idObraSocial' => $obraSocial ? $obraSocial->idObraSocial : null, // ID de la obra social del paciente
                    'matricula' => $patient->matriculaObraSocial, // Matrícula del paciente
                ]
            ]);
        } else {
            return response()->json(['success' => false, 'message' => 'Paciente no encontrado']);
        }
    }
}    
