<?php

namespace abdualiym\vote\entities\queries;

use yii\db\ActiveQuery;

class VotesQuery extends ActiveQuery
{
    public function active()
    {
        return $this->andWhere('[[status]]=1');
    }

    /**
     * @inheritdoc
     * @return \common\models\Foods[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\Foods|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

}