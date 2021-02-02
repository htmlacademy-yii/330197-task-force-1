<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%executer_responds}}`.
 */
class m201217_103813_add_bid_column_to_executer_responds_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%executer_responds}}', 'bid', $this->integer());
        $this->update('{{%executer_responds}}', ['bid'=> new \yii\db\Expression('EXTRACT(YEAR FROM DT_ADD)-id_user-EXTRACT(day FROM dt_add)')]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%executer_responds}}', 'bid');
    }
}
