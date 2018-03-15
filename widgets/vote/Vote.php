<?php

namespace frontend\widgets\vote;

use abdualiym\vote\entities\Question;
use abdualiym\vote\entities\Results;
use Yii;
use yii\base\Widget;

class Vote extends Widget
{

    public function run()
    {
        $questions = Question::find()->active()->all();
        $question = Question::find()->active()->one();
        $result= Results::listAnswersResult($question->id);

        return $this->render('_vote', ['questions' => $questions, 'result'=>$result]);
    }

}