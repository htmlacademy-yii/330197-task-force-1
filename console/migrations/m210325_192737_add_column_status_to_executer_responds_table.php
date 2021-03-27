<?php

use yii\db\Migration;

/**
 * Class m210325_192737_add_column_status_to_executer_responds_table
 */
class m210325_192737_add_column_status_to_executer_responds_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%executer_responds}}', 'status', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%executer_responds}}', 'status');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210325_192737_add_column_status_to_executer_responds_table cannot be reverted.\n";

        return false;
    }
    */
}
