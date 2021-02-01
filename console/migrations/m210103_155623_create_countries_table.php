<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%countries}}`.
 */
class m210103_155623_create_countries_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('countries', [
            'id' => $this->primaryKey(),
        ]);
        $this->alterColumn('countries', 'id', $this->smallInteger(8).' NOT NULL AUTO_INCREMENT');
        $this->addColumn('countries', 'country', $this->string());
        $this->batchInsert('countries',['country'],
            [
                ['Азербайджан'],['Армения'],['Белоруссия'],['Грузия'],['Казахстан'],['Киргизия'],['Латвия'],['Литва'],['Молдавия'],['Россия'],['Таджикистан'],['Туркмения'],['Узбекистан'],['Украина'],['Эстония']
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('countries');
    }
}
