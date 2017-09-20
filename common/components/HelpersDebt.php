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

        // наименование получателя
        $sheet->setCellValueByColumnAndRow(16, 3, $court->name);
        // ИНН получателя платежа
        $sheet->setCellValueByColumnAndRow(16, 5, $court->INN);
        // номер счета получателя платежа
        $sheet->setCellValueByColumnAndRow(36, 5, $court->beneficiary_account_number);

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