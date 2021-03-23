<?php

use yii\db\Migration;

/**
 * Class m210323_104308_add_attach_id_column_to_stored_files
 */
class m210323_104308_add_attach_id_column_to_stored_files extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%stored_files}}', 'attach_id', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%stored_files}}', 'attach_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210323_104308_add_attach_id_column_to_stored_files cannot be reverted.\n";

        return false;
    }
    */
}
