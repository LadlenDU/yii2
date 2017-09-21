<?php

namespace common\components;

use yii\db\ActiveRecord;
use common\models\Debtor;
use common\models\Court;

class HelpersDebt
{
    /**
     * Найти адрес.
     *
     * @param ActiveRecord $sourceRecord источник адреса
     * @param string $targetModel модель, в которой искать совпадающий адрес
     */
    public static function findCourtAddressForDebtor(ActiveRecord $sourceRecord, $targetModel)
    {
        return $targetModel::find()->one();
    }

    public static function fillInvoiceBlank(Debtor $debtor, Court $court)
    {
        $fileName = \Yii::getAlias('@common/data/sber_pd4.xls');

        $xls = \PHPExcel_IOFactory::load($fileName);
        $xls->setActiveSheetIndex(0);
        $sheet = $xls->getActiveSheet();

        // наименование получателя платежа
        $sheet->setCellValueByColumnAndRow(16, 3, $court->name_of_payee);

        // ИНН получателя платежа
        $sheet->setCellValueByColumnAndRow(16, 5, $court->INN);
        // номер счета получателя платежа
        $sheet->setCellValueByColumnAndRow(36, 5, $court->beneficiary_account_number);

        // наименование банка получателя платежа
        $sheet->setCellValueByColumnAndRow(16, 7, $court->beneficiary_bank_name);
        // БИК
        $sheet->setCellValueByColumnAndRow(52, 7, $court->BIC);

        // Номер кор./сч. банка получателя платежа
        $sheet->setCellValueByColumnAndRow(39, 9, $court->KBK);

        // наименование платежа
        $sheet->setCellValueByColumnAndRow(16, 10, 'Оплата госпошлины');
        // номер лицевого счета (код) плательщика
        $sheet->setCellValueByColumnAndRow(50, 10, $court->OKTMO);

        // Ф.И.О. плательщика
        $sheet->setCellValueByColumnAndRow(26, 12, $debtor->getFIOName());
        // Адрес плательщика
        $sheet->setCellValueByColumnAndRow(26, 13, $debtor->getFullAddress());

        // Сумма платежа
        $sheet->setCellValueByColumnAndRow(24, 14, $debtor->debtDetails[0]->amount);
        // Сумма платы за услуги - ???
        //$sheet->setCellValueByColumnAndRow(50, 14, );

        // Итого
        $sheet->setCellValueByColumnAndRow(20, 15, $debtor->debtDetails[0]->amount);


        header("Expires: Mon, 1 Apr 1974 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=pd4.xls");

        // Выводим содержимое файла
        $objWriter = new \PHPExcel_Writer_Excel5($xls);
        $objWriter->save('php://output');

        exit;
    }
}