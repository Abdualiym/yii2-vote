<?php

use yii\db\Migration;

/**
 * Handles the creation of table `vote_answers`.
 */
class m180301_133724_create_vote_answers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('vote_answers', [
            'id' => $this->primaryKey(),
            'question_id' => $this->integer()->notNull(),
            'status' => $this->integer()->notNull(),
            'sort' => $this->integer()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ],'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
        $this->addForeignKey('fk-votes_answers-id', 'vote_answers', 'question_id', 'vote_questions', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('vote_answers');
    }
}
