<?php

namespace App\Mail;

use App\Models\Booking;
use App\Models\Trip;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Booking $booking,
        public Trip    $trip,
        public string  $lang = 'ar',
    ) {}

    public function envelope(): Envelope
    {
        $subject = $this->lang === 'ar'
            ? 'تأكيد حجزك — ' . $this->booking->reference
            : 'Booking Confirmed — ' . $this->booking->reference;

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.booking-confirmation',
        );
    }
}
