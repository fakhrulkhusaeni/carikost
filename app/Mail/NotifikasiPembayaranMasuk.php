<?php

namespace App\Mail;

use App\Models\Riwayat;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotifikasiPembayaranMasuk extends Mailable
{
    use Queueable, SerializesModels;

    public $riwayat;

    /**
     * Create a new message instance.
     */
    public function __construct(Riwayat $riwayat)
    {
        $this->riwayat = $riwayat;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pembayaran Masuk',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.pembayaran_masuk',
            with: [
                'riwayat' => $this->riwayat
            ]
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
