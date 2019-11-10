<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%specialization}}`.
 */
class m190710_094729_create_specialization_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%specialization}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255),
        ]);
        // $this->createIndex('idx-users-category_id', 'users', 'category_id', false);
        // $this->addForeignKey("fk-users-category_id", "users", "category_id", "poll_category", "id");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // $this->dropForeignKey('fk-users-category_id','users');
        // $this->dropIndex('idx-users-category_id','users');       

        $this->dropTable('{{%specialization}}');
    }
}
