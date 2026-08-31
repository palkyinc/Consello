<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ComprobanteAprobadoMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $reserva;

    /**
     * Recibe la información del reserva/reserva
     */
    public function __construct($reserva)
    {
        $this->reserva = $reserva;
    }

    /**
     * Asunto del correo
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Comprobante de Transferencia Aprobado - Consello CPM',
        );
    }

    /**
     * Definición de la vista Markdown
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.comprobantes.aprobado',
            with: [
                'reserva' => $this->reserva,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}