<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `document_1_document_2_fields_from_user_info`.
 */
class m170929_173306_drop_document_1_document_2_fields_from_user_info_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropColumn('user_info', 'document_1');
        $this->dropColumn('user_info', 'document_2');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
    }
}
