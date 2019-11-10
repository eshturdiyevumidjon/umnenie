<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%polls}}`.
 */
class m190713_122102_create_polls_table extends Migration
{
    /**
     * {@inheritdoc}  
     */
    public function safeUp() 
    {
        $this->createTable('{{%polls}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->comment('Пользователи'),
            'type' => $this->integer()->comment('Тип '),
            'date_cr' => $this->date()->comment('Дата создание'),
            'date_end' => $this->date()->comment('Дата окончание'),
            'category_id' => $this->text()->comment('Категория '),
            'visibility' => $this->integer()->comment('Видимость '),
            'term' => $this->integer()->comment('Срок опроса'),
            'status' => $this->integer()->comment('Статус '),
            'view_comment' => $this->integer()->comment('Просмотреть комментарий'),
            'hashtags' => $this->string(255)->comment('Хэштеги'),
            'publications' => $this->string(255)->comment('Публикация'),
            'question' => $this->text()->comment('Текст '),
            'image' => $this->string(255)->comment('Фотография опроса '),
        ]);
        $this->createIndex('idx-polls-user_id', 'polls', 'user_id', false);
        $this->addForeignKey("fk-polls-user_id", "polls", "user_id", "users", "id");

        // $this->createIndex('idx-polls-category_id', 'polls', 'category_id', false);
        // $this->addForeignKey("fk-polls-category_id", "polls", "category_id", "poll_category", "id");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-polls-user_id','polls');
        $this->dropIndex('idx-polls-user_id','polls');
        
        // $this->dropForeignKey('fk-polls-category_id','polls');
        // $this->dropIndex('idx-polls-category_id','polls');

        $this->dropTable('{{%polls}}');
    }
}
