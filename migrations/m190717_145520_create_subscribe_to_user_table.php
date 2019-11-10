<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%subscribe_to_user}}`.
 */
class m190717_145520_create_subscribe_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%subscribe_to_user}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->comment('Подписчик'),
            'user_to' => $this->integer()->comment('Пользователь'),
            'date_cr' => $this->datetime()->comment('Дата и время подписки'),
        ]);
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        
        $this->dropTable('{{%subscribe_to_user}}');
    }
}
