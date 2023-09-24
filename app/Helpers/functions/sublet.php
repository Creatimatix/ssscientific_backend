<?php

if(!function_exists('sendMail')){
    function sendMail($class, $data){
        return new $class($data);
    }
}
