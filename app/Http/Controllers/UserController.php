<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ChangePasswordRequest;
use Carbon\Carbon;
use App\Models\Patient;
use App\Models\Professional;
use App\Models\User;
use App\Models\Province;
use App\Models\City;
use App\Models\Gender;
use App\Models\CivilState;

class UserController extends Controller
{
    public function showUserProfile()
    {
        $idUser = Session('UserId');

        $professional = Session('Professional_' . $idUser);
        $patient = Session('Patient_' . $idUser);

        $provinces = Province::all();
        $localities = City::all();
        $genders = Gender::all();
        $civilStates = CivilState::all();

        if ($professional) {
            $user = Professional::with(['city.province', 'user', 'gender', 'civilState'])->where('Usuarios_idUsuario', $idUser)->first();
        } elseif ($patient) {
            $user = Patient::with(['city.province', 'user', 'gender', 'civilState'])->where('Usuarios_idUsuario', $idUser)->first();
        }

        if($user->Fecha_Nacimiento) {
            $fechaNacimiento = Carbon::parse($user->Fecha_Nacimiento);
            $user->Edad = $fechaNacimiento->age;
        } else {
            $user->Edad = '-';
        }

        return view('dashboards.profile.userProfile', compact('user', 'provinces', 'localities', 'genders', 'civilStates'));
    }

    public function updateProfile(Request $request)
    {
        $idUser = Session('UserId');

        $professional = Session('Professional_' . $idUser);
        $patient = Session('Patient_' . $idUser);

        // Determinar si es un profesional o un paciente y actualizar los datos correspondientes
        if ($professional) {
            $user = Professional::where('Usuarios_idUsuario', $idUser)->first();
        } elseif ($patient) {
            $user = Patient::where('Usuarios_idUsuario', $idUser)->first();
        }

        if ($user) {
            $user->Apellido = $request->apellido;
            $user->Nombre = $request->nombre;
            $user->DNI = $request->dni;
            $user->Generos_idGenero = $request->genero;
            $user->Telefono = $request->telefono;
            $user->Fecha_Nacimiento = $request->fecha_nacimiento;
            $user->Domicilio = $request->domicilio;
            $user->Estados_Civiles_idEstado_Civil = $request->estado_civil;
            $user->Localidades_idLocalidad = $request->localidadProvincia;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Datos actualizados correctamente'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No se pudo actualizar los datos del usuario'
        ]);
    }

    public function updatePassword(ChangePasswordRequest $request)
    {
        $idUser = Session('UserId');

        $user = User::where('idUsuario', $idUser)->first();        

        if($user) {
            $user->Password = $request->new_password;
            $user->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Contraseña actualizada correctamente'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No se pudo actualizar la contraseña del usuario'
        ]);
    }
}
