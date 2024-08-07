<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\MedicalConsultationRecord;
use App\Models\Patient;
use App\Models\Appointment;

class DashboardController extends Controller
{
    public function showDashboard()
    {
        $idUser = Session('UserId');

        $professional = Session('Professional_' . $idUser);
        $patient = Session('Patient_' . $idUser);

        $data = [
            'patientCount' => Patient::count(),
            'patientsWithConsultationsCount' => Patient::whereHas('medicalHistory')->count(),
            'consultationsCount' => MedicalConsultationRecord::count(),
            'consultationsInProgressCount' => MedicalConsultationRecord::where('Historiales_idEstado_Historial', '1')->count(),
            'consultationsCompletedCount' => MedicalConsultationRecord::where('Historiales_idEstado_Historial', '2')->count(),
            'consultationsNotCompletedCount' => MedicalConsultationRecord::where('Historiales_idEstado_Historial', '3')->count(),
            'turnosPorMes' => array_replace(array_fill(1, 12, 0), Appointment::selectRaw('MONTH(Fecha) as month, COUNT(*) as count')
                ->groupBy('month')
                ->orderBy('month')
                ->get()
                ->pluck('count', 'month')
                ->toArray()),
            'turnosDelDia' => Appointment::whereDate('Fecha', today())->count(), // Agregar esta línea
            'patientsRegisteredPerMonth' => array_replace(array_fill(1, 12, 0), Patient::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->groupBy('month')
                ->orderBy('month')
                ->get()
                ->pluck('count', 'month')
                ->toArray()),
            'activeUsers' => Patient::where('Roles_idRol', 2) // Paciente
            ->where('Estados_Pacientes_idEstado', 1) // Habilitado
            ->whereHas('user', function ($query) {
                $query->where('Email_verified', 1); // Email verificado
            })->count(),
            'inactiveUsers' => Patient::where('Roles_idRol', 2) // Paciente
            ->where('Estados_Pacientes_idEstado', 2) // No Habilitado
            ->whereHas('user', function ($query) {
                $query->where('Email_verified', 1); // Email verificado
            })->count(),
        ];

        if ($professional || $patient) {
            return view('dashboards.dashboard', ['idUser' => $idUser, 'professional' => $professional, 'patient' => $patient, 'data' =>$data]);
        } else {
            return redirect()->route('login.form');
        }
    }

    public function showWelcome()
    {        
        $data = [
            'patientCount' => Patient::count(),
            'patientsWithConsultationsCount' => Patient::whereHas('medicalHistory')->count(),
            'consultationsCount' => MedicalConsultationRecord::count(),
            'consultationsInProgressCount' => MedicalConsultationRecord::where('Historiales_idEstado_Historial', '1')->count(),
            'consultationsCompletedCount' => MedicalConsultationRecord::where('Historiales_idEstado_Historial', '2')->count(),
            'consultationsNotCompletedCount' => MedicalConsultationRecord::where('Historiales_idEstado_Historial', '3')->count(),
            'turnosPorMes' => array_replace(array_fill(1, 12, 0), Appointment::selectRaw('MONTH(Fecha) as month, COUNT(*) as count')
                ->groupBy('month')
                ->orderBy('month')
                ->get()
                ->pluck('count', 'month')
                ->toArray()),
            'turnosDelDia' => Appointment::whereDate('Fecha', today())->count(), // Agregar esta línea
            'patientsRegisteredPerMonth' => array_replace(array_fill(1, 12, 0), Patient::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->groupBy('month')
                ->orderBy('month')
                ->get()
                ->pluck('count', 'month')
                ->toArray()),
            'activeUsers' => Patient::where('Roles_idRol', 2) // Paciente
            ->where('Estados_Pacientes_idEstado', 1) // Habilitado
            ->whereHas('user', function ($query) {
                $query->where('Email_verified', 1); // Email verificado
            })->count(),
            'inactiveUsers' => Patient::where('Roles_idRol', 2) // Paciente
            ->where('Estados_Pacientes_idEstado', 2) // No Habilitado
            ->whereHas('user', function ($query) {
                $query->where('Email_verified', 1); // Email verificado
            })->count(),
        ];

        return view('dashboards.welcome.welcome', ['data' => $data]);
    }

}

