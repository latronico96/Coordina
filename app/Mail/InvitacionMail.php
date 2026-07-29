<?php

namespace App\Mail;

use App\Models\Invitacion;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvitacionMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Invitacion $invitacion
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invitación a Coordina',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.invitacion',
            with: [
                'invitacion' => $this->invitacion,
                'url' => route('invitacion.aceptar', $this->invitacion->token),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
