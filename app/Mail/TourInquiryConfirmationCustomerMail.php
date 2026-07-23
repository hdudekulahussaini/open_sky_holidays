<?php

namespace App\Mail;

use App\Models\TourInquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TourInquiryConfirmationCustomerMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public TourInquiry $tourInquiry
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'We Received Your Tour Booking Inquiry - Open Sky Holidays',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.tour-inquiry-customer',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
