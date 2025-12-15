<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeNewUser extends Mailable
{
    use Queueable, SerializesModels;

    public $userName;
    public $userEmail;
    public $password;
    public $role;

    public function __construct($userName, $userEmail, $password, $role)
    {
        $this->userName = $userName;
        $this->userEmail = $userEmail;
        $this->password = $password;
        $this->role = $role;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome to CLPIS - Your Account Has Been Created',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.welcome-new-user',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
