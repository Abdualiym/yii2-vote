<?php

namespace abdualiym\vote\controllers;

use abdualiym\vote\entities\Answer;
use abdualiym\vote\entities\Question;
use abdualiym\vote\entities\Results;
use abdualiym\vote\forms\ResultsForm;
use Yii;
use yii\web\Controller;

/**
 *
 * Default controller for the `news` module
 *
 */
class RequestController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }


    public function actionListvote()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $vote = Question::find()->active()->one();
        $response['vote'] = $vote->translations['1']->question; // question text
        $response['question_id'] = $vote->id; // vote id
        if (isset($vote->resultsUserVote) && $vote->resultsUserVote->id) {
            $response['status'] = 3;
            return $response;
        }
        // cikl all question and compressed to array
        foreach ($vote->voteAnswers as $item) {
            $items['id'] = $item->id;
            $items['answer'] = $item->translations['1']->answer;
            $result[] = $items;
        }
        $response['answers'] = $result; // array answers
        $response['status'] = 1; //status protsess
        return $response;
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionVote()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $form = new ResultsForm();
        if (Yii::$app->request->isAjax) {
            $selected_id = Yii::$app->request->post('selected');
            if (isset($selected_id) || !empty($selected_id)) {
                $vote = Answer::findOne($selected_id)->question_id;
                $answers = Answer::find()->select('id')->where(['question_id' => $vote])->all();
                foreach ($answers as $items) {
                    $item['id'] = $items->id;
                    $item['count'] = Results::find()->where(['answer_id' => $items->id])->count();
                    $res[] = $item;
                }
                if ($form->validateDuplicate($selected_id)) {
                    $result = new Results();
                    if ($result->create($selected_id, $vote)) {
                        $response[] = $res;
                        $response['status'] = 1;
                        return $response;
                    } else {
                        $response['status'] = 0;
                        return $response;
                    }
                } else {
                    $response['count'] = $res;
                    $response['status'] = "duplicate";
                    return $response;
                }
            }
        }
    }
}