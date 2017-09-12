<?php

use yii\db\Migration;

/**
 * Handles the creation of table `page_tree`.
 * Has foreign keys to the tables:
 *
 * - `page`
 * - `tree`
 */
class m170912_083845_create_junction_table_for_page_and_tree_tables extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('page_tree', [
            'page_id' => $this->integer(),
            'tree_id' => $this->bigInteger(),
            'PRIMARY KEY(page_id, tree_id)',
        ]);

        // creates index for column `page_id`
        $this->createIndex(
            'idx-page_tree-page_id',
            'page_tree',
            'page_id'
        );

        // add foreign key for table `page`
        $this->addForeignKey(
            'fk-page_tree-page_id',
            'page_tree',
            'page_id',
            'page',
            'id',
            'CASCADE'
        );

        // creates index for column `tree_id`
        $this->createIndex(
            'idx-page_tree-tree_id',
            'page_tree',
            'tree_id'
        );

        // add foreign key for table `tree`
        $this->addForeignKey(
            'fk-page_tree-tree_id',
            'page_tree',
            'tree_id',
            'tree',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `page`
        $this->dropForeignKey(
            'fk-page_tree-page_id',
            'page_tree'
        );

        // drops index for column `page_id`
        $this->dropIndex(
            'idx-page_tree-page_id',
            'page_tree'
        );

        // drops foreign key for table `tree`
        $this->dropForeignKey(
            'fk-page_tree-tree_id',
            'page_tree'
        );

        // drops index for column `tree_id`
        $this->dropIndex(
            'idx-page_tree-tree_id',
            'page_tree'
        );

        $this->dropTable('page_tree');
    }
}
