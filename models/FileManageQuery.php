<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[FileManage]].
 *
 * @see FileManage
 */
class FileManageQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return FileManage[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return FileManage|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
