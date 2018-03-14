<?php

namespace abdualiym\vote\services;

use abdualiym\vote\entities\Results;
use abdualiym\vote\forms\ResultsForm;
use abdualiym\vote\repositories\ResultsRepository;

class ResultsManageService
{
    private $results;
    private $transaction;

    public function __construct(
        ResultsRepository $results,
        TransactionManager $transaction
    )
    {
        $this->results = $results;
        $this->transaction = $transaction;
    }

    /**
     * @param ResultsForm $form
     * @return Results
     */
    public function create(ResultsForm $form): Results
    {
        $results = Results::create($form->answer_id);
        $this->results->save($results);
        return $results;
    }

    public function edit($id, ResultsForm $form)
    {
        $results = $this->results->get($id);

        $results->edit($form->answer_id);

        $this->results->save($results);
    }

    public function activate($id)
    {
        $results = $this->results->get($id);
        $results->activate();
        $this->results->save($results);
    }

    public function draft($id)
    {
        $results = $this->results->get($id);
        $results->draft();
        $this->results->save($results);
    }

    public function remove($id)
    {
        $results = $this->results->get($id);
        $this->results->remove($results);
    }

}