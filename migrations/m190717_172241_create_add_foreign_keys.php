<?php

use yii\db\Migration;

/**
 * Class m190717_172241_create_add_foreign_keys
 */
class m190717_172241_create_add_foreign_keys extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('idx-answers-poll_id', 'answers', 'poll_id', false);
        $this->addForeignKey("fk-answers-poll_id", "answers", "poll_id", "polls", "id");

        $this->createIndex('idx-answers-poll_item_id', 'answers', 'poll_item_id', false);
        $this->addForeignKey("fk-answers-poll_item_id", "answers", "poll_item_id", "poll_items", "id");

        $this->createIndex('idx-answers-user_id', 'answers', 'user_id', false);
        $this->addForeignKey("fk-answers-user_id", "answers", "user_id", "users", "id");

        $this->createIndex('idx-block_user-user_from', 'block_user', 'user_from', false);
        $this->addForeignKey("fk-block_user-user_from", "block_user", "user_from", "users", "id");

        $this->createIndex('idx-block_user-user_to', 'block_user', 'user_to', false);
        $this->addForeignKey("fk-block_user-user_to", "block_user", "user_to", "users", "id");

        $this->createIndex('idx-complaints-user_id', 'complaints', 'user_id', false);
        $this->addForeignKey("fk-complaints-user_id", "complaints", "user_id", "users", "id");

        $this->createIndex('idx-subscribe_to_poll-user_id', 'subscribe_to_poll', 'user_id', false);
        $this->addForeignKey("fk-subscribe_to_poll-user_id", "subscribe_to_poll", "user_id", "users", "id");

        $this->createIndex('idx-subscribe_to_poll-poll_id', 'subscribe_to_poll', 'poll_id', false);
        $this->addForeignKey("fk-subscribe_to_poll-poll_id", "subscribe_to_poll", "poll_id", "polls", "id");


        $this->createIndex('idx-subscribe_to_user-user_id', 'subscribe_to_user', 'user_id', false);
        $this->addForeignKey("fk-subscribe_to_user-user_id", "subscribe_to_user", "user_id", "users", "id");

        $this->createIndex('idx-subscribe_to_user-user_to', 'subscribe_to_user', 'user_to', false);
        $this->addForeignKey("fk-subscribe_to_user-user_to", "subscribe_to_user", "user_to", "users", "id");

        $this->createIndex('idx-subscribes-user_id', 'subscribes', 'user_id', false);
        $this->addForeignKey("fk-subscribes-user_id", "subscribes", "user_id", "users", "id");

        $this->createIndex('idx-subscribes-user_from', 'subscribes', 'user_from', false);
        $this->addForeignKey("fk-subscribes-user_from", "subscribes", "user_from", "users", "id");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-answers-poll_id','answers');
        $this->dropIndex('idx-answers-poll_id','answers');

        $this->dropForeignKey('fk-answers-poll_item_id','answers');
        $this->dropIndex('idx-answers-poll_item_id','answers');

        $this->dropForeignKey('fk-answers-user_id','answers');
        $this->dropIndex('idx-answers-user_id','answers');

        $this->dropForeignKey('fk-block_user-user_from','block_user');
        $this->dropIndex('idx-block_user-user_from','block_user');

        $this->dropForeignKey('fk-block_user-user_to','block_user');
        $this->dropIndex('idx-block_user-user_to','block_user');

        $this->dropForeignKey('fk-complaints-user_id','complaints');
        $this->dropIndex('idx-complaints-user_id','complaints');

        $this->dropForeignKey('fk-subscribe_to_poll-user_id','subscribe_to_poll');
        $this->dropIndex('idx-subscribe_to_poll-user_id','subscribe_to_poll');

        $this->dropForeignKey('fk-subscribe_to_poll-poll_id','subscribe_to_poll');
        $this->dropIndex('idx-subscribe_to_poll-poll_id','subscribe_to_poll');

        $this->dropForeignKey('fk-subscribe_to_user-user_id','subscribe_to_user');
        $this->dropIndex('idx-subscribe_to_user-user_id','subscribe_to_user');

        $this->dropForeignKey('fk-subscribe_to_user-user_to','subscribe_to_user');
        $this->dropIndex('idx-subscribe_to_user-user_to','subscribe_to_user');

        $this->dropForeignKey('fk-subscribes-user_id','subscribes');
        $this->dropIndex('idx-subscribes-user_id','subscribes');

        $this->dropForeignKey('fk-subscribes-user_from','subscribes');
        $this->dropIndex('idx-subscribes-user_from','subscribes');
    }
}
