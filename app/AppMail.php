<?php

namespace App;

use App\Models\User;
use Illuminate\Support\Facades\Mail;

class AppMail extends Mail {
    protected $adminEmail = null;
    protected $adminName = null;
    public  $environment = null;
    protected $data = null;
    protected $adminParams = [];
    protected $adminLayout = null;
    protected $adminSubject = null;
    protected $testEmail = null;
    protected $testName = null;

    public function __construct($data)
    {
        $this->data = $data;
        $this->adminEmail = env('ADMIN_EMAIL', 'ssscientific0715@gmail.com');
        $this->adminName = env('ADMIN_EMAIL_NAME', 'Ssscientific');
        $this->environment = env('EMAIL_ENV', 'test');
        $this->testEmail = env('TEST_EMAIL', 'ssscientific0715@gmail.com');
        $this->testName = env('TEST_EMAIL_NAME', 'SS SCIENTIFIC');
    }

    public function testMail($email){
        $customerData = new \stdClass();
        $customerData->to = $email;
        $customerData->toName = "Email Test";
        $customerData->layout = 'emails.test';
        $customerData->data = $this->data;
        $customerData->subject = 'Test Email';
        $this->trigger($customerData);
        $this->adminLayout = 'emails.test';
        $this->adminSubject = "Test Subject";
    }

    protected function trigger($params){
        $to = $params->to;
        $toName = $params->toName;
        $subject = "SS Scientific - ". $params->subject;

        if($this->environment == 'local' || $this->environment == 'dev'){
            $to = $this->testEmail;
            $toName = $this->testName;

            $subject = '[Admin Ignore] SS Scientific - '. $params->subject;
            if(is_array($to)){

            }else{
                $toemail = $to;
                $to = [];
                $to[] = $toemail;
            }
        }

        $user = User::where("email", $params->to)->get()->first();

        if($user){
//            if(1 == User::UNSUBSCRIBE_EMAIL){
//                return false;
//            }
        }
        return parent::send($params->layout, $params->data, function ($message) use ($to, $toName, $subject, $params){
            if(isset($params->replyTo) && $params->replyTo != ''){
                $message->replyTo($params->replyTo, $params->replyToName);
            }

            if(isset($params->from) && $params->from != ''){
                $message->from($params->from, "SS Scientific");
            }

            if(is_array($to)){
                $message->to($to)
                    ->bcc('creatimatix@gmail.com')
                    ->subject($subject);
            }else{
                $message->to($to, $toName)
                    ->bcc('creatimatix@gmail.com')
                    ->subject($subject);
            }

            if(!empty($params->cc)){
                $message->cc($params->cc);
            }

            if(isset($params->attachments) && $params->attachments != ''){
                foreach($params->attachments as $attach){
                    $message->attach($attach);
                }
            }
//            if(!empty($params->attachData)) {
//                foreach($params->attachData as $attach){
//                    $message->attachData($attach['data'], $attach['name']);
//                }
//            }
            if (!empty($params->attachData) && is_array($params->attachData)) {
                foreach ($params->attachData as $attach) {
                    $message->attachData($attach['data'], $attach['name']);
                }
            }
        });
    }

    public function __destruct(){
        if($this->adminLayout !== ''){
            $to = $this->adminEmail;
            $toName = $this->adminName;
            $subject = trim($this->adminSubject) == ''? 'SS Scientific - Admin Copy': $this->adminSubject;

            if($this->environment == 'local' || $this->environment == 'dev'){
                $to = $this->testEmail;
                $toName = $this->testName;
                $subject = (trim($this->adminSubject) == '') ? 'Admin Copy': $this->adminSubject;
                $subject = '[Admin Ignore] SS Scientific - '. $subject;
            }

            parent::send($this->adminLayout, $this->data, function ($message) use ($to, $toName, $subject){
               if(array_key_exists('replyTo', $this->adminParams)){
                   $message->replyTo($this->adminParams['replyTo'], $this->adminParams['replyToName']);
               }

               if(trim($this->environment) == 'production'){
                   if(array_key_exists('toops', $this->adminParams)){
                       if(is_array($to)){
                           $to[] = 'ssscientific0715@gmail.com';
                       }else{
                           $toemail = $to;
                           $to = [];
                           $to[] = $toemail;
                           $to[] = 'ssscientific0715@gmail.com';
                       }
                   }
               }
                if(is_array($to)){
                    $message->to($to)
                        ->from('noreply@ssscientific.net')
                        ->subject($subject);
                }else{
                    $message->to($to)
                        ->from('noreply@ssscientific.net', $this->adminName)
                        ->subject($subject);
                }

                if(array_key_exists('attachments', $this->adminParams)){
                    foreach ($this->adminParams['attachments'] as $attach){
                        $message->attach($attach);
                    }
                }

                if(array_key_exists('attachData', $this->adminParams)){
                    foreach ($this->adminParams['attachData'] as $attach){
                        $message->attachData($attach['data'], $attach['name']);
                    }
                }
            });
        }
    }

    protected function makeName($subjectObject){
        return trim(implode(' ', array_filter([$subjectObject->first_name, $subjectObject->last_name])));
    }

    protected function apiLayout($layout){
        return 'emails.api.'.$layout;
    }

//    protected function emailLayout($layout){
//        return 'email.admin.'.$layout;
//    }

    protected function emailLayout($layout){
        return 'emails.'.$layout;
    }
}
