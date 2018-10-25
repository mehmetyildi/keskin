<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ApplicationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     * ApplicationMail constructor.
     * @param $name
     * @param $email
     * @param $phone
     * @param $position
     * @param $resume
     * @param $body
     */
    public function __construct($name, $email, $phone, $position, $resume, $body)
    {
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->position = $position;
        $this->resume = $resume;
        $this->body = $body;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('no-reply@uzermakina.com')
            ->subject('İş/Staj Başvurusu')
            ->markdown('emails.job')
            ->with(['name' => $this->name, 'email' => $this->email, 'phone' => $this->phone, 'position' => $this->position, 'body' => $this->body])
            ->attach($this->resume, [
                'as' => 'cv.'.$this->resume->getClientOriginalExtension()
            ]);
    }
}
