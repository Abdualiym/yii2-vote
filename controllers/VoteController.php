<?php

namespace abdualiym\vote\controllers;

use abdualiym\languageClass\Language;
use abdualiym\vote\entities\Answer;
use abdualiym\vote\entities\Question;
use abdualiym\vote\entities\Results;
use abdualiym\vote\forms\ResultsForm;
use abdualiym\vote\forms\ResultsSaveForm;
use abdualiym\vote\services\ResultsManageService;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use yii\web\Controller;

/**
 *
 * Vote controller for the `vote` module
 * Used for response list and add vote
 */
class VoteController extends Controller
{

    private $service;

    public function __construct($id, $module, ResultsManageService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    /**
     * @param not
     * @type request get
     * @return json (question, question_id, answers list, status response)
     */
    public function actionList()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
        $result = new Results();
        $question = $result->selectQuestion(); //select one active question
        $response = [
            'question' =>  $question->translate($question->id),
            'question_id' => $question->id,
            'answers' => $result->listAnswers($question->id),
            'status' => 1
            ];
        return $response ;
        }
        return ['message' => "The format does not fit request", 'status' => 0, 'ok' => false];
    }

    /**
     * @param integer ResultsForm[answer_id]
     * @return json
     * @function save user vote
     */
    public function actionAdd()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            $form = new ResultsForm();
            if ($form->load(Yii::$app->request->post()) && !Question::isVoted($form->answer_id)) {
                    try {
                        $this->service->create($form);
                        $response = ["status" => 1, "message" => Yii::t('app', 'Voting successfully received!')];
                    } catch (\DomainException $e) {
                        $response = ["ok" => false, "status" => 0, "message" => Yii::t('app', 'Something is wrong! ')];
                    }
                    return $response;
            }
            return [ "ok" => false, "status" => 0, "message" => ""];
        }
        return ['message' => "The format does not fit request", 'status' => 0, 'ok' => false];
    }

}