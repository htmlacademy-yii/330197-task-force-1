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

        $query = Tasks::find()->joinWith('usersIdcustomer u', true, 'INNER JOIN')->andWhere(['is not','avatar',null]);
        $provider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $tasks = $provider->getModels();
        foreach($tasks as $task){
            $this->insert('stored_files',
                            ['idtask'=>$task->id, 
                             'file_path'=>$task['usersIdcustomer']->avatar,
                            ]);
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
