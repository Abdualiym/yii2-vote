<?php

namespace abdualiym\vote\widgets\vote;

use Yii;
use yii\base\Widget;

class Vote extends Widget
{

    public function run()
    {
        return $this->render('_vote');
    }

}