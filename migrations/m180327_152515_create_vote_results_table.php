<?php

use yii\db\Migration;

/**
 * Handles the creation of table `vote_results`.
 */
class m180327_152515_create_vote_results_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('fk_vote_results_vote_questions_id', 'vote_results');

        $this->dropColumn('vote_results', 'question_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        false;
    }
}
