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
            [['user_ip', 'user_id'], 'required'],
            [['user_ip'], 'ip'],
        ];
    }

    public function validateDuplicate($answer_id = null)
    {
        if($answer_id == null){
            return null;
        }
        return Results::find()
            ->innerJoin('vote_answers', 'vote_results.answer_id = vote_answers.id')
            ->innerJoin('vote_questions', 'vote_answers.question_id = vote_questions.id')
            ->andWhere(['in', 'vote_questions.id', Answer::findOne($answer_id)->question_id])
            ->andWhere(['in', 'vote_results.user_ip', Yii::$app->request->getUserIP()])
            ->asArray()
            ->one();


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