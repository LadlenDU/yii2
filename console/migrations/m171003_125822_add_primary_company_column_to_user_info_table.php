<?php

use yii\db\Migration;

/**
 * Handles adding primary_company to table `user_info`.
 * Has foreign keys to the tables:
 *
 * - `company`
 */
class m171003_125822_add_primary_company_column_to_user_info_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('user_info', 'primary_company', $this->integer());

        // creates index for column `primary_company`
        $this->createIndex(
            'idx-user_info-primary_company',
            'user_info',
            'primary_company'
        );

        // add foreign key for table `company`
        $this->addForeignKey(
            'fk-user_info-primary_company',
            'user_info',
            'primary_company',
            'company',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `company`
        $this->dropForeignKey(
            'fk-user_info-primary_company',
            'user_info'
        );

        // drops index for column `primary_company`
        $this->dropIndex(
            'idx-user_info-primary_company',
            'user_info'
        );

        $this->dropColumn('user_info', 'primary_company');
    }
}
