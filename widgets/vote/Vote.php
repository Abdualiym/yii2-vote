<?php

namespace abdualiym\vote\widgets\vote;

use abdualiym\vote\entities\Question;
use Yii;
use yii\base\Widget;

class Vote extends Widget
{

    public function run()
    {
        $questions = Question::find()->active()->all();
        return $this->render('_vote', ['questions' => $questions]);
    }

}