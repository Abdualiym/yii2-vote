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
 * Default controller for the `news` module
 *
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
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

//ajax generate one question and list answers
    public function actionList()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
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

    /**
     * @param integer $id
     * @return mixed
     * save user answer and reponse results
     */
    public function actionAdd()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $form = new ResultsForm();

        if ($form->load(Yii::$app->request->post())) {

            if($form->validateDuplicate($form->answer_id)){
                $response['status'] = 0;
                $response['message'] = Yii::t('app', 'Your vote has been received!');
                return $response;
            }
                try {
                    $this->service->create($form);
                    $response['status'] = 1;
                    $response['message'] = Yii::t('app', 'Voting successfully received!');
                    return $response;
                } catch (\DomainException $e) {
                    $response['status'] = 0;
                    $response['message'] = Yii::t('app', 'Something is wrong!');
                    return $response;
                }
        }
    }

}