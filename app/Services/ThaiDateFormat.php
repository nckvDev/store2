<?php
namespace App\Services;

use Carbon\Carbon;

class ThaiDateFormat
{
    public static function DateFormat($arg)
    {
        $date = Carbon::parse($arg);
        $month = $date->month;
        $year = $date->year + 543;
        return $date->format("j/$month/$year - H:i");
    }

    public static function DateThaiFormat($arg)
    {
        $thai_months = [
            1 => 'มกราคม',
            2 => 'กุมภาพันธ์',
            3 => 'มีนาคม',
            4 => 'เมษายน',
            5 => 'พฤษภาคม',
            6 => 'มิถุนายน',
            7 => 'กรกฎาคม',
            8 => 'สิงหาคม',
            9 => 'กันยายน',
            10 => 'ตุลาคม',
            11 => 'พฤศจิกายน',
            12 => 'ธันวาคม',
        ];
        $date = Carbon::parse($arg);
        $months = $thai_months[$date->month];
        $year = $date->year + 543;
        return $date->format("j $months $year เวลา H:i");
    }
}
