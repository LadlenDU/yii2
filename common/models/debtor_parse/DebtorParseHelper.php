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

    const MONTHS_FULL = [
        'январь' => 1,
        'февраль' => 2,
        'март' => 3,
        'апрель' => 4,
        'май' => 5,
        'июнь' => 6,
        'июль' => 7,
        'август' => 8,
        'сенябрь' => 9,
        'октябрь' => 10,
        'ноябрь' => 11,
        'декабрь' => 12,
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

        if (strpos($dateRawString, '.') !== false) {
            list($month, $year) = explode('.', $dateRawString);
        } else {
            list($month, $year) = explode(' ', $dateRawString);
        }
        $month = trim($month);
        $year = trim($year);
        if (strlen($year) == 2) {
            $year = '20' . $year;
        }
        $month = mb_strtolower($month, 'UTF-8');
        if (isset(DebtorParseHelper::MONTHS[$month]) || isset(DebtorParseHelper::MONTHS_FULL[$month])) {
            $monthShortName = mb_strtolower(mb_substr(trim($month), 0, 3, 'UTF-8'), 'UTF-8');
            $monthNumber = DebtorParseHelper::MONTHS[$monthShortName];
        } else {
            $monthNumber = (int)$month;
        }
        if ($monthNumber < 10) {
            $monthNumber = '0' . $monthNumber;
        }

        $dateString = "$year-$monthNumber-01 00:00:00";

        return $dateString;
    }
}
