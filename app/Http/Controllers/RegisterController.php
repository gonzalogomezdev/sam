<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Mail;
use App\Models\Patient;
// use App\Models\Professional;
use App\Models\User;
use App\Mail\EmailConfirmation;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register (RegisterRequest $request){
		$data = $request->validated();

        $user = User::create([
            'Email' => $request->input('Email'),
            'Password' => $request->input('Password'),
            'Token' => Str::random(25),
            'Email_verified' => false,
        ]);

        // Verificar si el DNI ya existe en la tabla de pacientes
        $patient = Patient::where('DNI', $data['DNI'])->first();

        if ($patient) {
            // Actualizar el paciente existente con los nuevos datos
            $patient->Roles_idRol = 1; // Solicitante
            $patient->Usuarios_idUsuario = $user->idUsuario;
            $patient->save();

            $message = 'Ya eres un paciente registrado. Por favor, revisa tu correo electrónico para verificar tu cuenta.';
        } else {
            // Crear un nuevo paciente si no existe
            $patient = Patient::create([
                'Apellido' => $data['Apellido'] ?? null,
                'Nombre' => $data['Nombre'] ?? null,
                'DNI' => $data['DNI'] ?? null,
                'Telefono' => $data['Telefono'] ?? null,
                'Fecha_Nacimiento' => $data['Fecha_Nacimiento'] ?? null,
                'Domicilio' => $data['Domicilio'] ?? null,
                'created_at' => now(),
                'Localidades_idLocalidad' => 1,
                'Generos_idGenero' => 1, 
                'Estados_Civiles_idEstado_Civil' => 1, 
                'Roles_idRol' => 1, // Solicitante
                'Estados_Pacientes_idEstado' => 2, // No Habilitado (false)
                'Usuarios_idUsuario' => $user->idUsuario,
                'idObraSocial' => 1 // Sin obra social
            ]);

            $message = 'Se ha registrado con éxito. Por favor, revisa tu correo electrónico para verificar tu cuenta.';
        }

        // $profesional = Professional::create([
        //     'Apellido' => $data['Apellido'] ?? null,
        //     'Nombre' => $data['Nombre'] ?? null,
        //     'DNI' => $data['DNI'] ?? null,
        //     'Telefono' => $data['Telefono'] ?? null,
        //     'Domicilio' => $data['Domicilio'] ?? null,
        //     'Fecha_Nacimiento' => $data['Fecha_Nacimiento'] ?? null,
        //     'Localidades_idLocalidad' => 1,
        //     'Generos_idGenero' => 1, 
        //     'Estados_Civiles_idEstado_Civil' => 1, 
        //     'Usuarios_idUsuario' => $user->idUsuario
        // ]);
        
        // Mail::to($user->Email)->send(new EmailConfirmation($user->Token));
        
		if($user && $patient) {
            return redirect()->route('register.form')->with('success', $message);
        } else {
            return redirect()->route('register.form')->with('error', 'Ocurrio un error en el registro');
        }

	}
}
