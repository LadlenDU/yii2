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
}
