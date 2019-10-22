<?php

namespace app\controllers;

use app\models\Config;
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
        return parent::actions();
    }

    /**
     * 人脸分析
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
            $url = Config::ADV_API_URL . '/api/image/baiduapi/upload';
            $httpClient = new HttpClient();
            $data = $httpClient->post($url, ['file' => curl_file_create($filePath)], [], [], false);
            Yii::debug(Json::encode($data));
            $content = Util::parseHttpClientFaceDetectData($data);
            $items = [];
            if (isset($content['result']['face_list'][0])) {
                $face = $content['result']['face_list'][0];
                if (isset($face['age'])) {
                    $items[] = ['key' => '年龄', 'value' => $face['age'],];
                }
                if (isset($face['gender'])) {
                    if ($face['gender']['type'] == 'male') {
                        $items[] = ['key' => '性别', 'value' => '男',];
                    } else {
                        $items[] = ['key' => '性别', 'value' => '女',];
                    }
                }
                if (isset($face['beauty'])) {
                    $items[] = ['key' => '貌美', 'value' => $face['beauty']];
                }
                if (isset($face['emotion']['type'])) {
                    $items[] = ['key' => '表情', 'value' => $this->getEmotionType($face['emotion']['type'])];
                }
            }
            return $this->asJson($items);
        }
        throw new NotFoundHttpException('图片不存在!');
    }

    private function getEmotionType($type) {
        $types = [
            'angry' => '愤怒',
            'disgust' => '厌恶',
            'fear' => '恐惧',
            'happy' => '高兴',
            'sad' => '伤心',
            'surprise' => '惊讶',
            //'neutral' => '无情绪',
        ];
        return isset($types[$type]) ? $types[$type] : '自然';
    }

    public function checkAccess($action, $model = null, $params = [])
    {
        parent::checkAccess($action, $model, $params);
    }
}