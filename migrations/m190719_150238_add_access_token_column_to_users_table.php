<?php

use yii\db\Migration;

/**
 * Handles adding access_token to table `{{%users}}`.
 */
class m190719_150238_add_access_token_column_to_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%users}}', 'access_token', $this->string(255)->comment('Access Token'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%users}}', 'access_token');
    }
}
