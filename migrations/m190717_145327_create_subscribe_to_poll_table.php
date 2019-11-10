<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%subscribe_to_poll}}`.
 */
class m190717_145327_create_subscribe_to_poll_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%subscribe_to_poll}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->comment('Пользователь'),
            'poll_id' => $this->integer()->comment('Опрос'),
            'date_cr' => $this->datetime()->comment('Дата подписки'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropTable('{{%subscribe_to_poll}}');
    }
}
