<?php

namespace abdualiym\vote\repositories;

use abdualiym\vote\entities\Results;

class ResultsRepository
{
    public function get($id): Results
    {
        if (!$results = Results::findOne($id)) {
            throw new NotFoundException('Резултат не найден.');
        }
        return $results;
    }


    public function save(Results $results)
    {
        if (!$results->save()) {
            throw new \RuntimeException('Сохранние Резултат не выполнено.');
        }
    }


    public function remove(Results $results)
    {
        if (!$results->delete()) {
            throw new \RuntimeException('Удаление Резултат не выполнено.');
        }
    }
}