<?php

use yii\db\Migration;

/**
 * Handles adding birthday to table `user_info`.
 */
class m170928_095253_add_birthday_column_to_user_info_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('user_info', 'birthday', $this->datetime()->after('location_id'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('user_info', 'birthday');
    }
}
