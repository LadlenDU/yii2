<?php

namespace common\models;

use Yii;
use bupy7\pages\models\Page;

/**
 * @property PageTree[] $pageTrees
 * @property Page[] $pages
 */
class Tree extends \kartik\tree\models\Tree
{
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

    protected function linkPage($id)
    {
        if ($id) {
            $page = Page::findOne(['id' => $id]);
            $this->link('pages', $page);
        }
    }

    public function afterSave($insert, $changedAttributes)
    {
        $pageId = Yii::$app->request->post()[$this->getModelName()]['pages'];

        if ($insert) {
            $this->linkPage($pageId);
        } else {
            if (PageTree::find()->where(['tree_id' => $this->id])->exists()) {
                if ($pageId) {
                    PageTree::updateAll(['page_id' => $pageId], ['tree_id' => $this->id]);
                } else {
                    PageTree::deleteAll(['tree_id' => $this->id]);
                }
            } else {
                $this->linkPage($pageId);
            }
        }

        parent::afterSave($insert, $changedAttributes);
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

    public function getModelName()
    {
        $tag = explode("\\", self::className());
        return array_pop($tag);
    }

    /*public function getPage()
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
    }*/
}
