<?php

use yii\db\Migration;

/**
 * Handles the creation of table `company_files_houses`.
 */
class m171026_081603_create_company_files_houses_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable(
            'company_files_houses',
            [
                'id' => $this->primaryKey(),
                'content' => 'MEDIUMBLOB',
                'name' => $this->string(),
                'mime_type' => $this->string(),
            ],
            'COMMENT "Файлы компании c обслуживаемыми домами"'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('company_files_houses');
    }
}
