<?php

use yii\db\Migration;

/**
 * Handles the creation of table `application_package_to_the_contract`.
 */
class m171113_192552_create_application_package_to_the_contract_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('application_package_to_the_contract', [
            'id' => $this->primaryKey(),
            'number' => $this->integer()->unsigned()->notNull()->comment('Номер по порядку'),
            'name' => $this->string()->notNull()->comment('Название пакета приложений'),
        ],
            'COMMENT "Пакет договоров оказания юридических услуг"'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('application_package_to_the_contract');
    }
}
