<?php

use yii\db\Migration;

/**
 * Handles the creation of table `vote_results`.
 */
class m180301_144306_create_vote_results_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('vote_results', [
            'id' => $this->primaryKey(),
            'answer_id' => $this->integer()->notNull(),
            'question_id' => $this->integer()->notNull(),
            'user_ip'=> $this->string(50)->notNull(),
            'user_id'=> $this->integer()->defaultValue(null),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ],'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
        $this->addForeignKey('fk-votes_results-vote_answers_id', 'vote_results', 'answer_id', 'vote_answers', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_vote_results_vote_questions_id', 'vote_results', 'question_id', 'vote_questions', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('vote_results');
    }
}
