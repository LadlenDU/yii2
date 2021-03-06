<?php

namespace common\helpers;

use common\models\DebtDetails;
use yii\db\ActiveRecord;
use common\models\Debtor;
use common\models\Court;

class DebtHelper
{
    /**
     * Найти адрес.
     *
     * @param ActiveRecord $sourceRecord источник адреса
     * @param string $targetModel модель, в которой искать совпадающий адрес
     */
    public static function findCourtAddressForDebtor(ActiveRecord $sourceRecord, $targetModel)
    {
        //TODO: раализовать - пока суд не ищет, берет первый попавшийся
        return $targetModel::find()->one();
    }

    /**
     * Найти организацию должника
     *
     * @param ActiveRecord $sourceRecord должник
     * @return mixed
     */
    public static function findCompanyAddressForDebtor(ActiveRecord $sourceRecord)
    {
        //TODO: реализовать - пока организацию не ищет, берет первый попавшийся
        //return \common\models\info\Company::find()->one();
        //TODO: пока будем брать организацию по умолчанию залогиненого пользователя - рассмотреть, может так и надо
        return \Yii::$app->user->identity->userInfo->getPrimaryCompany()->one();

    }

    public static function fillInvoiceBlank(DebtDetails $debtDetails, Court $court, \PHPExcel_Worksheet $sheet)
    {
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
        $sheet->setCellValueByColumnAndRow(26, 12, $debtDetails->debtor->getFIOName());
        // Адрес плательщика
        $sheet->setCellValueByColumnAndRow(26, 13, $debtDetails->debtor->getFullAddress());

        $fee = $debtDetails->calculateStateFee();

        // Сумма платежа
        $sheet->setCellValueByColumnAndRow(24, 14, $fee);
        // Сумма платы за услуги - ???
        //$sheet->setCellValueByColumnAndRow(50, 14, );

        // Итого
        $sheet->setCellValueByColumnAndRow(20, 15, $fee);
    }
}
