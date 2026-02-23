<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactThankYou extends Mailable
{
    use Queueable, SerializesModels;

    public $contact;

    /**
     * Create a new message instance.
     */
    public function __construct($contact)
    {
        $this->contact = $contact;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Thank you for contacting me!')
            ->view('emails.contact_thank_you')
            ->with(['contact' => $this->contact]);
    }
}
