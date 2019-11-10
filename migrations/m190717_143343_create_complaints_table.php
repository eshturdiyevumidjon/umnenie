<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%complaints}}`.
 */
class m190717_143343_create_complaints_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%complaints}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->comment('Пользователь'),
            'text' => $this->text()->comment('Текст'),
            'date_cr' => $this->datetime()->comment('Дата создании'),
        ]);
        
    } 

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        
        $this->dropTable('{{%complaints}}');
    }
}
