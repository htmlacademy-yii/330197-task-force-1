<?php

use yii\db\Migration;

/**
 * Class m201126_153039_rename_idexecuter_column_to_faviorite_table
 */
class m201126_153039_rename_idexecuter_column_to_faviorite_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('{{%favorite}}','idexecuter','favorite_user');
        $this->renameColumn('{{%favorite}}','idtask','favorite_task');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('{{%favorite}}','favorite_user','idexecuter');
        $this->renameColumn('{{%favorite}}','favorite_task','idtask');
    }
}
