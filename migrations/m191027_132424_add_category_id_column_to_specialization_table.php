<?php

use yii\db\Migration;

/**
 * Handles adding category_id to table `{{%specialization}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%poll_category}}`
 */
class m191027_132424_add_category_id_column_to_specialization_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%specialization}}', 'category_id', $this->integer()->comment('Poll category'));

        // creates index for column `category_id`
        $this->createIndex(
            '{{%idx-specialization-category_id}}',
            '{{%specialization}}',
            'category_id'
        );

        // add foreign key for table `{{%poll_category}}`
        $this->addForeignKey(
            '{{%fk-specialization-category_id}}',
            '{{%specialization}}',
            'category_id',
            '{{%poll_category}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%poll_category}}`
        $this->dropForeignKey(
            '{{%fk-specialization-category_id}}',
            '{{%specialization}}'
        );

        // drops index for column `category_id`
        $this->dropIndex(
            '{{%idx-specialization-category_id}}',
            '{{%specialization}}'
        );

        $this->dropColumn('{{%specialization}}', 'category_id');
    }
}
