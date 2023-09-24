<?php

namespace App\Emailers;

use App\AppMail;

class Auth extends AppMail {
    public function __construct($data)
    {
        parent::__construct($data);
    }

    public function onRegister($user){
        $userData = new \stdClass();
        $userData->to = $user->email;
        $userData->toName = $user->email;
        $userData->layout = $this->emailLayout('test.testMail');
        $userData->data = $this->data;
        $userData->subject = $user->email;
        $this->trigger($userData);
        $this->adminLayout = $this->emailLayout('test.adminMail');
        $this->adminSubject = "New User";
    }
}
