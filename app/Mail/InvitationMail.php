<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     * InvitationMail constructor.
     * @param $name
     * @param $token
     */
    public function __construct($name, $token)
    {
        $this->name = $name;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('no-reply@piyetra.com')
            ->subject('Piyetra CMS Davetiyeniz')
            ->markdown('emails.invitation')
            ->with(['name' => $this->name, 'token' => $this->token]);
    }
}
