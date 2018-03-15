<?php

namespace abdualiym\vote\entities;

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
 * @property string $question_id
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
    public function getQuestion()
    {
        return $this->hasOne(Question::className(), ['id' => 'question_id']);
    }

    public function create($answer_id): self
    {
        $result = new static();
        $result->answer_id = $answer_id;
        $result->question_id = Answer::findOne($answer_id)->question_id;
        $result->user_ip = Yii::$app->getRequest()->getUserIP();
        $result->user_id = Yii::$app->user->id;
        return $result;
    }

    public function edit($answer_id)
    {
        $this->answer_id = $answer_id;
    }

    public function listAnswersResult($question_id){
         $answers = Answer::find()->select('id')->where(['question_id' => $question_id])->all();
           foreach ($answers as $items) {
               $item['id'] = $items->id;
               $item['count'] = Results::find()->where(['answer_id' => $items->id])->count();
               $res[] = $item;
           }
           $response['all'] = Results::find()->where(['question_id' => $question_id])->count();
           $response['items'] = $res;
          return $response;
    }



    public function selectQuestion(){
        $question = Question::find()->active()->one();
        return isset($question)? $question : null;
    }

    public function listAnswers($question_id,$lang_id = 1){
        $answers = Answer::find()->select('id')->where(['question_id' => $question_id])->all();
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
