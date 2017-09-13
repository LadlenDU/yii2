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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPageTrees()
    {
        //TODO: hasOne ???
        return $this->hasMany(PageTree::className(), ['tree_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPages()
    {
        //TODO: hasOne ??? page_tree - get table name from the class ??? PageTree::className()
        return $this->hasMany(Page::className(), ['id' => 'page_id'])->viaTable('page_tree', ['tree_id' => 'id']);
    }

    public function getModelName()
    {
        $tag = explode("\\", self::className());
        return array_pop($tag);
    }

    public static function find()
    {
        $query = parent::find();
        $nmActive = static::tableName() . '.active';
        $nmDisabled = static::tableName() . '.disabled';
        //TODO: переписать
        $query->andWhere("$nmActive IS NOT NULL AND $nmActive > 0 AND ($nmDisabled IS NULL OR $nmDisabled = 0)");
        return $query;
    }

    public static function getElementsByLevel($level = 0)
    {
        $levelName = 'lvl';   //TODO: consider treeStructure['depthAttribute'], what to do with table names in ['tree.id', 'tree.name', 'page.alias'] ???
        $elements = static::find()->joinWith('pages')->andWhere([$levelName => $level])
            ->select(['tree.id', 'tree.name', 'page.alias'])->all();

        return $elements;
    }
}
