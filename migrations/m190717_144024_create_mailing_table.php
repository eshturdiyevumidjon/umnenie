<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%mailing}}`.
 */
class m190717_144024_create_mailing_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%mailing}}', [
            'id' => $this->primaryKey(),
            'message' => $this->text()->comment('Текст'),
            'user' => $this->text()->comment('За кого отправлено'),
            'date_cr' => $this->datetime()->comment('Дата создании'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%mailing}}');
    }
}
