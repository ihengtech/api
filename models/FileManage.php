<?php

namespace app\models;

use Yii;
use yii\helpers\Json;

/**
 * This is the model class for table "{{%file_manage}}".
 *
 * @property int $id ID
 * @property int $device_id 设备 ID
 * @property string $raw_name 图像原始名称
 * @property string $unique_name 图像原始名称
 * @property string $detail DEVICE CONFIG
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 */
class FileManage extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%file_manage}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['device_id'], 'integer'],
            [['raw_name'], 'required'],
            [['detail'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['unique_name'], 'string', 'max' => 255],
            [['raw_name'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png,jpg,jpeg,gif'],
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
            'raw_name' => Yii::t('app', '图像原始名称'),
            'unique_name' => Yii::t('app', '图像原始名称'),
            'detail' => Yii::t('app', 'DEVICE CONFIG'),
            'created_at' => Yii::t('app', '创建时间'),
            'updated_at' => Yii::t('app', '更新时间'),
        ];
    }

    public static function getUploadDir()
    {
        return Yii::getAlias('@frontend') . DIRECTORY_SEPARATOR . 'web' . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR;
    }

    public static function getUrlPath($file = null)
    {
        return 'upload/images/' . $file;
    }

    /**
     * @param $src
     * @param $saveFilename
     * @param int $percent
     * @return bool
     */
    public static function compressImage($src, $saveFilename, $percent = 1)
    {
        if (!is_file($src)) {
            return false;
        }
        if (!extension_loaded('gd')) {
            return false;
        }
        list($width, $height, $type, $attr) = getimagesize($src);
        $imageInfo = [
            'width' => $width,
            'height' => $height,
            'type' => image_type_to_extension($type, false),
            'attr' => $attr,
        ];
        $functionName = strtolower('imagecreatefrom' . $imageInfo['type']);
        if (!function_exists($functionName)) {
            return false;
        }
        $sourceImage = $functionName($src);
        $resizeWidth = floor($imageInfo['width'] * $percent);
        $resizeHeight = floor($imageInfo['height'] * $percent);
        $distImage = imagecreatetruecolor($resizeWidth, $resizeHeight);
        imagecopyresampled($distImage, $sourceImage, 0, 0, 0, 0, $resizeWidth, $resizeHeight, $imageInfo['width'], $imageInfo['height']);
        imagedestroy($sourceImage);
        $saveFunction = strtolower('image' . $imageInfo['type']);
        if (!function_exists($saveFunction)) {
            return false;
        }
        $tmpPath = FileManage::getUploadDir() . DIRECTORY_SEPARATOR . 'compress';
        if (!is_dir($tmpPath)) {
            mkdir($tmpPath);
        }
        if (!is_dir($tmpPath)) {
            return false;
        }
        $tmpFile = $tmpPath . DIRECTORY_SEPARATOR . $saveFilename;
        $saveFunction($distImage, $tmpFile);
        imagedestroy($distImage);
        return true;
    }

    public function setDefaultField()
    {
        $this->device_id = 0;
        $this->detail = Json::encode([]);
        $this->created_at = date('Y-m-d H:i:s', time());
        $this->updated_at = date('Y-m-d H:i:s', time());
    }

    public function getUniqueName($tmpName, $extensionName)
    {
        return md5(uniqid('img_') . $tmpName . microtime() . rand(1, 100)) . '.' . $extensionName;
    }

    /**
     * {@inheritdoc}
     * @return FileManageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FileManageQuery(get_called_class());
    }
}
