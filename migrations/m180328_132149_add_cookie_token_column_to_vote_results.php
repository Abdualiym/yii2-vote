<?php

use yii\db\Migration;
use abdualiym\vote\entities\Results;

/**
 * Class m180328_132149_add_cookie_token_column_to_vote_results
 */
class m180328_132149_add_cookie_token_column_to_vote_results extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('vote_results', 'cookie_token', $this->string(50)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180328_132149_add_cookie_token_column_to_vote_results cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180328_132149_add_cookie_token_column_to_vote_results cannot be reverted.\n";

        return false;
    }
    */
}
