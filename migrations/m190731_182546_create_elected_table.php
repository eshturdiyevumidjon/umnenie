<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%elected}}`.
 */
class m190731_182546_create_elected_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%elected}}', [
            'id' => $this->primaryKey(),
            'poll_id' => $this->integer()->comment('Опросы'),
            'user_id' => $this->integer()->comment('Пользователи'),
            'cr_date' => $this->datetime()->comment('Дата создания'),
        ]);
        $this->createIndex('idx-elected-user_id', 'elected', 'user_id', false);
        $this->addForeignKey("fk-elected-user_id", "elected", "user_id", "users", "id");

        $this->createIndex('idx-elected-poll_id', 'elected', 'poll_id', false);
        $this->addForeignKey("fk-elected-poll_id", "elected", "poll_id", "polls", "id");
    }
 
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-elected-user_id','elected');
        $this->dropIndex('idx-elected-user_id','elected');

        $this->dropForeignKey('fk-elected-poll_id','elected');
        $this->dropIndex('idx-elected-poll_id','elected');
        
        $this->dropTable('{{%elected}}');
    }
}
