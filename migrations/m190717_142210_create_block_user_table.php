<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%block_user}}`.
 */
class m190717_142210_create_block_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%block_user}}', [
            'id' => $this->primaryKey(),
            'user_from' => $this->integer()->comment('Пользователь'),
            'user_to' => $this->integer()->comment('Кто заблокирован'),
            'date_cr' => $this->datetime()->comment('Дата блокировки'),
        ]);
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {  
        $this->dropTable('{{%block_user}}');
    }
}
