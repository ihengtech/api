<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%device}}".
 *
 * @property int $id ID
 * @property int $uid UID
 * @property string $serial_number SERIAL NUMBER
 * @property string $mac_address MAC ADDRESS
 * @property double $lng 经度
 * @property double $lat 纬度
 * @property string $device_config DEVICE CONFIG
 * @property int $status 状态
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 */
class Device extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%device}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'status'], 'integer'],
            [['serial_number', 'mac_address'], 'required'],
            [['lng', 'lat'], 'number'],
            [['device_config'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['serial_number', 'mac_address'], 'string', 'max' => 255],
            [['serial_number'], 'unique'],
            [['mac_address'], 'unique'],
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
            'serial_number' => Yii::t('app', 'SERIAL NUMBER'),
            'mac_address' => Yii::t('app', 'MAC ADDRESS'),
            'lng' => Yii::t('app', '经度'),
            'lat' => Yii::t('app', '纬度'),
            'device_config' => Yii::t('app', 'DEVICE CONFIG'),
            'status' => Yii::t('app', '状态'),
            'created_at' => Yii::t('app', '创建时间'),
            'updated_at' => Yii::t('app', '更新时间'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return DeviceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DeviceQuery(get_called_class());
    }
}
