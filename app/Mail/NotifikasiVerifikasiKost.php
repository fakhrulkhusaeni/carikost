<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotifikasiVerifikasiKost extends Mailable
{
    use Queueable, SerializesModels;

    public $kost;
    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct($kost, $user)
    {
        $this->kost = $kost;
        $this->user = $user;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Hunian Anda Telah Diverifikasi',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.verifikasi_kost',
            with: [
                'kost' => $this->kost,
                'user' => $this->user,
                'facilities' => json_decode($this->kost->facilities, true),
                'rules' => json_decode($this->kost->rules, true),
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments(): array
    {
        return [];
    }
}
