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


function priceToWords($price) {
    $ones = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine'];
    $tens = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];
    $teens = ['Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'];
    $scales = ['', 'Thousand', 'Million', 'Billion', 'Trillion'];

    if ($price == 0) {
        return 'Zero Only';
    }

    $price = round($price, 2);
    $wholePart = floor($price);
    $fractionalPart = round(($price - $wholePart) * 100);

    $words = [];

    for ($i = 0; $wholePart > 0; $i++) {
        if ($wholePart % 1000 != 0) {
            $chunk = [];
            $hundreds = floor(($wholePart % 1000) / 100);
            $tensAndOnes = $wholePart % 100;

            if ($hundreds > 0) {
                $chunk[] = $ones[$hundreds];
                $chunk[] = 'Hundred';
            }

            if ($tensAndOnes >= 20) {
                $chunk[] = $tens[floor($tensAndOnes / 10)];
                if ($tensAndOnes % 10 > 0) {
                    $chunk[] = $ones[$tensAndOnes % 10];
                }
            } elseif ($tensAndOnes >= 10) {
                $chunk[] = $teens[$tensAndOnes - 10];
            } elseif ($tensAndOnes > 0) {
                $chunk[] = $ones[$tensAndOnes];
            }

            if ($i > 0 && count($chunk) > 0) {
                $chunk[] = $scales[$i];
            }

            $words = array_merge($chunk, $words);
        }
        $wholePart = floor($wholePart / 1000);
    }

    $result = implode(' ', $words);

    if ($fractionalPart > 0) {
        $result .= ' And';
        if ($fractionalPart >= 20) {
            $result .= ' ' . $tens[floor($fractionalPart / 10)];
            if ($fractionalPart % 10 > 0) {
                $result .= ' ' . $ones[$fractionalPart % 10];
            }
        } elseif ($fractionalPart >= 10) {
            $result .= ' ' . $teens[$fractionalPart - 10];
        } else {
            $result .= ' ' . $ones[$fractionalPart];
        }
        $result .= ' Cents';
    }

    return $result . ' Only';
}
