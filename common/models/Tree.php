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
    #public $pages;

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

    protected function linkPage($id) {
        $page = Page::findOne(['id' => $id]);
        $this->link('pages', $page);
    }

    public function afterSave($insert, $changedAttributes)
    {
        #parent::afterSave($insert, $changedAttributes);

        if (!empty($_POST['Tree']['pages'])) {

            if ($insert) {

                $this->linkPage(Yii::$app->request->post()[$this->getModelName()]['pages']);

                /*$page = Page::findOne(['id' => Yii::$app->request->post()[$this->getModelName()]['pages']]);
                $this->link('pages', $page);*/

                //Yii::$app->request->post()

                /*$page = Page::findOne(['id' => $_POST['Tree']['pages']]);
                #$page->save();
                $this->link('pages', $page);*/

               /* $userGroup = new PageTree();
                // load data from form into $userGroup and validate
                if ($userGroup->load(Yii::$app->request->post()) && $userGroup->validate()) {
                    // all data in $userGroup is valid
                    // --> create item in junction table incl. additional data
                    $this->link('pages', $page, $userGroup->getDirtyAttributes());
                }*/

                /*$pageTree = new PageTree([
                    'page_id' => $_POST['Tree']['pages'],
                    'tree_id' => $this->id,
                ]);
                $this->link('pageTrees', $pageTree);*/

                /*//TODO: тупой костыль-рассмотреть link()
                $command = $this->db->createCommand()->insert('page_tree', [
                    'page_id' => $_POST['Tree']['pages'],
                    'tree_id' => $this->id,
                ]);
                $command->execute();*/
            } else {
                /*PageTree::updateAll(['page_id' => $_POST['Tree']['pages']], ['tree_id' => $this->id]);*/
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
        return __CLASS__;
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
