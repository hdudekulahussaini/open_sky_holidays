<?php

namespace App\Mail;

use App\Models\Enquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EnquiryConfirmationCustomerMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Enquiry $enquiry
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'We Received Your Travel Enquiry - Open Sky Holidays',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.enquiry-customer',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
