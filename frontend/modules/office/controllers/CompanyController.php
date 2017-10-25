<?php

namespace frontend\modules\office\controllers;

use common\helpers\FileUploadHelper;
use Yii;
use common\models\info\Company;
use common\models\info\CompanySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\UserInfo;
use yii\web\UploadedFile;
use common\models\info\CompanyFiles;

/**
 * CompanyController implements the CRUD actions for Company model.
 */
class CompanyController extends Controller
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
     * Lists all Company models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CompanySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCompanyFile($id, $action = false)
    {
        $model = $this->findCompanyFilesModel($id);
        FileUploadHelper::handleAction($model, $action);
    }

    /**
     * Displays a single Company model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        /*return $this->render('view', [
            'model' => $this->findModel($id),
        ]);*/

        $model = $this->findModel($id);

        $fileUpload = new FileUploadHelper('/office/company/company-file', [
            'pluginOptions' => [
                'initialCaption' => Yii::t('app', 'Файлы УГРЮЛ'),
            ],
        ]);
        $fileUploadConfig = $fileUpload->fileUploadConfig($model->companyFiles);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($uploadedFiles = UploadedFile::getInstances($model, 'company_files')) {
                foreach ($uploadedFiles as $upFile) {
                    $companyFiles = new CompanyFiles();
                    $companyFiles->content = file_get_contents($upFile->tempName);
                    $companyFiles->name = $upFile->name;
                    $companyFiles->mime_type = $upFile->type;
                    $companyFiles->save();
                    $model->link('companyFiles', $companyFiles);
                    //$infoModel->save(false);
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('view', [
                'model' => $model,
                'fileUploadConfig' => $fileUploadConfig,
            ]);
        }
    }

    /**
     * Creates a new Company model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Company();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                $userInfoModel = UserInfo::find()->where(['user_id' => Yii::$app->user->identity->getId()])->one();
                $userInfoModel->link('companies', $model);
                //return $this->redirect(['view', 'id' => $model->id]);
                //TODO может понадобиться скорректировать
                return $this->redirect('/office/my-organization');
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Company model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    /*public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->id]);
            return $this->redirect('/office/my-organization');
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }*/

    /**
     * Deletes an existing Company model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect('/office/my-organization');
        //return $this->redirect(Yii::$app->request->referrer ?: ['index']);
        //return $this->redirect(['index']);
    }

    /**
     * Finds the Company model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Company the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $userInfoId = UserInfo::find()->where(['user_id' => Yii::$app->user->identity->getId()])->one()->primaryKey;
        $model = Company::find()
            ->joinWith(['userInfoCompanies', 'legalAddressLocation'])
            ->andFilterWhere(['user_info_company.user_info_id' => $userInfoId, 'company.id' => $id])
            ->one();

        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'Запрашиваемая страница не найдена.'));
        }
    }

    protected function findCompanyFilesModel($id)
    {
        if (($model = CompanyFiles::findOne($id)) !== null) {
            return $model;
        }
        throw new \yii\web\NotFoundHttpException();
    }
}
