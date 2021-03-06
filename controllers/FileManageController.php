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
use yii\web\UploadedFile;

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
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                // restrict access to
                'Origin' => \Yii::$app->params['allowOrigin'],
                'Access-Control-Request-Method' => \Yii::$app->params['accessControlRequestMethod'],
                'Access-Control-Allow-Credentials' => true,
                // Allow OPTIONS caching
                'Access-Control-Max-Age' => \Yii::$app->params['accessControlMaxAge'],
                'Access-Control-Expose-Headers' => \Yii::$app->params['accessControlExposeHeaders'],
                'Access-Control-Allow-Headers' => \Yii::$app->params['accessControlAllowHeaders'],
            ],
        ];
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
     * base64
     * @return FileManage
     * @throws ServerErrorHttpException
     */
    public function actionCreate()
    {
        $model = new FileManage();
        $fileBase64 = Yii::$app->request->post('raw_name');
        if (empty($fileBase64)) {
            $model->addError('raw_name', "请上传base64图片");
            return $model;
        }
        $fileBase64 = preg_replace("#^data:image/jpeg;base64,#", "", $fileBase64);
        $file = base64_decode($fileBase64, true);
        if (empty($file)) {
            $model->addError('raw_name', "文件解码错误!");
            return $model;
        }
        $model->setDefaultField();
        $model->raw_name = uniqid('jpeg');
        $model->unique_name = $model->getUniqueName($model->raw_name, 'jpeg');
        $savePath = Yii::getAlias('@fileManage') . DIRECTORY_SEPARATOR . $model->unique_name;
        if (file_put_contents($savePath, $file) && $model->save(false)) {
            return $model;
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
        return $model;
    }

    /**
     * 上传
     * @return FileManage
     * @throws ServerErrorHttpException
     */
    public function actionUpload()
    {
        $model = new FileManage();
        $model->raw_name = UploadedFile::getInstanceByName('raw_name');
        if (!$model->validate()) {
            return $model;
        }
        $fileObject = $model->raw_name;
        $model->setDefaultField();
        $model->raw_name = $fileObject->getBaseName();
        $model->unique_name = $model->getUniqueName($fileObject->tempName, $fileObject->getExtension());
        $savePath = Yii::getAlias('@fileManage') . DIRECTORY_SEPARATOR . $model->unique_name;
        if ($fileObject->saveAs($savePath) && $model->save(false)) {
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