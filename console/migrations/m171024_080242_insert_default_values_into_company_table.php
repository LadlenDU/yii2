<?php

use yii\db\Migration;

class m171024_080242_insert_default_values_into_company_table extends Migration
{
    public function safeUp()
    {
        $this->execute('ALTER TABLE `company_type` AUTO_INCREMENT=0');
        $this->batchInsert('company_type', ['name'], [
                ['Управляющая компания'],
                ['Товарищество собственников жилья'],
                ['Товарищество собственников недвижимости'],
                ['Жилищно - строительный кооператив'],
                ['Потребительский жилищно - строительный кооператив'],
                ['Жилищный кооператив'],
                ['Жилищно - эксплуатационный потребительский кооператив'],
                ['Даное некоммерческое партнерство'],
                ['Дачное некоммерческое товарищество'],
                ['Садовое некоммерческое партнерство'],
                ['Садовое некоммерческое товарищество'],
                ['Ресурсоснабжающая организация'],
                ['Сервисная организация'],
                ['Аварийно - диспетчерская служба'],
                //['', 'Товарищество собственников недвижимости'],
                //['', 'Жилищно - эксплуатационный потребительский кооператив'],
                ['Совет дома'],
                ['Гаражно - строительный кооператив'],
                ['Потребительский гаражно - строительный кооператив'],
                ['Коттеджно - эксплуатационный потребительский кооператив'],
            ]
        );
    }

    public function safeDown()
    {
        echo "company_type will be cleaned.\n";

        $this->delete('company_type');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171024_080242_insert_default_values_into_company_table cannot be reverted.\n";

        return false;
    }
    */
}
