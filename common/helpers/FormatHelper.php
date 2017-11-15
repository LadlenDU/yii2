<?php

namespace common\helpers;

class FormatHelper
{
    public static function roubleKopek($amount): string
    {
        $amountFormatted = number_format($amount, 2, '.', ' ');
        list($rouble, $kopek) = explode('.', $amountFormatted);
        return "$rouble руб. $kopek коп.";
    }

    public static function convertDatetimeToTimezone(string $dateTime, string $toTimeZone = 'Europe/Moscow'): string
    {
        $datetime = new \DateTime($dateTime);
        $tm = new \DateTimeZone($toTimeZone);
        $datetime->setTimezone($tm);
        return $datetime->format('Y-m-d H:i:s');
    }

    /**
     * Приветсти дату типа '2014-09-07 15:12:17' к началу первого дня - '2014-09-01 00:00:00'
     */
    public static function setDateToMonthStart(string $date): string
    {
        return substr($date, 0, 8) . '01 00:00:00';
    }

    /**
     * Добавить к дате типа '2014-09-07 15:12:17' строковый интервал типа '1 month'
     *
     * @param string $datetime
     * @param string $interval строковый интервал (напр. '1 month')
     * @return string
     */
    public static function addIntervalToDateTimeString(string $datetime, string $interval): string
    {
        $intervalObj = date_interval_create_from_date_string($interval);
        $dateTimeObj = date_create($datetime);
        if (!$dateTimeObj) {
            return '0000-00-00 00:00:00';
        }
        $dateTimeObj = date_add($dateTimeObj, $intervalObj);
        return $dateTimeObj->format('Y-m-d H:i:s');
    }
}
