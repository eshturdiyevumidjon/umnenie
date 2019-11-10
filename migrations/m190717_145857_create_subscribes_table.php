<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%subscribes}}`.
 */
class m190717_145857_create_subscribes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%subscribes}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->comment('Подписчик'),
            'user_from' => $this->integer()->comment('За кого подписан'),
            'date_cr' => $this->datetime()->comment('Дата подписки'),
        ]);
        
    }
 
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        
        $this->dropTable('{{%subscribes}}');
    }
}
