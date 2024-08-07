<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Professional;
use App\Models\Patient;
use App\Models\Message;

use App\Events\ChatMessageBroadcast; 
use App\Events\NewMessageNotification; 
use App\Events\UpdateListUsers; 

class MessageController extends Controller
{
    public function showMessages() 
    {
        $idUser = Session('UserId');
        
        $professional = Session('Professional_' . $idUser);
        $patient = Session('Patient_' . $idUser);

        $listUsers = [];
        $usersWithMessages = collect();

        if ($professional) {
            $listUsers = Patient::where('Roles_idRol', 2) // Rol de paciente
            ->where('Estados_Pacientes_idEstado', 1) // Estado habilitado
            ->get();

            foreach ($listUsers as $user) {
                $userLastMessage = Message::where('Remitente_id', $professional->Usuarios_idUsuario)
                ->where('Destinatario_id', $user->Usuarios_idUsuario) //Usuario actual en el bucle. Por ej: 19
                ->orWhere('Remitente_id', $user->Usuarios_idUsuario)  
                ->Where('Destinatario_id', $professional->Usuarios_idUsuario) 
                ->orderBy('Fecha_Hora', 'desc')
                ->first();

                if ($userLastMessage) {
                    $user->userLastMessage = $userLastMessage->Mensaje;
                    $user->userDateMessage = $userLastMessage->Fecha_Hora;
                } else {
                    $user->userLastMessage = 'Sin mensajes';
                    $user->userDateMessage = null;
                }

                $usersWithMessages->push($user);
            }
        } else if ($patient) {
            $listUsers = Professional::all();

            foreach ($listUsers as $user) {
                $userLastMessage = Message::where('Remitente_id', $patient->Usuarios_idUsuario)
                ->where('Destinatario_id', $user->Usuarios_idUsuario) //Usuario actual en el bucle. Por ej: 19
                ->orWhere('Remitente_id', $user->Usuarios_idUsuario)  
                ->Where('Destinatario_id', $patient->Usuarios_idUsuario) 
                ->orderBy('Fecha_Hora', 'desc')
                ->first();

                if ($userLastMessage) {
                    $user->userLastMessage = $userLastMessage->Mensaje;
                    $user->userDateMessage = $userLastMessage->Fecha_Hora;
                } else {
                    $user->userLastMessage = 'Sin mensajes';
                    $user->userDateMessage = null;
                }

                $usersWithMessages->push($user);
            }
        }

        $usersWithMessages = $usersWithMessages->sortByDesc('userDateMessage');

        return view('dashboards.messaging.messages', compact('idUser', 'patient', 'professional', 'usersWithMessages', 'listUsers'));
    }

    public function getConversation(Request $request)
    {
        $idUser = Session('UserId');
        
        $professional = Session('Professional_' . $idUser);
        $patient = Session('Patient_' . $idUser);

        $idConver = intval($request->input('id')); //intval convierte el valor a entero
        $conver = [];
        
        if ($professional) {
            $conver = Message::where('Remitente_id', $professional->Usuarios_idUsuario)
            ->where('Destinatario_id', $idConver)
            ->orWhere('Remitente_id', $idConver)
            ->where('Destinatario_id', $professional->Usuarios_idUsuario)
            ->get();
            
            if ($conver->isEmpty()) {
                $noMessages = true;
            } else {
                $noMessages = false;
            }

        } else if ($patient) {
            $conver = Message::where('Remitente_id', $patient->Usuarios_idUsuario)
            ->where('Destinatario_id', $idConver)
            ->orWhere('Remitente_id', $idConver)
            ->where('Destinatario_id', $patient->Usuarios_idUsuario)
            ->get();

            if ($conver->isEmpty()) {
                $noMessages = true;
            } else {
                $noMessages = false;
            }
        } 
        
        foreach ($conver as $message) {
            $remitente = User::where('idUsuario', $message->Remitente_id)->first();

            if ($remitente) {
                if($remitente->getProfessional) {
                    $message->userName = $remitente->getProfessional->Nombre;
                } else if ($remitente->getPatient){
                    $message->userName = $remitente->getPatient->Nombre;
                }
            }
        }

        return response()->json(['idConver' => $idConver, 'conver' => $conver, 'noMessages' => $noMessages]);
    }

    public function sendMessage(Request $request)
    {
        $message = Message::create([
            'Mensaje' => $request->input('message'),
            'Fecha_Hora' => now()->toDateTimeString(),
            'Remitente_id' => $request->input('remitenteId'),
            'Destinatario_id' => $request->input('destinatarioId'),
        ]);
        
        // Dispara el evento para actualizar la lista de usuarios
        event(new UpdateListUsers($request->input('remitenteId'), $request->input('destinatarioId'), $request->input('message')));

        // Dispara el evento para notificar al usuario destinatario
        event(new NewMessageNotification($request->input('remitenteId'), $request->input('destinatarioId'), $request->input('issuer')));

        return response()->json(['success' => 'Mensaje guardado correctamente']);
    }

    public function broadcast(Request $request)
    {
        // Obtiene el ID del remitente/emisor (en sesión) desde la solicitud
        $idUser = $request->input('remitenteId');

        // Obtiene el ID del destinatario desde la solicitud
        $idDestinatario = $request->input('destinatarioId');

        // Obtiene el nombre del remitente/emisor desde la solicitud
        $issuer = $request->input('issuer');

        // Obtiene el contenido del mensaje desde la solicitud
        $message = $request->input('message');

        // Obtiene el horario en el que se envio el mensaje desde la solicitud
        $time = $request->input('time');

        // Dispara el evento de difusión del mensaje
        event(new ChatMessageBroadcast($idUser, $idDestinatario, $issuer, $message, $time));

        return response()->json(['success' => 'Mensaje enviado por pusher correctamente']);
    }
}
