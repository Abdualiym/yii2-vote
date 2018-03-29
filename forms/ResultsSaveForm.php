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
class ResultsSaveForm extends Model
{

    public $question_id;
    public $user_ip;
    public $user_id;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        ];
    }

    public function validateDuplicate($answer_id)
    {
        $result = Results::find()->where(['answer_id' => $answer_id, 'user_ip' => Yii::$app->getRequest()->getUserIP()])->count();
        return $result == 0 ? true : null;

    }

    public function loadForm($question_id):self
    {
        $this->question_id = $question;
        $this->user_ip = $question;
        $this->user_id = $question;
        $this->validate()? $this : null;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_ip' => Yii::t('vote', 'User Ip'),
            'user_id' => Yii::t('vote', 'User ID'),
            'created_at' => Yii::t('vote', 'Created At'),
            'updated_at' => Yii::t('vote', 'Updated At'),
        ];
    }

}