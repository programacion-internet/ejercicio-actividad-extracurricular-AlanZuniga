<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InscripcionConfirmada extends Mailable
{
    use Queueable, SerializesModels;

    public $evento;
    public $user;

    public function __construct($evento, $user)
    {
        $this->evento = $evento;
        $this->user = $user;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Inscripcion confirmada al evento',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.inscripcion-confirmada', 
        );
    }
}