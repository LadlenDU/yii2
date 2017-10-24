<?php

use yii\db\Migration;

/**
 * Handles adding next_some to table `company`.
 * Has foreign keys to the tables:
 *
 * - `location`
 */
class m171024_103840_add_next_some_columns_to_company_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('company', 'site', $this->text()->comment('Сайт')->after('email'));
        $this->addColumn('company', 'postal_address_location_id', $this->integer()->comment('Юридический адрес')->after('legal_address_location_id'));
        $this->addColumn('company', 'OGRN_IP_number', $this->string()->comment('Номер ОГРН / ОГРНИП')->after('OGRN_IP_type'));
        $this->addColumn('company', 'OGRN_IP_date', $this->datetime()->comment('Дата ОГРН / ОГРНИП')->after('OGRN_IP_number'));
        $this->addColumn('company', 'OGRN_IP_registered_company', $this->string()->comment('Наименование зарегистрировавшей организации ОГРН / ОГРНИП')->after('OGRN_IP_date'));

        // creates index for column `postal_address_location_id`
        $this->createIndex(
            'idx-company-postal_address_location_id',
            'company',
            'postal_address_location_id'
        );

        // add foreign key for table `location`
        $this->addForeignKey(
            'fk-company-postal_address_location_id',
            'company',
            'postal_address_location_id',
            'location',
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
            'fk-company-postal_address_location_id',
            'company'
        );

        // drops index for column `postal_address_location_id`
        $this->dropIndex(
            'idx-company-postal_address_location_id',
            'company'
        );

        $this->dropColumn('company', 'site');
        $this->dropColumn('company', 'postal_address_location_id');
        $this->dropColumn('company', 'OGRN_IP_number');
        $this->dropColumn('company', 'OGRN_IP_date');
        $this->dropColumn('company', 'OGRN_IP_registered_company');
    }
}
