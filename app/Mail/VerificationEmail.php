<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class VerificationEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $verification_code;
    /**
     * Create a new message instance.
     */
    public function __construct(User $user, $verification_code)
    {
        $this->user = $user;
        $this->verification_code = $verification_code;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Konfirmasi Email',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.auth.verification-email',
            with: [
                'user' => $this->user,
                'verification_code' => $this->verification_code,
            ],
        );
    }
}
