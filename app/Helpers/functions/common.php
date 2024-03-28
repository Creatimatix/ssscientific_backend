<?php


if (!function_exists('__date')) {

    /**
     * Return readable date from timestamp
     *
     * @param integer|float $timestamp specify timestamp
     * @return mixed returns clean number after removing decimal
     */
    function __date($timestamp, $format = 'F d, Y') {
        return date($format, $timestamp);
    }

}

if (!function_exists('__datetime')) {

    /**
     * Return readable date from timestamp
     *
     * @param integer|float $timestamp specify timestamp
     * @return mixed returns clean number after removing decimal
     */
    function __datetime($timestamp, $format = 'F d, Y h:i:s a') {
        return date($format, $timestamp);
    }
}


if(!function_exists('sendMail')){
    function sendMail($class, $data){
        return new $class($data);
    }
}
if(!function_exists('slug')){
    function slug($string) {
        return preg_replace(
            array('/\s+/', '/[^\w\-]+/', '/\-\-+/', '/^-+/', '/-+$/'),
            array('-', '', '-', '', ''),
            trim(strtolower($string))
        );
    }
}
