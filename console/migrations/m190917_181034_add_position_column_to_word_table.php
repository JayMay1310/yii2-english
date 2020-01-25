<?php

use yii\db\Migration;

/**
 * Handles adding position to table `word`.
 */
class m190917_181034_add_position_column_to_word_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('word', 'send_telegram', $this->boolean());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('word', 'send_telegram');
    }
}
