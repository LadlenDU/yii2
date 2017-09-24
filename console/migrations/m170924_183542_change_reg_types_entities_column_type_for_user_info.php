<?php

use yii\db\Migration;

class m170924_183542_change_reg_types_entities_column_type_for_user_info extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('legal_entity', 'user_info_id', $this->integer()->notNull()->unique());
        $this->alterColumn('individual', 'user_info_id', $this->integer()->notNull()->unique());
        $this->alterColumn('individual_entrepreneur', 'user_info_id', $this->integer()->notNull()->unique());
    }

    public function safeDown()
    {
        echo "m170924_183542_change_reg_types_entities_column_type_for_user_info cannot be reverted.\n";

        $this->alterColumn('individual_entrepreneur', 'user_info_id', $this->integer()->notNull());
        $this->alterColumn('individual', 'user_info_id', $this->integer()->notNull());
        $this->alterColumn('legal_entity', 'user_info_id', $this->integer()->notNull());

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170924_183542_change_reg_types_entities_column_type_for_user_info cannot be reverted.\n";

        return false;
    }
    */
}
