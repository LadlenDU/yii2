<?php

namespace common\components;

use yii\db\ActiveRecord;
use common\models\Debtor;
use common\models\Court;
use moonland\phpexcel\Excel;
use arogachev\excel\import\basic\Importer;

#use PHPExcel;

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

        #$data = Excel::import($fileName);

        $xls = \PHPExcel_IOFactory::load($fileName);
        $xls->setActiveSheetIndex(0);
        $sheet = $xls->getActiveSheet();

        //$sheet->setCellValue('R3C17', 'Это тестовый текст');
        $sheet->setCellValueByColumnAndRow(16, 3, 'Это тестовый текст55');
        //$sheet->setCellValueByColumnAndRow(0, 1, 'Это 12345');

        /*header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
        header("Content-Disposition: attachment; filename=pd4.xls");  //File name extension was wrong
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private",false);*/

        header("Expires: Mon, 1 Apr 1974 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=pd4.xls");

        // Выводим содержимое файла
        $objWriter = new \PHPExcel_Writer_Excel5($xls);
        $objWriter->save('php://output');


        #print_r($sheet);

        exit;
    }
}