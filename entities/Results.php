<?php

namespace abdualiym\vote\entities;

use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

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
    public function getQuestion()
    {
        return $this->hasOne(Question::className(), ['id' => 'question_id']);
    }

    public function create($answer_id, $question_id): self
    {
        $this->user_ip = Yii::$app->getRequest()->getUserIP();
        $this->answer_id = $answer_id;
        $this->question_id = $question_id;
        $this->user_id = Yii::$app->user->id;
        return $this->save() ? $this : null;
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
