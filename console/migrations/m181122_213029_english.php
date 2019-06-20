<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Class m181122_213029_english
 */
class m181122_213029_english extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%category}}', [
            'id' => Schema::TYPE_PK,
            'parent_id' => Schema::TYPE_INTEGER,
            'title' => Schema::TYPE_STRING,
            'slug' => Schema::TYPE_STRING,
            'last_update' => Schema::TYPE_DATETIME,
        ], $tableOptions);
        
        $this->addForeignKey('fk-category-parent_id-category-id', '{{%category}}', 'parent_id', '{{%category}}', 'id', 'CASCADE');

        $this->createTable('{{%word}}', [
            'id' => Schema::TYPE_PK,
            'word' => Schema::TYPE_STRING,
            'translation' => Schema::TYPE_STRING,
            'category_id' => Schema::TYPE_INTEGER,
            'last_update' => Schema::TYPE_DATETIME,
            'count' => Schema::TYPE_INTEGER,

        ], $tableOptions);
        $this->addForeignKey('fk-word-category_id-category_id', '{{%word}}', 'category_id', '{{%category}}', 'id', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable('{{%word}}');
        $this->dropTable('{{%category}}');
    }

}
