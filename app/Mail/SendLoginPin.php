<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendLoginPin extends Mailable
{
    use Queueable, SerializesModels;

    public $pin;

    /**
     * Create a new message instance.
     */
    public function __construct(string $pin)
    {
        $this->pin = $pin;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tu PIN de Acceso para Banco de Bogotá',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.login-pin',
        );
    }
}