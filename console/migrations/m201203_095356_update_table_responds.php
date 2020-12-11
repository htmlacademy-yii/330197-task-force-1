<?php

use yii\db\Migration;

/**
 * Class m201203_095356_update_table_responds
 */
class m201203_095356_update_table_responds extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('responds', 'id', $this->smallInteger(8));
        $this->update('responds', ['id'=> new \yii\db\Expression('idexecuter-10')]);
        $this->addPrimaryKey('PK1', 'responds', 'id');
        $this->alterColumn('responds', 'id', $this->smallInteger(8).' NOT NULL AUTO_INCREMENT');

        $this->renameColumn('responds', 'idexecuter', 'id_user');
        $this->renameColumn('responds', 'idtask', 'target_task_id');

        $this->renameTable('responds', 'executer_responds');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameTable('executer_responds','responds');
        $this->renameColumn('responds', 'target_task_id', 'idtask');
        $this->renameColumn('responds', 'id_user', 'idexecuter');
        $this->dropColumn('responds', 'id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201203_095356_update_table_responds cannot be reverted.\n";

        return false;
    }
    */
}
