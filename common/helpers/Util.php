<?php

namespace common\helpers;

use yii\helpers\Json;

class  Util
{
    public static function parseHttpClientFaceDetectData($data)
    {
        $content = [];
        try {
            $json = Json::decode($data['content']);
        } catch (\Throwable $e) {
            $json = [];
        }
        if (isset($json['content'])) {
            try {
                $content = Json::decode($json['content']);
            } catch (\Throwable $e) {
                $content = [];
            }
        }
        return $content;
    }

    public static function parseHttpClientWaresData($data)
    {
        try {
            $content = Json::decode($data['content']);
        } catch (\Throwable $e) {
            $content = [];
        }
        return $content;
    }
}