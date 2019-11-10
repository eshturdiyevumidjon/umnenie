<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%chat}}`.
 */
class m190710_140917_create_chat_table extends Migration
{
    /** 
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%chat}}', [
            'id' => $this->primaryKey(),
            'type' => $this->integer()->comment('Тип'),
            'chat_id' => $this->string(255)->comment('Чат ИД'),
            'date_cr' => $this->datetime()->comment('Дата создания'),
            'from' => $this->integer()->comment('Создатель'),
            'to' => $this->integer()->comment('Получатель'),
            'title' => $this->string(255)->comment('Заголовок'),
            'file' => $this->string(255)->comment('Файл'),
            'text' => $this->text()->comment('Текст'),
            'reply' => $this->integer()->comment('Ответить'),
            'deleted' => $this->boolean()->comment('Удалено'),
        ]);

        $this->createIndex('idx-chat-from', 'chat', 'from', false);
        $this->addForeignKey("fk-chat-from", "chat", "from", "users", "id");

        $this->createIndex('idx-chat-to', 'chat', 'to', false);
        $this->addForeignKey("fk-chat-to", "chat", "to", "users", "id");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-chat-from','chat');
        $this->dropIndex('idx-chat-from','chat');
        
        $this->dropForeignKey('fk-chat-to','chat');
        $this->dropIndex('idx-chat-to','chat');

        $this->dropTable('{{%chat}}');
    }
}
