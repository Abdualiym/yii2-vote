<?php

namespace abdualiym\vote\controllers;

use abdualiym\vote\entities\Answer;
use abdualiym\vote\entities\Question;
use abdualiym\vote\entities\Results;
use abdualiym\vote\forms\QuestionForm;
use abdualiym\vote\forms\ResultsForm;
use abdualiym\vote\services\QuestionManageService;
use Yii;
use yii\base\ViewContextInterface;
use yii\data\Pagination;
use yii\filters\VerbFilter;
use yii\web\Controller;

/**
 * QuestionController implements the CRUD actions for Question model.
 */
class QuestionController extends Controller implements ViewContextInterface
{
    private $service;

    public function __construct($id, $module, QuestionManageService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }


    public function getViewPath()
    {
        return Yii::getAlias('@vendor/abdualiym/vote/views/question');
    }


    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'activate' => ['POST'],
                    'draft' => ['POST'],
                ],
            ],
        ];
    }


    public function actionIndex()
    {
        $query = Question::find()->orderBy(['created_at' => SORT_DESC]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 10]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('index', [
            'models' => $models,
            'pages' => $pages,
        ]);
    }


    public function actionView($id)
    {
        return $this->render('view', [
            'question' => $this->findModel($id),
        ]);
    }


    public function actionCreate()
    {
        $form = new QuestionForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $question = $this->service->create($form);
                Yii::$app->session->setFlash('success', Yii::t('app', 'Question successfully added!'));
                return $this->redirect(['view', 'id' => $question->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('Create error.', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form
        ]);
    }


    public function actionUpdate($id)
    {
        $question = $this->findModel($id);
        $form = new QuestionForm($question);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($question->id, $form);
                Yii::$app->session->setFlash('success', Yii::t('app', 'Question successfully updated!'));
                return $this->redirect(['view', 'id' => $question->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('update', ['model' => $form,
            'slide' => $question,]);
    }


    /**
     * @param integer $id
     * @return mixed
     */
    public function actionActivate($id)
    {
        try {
            $this->service->activate($id);
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['view', 'id' => $id]);
    }
    /**
     * @param integer $id
     * @return mixed
     */
    public function actionListvote()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $vote = Question::find()->active()->one();
        $response['vote'] = $vote->translations['1']->question; // question text
        $response['vote_id'] = $vote->id; // vote id
        if($vote->resultsUserVote->id){
            $response['status'] = 1;
            return $response;
        }
            // cikl all question and compressed to array
            foreach ($vote->voteAnswers as $item){
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
        if (Yii::$app->request->isAjax){
            $selected_id = Yii::$app->request->post('selected');
            if(isset($selected_id) || !empty($selected_id)){
                $vote = Answer::findOne($selected_id)->vote_id;
                $answers = Answer::find()->select('id')->where(['vote_id' => $vote])->all();
                foreach ($answers as $items){
                    $item['id'] = $items->id;
                    $item['count'] = Results::find()->where(['answer_id' => $items->id])->count();
                    $res[] = $item;
                }
                if($form->validateDuplicate($selected_id)){
                        $result = new Results();
                        if($result->create($selected_id, $vote)){
                            $response[] = $res;
                            $response['status'] = 1;
                            return $response;
                        }else{
                            $response['status'] = 0;
                            return $response;
                        }
                }else{
                    $response['count'] = $res;
                    $response['status'] = "duplicate";
                    return $response;
                }
            }
        }
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionDraft($id)
    {
        try {
            $this->service->draft($id);
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['view', 'id' => $id]);
    }


    public function actionDelete($id)
    {
        try {
            $this->service->remove($id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->goBack((!empty(Yii::$app->request->referrer) ? Yii::$app->request->referrer : null));
    }


    /**
     * Finds the Slide model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Question the loaded model
     * @throws \DomainException if the model cannot be found
     */
    protected function findModel($id): Question
    {
        if (($model = Question::findOne($id)) !== null) {
            return $model;
        }
        throw new \DomainException('The requested question does not exist.');
    }
}
