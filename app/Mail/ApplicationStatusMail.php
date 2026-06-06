<?php

namespace App\Mail;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApplicationStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Application $application,
        public string $status
    ) {}

    public function envelope(): Envelope
    {
        $subject = $this->status === 'lolos'
            ? 'Selamat! Lamaran Anda Lolos Seleksi — PT Nusantara Turbin dan Propulsi'
            : 'Update Status Lamaran — PT Nusantara Turbin dan Propulsi';

        return new Envelope(
            subject: $subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.application_status',
        );
    }
}
