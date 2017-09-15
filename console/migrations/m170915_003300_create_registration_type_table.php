<?php

use yii\db\Migration;

/**
 * Handles the creation of table `registration_type`.
 */
class m170915_003300_create_registration_type_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('registration_type', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'short_name' => $this->string(10),
            'table_name' => $this->string(40)->comment('Таблица в БД с информацией.'),
        ]);

        $this->batchInsert('registration_type', ['name', 'short_name', 'table_name'],
            [
                ['юридическое лицо', 'ЮЛ', 'legal_entity'],
                ['индивидуальный предприниматель', 'ИП', 'individual_entrepreneur'],
                ['физическое лицо', 'ФЛ', 'individual']
            ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->delete('registration_type', ['id' => [1, 2, 3]]);
        $this->dropTable('registration_type');
    }
}
