<?php

namespace App\Emailers;

use App\AppMail;

class Quote extends AppMail {
    public function __construct($data)
    {
        parent::__construct($data);
    }

    public function sendQuote($customer, $attachment, $type = 'customer', $quotes = null){
        $userData = new \stdClass();
        $userData->to = $customer->email;
        $userData->toName = $this->makeName($customer);
        if($type == 'customer'){
            $userData->layout = $this->emailLayout('quotes.userQuote');
        }
        $userData->data = $this->data;
        $userData->subject = 'Quote Request of - '.$quotes->quote_no;
        $userData->attachData = $attachment;
        $this->trigger($userData);
        if($type == 'customer'){
            $this->adminLayout = $this->emailLayout('quotes.adminQuote');
            $this->adminParams['attachData'] =  $attachment;
            $this->adminSubject = "Proposal Request of ".$customer->full_name;
        }
    }
}
