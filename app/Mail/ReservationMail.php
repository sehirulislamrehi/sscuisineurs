<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ReservationMail extends Mailable
{
    use Queueable, SerializesModels;
    public $reservation;

    /** 
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($reservation, $subject)
    {
        $this->reservation=$reservation;
        $this->subject($subject);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.reservation',['resarvation' => $this->reservation]);
    }
}