<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OfferMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     * OfferMail constructor.
     * @param $name
     * @param $company
     * @param $city
     * @param $phone
     * @param $email
     * @param $materialType
     * @param $thickness
     * @param $sizes
     * @param $weight
     * @param $offerFile
     * @param $body
     */
    public function __construct($name, $company, $city, $phone, $email, $materialType, $thickness, $sizes, $weight, $offerFile, $body)
    {
        $this->name = $name;
        $this->company = $company;
        $this->city = $city;
        $this->phone = $phone;
        $this->email = $email;
        $this->materialType = $materialType;
        $this->thickness = $thickness;
        $this->sizes = $sizes;
        $this->weight = $weight;
        $this->offerFile = $offerFile;
        $this->body = $body;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('no-reply@gulmelet.com')
            ->subject('Yeni Teklif Talebi')
            ->markdown('emails.offer')
            ->with([
                'name' => $this->name,
                'company' => $this->company,
                'city' => $this->city,
                'phone' => $this->phone,
                'email' => $this->email,
                'materialType' => $this->materialType,
                'thickness' => $this->thickness,
                'sizes' => $this->sizes,
                'weight' => $this->weight,
                'body' => $this->body])
            ->attach($this->offerFile, [
                'as' => 'file.'.$this->offerFile->getClientOriginalExtension()
            ]);
    }
}
