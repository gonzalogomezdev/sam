<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AppointmentConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $patient;
    public $date;
    public $time;

    public function __construct($p1, $p2, $p3)
    {
        $this->patient = $p1;
        $this->date = $p2;
        $this->time = $p3;
    }

    public function build()
    {
        return $this->subject('Confirmación de turno')->view('emails.appointmentConfirm');
    }
}
