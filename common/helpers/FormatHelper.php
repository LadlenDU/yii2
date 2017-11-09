<?php

namespace common\helpers;

class FormatHelper
{
    public static function roubleKopek($amount)
    {
        $amountFormatted = number_format($amount, 2, '.', ' ');
        list($rouble, $kopek) = explode('.', $amountFormatted);
        return "$rouble руб. $kopek коп.";
    }

    public static function convertDatetimeToTimezone(string $dateTime, string $toTimeZone = 'Europe/Moscow')
    {
        $datetime = new \DateTime($dateTime);
        $tm = new \DateTimeZone($toTimeZone);
        $datetime->setTimezone($tm);
        return $datetime->format('Y-m-d H:i:s');
    }
}
