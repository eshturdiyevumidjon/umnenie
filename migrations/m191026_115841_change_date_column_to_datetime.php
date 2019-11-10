<?php

use yii\db\Migration;

/**
 * Class m191026_115841_change_date_column_to_datetime
 */
class m191026_115841_change_date_column_to_datetime extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->alterColumn('polls', 'date_cr', $this->datetime() );//timestamp new_data_type
    }

    public function down() 
    {
        $this->alterColumn('polls','date_cr', $this->date() );//int is old_data_type
    }
}
