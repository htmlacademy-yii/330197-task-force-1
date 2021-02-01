<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%city}}`.
 */
class m210103_161713_add_country_id_column_to_city_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('cities', 'country_id', $this->smallInteger(8));
        $this->addForeignKey('FK3', 'cities', 'country_id', 'countries', 'id');

        $this->update('cities', ['country_id'=> 10],['not in','city',['Алупка','Алушта','Армянск','Бахчисарай','Белогорск','Джанкой',
'Евпатория','Керчь','Красноперекопск','Саки','Симферополь','Старый Крым','Судак','Феодосия','Щёлкино','Ялта']]);
        $this->update('cities', ['country_id'=> 14],['in','city',['Алупка','Алушта','Армянск','Бахчисарай','Белогорск','Джанкой',
'Евпатория','Керчь','Красноперекопск','Саки','Симферополь','Старый Крым','Судак','Феодосия','Щёлкино','Ялта']]);
        $this->update('cities', ['country_id'=> 10],['in','id',84]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FK3', 'cities');
        $this->dropColumn('cities', 'country_id');
    }
}
