<?php

use yii\db\Migration;

/**
 * Class m201217_151908_update_current_status_ot_tasks
 */
class m201217_151908_update_current_status_ot_tasks extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->update('tasks',['current_status' =>'new'],['in','id',[1,4]]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->update('tasks',['current_status' =>'done'],['in','id',[1,4]]);
    }
}
