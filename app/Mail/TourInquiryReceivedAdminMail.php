<?php

namespace App\Mail;

use App\Models\TourInquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TourInquiryReceivedAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public TourInquiry $tourInquiry
    ) {}

    public function envelope(): Envelope
    {
        $tourTitle = $this->tourInquiry->tour?->title ?? 'Tour Package';

        return new Envelope(
            subject: 'New Tour Booking Inquiry: '.$tourTitle,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.tour-inquiry-admin',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
