<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%users}}`.
 */
class m210105_193109_add_city_id_column_to_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('users', 'city_id', 'mediumint(9)');
        $this->update('users', ['city_id'=> new \yii\db\Expression('id*EXTRACT(MONTH FROM birthday)')]);
        $this->addForeignKey('FKCID1', 'users', 'city_id', 'cities', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FKCID1', 'users');
        $this->dropColumn('users', 'city_id');
    }
}
