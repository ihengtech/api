<?php

namespace app\controllers;

use app\models\FaceDetect;
use app\models\FileManage;
use common\helpers\HttpClient;
use common\helpers\Util;
use Yii;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\helpers\Json;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;

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

    /**
     * @throws NotFoundHttpException
     */
    public function actionApiAnalysis()
    {
        $id = Yii::$app->request->get('id');
        if (!is_numeric($id)) {
            throw new NotFoundHttpException('图片不存在!');
        }
        $fileManage = FileManage::findOne($id);
        if ($fileManage === null) {
            throw new NotFoundHttpException('图片不存在!');
        }
        $filePath = Yii::getAlias('@fileManage') . DIRECTORY_SEPARATOR . $fileManage->unique_name;
        if (file_exists($filePath)) {
            $url = FaceDetect::API_URL . '/api/image/baiduapi/upload';
            $httpClient = new HttpClient();
            $data = $httpClient->post($url, ['file' => curl_file_create($filePath)], [], [], false);
            Yii::debug(Json::encode($data));
            $content = Util::parseHttpClientContent($data);
            print_r($content);
            exit;
        }
        throw new NotFoundHttpException('图片不存在!');
    }

    public function checkAccess($action, $model = null, $params = [])
    {
        parent::checkAccess($action, $model, $params);
    }
}