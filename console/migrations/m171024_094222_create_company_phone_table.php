<?php

use yii\db\Migration;

/**
 * Handles the creation of table `company_phone`.
 * Has foreign keys to the tables:
 *
 * - `company`
 */
class m171024_094222_create_company_phone_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('company_phone', [
            'id' => $this->primaryKey(),
            'company_id' => $this->integer()->notNull(),
            'phone' => $this->string()->notNull(),
        ]);

        // creates index for column `company_id`
        $this->createIndex(
            'idx-company_phone-company_id',
            'company_phone',
            'company_id'
        );

        // add foreign key for table `company`
        $this->addForeignKey(
            'fk-company_phone-company_id',
            'company_phone',
            'company_id',
            'company',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-unique-company_id-phone-company_phone',
            'company_phone',
            'company_id, phone',
            1
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropIndex(
            'idx-unique-company_id-phone-company_phone',
            'company_phone'
        );

        // drops foreign key for table `company`
        $this->dropForeignKey(
            'fk-company_phone-company_id',
            'company_phone'
        );

        // drops index for column `company_id`
        $this->dropIndex(
            'idx-company_phone-company_id',
            'company_phone'
        );

        $this->dropTable('company_phone');
    }
}
