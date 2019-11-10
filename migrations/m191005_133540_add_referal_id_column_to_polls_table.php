<?php

use yii\db\Migration;

/**
 * Handles adding referal_id to table `{{%polls}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 */
class m191005_133540_add_referal_id_column_to_polls_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%polls}}', 'referal_id', $this->integer()->comment('Реферальная'));

        // creates index for column `referal_id`
        $this->createIndex(
            '{{%idx-polls-referal_id}}',
            '{{%polls}}',
            'referal_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-polls-referal_id}}',
            '{{%polls}}',
            'referal_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-polls-referal_id}}',
            '{{%polls}}'
        );

        // drops index for column `referal_id`
        $this->dropIndex(
            '{{%idx-polls-referal_id}}',
            '{{%polls}}'
        );

        $this->dropColumn('{{%polls}}', 'referal_id');
    }
}
