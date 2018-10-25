<?php

namespace App\Http\Controllers;


use Mailgun\Mailgun;

class ValidationController extends Controller
{


    public function validateMailgun($email)
    {
        $mgClient = new Mailgun('pubkey-da5143b6b1b19b037ba0fa40935afdad');
        $result = $mgClient->get("address/validate", array('address' => $email));
        return [
            "code" => $result->http_response_code,
            "address" => $result->http_response_body->address,
            "did_you_mean" => $result->http_response_body->did_you_mean,
            "is_valid" => $result->http_response_body->is_valid
        ];
    }
}
