<?php

namespace app\commands;

use app\models\User;
use Yii;
use yii\console\Controller;

/**
 * Class UserController
 * @package app\commands
 */
class UserController extends Controller
{
    /**
     * @throws \yii\base\Exception
     */
    public function actionInitAdminUser()
    {
        $model = User::find()->where(['id' => 1])->one();
        if ($model === null) {
            $model = new User();
            $model->id = 1;
            $model->username = 'root';
            $model->password_hash = Yii::$app->security->generatePasswordHash('root_WSX3edc');
            $model->access_token = md5(sprintf('%d%s%s', 1, microtime(), rand(0, 1000)));
            $model->created_at = date('Y-m-d H:i:s', time());
            $model->updated_at = $model->created_at;
            if ($model->save()) {
                $this->stdout(sprintf("%s\n", "init success"));
            } else {
                $this->stdout(sprintf("%s[message: %s]\n", "init failed", $model->getErrorSummary(true)));
            }
        }
    }
}