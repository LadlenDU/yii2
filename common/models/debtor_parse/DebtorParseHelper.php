<?php

namespace common\models\debtor_parse;

class DebtorParseHelper
{
    const MONTHS = [
        'янв' => 1,
        'фев' => 2,
        'мар' => 3,
        'апр' => 4,
        'май' => 5,
        'июн' => 6,
        'июл' => 7,
        'авг' => 8,
        'сен' => 9,
        'окт' => 10,
        'ноя' => 11,
        'дек' => 12,
    ];

    /**
     * Конвертация формата типа "янв.14" в формат MySQL '0000-00-00 00:00:00'
     *
     * @param string $dateRawString
     * @return string
     */
    public static function convertDateFormat_1($dateRawString)
    {
        //TODO: обработка ошибок
        $dateString = false;

        list($month, $year) = explode('.', $dateRawString);
        $monthShortName = mb_substr(trim($month), 0, 3, 'UTF-8');
        $year = '20' . trim($year);
        $monthNumber = isset(DebtorParseHelper::MONTHS[$monthShortName]) ? DebtorParseHelper::MONTHS[$monthShortName] : 1;
        if ($monthNumber < 10) {
            $monthNumber = '0' . $monthNumber;
        }

        $dateString = "$year-$monthNumber-01 00:00:00";

        return $dateString;
    }
}
