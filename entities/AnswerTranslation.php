<?php

namespace abdualiym\vote\entities;

use yii\db\ActiveRecord;

/**
 *
 * @property integer $id
 * @property integer $lang_id
 * @property string $answer
 */
class AnswerTranslation extends ActiveRecord
{
    public static function create($lang_id, $answer): self
    {
        $translation = new static();
        $translation->lang_id = $lang_id;
        $translation->answer = $answer;
        return $translation;
    }

    public static function blank($lang_id): self
    {
        $translation = new static();
        $translation->lang_id = $lang_id;
        return $translation;
    }

    public function edit($answer)
    {
        $this->answer = $answer;
    }
    //select language

    public function isForLanguage($id): bool
    {
        return $this->lang_id == $id;
    }
    //table name
    public static function tableName(): string
    {
        return '{{%vote_answer_translations}}';
    }
}
