<?php

namespace abdualiym\vote\services;

use abdualiym\vote\entities\Question;
use abdualiym\vote\forms\QuestionForm;
use abdualiym\vote\repositories\QuestionRepository;

class QuestionManageService
{
    private $questions;
    private $transaction;

    public function __construct(
        QuestionRepository $questions,
        TransactionManager $transaction
    )
    {
        $this->questions = $questions;
        $this->transaction = $transaction;
    }

    /**
     * @param QuestionForm $form
     * @return Question
     */
    public function create(QuestionForm $form): Question
    {
        $question = Question::create($form->type);

        foreach ($form->translations as $translation) {
            $question->setTranslation($translation->lang_id, $translation->question);
        }

        $this->questions->save($question);

        return $question;
    }

    public function edit($id, QuestionForm $form)
    {
        $question = $this->questions->get($id);

        $question->edit($form->type);

        foreach ($form->translations as $translation) {
            $question->setTranslation($translation->lang_id, $translation->question);
        }

        $this->questions->save($question);
    }

    public function activate($id)
    {
        $question = $this->questions->get($id);
        $question->activate();
        $this->questions->save($question);
    }

    public function draft($id)
    {
        $question = $this->questions->get($id);
        $question->draft();
        $this->questions->save($question);
    }

    public function remove($id)
    {
        $question = $this->questions->get($id);
        $this->questions->remove($question);
    }

}