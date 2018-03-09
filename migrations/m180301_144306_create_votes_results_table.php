<?php

use yii\db\Migration;

/**
 * Handles the creation of table `votes_results`.
 */
class m180301_144306_create_votes_results_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('votes_results', [
            'id' => $this->primaryKey(),
            'answer_id' => $this->integer()->notNull(),
            'question_id' => $this->integer()->notNull(),
            'user_ip'=> $this->string(50)->notNull(),
            'user_id'=> $this->integer()->defaultValue(null),
            'created_at' => $this->integer()->notNull(),
        ]);
        $this->addForeignKey('fk-votes_results-vote_answers_id', 'votes_results', 'answer_id', 'vote_answers', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_vote_results_vote_votes_id', 'votes_results', 'question_id', 'vote_votes', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('votes_results');
    }
}
