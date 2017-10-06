<?php

namespace frontend\modules\office\controllers;

use Yii;
use common\models\Debtor;
use common\models\DebtorSearch;
use common\models\Location;
use common\models\Name;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DebtorController implements the CRUD actions for Debtor model.
 */
class DebtorController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Debtor models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DebtorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Debtor model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Debtor model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Debtor();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $locationModel = Location::find()->where(['location_id' => $this->location->id])->one();
            $locationModel->link('location', $model);

            $nameModel = Name::find()->where(['name_id' => $this->name->id])->one();
            $nameModel->link('name', $model);

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Debtor model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if (!$model->location) {

            }
            //$locationModel = Location::find()->where(['location_id' => $this->location->id])->one();
            $locationModel = $model->location ? $model->location : new Location;
            //TODO: проверить
            $locationModel->save();
            $locationModel->link('debtors', $model);

            //$nameModel = Name::find()->where(['name_id' => $this->name->id])->one();
            $nameModel = $model->name ? $model->name : new Name;
            //TODO: проверить
            $nameModel->save();
            $nameModel->link('debtors', $model);

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Debtor model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Debtor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Debtor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Debtor::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
