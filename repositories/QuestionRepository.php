<?php

namespace abdualiym\vote\repositories;

use abdualiym\vote\entities\Question;

class QuestionRepository
{
    public function get($id): Question
    {
        if (!$question = Question::findOne($id)) {
            throw new NotFoundException('Вопрос не найден.');
        }
        return $question;
    }


    public function save(Question $question)
    {
        if (!$question->save()) {
            throw new \RuntimeException('Сохранние Вопроса не выполнено.');
        }
    }


    public function remove(Question $question)
    {
        if (!$question->delete()) {
            throw new \RuntimeException('Удаление Вопроса не выполнено.');
        }
    }
}