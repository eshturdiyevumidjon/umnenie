<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%like}}`.
 */
class m190731_170705_create_like_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%like}}', [
            'id' => $this->primaryKey(),
            'poll_id' => $this->integer()->comment('Опросы'),
            'user_id' => $this->integer()->comment('Пользователи'),
            'cr_date' => $this->datetime()->comment('Дата создания'),
        ]);
        $this->createIndex('idx-like-user_id', 'like', 'user_id', false);
        $this->addForeignKey("fk-like-user_id", "like", "user_id", "users", "id");

        $this->createIndex('idx-like-poll_id', 'like', 'poll_id', false);
        $this->addForeignKey("fk-like-poll_id", "like", "poll_id", "polls", "id");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-like-user_id','like');
        $this->dropIndex('idx-like-user_id','like');

        $this->dropForeignKey('fk-like-poll_id','like');
        $this->dropIndex('idx-like-poll_id','like');
        
        $this->dropTable('{{%like}}');
    }
}
