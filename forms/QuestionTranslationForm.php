<?php

namespace abdualiym\vote\forms;

use abdualiym\vote\entities\QuestionTranslation;
use yii\base\Model;

/**
 */
class QuestionTranslationForm extends Model
{

    public $lang_id;
    public $question;

    public function __construct(QuestionTranslation $translation = null, $config = [])
    {
        if ($translation) {
            $this->lang_id = $translation->lang_id;
            $this->question = $translation->question;
        }
        parent::__construct($config);
    }

    // validation

    public function rules(): array
    {
        return [
            [['lang_id', 'question'], 'required'],
            ['lang_id', 'integer'],
            [['question'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'lang_id' => 'Язык',
            'question' => 'Вопрос',
        ];
    }
}