<?php

use yii\db\Migration;

/**
 * Class m210108_102332_insert_rows_to_portfolio_table
 */
class m210108_102332_insert_rows_to_portfolio_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('portfolio', 'id', $this->smallInteger(8));
        $this->delete('portfolio');
        $this->addPrimaryKey('PK1', 'portfolio', 'id');
        $this->alterColumn('portfolio', 'id', $this->smallInteger(8).' NOT NULL AUTO_INCREMENT');

        $this->batchInsert('portfolio',['idexecuter','photo'],
            [
                [11,'rome-photo.jpg'],[11,'dotonbori-photo.png'],
                [12,'rome-photo.jpg'],[12,'smartphone-photo.png'],
                [16,'rome-photo.jpg'],[19,'smartphone-photo.png'],
                [21,'rome-photo.jpg'],[21,'smartphone-photo.png'],[21,'dotonbori-photo.png'],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('portfolio');
        $this->dropColumn('portfolio', 'id');
        $this->batchInsert('portfolio',['idexecuter','photo'],
            [
                [11,'img/rome-photo.jpg'],[12,'img/dotonbori-photo.png'],
            ]);

        
    }
}
