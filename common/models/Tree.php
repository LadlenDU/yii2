<?php

namespace common\models;

use Yii;
use bupy7\pages\models\Page;

/**
 * @property Page $page_mod
 *
 * @property PageTree[] $pageTrees
 * @property Page[] $pages
 */
class Tree extends \kartik\tree\models\Tree
{
    #public $page = null;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tree';
    }

    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['page'] = Yii::t('app', 'Страница');
        return $labels;
    }

    /*public function transactions()
    {
        return [
            #self::SCENARIO_DEFAULT => self::OP_ALL,
            self::SCENARIO_DEFAULT => false,
        ];
    }*/

    /*public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            return true;
        }
        return false;
    }*/

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        #$this->save();

        if (!empty($_POST['Tree']['pages'])) {
            if ($insert) {

                /*$pageTree = new PageTree([
                    'page_id' => $_POST['Tree']['pages'],
                    'tree_id' => $this->id,
                ]);
                $this->link('pageTree', $pageTree);*/

                $command = $this->db->createCommand()->insert('page_tree', [
                    'page_id' => $_POST['Tree']['pages'],
                    'tree_id' => $this->id,
                ]);
                if (!$command->execute()) {
                    return false;
                }

               /* static::getDb()->schema->insert('page_tree', [
                    'page_id' => $_POST['Tree']['pages'],
                    'tree_id' => $this->id,
                ]);*/

                /*$page2tree = new PageTree([
                    'page_id' => $_POST['Tree']['pages'],
                    'tree_id' => $this->id,
                ]);
                $page2tree->save(false);*/
            } else {
                /*PageTree::updateAll(['page_id' => $_POST['Tree']['pages']], ['tree_id' => $this->id]);*/
            }
        }
    }

    /*public function save($runValidation = true, $attributeNames = NULL)
    {
        parent::save($runValidation, $attributeNames);
        $yy = $runValidation;
    }*/

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPageTrees()
    {
        return $this->hasMany(PageTree::className(), ['tree_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPages()
    {
        return $this->hasMany(Page::className(), ['id' => 'page_id'])->viaTable('page_tree', ['tree_id' => 'id']);
    }

    public function getPage()
    {
        #return $this->hasMany(Page::className(), ['id' => 'page_id'])->viaTable('page_tree', ['tree_id' => 'id']);
        //$page = PageTree::find()->select(['page_id'])->where(['id' => 2])->one();
        return $this->hasMany(Page::className(), ['id' => 'page_id'])->viaTable('page_tree', ['tree_id' => 'id']);
    }

    public function getPageTree()
    {
        return $this->hasMany(PageTree::className(), ['page_id' => 'id']);
    }

    public function setPage($id)
    {
        $tt = $id;
    }
}
