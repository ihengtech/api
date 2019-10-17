<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Merchandise]].
 *
 * @see Merchandise
 */
class MerchandiseQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Merchandise[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Merchandise|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
