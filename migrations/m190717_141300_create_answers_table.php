<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%answers}}`.
 */
class m190717_141300_create_answers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%answers}}', [
            'id' => $this->primaryKey(),
            'comment' => $this->text()->comment('Комментария'),
            'poll_id' => $this->integer()->comment('Опрос'),
            'poll_item_id' => $this->integer()->comment('Пункт опроса'),
            'user_id' => $this->integer()->comment('Пользователь'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%answers}}');
    }
}
