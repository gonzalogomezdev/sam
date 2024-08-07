<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Models\Patient;
use App\Models\Professional;

use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $email = $request->input('Email');
    	$password = $request->input('Password');

    	$user = User::where('Email', $email)->first();

        if ($user && (password_verify($password, $user->Password) || $password === $user->Password)) {

            $patient = Patient::where('Usuarios_idUsuario', $user->idUsuario)->first();

            $professional = Professional::where('Usuarios_idUsuario', $user->idUsuario)->first();

            if ($professional) {
                //Se crea la session del usuario. Primero se pone una clave, y en ella se almacena un valor
                Session::put('UserId', $user->idUsuario);
                Session::put('Professional_'. $user->idUsuario, $professional);
                return redirect()->route('dashboard');
            } elseif ($patient) {
                // Solicitante y No habilitado
                if ($patient->Roles_idRol === 1 && $patient->Estados_Pacientes_idEstado === 2) {
                    return redirect()->route('login.form')->with('inProgress', 'Su solicitud esta siendo procesada.');
                // Paciente y Habilitado
                } elseif ($patient->Roles_idRol === 2 && $patient->Estados_Pacientes_idEstado === 1) {
                    Session::put('UserId', $user->idUsuario);
                    Session::put('Patient_'. $user->idUsuario, $patient);
                    return redirect()->route('dashboard');
                } else {
                    return redirect()->route('login.form')->with('reject', 'Usted no esta habilitado/a en el sistema.');
                }
            } else {
                return redirect()->route('login.form')->with('errorUser', 'El usuario no tiene un paciente asociado.');
            }
        } else {
            return redirect()->route('login.form')->with('errorData', 'Acceso inválido. Por favor, inténtelo otra vez.');
        }
    }
}

?>
