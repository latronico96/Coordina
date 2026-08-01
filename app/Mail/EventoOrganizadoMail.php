<?php

namespace App\Mail;

use App\Models\Asignacion;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EventoOrganizadoMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Asignacion $asignacion
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nueva asignación en Coordina'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.evento-asignado',
            with: [
                'asignacion' => $this->asignacion,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
