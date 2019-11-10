<?php

use yii\db\Migration;

/**
 * Handles adding sms_code to table `{{%users}}`.
 */
class m191010_180917_add_sms_code_column_to_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%users}}', 'sms_code', $this->string(255)->comment('Sms Code'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%users}}', 'sms_code');
    }
}
