<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%config}}".
 *
 * @property int $id ID
 * @property int $uid UID
 * @property string $config_key CONFIG KEY
 * @property string $config_value CONFIG VALUE
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 */
class Config extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%config}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid'], 'integer'],
            [['config_key'], 'required'],
            [['config_value'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['config_key'], 'string', 'max' => 255],
            [['config_key'], 'unique'],
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
            'config_key' => Yii::t('app', 'CONFIG KEY'),
            'config_value' => Yii::t('app', 'CONFIG VALUE'),
            'created_at' => Yii::t('app', '创建时间'),
            'updated_at' => Yii::t('app', '更新时间'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return ConfigQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ConfigQuery(get_called_class());
    }
}
