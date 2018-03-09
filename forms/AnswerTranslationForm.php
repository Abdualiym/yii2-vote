<?php

namespace abdualiym\vote\forms;

use abdualiym\vote\entities\AnswerTranslation;
use Yii;
use yii\base\Model;

/**
 *
 */
class AnswerTranslationForm extends Model
{
    public $lang_id;
    public $answer;

    public function __construct(AnswerTranslation $translation = null, $config = [])
    {
        if ($translation) {
            $this->lang_id = $translation->lang_id;
            $this->answer = $translation->answer;
        }
        parent::__construct($config);
    }


    public function rules(): array
    {
        return [
            [['lang_id', 'answer'], 'required'],
            ['lang_id', 'integer'],
            [['answer'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'lang_id' => 'Язык',
            'answer' => 'Ответь',
        ];
    }
}