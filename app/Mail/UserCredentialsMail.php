<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserCredentialsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $sub;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $sub)
    {
        $this->data = $data;
        $this->sub = $sub;

    }

    /**
     * Get the message envelope instance.
     *
     * @return \Illuminate\Mail\Mailables\Envelope|null
     */
    public function envelope(): ?Envelope
    {
        return new Envelope(
            subject: $this->sub
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.user_credentials'
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
