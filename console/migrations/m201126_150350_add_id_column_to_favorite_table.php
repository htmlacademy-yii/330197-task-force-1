<?php

use yii\db\Migration;
use yii\db\Query;

/**
 * Handles adding columns to table `{{%favorite}}`.
 */
class m201126_150350_add_id_column_to_favorite_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%favorite}}', 'id', $this->smallInteger(8));
        
        $this->update('{{%favorite}}', ['id'=> new \yii\db\Expression('ifnull(iduser,0)+ifnull(idtask,0)+ifnull(idexecuter,0)')],'id is null');
        
        $this->addPrimaryKey('PK1', '{{%favorite}}', 'id');
        $this->alterColumn('{{%favorite}}', 'id', $this->smallInteger(8).' NOT NULL AUTO_INCREMENT');
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%favorite}}', 'id');
    }
}
