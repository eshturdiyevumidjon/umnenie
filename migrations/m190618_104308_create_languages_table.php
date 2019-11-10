<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%languages}}`.
 */
class m190618_104308_create_languages_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%languages}}', [
            'id' => $this->primaryKey(),
            'key' => $this->string(255),
            'name_uz' => $this->text(),
            'name_ru' => $this->text(),
            'name_eng' => $this->text(),
        ]); 
        
        // $this->insert('languages',array('id' => '1','key' => 'home','name_uz' => 'Bosh sahifa','name_ru' => 'Главная','name_eng' => 'Home'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%languages}}');
    }
}
