<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatMessageBroadcast implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $idSender; // ID del remitente del mensaje
    public $idAddressee; // ID del destinatario del mensaje
    public $issuer; // Emisor del mensaje
    public $message; // Contenido del mensaje
    public $time; // Hora del mensaje

    // Constructor del evento, recibe los datos del remitente, destinatario y mensaje
    public function __construct($p1, $p2, $p3, $p4, $p5)
    {
        $this->idSender = $p1; // Asigna el ID del remitente
        $this->idAddressee = $p2; // Asigna el ID del destinatario
        $this->issuer = $p3; // Asigna el nombre del emisor (remitente)
        $this->message = $p4; // Asigna el contenido del mensaje
        $this->time = $p5; // Asigna la hora del mensaje
    }

    // Especifica el canal en el que se transmitirá el evento
    public function broadcastOn(): array
    {
        return ['chat-channel'];
    }

    // Especifica el nombre del evento que será transmitido
    public function broadcastAs(): string
    {
        return 'chat-event';
    }
}
?>
