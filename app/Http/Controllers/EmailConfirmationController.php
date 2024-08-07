<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class EmailConfirmationController extends Controller
{
    public function verifyEmail($token)
    {
        $usuario = User::where('Token', $token)->first();

        if ($usuario) {
            $usuario->update(['Email_verified' => true]);
            $usuario->update(['Token' => null]);
        }
    }
}
