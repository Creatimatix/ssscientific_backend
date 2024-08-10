<?php

use Carbon\Carbon;

if (!function_exists('generateQuoteNo')) {
    function generateQuoteNo($category,$id){

        $currentDate = new DateTime();

        if ($currentDate->format('n') < 4) {
            $financialYearStart = (date('Y') - 1) . '-04-01';
            $financialYearEnd = date('Y') . '-03-31';
        } else {
            $financialYearStart = date('Y') . '-04-01';
            $financialYearEnd = (date('Y') + 1) . '-03-31';
        }

        $financialYear = date('y', strtotime($financialYearStart)) . '-' . date('y', strtotime($financialYearEnd));

        return "SSS/".$category.'/'.$id.'/'.$financialYear;
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

