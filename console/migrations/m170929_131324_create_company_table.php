<?php

use yii\db\Migration;

/**
 * Handles the creation of table `company`.
 * Has foreign keys to the tables:
 *
 * - `location`
 * - `location`
 * - `name`
 */
class m170929_131324_create_company_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('company', [
            'id' => $this->primaryKey(),
            'full_name' => $this->string()->notNull(),
            'short_name' => $this->string(),
            'legal_address_location_id' => $this->integer()->comment('юридический адрес'),
            'actual_address_location_id' => $this->integer()->comment('фактический адрес'),
            'INN' => $this->string()->comment('ИНН'),
            'KPP' => $this->string()->comment('КПП'),
            'BIK' => $this->string()->comment('БИК'),
            'OGRN' => $this->string()->comment('ОГРН'),
            'checking_account' => $this->string()->comment('расчетный счет'),
            'correspondent_account' => $this->string()->comment('корреспондентский счет'),
            'full_bank_name' => $this->string()->comment('полное наименование банка'),
            'CEO' => $this->integer()->comment('генеральный директор'),
            'operates_on_the_basis_of' => $this->string()->comment('действует на основании'),
            'phone' => $this->string()->comment('телефон'),
            'fax' => $this->string()->comment('факс'),
            'email' => $this->string()->comment('e-mail'),
        ]);

        // creates index for column `legal_address_location_id`
        $this->createIndex(
            'idx-company-legal_address_location_id',
            'company',
            'legal_address_location_id'
        );

        // add foreign key for table `location`
        $this->addForeignKey(
            'fk-company-legal_address_location_id',
            'company',
            'legal_address_location_id',
            'location',
            'id',
            'CASCADE'
        );

        // creates index for column `actual_address_location_id`
        $this->createIndex(
            'idx-company-actual_address_location_id',
            'company',
            'actual_address_location_id'
        );

        // add foreign key for table `location`
        $this->addForeignKey(
            'fk-company-actual_address_location_id',
            'company',
            'actual_address_location_id',
            'location',
            'id',
            'CASCADE'
        );

        // creates index for column `CEO`
        $this->createIndex(
            'idx-company-CEO',
            'company',
            'CEO'
        );

        // add foreign key for table `name`
        $this->addForeignKey(
            'fk-company-CEO',
            'company',
            'CEO',
            'name',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `location`
        $this->dropForeignKey(
            'fk-company-legal_address_location_id',
            'company'
        );

        // drops index for column `legal_address_location_id`
        $this->dropIndex(
            'idx-company-legal_address_location_id',
            'company'
        );

        // drops foreign key for table `location`
        $this->dropForeignKey(
            'fk-company-actual_address_location_id',
            'company'
        );

        // drops index for column `actual_address_location_id`
        $this->dropIndex(
            'idx-company-actual_address_location_id',
            'company'
        );

        // drops foreign key for table `name`
        $this->dropForeignKey(
            'fk-company-CEO',
            'company'
        );

        // drops index for column `CEO`
        $this->dropIndex(
            'idx-company-CEO',
            'company'
        );

        $this->dropTable('company');
    }
}
