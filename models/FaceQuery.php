<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Face]].
 *
 * @see Face
 */
class FaceQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Face[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Face|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
