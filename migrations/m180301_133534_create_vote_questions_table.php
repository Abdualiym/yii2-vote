<?php

use yii\db\Migration;

/**
 * Handles the creation of table `vote_questions`.
 */
class m180301_133534_create_vote_questions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('vote_questions', [
            'id' => $this->primaryKey(),
            'vote_id' => $this->integer()->notNull(),
            'lang_id' => $this->integer()->notNull(),
            'question' => $this->text()->notNull(),
        ]);
        $this->addForeignKey('fk-vote_questions-vote_vote_id', 'vote_questions', 'vote_id', 'vote_votes', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('vote_questions');
    }
}
