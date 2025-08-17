<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactNotification extends Mailable
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
        return $this->subject('New contact message from ' . ($this->contact->name ?? 'Website'))
                    ->view('emails.contact_notification')
                    ->with(['contact' => $this->contact]);
    }
}
