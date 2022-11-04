<?php
namespace App\Services;

use Carbon\Carbon;

class ThaiDateFormat
{
    public static function DateFormat($arg)
    {
        $thai_months = [
            1 => 'ม.ค.',
            2 => 'ก.พ.',
            3 => 'มี.ค.',
            4 => 'เม.ย.',
            5 => 'พ.ค.',
            6 => 'มิ.ย.',
            7 => 'ก.ค.',
            8 => 'ส.ค.',
            9 => 'ก.ย.',
            10 => 'ต.ค.',
            11 => 'พ.ย.',
            12 => 'ธ.ค.',
        ];
        $date = Carbon::parse($arg);
        $months = $thai_months[$date->month];
        $month = $date->month;
        $year = $date->year + 543;
        return $date->format("j/$month/$year - H:i");
    }
}
