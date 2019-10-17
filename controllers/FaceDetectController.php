<?php

namespace app\controllers;

use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;

/**
 * 参考url: http://back-groud.ihengtech.com:6688/swagger-ui.html
 * Class FaceController
 * @package app\controllers
 */
class FaceDetectController extends ActiveController
{
    public $modelClass = 'app\models\Face';
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
        return parent::actions();
    }

    public function checkAccess($action, $model = null, $params = [])
    {
        parent::checkAccess($action, $model, $params);
    }
}