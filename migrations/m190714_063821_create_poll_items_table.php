<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%poll_items}}`.
 */
class m190714_063821_create_poll_items_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%poll_items}}', [
            'id' => $this->primaryKey(),
            'poll_id' => $this->integer()->comment('Опросы'),
            'option' => $this->string(255)->comment('Вариант ответа'),
            'image' => $this->string(255)->comment('Картинка'),
        ]);
        $this->createIndex('idx-poll_items-poll_id', 'poll_items', 'poll_id', false);
        $this->addForeignKey("fk-poll_items-poll_id", "poll_items", "poll_id", "polls", "id");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-poll_items-poll_id','poll_items');
        $this->dropIndex('idx-poll_items-poll_id','poll_items');

        $this->dropTable('{{%poll_items}}');
    }
}
