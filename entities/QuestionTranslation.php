<?php

namespace abdualiym\vote\entities;

use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property integer $lang_id
 * @property string $question_id
 * @property string $question
 *
 */
class QuestionTranslation extends ActiveRecord
{
    // create
    public static function create($lang_id, $question): self
    {
        $translation = new static();
        $translation->lang_id = $lang_id;
        $translation->question = $question;
        return $translation;
    }

    public static function blank($lang_id): self
    {
        $translation = new static();
        $translation->lang_id = $lang_id;
        return $translation;
    }

    public function edit($question)
    {
        $this->question = $question;
    }

    // select language
    public function isForLanguage($id): bool
    {
        return $this->lang_id == $id;
    }

    // this table
    public static function tableName(): string
    {
        return '{{%vote_question_translations}}';
    }
}
