<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%merchandise}}".
 *
 * @property int $id ID
 * @property int $uid UID
 * @property string $name 用户名
 * @property int $price 原价
 * @property int $discount 打折
 * @property string $image_url 商品图像
 * @property string $detail MERCHANDISE DETAIL
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
        return '{{%merchandise}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'price', 'discount', 'status'], 'integer'],
            [['name'], 'required'],
            [['detail'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['image_url'], 'string', 'max' => 255],
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
            'name' => Yii::t('app', '用户名'),
            'price' => Yii::t('app', '原价'),
            'discount' => Yii::t('app', '打折'),
            'image_url' => Yii::t('app', '商品图像'),
            'detail' => Yii::t('app', 'MERCHANDISE DETAIL'),
            'status' => Yii::t('app', '状态'),
            'created_at' => Yii::t('app', '创建时间'),
            'updated_at' => Yii::t('app', '更新时间'),
        ];
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
