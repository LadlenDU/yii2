<?php

use yii\db\Migration;

/**
 * Handles adding document_1 to table `user_info`.
 */
class m170926_132409_add_document_1_column_to_user_info_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('user_info', 'document_1', $this->binary());
        $this->addColumn('user_info', 'document_2', $this->binary());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('user_info', 'document_1');
        $this->dropColumn('user_info', 'document_2');
    }
}
