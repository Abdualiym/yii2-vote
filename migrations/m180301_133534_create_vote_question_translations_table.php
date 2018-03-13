<?php

use yii\db\Migration;

/**
 * Handles the creation of table `vote_question_translations`.
 */
class m180301_133534_create_vote_question_translations_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('vote_question_translations', [
            'id' => $this->primaryKey(),
            'question_id' => $this->integer()->notNull(),
            'lang_id' => $this->integer()->notNull(),
            'question' => $this->text()->notNull(),
        ],'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
        $this->addForeignKey('fk-vote_question_translations-vote_vote_id', 'vote_question_translations', 'question_id', 'vote_questions', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('vote_question_translations');
    }
}
