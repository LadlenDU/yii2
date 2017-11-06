<?php

namespace common\models\debtor_parse;

class Format_csv_1
{
    //TODO: разнести таким образом эти данные
    /*protected static $FIELDS_NAME = [
        'full_name' => [
            'ФИО квартиросъемщика',
        ],
    ];*/

    /**
     * Форматирование "сырого" формата первого csv файла ("2014.csv")
     *
     * @param array $sheetDataRaw
     */
    public static function format(array $sheetDataRaw)
    {
        $sheetData = [];

        $startPart = 0;
        $street = '';
        $building = 0;

        // Дата начисления (accrual)
        $accrualDate = false;

        foreach ($sheetDataRaw as $key => $row) {

            if ($key == 1) {
                $accrualDate = DebtorParseHelper::convertDateFormat_1($row[0]);
            }

            if ($key < 9) {
                continue;
            }

            if ($key == 9) {
                $sheetData[$key] = $row;
                $sheetData[9][3] = 'Входящее сальдо (дебет)';
                $sheetData[9][4] = 'Входящее сальдо (кредит)';
                $sheetData[9][11] = 'Исходящее сальдо (дебет)';
                $sheetData[9][12] = 'Исходящее сальдо (кредит)';
                // Отсутствующие поля
                $sheetData[9][15] = 'Улица';
                $sheetData[9][16] = 'Дом';
                $sheetData[9][17] = 'Дата начисления';
                //$sheetData[9][18] = 'Дата оплаты';
                continue;
            }

            if (!$row[0]) {
                // Начало части "улица-дом"
                $startPart = 1;
                continue;
            }

            // Вычисляем конец части "улица-дом"
            $itogo = mb_strtolower(mb_substr($row[0], 0, 5, 'UTF-8'), 'UTF-8');
            if ($itogo == 'итого') {
                /*if ('Итого по всем домам' == $sheetData[$key][0]) {
                }*/
                continue;
            }

            if ($startPart == 1) {
                list($street, $building) = explode('д.', $row[0]);
                //list($street, $building) = explode('ул.', $sheetData[$key][0]);
                /*$parts = explode('ул.', $sheetData[$key][0]);
                if (empty($parts[1])) {
                }*/
                $street = trim($street);
                $building = trim(str_replace('д.', '', $building));
                $startPart = 2;
                continue;
            }

            $sheetData[$key] = $row;

            // дата
            $sheetData[$key][14] = trim($sheetData[$key][14]);
            if ($sheetData[$key][14]) {
                $sheetData[$key][14] = DebtorParseHelper::convertDateFormat_1($sheetData[$key][14]);
                /*list($month, $year) = explode('.', $sheetData[$key][14]);
                $monthShortName = mb_substr(trim($month), 0, 3, 'UTF-8');
                $year = '20' . trim($year);
                $monthNumber = isset(DebtorParseHelper::MONTHS[$monthShortName]) ? DebtorParseHelper::MONTHS[$monthShortName] : 1;
                if ($monthNumber < 10) {
                    $monthNumber = '0' . $monthNumber;
                }
                //$sheetData[$key][14] = "01.$monthNumber.$year";
                $sheetData[$key][14] = "$year-$monthNumber-01 00:00:00";*/
            }

            $sheetData[$key][15] = $street;
            $sheetData[$key][16] = $building;
            $sheetData[$key][17] = $accrualDate;
        }

        return $sheetData;
    }


}
