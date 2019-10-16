<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "merchandise".
 *
 * @property int $id ID
 * @property int $uid UID
 * @property string $name 商品名称
 * @property string $redirect_url 跳转地址
 * @property int $price 价格
 * @property int $discount 折扣
 * @property string $image_url 图片地址
 * @property int $status 状态
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 */
class Merchandise extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'merchandise';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'name', 'redirect_url', 'price', 'discount', 'image_url', 'status'], 'required'],
            [['uid', 'price', 'discount', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['redirect_url', 'image_url'], 'string', 'max' => 2753],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'uid' => Yii::t('app', 'UID'),
            'name' => Yii::t('app', '商品名称'),
            'redirect_url' => Yii::t('app', '跳转地址'),
            'price' => Yii::t('app', '价格'),
            'discount' => Yii::t('app', '折扣'),
            'image_url' => Yii::t('app', '图片地址'),
            'status' => Yii::t('app', '状态'),
            'created_at' => Yii::t('app', '创建时间'),
            'updated_at' => Yii::t('app', '更新时间'),
        ];
    }

    public function fields()
    {
        return parent::fields(); // TODO: Change the autogenerated stub
    }

    /**
     * {@inheritdoc}
     * @return MerchandiseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MerchandiseQuery(get_called_class());
    }
}
