<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'Apellido' => 'required',
            'Nombre' => 'required',
            'DNI' => 'required',
            'Email' => [
                'required',
                'Email',
                Rule::unique('Usuarios', 'Email'),
            ],
            'Password' => [
                'required',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
            ],
            'passwordConfirmation' => 'required|same:Password',
        ];
    }

    public function messages()
    {
        return [
            'Password.min' => 'La contraseña debe tener al menos 8 caracteres, incluyendo letras mayúsculas, minúsculas, números y caracteres especiales.',
            'Password.regex' => 'La contraseña debe tener al menos 8 caracteres, incluyendo letras mayúsculas, minúsculas, números y caracteres especiales.',
            'Email.unique' => 'Este correo electrónico ya está registrado.',
            'passwordConfirmation.same' => 'Las contraseñas no coinciden.',
        ];
    }
}
