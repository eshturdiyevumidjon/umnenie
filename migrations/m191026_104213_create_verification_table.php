<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%verification}}`.
 */
class m191026_104213_create_verification_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%verification}}', [
            'id' => $this->primaryKey(),
            'sms_code' => $this->string(255)->comment('Sms Code'),
            'phone' => $this->string(255)->comment('Телефон номер'),
            'status' => $this->integer()->comment('Статус'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%verification}}');
    }
}
