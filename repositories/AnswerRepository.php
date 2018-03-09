<?php

namespace abdualiym\vote\repositories;

use abdualiym\vote\entities\Answer;

class AnswerRepository
{
    public function get($id): Answer
    {
        if (!$answer = Answer::findOne($id)) {
            throw new NotFoundException('Ответ не найден.');
        }
        return $answer;
    }


    public function save(Answer $answer)
    {
        if (!$answer->save()) {
            throw new \RuntimeException('Сохранние Ответ не выполнено.');
        }
    }


    public function remove(Answer $answer)
    {
        if (!$answer->delete()) {
            throw new \RuntimeException('Удаление Ответ не выполнено.');
        }
    }
}