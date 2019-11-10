<?php

use yii\db\Migration;

/**
 * Handles adding expire_at to table `{{%users}}`.
 */
class m190722_142940_add_expire_at_column_to_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%users}}', 'expire_at', $this->integer()->comment('Token expiration time'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%users}}', 'expire_at');
    }
}
