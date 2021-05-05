<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "countries".
 *
 * @property int $id
 * @property string|null $country
 *
 * @property Cities[] $cities
 */
class Countries extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'countries';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['country'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'country' => 'Country',
        ];
    }

    /**
     * Gets query for [[Cities]].
     *
     * @return \yii\db\ActiveQuery|ExecutersCategoryQuery
     */
    public function getCities()
    {
        return $this->hasMany(Cities::class, ['country_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return CountriesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CountriesQuery(get_called_class());
    }
}
