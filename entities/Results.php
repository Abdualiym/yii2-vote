<?php

namespace abdualiym\vote\entities;

use abdualiym\languageClass\Language;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

/**
 *
 * This is the model class for table "vote_results".
 *
 *
 * @property int $id
 * @property int $answer_id
 * @property string $user_ip
 * @property int $user_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Answer $answer
 */
class Results extends \yii\db\ActiveRecord
{

    const STATUS_DRAFT = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_ARCHIVE = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vote_results';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnswer(): ActiveQuery
    {
        return $this->hasOne(Answer::class(), ['id' => 'answer_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */

    public function create($answer_id, $cookie_token): self
    {
        $result = new static();
        $result->answer_id = $answer_id;
        $result->cookie_token = $cookie_token;
        $result->user_ip = Yii::$app->getRequest()->getUserIP();
        $result->user_id = Yii::$app->user->id;
        return $result;
    }

    public function edit($answer_id)
    {
        $this->answer_id = $answer_id;
    }
    /**
     * for frontend
     * @return \yii\db\ActiveQuery
     * Response all count voted question and answers
     */
    public function listAnswersResult($question_id){
        $answers = Answer::find()->select('id')
            ->where(['question_id' => $question_id, 'status' =>1])
            ->orderBy(['sort' => SORT_DESC])->all();
        foreach ($answers as $items) {
            $item['id'] = $items->id;
            $item['name'] = $items->translate($items->id);
            $answerCount = Results::find()
                ->select(['vote_results.id', 'COUNT(vote_results.answer_id) as AnswerCount'])
                ->innerJoin('vote_answers', 'vote_results.answer_id = vote_answers.id')
                ->innerJoin('vote_questions', 'vote_answers.question_id = vote_questions.id')
                ->andWhere(['in', 'vote_results.answer_id', $items->id])
                ->andWhere(['in', 'vote_answers.status',self::STATUS_ACTIVE])
                ->having('COUNT(vote_results.id)>=1')
                ->asArray()
                ->one();
            $item['count'] = $answerCount['AnswerCount'];
            if($answerCount['AnswerCount'] == null || empty($answerCount['AnswerCount'])){
                $count_answer = 0;
            }else{
                $count_answer = $answerCount['AnswerCount'];
            }
            $item['count_message'] = Yii::t('vote', '{n,plural,=0{not voted} =1{# vote} =2{# votes} other{# votes}}', ['n' => $count_answer]);
            $res[] = $item;
        }
        if(Question::find()->count() >=1){
            $questionCount = Results::find()
                ->select(['vote_results.id', 'COUNT(vote_results.answer_id) as QuestionCount'])
                ->innerJoin('vote_answers', 'vote_results.answer_id = vote_answers.id')
                ->innerJoin('vote_questions', 'vote_answers.question_id = vote_questions.id')
                ->andWhere(['in', 'vote_questions.id', $question_id])
                ->andWhere(['in', 'vote_questions.status', self::STATUS_ACTIVE])
                ->andWhere(['in', 'vote_answers.status', self::STATUS_ACTIVE])
                ->having('COUNT(vote_results.id)>=1')
                ->asArray()
                ->one();
        }else{
            $questionCount['QuestionCount'] = 0;
        }


        $response['question'] = Question::translate($question_id);
        $response['all'] = $questionCount['QuestionCount'];
        $response['items'] = $res;
        return $response;
    }

    public function addCookies($token)
    {
        $cookies = Yii::$app->request->cookies;
        $cookie = new \yii\web\Cookie([
            'name' => 'cookie_token',
            'value' => $token,
            'expire' => time() + 86400 * 365,
        ]);
        \yii::$app->response->cookies->add($cookie);
        if($cookies->has('cookie_token')){return true;}else{return null;}

    }
    /**
     * for frontend
     * @return \yii\db\ActiveQuery
     * select one active question for ajax widget
     */
    public function CookieToken(){

        $cookies = Yii::$app->request->cookies;
        return $cookies->get('cookie_token')->value;
    }
    /**
     * for frontend
     * @return \yii\db\ActiveQuery
     * select one active question for ajax widget
     */
    public function selectQuestion(){
        $question = Question::find()->active()->one();
        return isset($question)? $question : null;
    }

    /**
     * for frontend
     * @return \yii\db\ActiveQuery
     * list answers for ajax widget
     */
    public function listAnswers($question_id){
        $answers = Answer::find()->select('id')
            ->where(['question_id' => $question_id, 'status' => self::STATUS_ACTIVE])
            ->orderBy(['sort' => SORT_DESC])
            ->all();
        foreach ($answers as $items) {
            $response[] = ['id' => $items->id,
            'answer' => $items->translate($items->id)];
        }
        return $response;
    }
    // behaviors
    public function behaviors(): array
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => SaveRelationsBehavior::className(),
            ],
        ];
    }

}
