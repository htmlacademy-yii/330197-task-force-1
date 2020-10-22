<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%users}}`.
 */
class m201022_173624_add_views_column_to_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%users}}', 'views', $this->integer());
        $this->update('{{%users}}', ['views'=> new \yii\db\Expression('EXTRACT(MONTH FROM birthday)')], 'role = 2');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%users}}', 'views');
    }
}
