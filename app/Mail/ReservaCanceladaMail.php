<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReservaCanceladaMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public array $reservaData;

    public function __construct(array $reservaData)
    {
        $this->reservaData = $reservaData;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Cancelación de reserva por falta de pago',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.reserva-cancelada',
        );
    }
}