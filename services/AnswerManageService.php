<?php

namespace abdualiym\vote\services;

use abdualiym\vote\entities\Answer;
use abdualiym\vote\forms\AnswerForm;
use abdualiym\vote\repositories\AnswerRepository;

class AnswerManageService
{
    private $answers;
    private $transaction;

    public function __construct(
        AnswerRepository $answers,
        TransactionManager $transaction
    )
    {
        $this->answers = $answers;
        $this->transaction = $transaction;
    }

    /**
     * @param AnswerForm $form
     * @return Answer
     */
    public function create(AnswerForm $form): Answer
    {
        $answer = Answer::create($form->sort, $form->question_id);

        foreach ($form->translations as $translation) {
            $answer->setTranslation($translation->lang_id, $translation->answer);
        }
        $this->answers->save($answer);
        return $answer;
    }

    public function edit($id, AnswerForm $form)
    {
        $answer = $this->answers->get($id);

        $answer->edit($form->sort);

        foreach ($form->translations as $translation) {
            $answer->setTranslation($translation->lang_id, $translation->answer);
        }

        $this->answers->save($answer);
    }

    public function activate($id)
    {
        $answer = $this->answers->get($id);
        $answer->activate();
        $this->answers->save($answer);
    }

    public function draft($id)
    {
        $answer = $this->answers->get($id);
        $answer->draft();
        $this->answers->save($answer);
    }

    public function remove($id)
    {
        $answer = $this->answers->get($id);
        $this->answers->remove($answer);
    }
}