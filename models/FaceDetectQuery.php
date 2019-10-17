<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[FaceDetect]].
 *
 * @see FaceDetect
 */
class FaceDetectQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return FaceDetect[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return FaceDetect|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
