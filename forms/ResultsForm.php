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

    public $answer_id;
    public $question_id;
    public $user_ip;
    public $user_id;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['answer_id', 'user_ip', 'question_id'], 'required'],
            [['user_ip'], 'ip'],
        ];
    }

    public function validateDuplicate($answer_id)
    {

        $result = Results::find()->where(['answer_id' => $answer_id, 'user_ip' => Yii::$app->getRequest()->getUserIP()])->count();
        if($result < 1){
            return true;
        }else{
            return null;
        }
    }


    public function validateForm($resultForm): self
    {
        $result = new Results();
        $result->create($resultForm) ? $result : null;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'answer_id' => Yii::t('app', 'Answer ID'),
            'user_ip' => Yii::t('app', 'User Ip'),
            'user_id' => Yii::t('app', 'User ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

}