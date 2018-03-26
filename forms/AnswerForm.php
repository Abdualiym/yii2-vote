<?php

namespace abdualiym\vote\forms;

use abdualiym\languageClass\Language;
use abdualiym\vote\entities\Answer;
use elisdn\compositeForm\CompositeForm;
use yii\helpers\ArrayHelper;

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
            return $answer['translations'][0]['answer'];
        });
    }

    public function attributeLabels()
    {
        return [
            'sort' => 'Порядок',
            'status' => 'Статус',
            'question_id' => 'Вопрос',
            'created_at' => 'Дата добавления',
            'updated_at' => 'Дата обновления',
            'created_by' => 'Добавил',
            'updated_by' => 'Обновил',
        ];
    }

    public function internalForms()
    {
        return ['translations'];
    }
}