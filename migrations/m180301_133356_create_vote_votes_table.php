<?php

use yii\db\Migration;

/**
 * Handles the creation of table `vote_votes`.
 */
class m180301_133356_create_vote_votes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('vote_votes', [
            'id' => $this->primaryKey(),
            'status' => $this->integer()->notNull(),
            'type' => $this->integer()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('vote_votes');
    }
}
