<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Handles the creation of table `dialog`.
 */
class m190801_182631_create_dialog_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%dialogname}}', [
            'id' => Schema::TYPE_PK,
            'parent_id' => Schema::TYPE_INTEGER,
            'title' => Schema::TYPE_STRING,
            'slug' => Schema::TYPE_STRING,
            'last_update' => Schema::TYPE_DATETIME,
        ], $tableOptions);
        
        $this->addForeignKey('fk-dialog-parent_id-dialogname-id', '{{%dialogname}}', 'parent_id', '{{%dialogname}}', 'id', 'CASCADE');

        $this->createTable('{{%dialogdetail}}', [
            'id' => Schema::TYPE_PK,
            'dialog' => Schema::TYPE_STRING,
            'translation' => Schema::TYPE_STRING,
            'step' => Schema::TYPE_INTEGER,
            'dialog_id' => Schema::TYPE_INTEGER,
            'last_update' => Schema::TYPE_DATETIME,
            'count' => Schema::TYPE_INTEGER,

        ], $tableOptions);
        $this->addForeignKey('fk-dialogname-category_id-dialogname_id', '{{%dialogdetail}}', 'dialog_id', '{{%dialogname}}', 'id', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%dialogdetail}}');
        $this->dropTable('{{%dialogname}}');
    }
}
