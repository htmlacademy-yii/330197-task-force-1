<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%users}}`.
 */
class m210219_092651_add_status_column_to_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%users}}', 'status', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%users}}', 'status');
    }
}
