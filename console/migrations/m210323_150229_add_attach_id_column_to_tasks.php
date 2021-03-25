<?php

use yii\db\Migration;

/**
 * Class m210323_150229_add_attach_id_column_to_tasks
 */
class m210323_150229_add_attach_id_column_to_tasks extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%tasks}}', 'attach_id', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%tasks}}', 'attach_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210323_150229_add_attach_id_column_to_tasks cannot be reverted.\n";

        return false;
    }
    */
}
