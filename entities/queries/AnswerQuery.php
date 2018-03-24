<?php

namespace abdualiym\vote\entities\queries;

use yii\db\ActiveQuery;

class AnswerQuery extends ActiveQuery
{
    public function active()
    {
        return $this->andWhere('[[status]]=1');
    }

    /**
     * @inheritdoc
     * @return abdualiym\vote\entities\Answer[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return abdualiym\vote\entities\Answer|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

}