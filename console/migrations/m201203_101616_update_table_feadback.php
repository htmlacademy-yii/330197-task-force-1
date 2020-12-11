<?php

use yii\db\Migration;

/**
 * Class m201203_101616_update_table_feadback
 */
class m201203_101616_update_table_feadback extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('feadback', 'id', $this->smallInteger(8));
        $this->update('feadback', ['id'=> new \yii\db\Expression('ROUND((EXTRACT(DAY FROM dt_add) * EXTRACT(month FROM dt_add) * idexecuter*rate*idcustomer-idcustomer-idexecuter-rate-idtask-EXTRACT(DAY FROM dt_add)-EXTRACT(month FROM dt_add))/365)')]);
        $this->addPrimaryKey('PK1', 'feadback', 'id');
        $this->alterColumn('feadback', 'id', $this->smallInteger(8).' NOT NULL AUTO_INCREMENT');

        $this->renameColumn('feadback', 'idcustomer', 'id_user');
        $this->renameColumn('feadback', 'idexecuter', 'target_user_id');
        $this->renameColumn('feadback', 'idtask', 'target_task_id');

        $this->renameTable('feadback', 'feedback_about_executer');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameTable('feedback_about_executer','feadback');
        $this->renameColumn('feadback', 'target_task_id', 'idtask');
        $this->renameColumn('feadback', 'target_user_id', 'idexecuter');
        $this->renameColumn('feadback', 'id_user', 'idcustomer');
        $this->dropColumn('feadback', 'id');
    }

}
