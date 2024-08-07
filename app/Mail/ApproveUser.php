<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApproveUser extends Mailable
{
    use Queueable, SerializesModels;

    public $patient;

    public function __construct($p1)
    {
        $this->patient = $p1;
    }

    public function build()
    {
        return $this->subject('Su cuenta ha sido aprobada!')->view('emails.approveUser');
    }

}
