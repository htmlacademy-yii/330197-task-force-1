<?php

use yii\db\Migration;

/**
 * Class m201203_172756_update_table_tasks_set_idexecuter
 */
class m201203_172756_update_table_tasks_set_idexecuter extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->update('tasks', ['idexecuter'=> 12], 'id=12');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->update('tasks', ['idexecuter'=> null], 'id=12');
    }

}
