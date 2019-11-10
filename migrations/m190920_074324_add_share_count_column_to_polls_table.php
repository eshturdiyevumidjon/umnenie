<?php

use yii\db\Migration;

/**
 * Handles adding share_count to table `{{%polls}}`.
 */
class m190920_074324_add_share_count_column_to_polls_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%polls}}', 'share_count', $this->integer()->defaultValue(0)->comment('Кол-во Поделится'));
        $this->addColumn('{{%polls}}', 'qr_count', $this->integer()->defaultValue(0)->comment('Кол-во Qr Code'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%polls}}', 'share_count');
        $this->dropColumn('{{%polls}}', 'qr_count');
    }
}
