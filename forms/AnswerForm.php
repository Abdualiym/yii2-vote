<?php

namespace abdualiym\vote\forms;

use abdualiym\languageClass\Language;
use abdualiym\vote\entities\Answer;
use elisdn\compositeForm\CompositeForm;
use yii\helpers\ArrayHelper;
use Yii;

/**
 *
 * @property AnswerTranslationForm $translations
 */
class AnswerForm extends CompositeForm
{
    public $sort;
    public $status;
    public $question_id;
    private $_answer;

    public function __construct(Answer $answer = null, $config = [])
    {
        if ($answer) {
            $this->sort = $answer->sort;
            $this->question_id = $answer->question_id;
            $this->translations = array_map(function (array $language) use ($answer) {
                return new AnswerTranslationForm($answer->getTranslation($language['id']));
            }, Language::langList(\Yii::$app->params['languages']));
            $this->_answer = $answer;
        } else {
            $this->translations = array_map(function () {
                return new AnswerTranslationForm();
            }, Language::langList(\Yii::$app->params['languages']));
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['sort'], 'required'],
            [['sort', 'question_id'], 'integer'],
        ];
    }

    public function answerList(): array
    {
        return ArrayHelper::map(
            Answer::find()->with('translations')->asArray()->all(), 'id', function (array $answer) {
            return $answer['translations'][1]['answer'];
        });
    }

    public function attributeLabels()
    {
        return [
            'sort' => Yii::t('vote', 'Sort'),
            'status' => Yii::t('vote', 'Status'),
            'question_id' => Yii::t('vote', 'Question'),
            'created_at' => Yii::t('vote', 'Created at'),
            'updated_at' => Yii::t('vote', 'Updated at'),
            'created_by' => Yii::t('vote', 'Created by'),
            'updated_by' => Yii::t('vote', 'Updated by'),
        ];
    }

    public function internalForms()
    {
        return ['translations'];
    }
}