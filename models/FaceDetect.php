<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%face_detect}}".
 *
 * @property int $id ID
 * @property int $device_id 设备 ID
 * @property int $file_manage_id 文件 ID
 * @property string $created_at 创建时间
 * @property string $analysis_result ANALYSIS RESULT
 */
class FaceDetect extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%face_detect}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['device_id', 'file_manage_id'], 'integer'],
            [['created_at'], 'safe'],
            [['analysis_result'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'device_id' => Yii::t('app', '设备 ID'),
            'file_manage_id' => Yii::t('app', '文件 ID'),
            'created_at' => Yii::t('app', '创建时间'),
            'analysis_result' => Yii::t('app', 'ANALYSIS RESULT'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return FaceDetectQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FaceDetectQuery(get_called_class());
    }
}
