<?php

namespace abdualiym\vote\controllers;

use abdualiym\vote\entities\Answer;
use abdualiym\vote\entities\Question;
use abdualiym\vote\entities\QuestionTranslation;
use abdualiym\vote\entities\Results;
use abdualiym\vote\forms\QuestionForm;
use abdualiym\vote\forms\ResultsForm;
use abdualiym\vote\services\QuestionManageService;
use Yii;
use yii\base\ViewContextInterface;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
use yii\web\Controller;

/**
 *
 * QuestionController implements the CRUD actions for Question model.
 *
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
        return Yii::getAlias('@vendor/abdualiym/yii2-vote/views/question');
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
            'question' => $question,]);
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
        return $this->redirect(['index']);
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
        throw new \DomainException('The requested slide does not exist.');
    }
}
