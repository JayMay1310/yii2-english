<?php

use yii\db\Migration;

/**
 * Handles the creation of table `link`.
 */
class m191028_185251_create_link_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('link', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'link' => $this->string(100),
            'id_word' => $this->json(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('link');
    }
}
