<?php

namespace abdualiym\vote\forms;

use abdualiym\languageClass\Language;
use abdualiym\vote\entities\Question;
use elisdn\compositeForm\CompositeForm;
use abdualiym\vote\helpers\QuestionHelper;

/**
 *
 * @property QuestionTranslationForm $translations
 */
class QuestionForm extends CompositeForm
{
    public $type;
    public $status;
    private $_question;

    public function __construct(Question $question = null, $config = [])
    {
        if ($question) {
            $this->type = $question->type;
            $this->translations = array_map(function (array $language) use ($question) {
                return new QuestionTranslationForm($question->getTranslation($language['id']));
            }, Language::langList(\Yii::$app->params['languages']));
            $this->_question = $question;
        } else {
            $this->translations = array_map(function () {
                return new QuestionTranslationForm();
            }, Language::langList(\Yii::$app->params['languages']));
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['type'], 'required'],
            [['type'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'type' => 'Тип запроса',
            'status' => 'Статус',
            'created_at' => 'Дата добавления',
            'updated_at' => 'Дата обновления',
            'created_by' => 'Добавил',
            'updated_by' => 'Обновил',
        ];
    }


    public function typesList(): array
    {
        return QuestionHelper::typeList();
    }


    public function internalForms()
    {
        return ['translations'];
    }
}