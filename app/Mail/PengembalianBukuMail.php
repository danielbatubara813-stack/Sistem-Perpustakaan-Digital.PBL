<?php

namespace App\Mail;

use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PengembalianBukuMail extends Mailable
{
    use SerializesModels;

    public $pengembalian;

    public function __construct($pengembalian)
    {
        $this->pengembalian = $pengembalian;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Konfirmasi Pengembalian Buku',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.pengembalian-buku',
        );
    }
}