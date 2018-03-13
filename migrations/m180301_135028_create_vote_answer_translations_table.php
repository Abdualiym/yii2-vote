<?php

use yii\db\Migration;

/**
 * Handles the creation of table `vote_answer_translations`.
 */
class m180301_135028_create_vote_answer_translations_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('vote_answer_translations', [
            'id' => $this->primaryKey(),
            'answer_id' => $this->integer()->notNull(),
            'lang_id' => $this->integer()->notNull(),
            'answer' => $this->text()->notNull()
        ],'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
        $this->addForeignKey('fk-vote_answer_questions-vote_answers_id', 'vote_answer_translations', 'answer_id', 'vote_answers', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('vote_answer_translations');
    }
}
