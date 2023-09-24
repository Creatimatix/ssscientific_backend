<?php

use Carbon\Carbon;

if (!function_exists('generateQuoteNo')) {
    function generateQuoteNo($id){
        return "Quote-".time().'-'.$id;
    }
}

function status($type = null){
    $arr = [
        1 => "Active",
        2 => "Inactive",
    ];

    if($type){
        return $arr[$type];
    }
}


if (!function_exists('getFinancialYear')) {
    function getFinancialYear($date = null)
    {
        if(!$date){
            $date = date('Y-m-d');
        }
        $carbonDate = Carbon::parse($date);
        $year = $carbonDate->year;

        // Check if the given date is before or on March 31
        if ($carbonDate->month <= 3 && $carbonDate->day <= 31) {
            $year--;
        }

        $startYear = $year;
        $endYear = $year + 1;

        $start = Carbon::createFromDate($startYear, 4, 1);
        $end = Carbon::createFromDate($endYear, 3, 31);

        return substr($start->format('Y'), -2).' - ' .substr($end->format('Y'), -2);
    }
}
