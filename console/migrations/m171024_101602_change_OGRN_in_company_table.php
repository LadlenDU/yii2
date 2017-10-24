<?php

use yii\db\Migration;

class m171024_101602_change_OGRN_in_company_table extends Migration
{
    public function safeUp()
    {
        $this->dropColumn('company', 'OGRN');
        $this->addColumn('company', 'OGRN_IP_type', $this->integer()->unsigned()->comment('comment("Тип: ОГРН(0) или ОГРНИП(1)')->after('BIK'));
    }

    public function safeDown()
    {
        echo "m171024_101602_change_OGRN_in_company_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171024_101602_change_OGRN_in_company_table cannot be reverted.\n";

        return false;
    }
    */
}
