<?php

use yii\db\Migration;
use frontend\models\Tasks;
use frontend\models\Users;
use yii\data\ActiveDataProvider;

/**
 * Class m201224_180343_update_stored_files_table
 */
class m201224_180343_update_stored_files_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('stored_files', 'id', $this->smallInteger(8));
        $this->addPrimaryKey('PK1', 'stored_files', 'id');
        $this->alterColumn('stored_files', 'id', $this->smallInteger(8).' NOT NULL AUTO_INCREMENT');

        $this->alterColumn('stored_files', 'file_path', $this->string());

        $tasks = Tasks::find()->all();
        foreach($tasks as $task){
            $user = Users::findOne($task->idcustomer);
            if($user->avatar){
                $this->insert('stored_files',
                            ['idtask'=>$task->id, 
                             'file_path'=>$user->avatar,
                            ]);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('stored_files');
        $this->dropColumn('stored_files', 'id');
    }
}
