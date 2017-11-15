<?php

namespace frontend\modules\office\controllers;

use common\helpers\FileUploadHelper;
use common\models\info\CompanyFilesHouses;
use Yii;
use common\models\info\Company;
use common\models\info\CompanySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\UserInfo;
use yii\web\UploadedFile;
use common\models\info\CompanyFiles;
use yii\filters\AccessControl;
use common\models\Location;

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
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
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
        $primaryCompanyId = Yii::$app->user->identity->userInfo->primary_company;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'primaryCompanyId' => $primaryCompanyId,
        ]);
    }

    public function actionCompanyFile($id, $action = false)
    {
        $model = $this->findCompanyFilesModel($id);
        FileUploadHelper::handleAction($model, $action);
    }

    public function actionCompanyFileHouses($id, $action = false)
    {
        $model = $this->findCompanyFilesHousesModel($id);
        FileUploadHelper::handleAction($model, $action);
    }

    public function actionSetPrimary()
    {
        $primary_company_id = Yii::$app->request->post('primary_company_id');
        if (Yii::$app->request->isAjax) {
            //UserInfo::find()->where(['user_id' => Yii::$app->user->identity->getId()])
            Yii::$app->user->identity->userInfo->primary_company = $primary_company_id;
            Yii::$app->user->identity->userInfo->save();
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return 'Организация по умолчанию установлена';
        }
        return 'Не AJAX запрос';
    }

    protected function showForm($id = null, $editMode = false)
    {
        /*return $this->render('view', [
            'model' => $this->findModel($id),
        ]);*/

        if ($id) {
            $model = $this->findModel($id);
        } else {
            $model = new Company();
            //TODO: косяк
            $model->company_type_id = 1;
            $model->tax_system_id = 1;
        }

        /*if (!$model->legal_address_location_id) {
            $location = new Location;
            $location->save();
            $model->link('legalAddressLocation', $location);
        }
        if (!$model->actual_address_location_id) {
            $location = new Location;
            $location->save();
            $model->link('actualAddressLocation', $location);
        }
        if (!$model->postal_address_location_id) {
            $location = new Location;
            $location->save();
            $model->link('postalAddressLocation', $location);
        }*/

        $fileUpload = new FileUploadHelper('/office/company/company-file', [
            'pluginOptions' => [
                'initialCaption' => Yii::t('app', 'Файлы ЕГРЮЛ'),
            ],
        ]);
        $fileUploadConfig = $fileUpload->fileUploadConfig($model->companyFiles);

        $fileUploadHouses = new FileUploadHelper('/office/company/company-file-houses', [
            'pluginOptions' => [
                'initialCaption' => Yii::t('app', 'Файлы обслуживаемых домов'),
            ],
        ]);
        $fileUploadHousesConfig = $fileUploadHouses->fileUploadConfig($model->companyFilesHouses);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if (!$model->userInfoCompanies) {
                $userInfoModel = UserInfo::find()->where(['user_id' => Yii::$app->user->identity->getId()])->one();
                $userInfoModel->link('companies', $model);
            }

            $this->attachCompanyFiles($model);
            $this->attachCompanyFilesHouses($model);
            $this->attachCEO($model);

            return $this->redirect(['view', 'id' => $model->id]);
        } else {

            $companyFilesNames = [];
            foreach ($model->companyFiles as $file) {
                $companyFilesNames[] = $file->name;
            }
            $companyFilesNames = implode('; ', $companyFilesNames);

            //TODO: пересмотреть работу
            if ($model->cEO) {
                $model->CEO_last_name = $model->cEO->second_name;
                $model->CEO_first_name = $model->cEO->first_name;
                $model->CEO_patronymic = $model->cEO->patronymic;
            }

            return $this->render('view', [
                'model' => $model,
                'filesUploading' => [
                    'fileUploadConfig' => $fileUploadConfig,
                    'companyFilesNames' => $companyFilesNames,
                ],
                'filesUploadingHouses' => [
                    'fileUploadHousesConfig' => $fileUploadHousesConfig,
                    //'companyFilesNames' => $companyFilesNames,
                ],
                'edit' => $editMode,
            ]);
        }
    }

    protected function attachCompanyFiles(Company &$model)
    {
        if ($uploadedFiles = UploadedFile::getInstances($model, 'company_files')) {
            foreach ($uploadedFiles as $upFile) {
                $companyFiles = new CompanyFiles();
                $companyFiles->content = file_get_contents($upFile->tempName);
                $companyFiles->name = $upFile->name;
                $companyFiles->mime_type = $upFile->type;
                $companyFiles->save();
                $model->link('companyFiles', $companyFiles);
            }
        }
    }

    protected function attachCompanyFilesHouses(Company &$model)
    {
        if ($uploadedFilesHouses = UploadedFile::getInstances($model, 'company_files_houses')) {
            foreach ($uploadedFilesHouses as $upFileHouse) {
                $companyFilesHouses = new CompanyFilesHouses();
                $companyFilesHouses->content = file_get_contents($upFileHouse->tempName);
                $companyFilesHouses->name = $upFileHouse->name;
                $companyFilesHouses->mime_type = $upFileHouse->type;
                $companyFilesHouses->save();
                $model->link('companyFilesHouses', $companyFilesHouses);
            }
        }
    }

    protected function attachCEO(Company &$model)
    {
        #$userInfoModel = UserInfo::find()->where(['user_id' => Yii::$app->user->identity->getId()])->one();
        #$userInfoModel->link('companies', $model);

        if ($model->cEO) {
            $name = $model->cEO;
        } else {
            $name = new \common\models\Name;
            //$name->save();
        }

        $name->first_name = $model->CEO_first_name;
        $name->second_name = $model->CEO_last_name;
        $name->patronymic = $model->CEO_patronymic;
        $name->save();
        $model->link('cEO', $name);
    }

    /**
     * Displays a single Company model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->showForm($id);
    }

    /**
     * Creates a new Company model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $newCompany = new Company();
        $newCompany->full_name = Yii::t('app', '< полное наименование отстутствует >');
        $newCompany->short_name = Yii::t('app', '< сокращенное наименование отстутствует >');
        $newCompany->save(false);
        $newCompany->link('userInfos0', Yii::$app->user->identity->userInfo);

        //return $this->redirect(['/office/my-organization/update', 'id' => $newCompany->getPrimaryKey()]);

        return $this->showForm($newCompany->getPrimaryKey(), true);

        /*$model = new Company();

        if ($model->load(Yii::$app->request->post())) {
            //TODO: валидация не проходит - заполнить
            $model->company_type_id = 1;
            $model->tax_system_id = 1;
            if ($model->save(false)) {
                $userInfoModel = UserInfo::find()->where(['user_id' => Yii::$app->user->identity->getId()])->one();
                $userInfoModel->link('companies', $model);

                if ($model->cEO) {
                    $name = $model->cEO;
                } else {
                    $name = new \common\models\Name;
                    $name->save();
                }

                $name->first_name = $model->CEO_first_name;
                $model->link('cEO', $name);
                //$name->link('companies', $this);

                //return $this->redirect(['view', 'id' => $model->id]);
                //TODO может понадобиться скорректировать
                return $this->redirect('/office/my-organization');
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);*/
    }

    /**
     * Updates an existing Company model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        return $this->showForm($id, true);
    }
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

        return $this->redirect('/office/company');
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
        //$userInfoId = UserInfo::find()->where(['user_id' => Yii::$app->user->identity->getId()])->one()->primaryKey;
        $userInfoId = Yii::$app->user->identity->userInfo->primaryKey;
        $model = Company::find()
            ->joinWith(['userInfoCompanies', 'legalAddressLocation', 'cEO'])
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

    protected function findCompanyFilesHousesModel($id)
    {
        if (($model = CompanyFilesHouses::findOne($id)) !== null) {
            return $model;
        }
        throw new \yii\web\NotFoundHttpException();
    }
}
