<?php

namespace App\Mail;

use App\Models\Booking;
use App\Models\Trip;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class TripCompleted extends Mailable
{
    use Queueable, SerializesModels;

    public string $reviewUrl;

    public function __construct(
        public Booking $booking,
        public Trip    $trip,
        public string  $lang = 'ar',
    ) {
        $this->reviewUrl = URL::signedRoute('review.form', [
            'booking' => $booking->reference,
        ]);
    }

    public function envelope(): Envelope
    {
        $subject = $this->lang === 'ar'
            ? '🌟 كيف كانت رحلتك؟ شاركنا رأيك — ' . $this->trip->getTranslation('title', 'ar')
            : '🌟 How was your trip? Share your experience — ' . $this->trip->getTranslation('title', 'en');

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(view: 'emails.trip-completed');
    }
}
