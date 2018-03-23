<?php

namespace abdualiym\vote\controllers;

use abdualiym\vote\entities\Answer;
use abdualiym\vote\forms\AnswerForm;
use abdualiym\vote\forms\AnswerSearch;
use abdualiym\vote\services\AnswerManageService;
use Yii;
use yii\base\ViewContextInterface;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
use yii\web\Controller;

/**
 *
 * AnswerController implements the CRUD actions for Answer model.
 */
class AnswerController extends Controller implements ViewContextInterface
{
    private $service;
    public function __construct($id, $module, AnswerManageService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }


    public function getViewPath()
    {
        return Yii::getAlias('@vendor/abdualiym/yii2-vote/views/answer');
    }


    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'view', 'update', 'activate', 'draft', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
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
        $searchModel = new AnswerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'answer' => $this->findModel($id),
        ]);
    }

    public function actionCreate($question_id)
    {
        $form = new AnswerForm();
        $answers = Answer::find()->where(['question_id' => $question_id])->all();
        $form->question_id = $question_id;

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->create($form);
                Yii::$app->session->setFlash('success', Yii::t('app', 'Answer successfully added!'));

                if(empty(Yii::$app->request->post('more'))){
                    return $this->redirect('/vote/question/index');
                }
                return $this->goBack((!empty(Yii::$app->request->referrer) ? Yii::$app->request->referrer : null));
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('Create error.', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
            'answers' => $answers
        ]);
    }


    public function actionUpdate($id)
    {
        $answer = $this->findModel($id);
        $form = new AnswerForm($answer);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($answer->id, $form);
                Yii::$app->session->setFlash('success', Yii::t('app', 'Answer successfully updated!'));
                return $this->redirect(['view', 'id' => $answer->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('update', ['model' => $form,
            'answer' => $answer,]);
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
     * Finds the Answer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Answer the loaded model
     * @throws \DomainException if the model cannot be found
     */
    protected function findModel($id): Answer
    {
        if (($model = Answer::findOne($id)) !== null) {
            return $model;
        }
        throw new \DomainException('The requested answer does not exist.');
    }
}
