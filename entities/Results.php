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

    public function create($answer_id): self
    {
        $result = new static();
        $result->answer_id = $answer_id;
        $result->user_ip = Yii::$app->getRequest()->getUserIP();
        $result->user_id = Yii::$app->user->id;
        return $result;
    }

    public function edit($answer_id)
    {
        $this->answer_id = $answer_id;
    }

    public function listAnswersResult($question_id){
        $answers = Answer::find()->select('id')->where(['question_id' => $question_id])->orderBy(['sort' => SORT_DESC])->all();
        foreach ($answers as $items) {
            $item['id'] = $items->id;
            $answerCount = Results::find()
                ->select(['vote_results.id', 'COUNT(vote_results.answer_id) as AnswerCount'])
                ->innerJoin('vote_answers', 'vote_results.answer_id = vote_answers.id')
                ->innerJoin('vote_questions', 'vote_answers.question_id = vote_questions.id')
                ->andWhere(['in', 'vote_results.answer_id', $items->id])
                ->having('COUNT(vote_results.id)>=1')
                ->asArray()
                ->one();
            $item['count'] = $answerCount['AnswerCount'];
            $res[] = $item;
        }
        $questionCount = Results::find()
            ->select(['vote_results.id', 'COUNT(vote_results.answer_id) as QuestionCount'])
            ->innerJoin('vote_answers', 'vote_results.answer_id = vote_answers.id')
            ->innerJoin('vote_questions', 'vote_answers.question_id = vote_questions.id')
            ->andWhere(['in', 'vote_questions.id', $question_id])
            ->having('COUNT(vote_results.id)>=1')
            ->asArray()
            ->one();

        $response['all'] = $questionCount['QuestionCount'];
        $response['items'] = $res;
        return $response;
    }



    public function selectQuestion(){
        $question = Question::find()->active()->one();
        return isset($question)? $question : null;
    }

    public function listAnswers($question_id){
        $lang = Language::getLangByPrefix(\Yii::$app->language);
        $lang_id = $lang['id'];
        $answers = Answer::find()->select('id')->where(['question_id' => $question_id])->orderBy(['sort' => SORT_DESC])->all();
        foreach ($answers as $items) {
            $item['id'] = $items->id;
            $item['answer'] = (ArrayHelper::map($items->translations,'lang_id','answer'))[$lang_id];
            $response[] = $item;
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
