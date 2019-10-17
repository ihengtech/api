<?php

namespace app\controllers;

use Yii;
use app\models\FileManage;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use yii\web\ServerErrorHttpException;

class FileManageController extends ActiveController
{
    public $modelClass = 'app\models\FileManage';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();
        \Yii::$app->user->enableSession = false;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            'authMethods' => [
                HttpBasicAuth::className(),
                HttpBearerAuth::className(),
                QueryParamAuth::className(),
            ],
        ];
        //$behaviors['rateLimiter']['enableRateLimitHeaders'] = false;
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions(); // TODO: Change the autogenerated stub
        unset($actions['create']);
        return $actions;
    }

    /**
     * 使用base64方式上传文件
     * @return FileManage
     * @throws ServerErrorHttpException
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\ForbiddenHttpException
     */
    public function actionCreate()
    {
        $this->checkAccess($this->id);
        $model = new FileManage();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->save()) {
            return $model;
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
        return $model;
    }

    /**
     * 使用表单形式上传文件
     * @return FileManage
     * @throws ServerErrorHttpException
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\ForbiddenHttpException
     */
    public function actionUpload()
    {
        $this->checkAccess($this->id);
        $model = new FileManage();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->save()) {
            return $model;
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
        return $model;
    }

    public function checkAccess($action, $model = null, $params = [])
    {
        parent::checkAccess($action, $model, $params); // TODO: Change the autogenerated stub
    }
}