<?php

namespace App\Mail;

use App\Models\FreelancerProfile;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FreelancerApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public FreelancerProfile $freelancer)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Freelancer Profile Has Been Approved!',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.freelancer-approved',
        );
    }
}
