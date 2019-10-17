<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%rule}}".
 *
 * @property int $id ID
 * @property int $uid UID
 * @property int $device_id DEVICE ID
 * @property string $rule_key 条件名称
 * @property int $rule_condition 条件
 * @property string $rule_value 条件值
 * @property string $notice 描述
 * @property int $status 状态
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 */
class Rule extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%rule}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'device_id', 'rule_condition', 'status'], 'integer'],
            [['rule_key', 'rule_condition', 'rule_value', 'notice'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['rule_key'], 'string', 'max' => 50],
            [['rule_value', 'notice'], 'string', 'max' => 255],
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
            'device_id' => Yii::t('app', 'DEVICE ID'),
            'rule_key' => Yii::t('app', '条件名称'),
            'rule_condition' => Yii::t('app', '条件'),
            'rule_value' => Yii::t('app', '条件值'),
            'notice' => Yii::t('app', '描述'),
            'status' => Yii::t('app', '状态'),
            'created_at' => Yii::t('app', '创建时间'),
            'updated_at' => Yii::t('app', '更新时间'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return RuleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RuleQuery(get_called_class());
    }
}
