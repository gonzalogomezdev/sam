<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewMessageNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $idSender; // ID del remitente del mensaje
    public $idAddressee; // ID del destinatario del mensaje
    public $issuer; // Emisor del mensaje

    public function __construct($p1, $p2, $p3)
    {
        $this->idSender = $p1;
        $this->idAddressee = $p2;
        $this->issuer = $p3;
    }

    public function broadcastOn():array
    {
        return ['notification-channel'];
    }

    public function broadcastAs(): string
    {
        return 'notification-event';
    }
}
