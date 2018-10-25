<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * ContactMail constructor.
     * Create a new message instance.
     * @param $name
     * @param $email
     * @param $phone
     * @param $department
     * @param $body
     */
    public function __construct($name, $company, $email, $phone, $department, $body)
    {
        $this->name = $name;
        $this->company = $company;
        $this->email = $email;
        $this->phone = $phone;
        $this->department = $department;
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
            ->subject('Web İletişim')
            ->markdown('emails.contact')
            ->with(['name' => $this->name, 'company' => $this->company, 'email' => $this->email, 'phone' => $this->phone, 'department' => $this->department, 'body' => $this->body]);
    }
}
