<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class QuoteMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     * @param $product
     * @param $name
     * @param $email
     * @param $phone
     * @param $body
     * @return void
     */
    public function __construct($product, $name, $company, $email, $phone, $body)
    {
        $this->product = $product;
        $this->name = $name;
        $this->company = $company;
        $this->email = $email;
        $this->phone = $phone;
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
            ->subject('Teklif Talebi')
            ->markdown('emails.quote')
            ->with(['product' => $this->product, 'name' => $this->name, 'company' => $this->company, 'email' => $this->email, 'phone' => $this->phone, 'body' => $this->body]);
    }
}
