<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;
use yii\filters\RateLimitInterface;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property int $id ID
 * @property string $mobile_phone 手机号码
 * @property string $we_chat_open_id 微信 OPENID
 * @property string $username 用户名
 * @property string $password_hash 密码
 * @property string $access_token ACCESS_TOKEN
 * @property int $role 角色
 * @property int $points 积分
 * @property string $avatar_url 头像
 * @property string $email 电子邮件
 * @property string $auth_key 验证KEY
 * @property string $access_token_expired_at TOKEN 过期时间
 * @property string $password_reset_token 密码重置TOKEN
 * @property string $last_login_at 最后登录时间
 * @property int $rate_limit 速率限制
 * @property int $allowance 剩余请求次数
 * @property int $allowance_updated_at 请求时间戳
 * @property int $status 状态
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface, RateLimitInterface
{

    const STATUS_DELETED = -1;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mobile_phone', 'username', 'password_hash', 'access_token'], 'required'],
            [['role', 'points', 'rate_limit', 'allowance', 'allowance_updated_at', 'status'], 'integer'],
            [['access_token_expired_at', 'last_login_at', 'created_at', 'updated_at'], 'safe'],
            [['mobile_phone'], 'string', 'max' => 20],
            [['we_chat_open_id', 'username', 'password_hash', 'access_token', 'avatar_url', 'email', 'auth_key', 'password_reset_token'], 'string', 'max' => 255],
            [['mobile_phone'], 'unique'],
            [['username'], 'unique'],
            [['access_token'], 'unique'],
            [['we_chat_open_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'mobile_phone' => Yii::t('app', '手机号码'),
            'we_chat_open_id' => Yii::t('app', '微信 OPENID'),
            'username' => Yii::t('app', '用户名'),
            'password_hash' => Yii::t('app', '密码'),
            'access_token' => Yii::t('app', 'ACCESS_TOKEN'),
            'role' => Yii::t('app', '角色'),
            'points' => Yii::t('app', '积分'),
            'avatar_url' => Yii::t('app', '头像'),
            'email' => Yii::t('app', '电子邮件'),
            'auth_key' => Yii::t('app', '验证KEY'),
            'access_token_expired_at' => Yii::t('app', 'TOKEN 过期时间'),
            'password_reset_token' => Yii::t('app', '密码重置TOKEN'),
            'last_login_at' => Yii::t('app', '最后登录时间'),
            'rate_limit' => Yii::t('app', '速率限制'),
            'allowance' => Yii::t('app', '剩余请求次数'),
            'allowance_updated_at' => Yii::t('app', '请求时间戳'),
            'status' => Yii::t('app', '状态'),
            'created_at' => Yii::t('app', '创建时间'),
            'updated_at' => Yii::t('app', '更新时间'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return User::find()->where(['access_token' => $token])->one();
    }

    /**
     * @param $username
     * @return User|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token)
    {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * @param $password
     * @throws \yii\base\Exception
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }


    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Returns the maximum number of allowed requests and the window size.
     * @param \yii\web\Request $request the current request
     * @param \yii\base\Action $action the action to be executed
     * @return array an array of two elements. The first element is the maximum number of allowed requests,
     * and the second element is the size of the window in seconds.
     */
    public function getRateLimit($request, $action)
    {
        return [$this->rate_limit, 100]; // $rateLimit requests per second
    }

    /**
     * Loads the number of allowed requests and the corresponding timestamp from a persistent storage.
     * @param \yii\web\Request $request the current request
     * @param \yii\base\Action $action the action to be executed
     * @return array an array of two elements. The first element is the number of allowed requests,
     * and the second element is the corresponding UNIX timestamp.
     */
    public function loadAllowance($request, $action)
    {
        return [$this->allowance, $this->allowance_updated_at];
    }

    /**
     * Saves the number of allowed requests and the corresponding timestamp to a persistent storage.
     * @param \yii\web\Request $request the current request
     * @param \yii\base\Action $action the action to be executed
     * @param int $allowance the number of allowed requests remaining.
     * @param int $timestamp the current timestamp.
     */
    public function saveAllowance($request, $action, $allowance, $timestamp)
    {
        $this->allowance = $allowance;
        $this->allowance_updated_at = $timestamp;
        $this->save();
    }
}
