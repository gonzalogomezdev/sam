<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Usuario;
use App\Models\MedicalHistory;
use App\Models\EstadoHistoriales;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Crypt;

class MedicalHistoryController extends Controller
{
    public function index()
    {
        $patients = Patient::has('medicalHistory')->get();
    
        if ($patients->isEmpty()) {
            return response()->json(['message' => 'No hay pacientes con historial médico.'], 200);
        }
    
        $data = []; // Inicializar la variable $data fuera del bucle
    
        foreach ($patients as $patient) {
            $medicalHistories = $patient->medicalHistory;
    
            foreach ($medicalHistories as $history) {
                try {
                    // Verificar si las cadenas no están vacías antes de descifrar
                    if (!empty($history->Diagnostico)) {
                        $history->Diagnostico = Crypt::decryptString($history->Diagnostico);
                    }
                    if (!empty($history->Tratamiento)) {
                        $history->Tratamiento = Crypt::decryptString($history->Tratamiento);
                    }
                    if (!empty($history->Medicamento)) {
                        $history->Medicamento = Crypt::decryptString($history->Medicamento);
                    }

                    $history->Fecha = Carbon::parse($history->Fecha)->format('d/m/Y');
                } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                    // Manejo de excepción si ocurre un error de descifrado
                    return response()->json(['error' => 'Error al descifrar los datos: ' . $e->getMessage()], 500);
                }
    
                $estadoHistorial = EstadoHistoriales::find($history->Estados_Historiales_idEstado_Historial);
                $history->estadoHistorial = $estadoHistorial;
            }
    
            $data[] = [
                'patient' => $patient->toArray(),
                'historiales' => $medicalHistories->toArray()
            ];
        }
    
        $estadosHistoriales = EstadoHistoriales::all(); // Mover fuera del bucle
    
        return view('dashboards.medical.medicalHistory', [
            'patientsWithMedicalHistory' => $patients,
            'medicalHistorys' => $data,
            'estadosHistoriales' => $estadosHistoriales
        ]);
    }

    public function verHistorial($idPaciente)
    {
        $paciente = Patient::findOrFail($idPaciente);
        $historialesClinicos = MedicalHistory::where('Pacientes_idPaciente', $idPaciente)->get();
        dd($historialesClinicos);
        /* return view('historial', ['historialesClinicos' => $historialesClinicos]); */
    }

    public function actualizarEstado(Request $request)
    {
        $idUser = Session('UserId');
        $professional = Session('Professional_' . $idUser);
        $patient = Session('Patient_' . $idUser);
    
        try {
            $historial = MedicalHistory::findOrFail($request->historial_id);
            $historial->Historiales_idEstado_Historial = $request->estado_tratamiento;
            $historial->save();
    
            return response()->json(['success' => true, 'message' => 'Estado del tratamiento actualizado exitosamente']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function pdf(Request $request)
    {
        // Encontrar el historial clínico por ID
        $historial = MedicalHistory::findOrFail($request->id);
    
        // Encontrar el paciente asociado
        $paciente = Patient::findOrFail($historial->Pacientes_idPaciente);
    
        // Desencriptar los datos del historial clínico
        $historial->Tratamiento = Crypt::decryptString($historial->Tratamiento);
        $historial->Medicamento = Crypt::decryptString($historial->Medicamento);
    
        // Fecha para el PDF
        $fechaPDF = Carbon::now()->format('d m Y');
    
        // Generar el PDF con los datos desencriptados
        $pdf = Pdf::loadView(
            'dashboards.medical.pdf',
            [
                'historial' => $historial,
                'paciente' => $paciente,
                'fechaPDF' => $fechaPDF
            ]
        )->setPaper('a5', 'portrait');
    
        return $pdf->stream();
    }
}
