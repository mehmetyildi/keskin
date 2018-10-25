<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SiteMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     * SiteMail constructor.
     * @param $sender
     * @param $subject
     * @param $body
     */
    public function __construct($sender, $subject, $body)
    {
        $this->sender = $sender;
        $this->subject = $subject;
        $this->body = $body;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->sender)
            ->subject($this->subject)
            ->markdown('emails.site')
            ->with(['body' => $this->body]);
    }
}
