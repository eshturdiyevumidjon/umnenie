<?php

use yii\db\Migration;

/**
 * Handles adding poll_id to table `{{%complaints}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%polls}}`
 */
class m190920_071807_add_poll_id_column_to_complaints_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%complaints}}', 'poll_id', $this->integer()->comment('Опрос'));

        // creates index for column `poll_id`
        $this->createIndex(
            '{{%idx-complaints-poll_id}}',
            '{{%complaints}}',
            'poll_id'
        );

        // add foreign key for table `{{%polls}}`
        $this->addForeignKey(
            '{{%fk-complaints-poll_id}}',
            '{{%complaints}}',
            'poll_id',
            '{{%polls}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%polls}}`
        $this->dropForeignKey(
            '{{%fk-complaints-poll_id}}',
            '{{%complaints}}'
        );

        // drops index for column `poll_id`
        $this->dropIndex(
            '{{%idx-complaints-poll_id}}',
            '{{%complaints}}'
        );

        $this->dropColumn('{{%complaints}}', 'poll_id');
    }
}
