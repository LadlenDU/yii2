<?php

use yii\db\Migration;

/**
 * Handles the creation of table `court`.
 */
class m170919_182456_create_court_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('court', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'address' => $this->string()->comment('адрес - если был указан одной строкой'),
            'district' => $this->string()->comment('район'),
            'districtId' => $this->string()->comment('код района'),
            'city' => $this->string()->comment('город (населённый пункт)'),
            'cityId' => $this->string()->comment('код города (населённого пункта)'),
            'street' => $this->string()->comment('улица'),
            'streetId' => $this->string()->comment('код улицы'),
            'building' => $this->string()->comment('дом (строение)'),
            'buildingId' => $this->string()->comment('код дома (строения)'),
            'phone' => $this->string(),
            'name_of_payee' => $this->string()->comment('наименование получателя платежа'),
            'BIC' => $this->string()->comment('БИК'),
            'beneficiary_account_number' => $this->string()->comment('номер счета получателя платежа'),
            'INN' => $this->string()->comment('ИНН'),
            'KPP' => $this->string()->comment('КПП'),
            'OKTMO' => $this->string()->comment('ОКТМО'),
            'beneficiary_bank_name' => $this->string()->comment('наименование банка получателя платежа'),
            'KBK' => $this->string()->comment('КБК'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('court');
    }
}
