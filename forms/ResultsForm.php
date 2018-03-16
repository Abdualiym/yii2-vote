<?php

namespace abdualiym\vote\forms;

use abdualiym\vote\entities\Answer;
use abdualiym\vote\entities\Results;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * @property AnswerTranslationForm $translations
 */
class ResultsForm extends Model
{

    public $question_id;
    public $user_ip;
    public $user_id;
    public $answer_id;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['answer_id'], 'required'],
            [['answer_id'], 'integer'],
            [['user_ip', 'user_id', 'question_id'], 'required'],
            [['user_ip'], 'ip'],
        ];
    }

    public function validateDuplicate($answer_id = null)
    {
        if($answer_id == null){
            return null;
        }
        if($question = Answer::findOne(['id'=> $answer_id])->question_id){
            return Results::findOne(['question_id' => $question, 'user_ip' => Yii::$app->request->getUserIP()]);

        }
        return null;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'answer_id' => Yii::t('app', 'Answer ID')
        ];
    }

}