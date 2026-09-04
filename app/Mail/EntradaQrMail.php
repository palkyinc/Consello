<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Reserva;

class EntradaQrMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $qrCode; // Variable para almacenar el código QR
    
    /**
     * Create a new message instance.
     */
    public function __construct(Reserva $reserva)
    {
        // En tu Mailable EntradaQrMail.php
        $this->qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')
            ->size(250)
            ->generate($reserva->ticket_code); // Generar el código QR
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Entrada Qr Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.entrada-qr-mail',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
