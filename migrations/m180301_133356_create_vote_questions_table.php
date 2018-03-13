<?php

use yii\db\Migration;

/**
 * Handles the creation of table `vote_questions`.
 */
class m180301_133356_create_vote_questions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('vote_questions', [
            'id' => $this->primaryKey(),
            'status' => $this->integer()->notNull(),
            'type' => $this->integer()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('vote_questions');
    }
}
