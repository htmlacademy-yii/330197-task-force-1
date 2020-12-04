<?php

use yii\db\Migration;
use frontend\models\Tasks;

/**
 * Class m201130_163755_update_table_comments
 */
class m201130_163755_update_table_comments extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('comments', 'rate');

        $this->addColumn('comments', 'id_user', 'mediumint(9) NOT NULL');
        $this->update('comments', ['id_user'=> new \yii\db\Expression('idtask')]);
        $this->addForeignKey('FK2', 'comments', 'id_user', 'users', 'id','CASCADE','CASCADE');

        $this->addColumn('comments', 'id', $this->smallInteger(8));
        $this->update('comments', ['id'=> new \yii\db\Expression('idtask')]);
        $this->addPrimaryKey('PK1', 'comments', 'id');
        $this->alterColumn('comments', 'id', $this->smallInteger(8).' NOT NULL AUTO_INCREMENT');

        $this->renameColumn('comments', 'idtask', 'target_task_id');
        $this->renameTable('comments', 'comments_for_task');
    
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameTable('comments_for_task','comments');
        $this->renameColumn('comments', 'target_task_id', 'idtask');
        $this->dropColumn('comments', 'id');
        $this->dropForeignKey('FK2', 'comments');
        $this->dropColumn('comments', 'id_user');
        $this->addColumn('comments', 'rate', $this->smallInteger(2));
    }

}
