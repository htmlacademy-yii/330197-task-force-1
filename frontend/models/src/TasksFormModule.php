<?php

namespace frontend\models\src;

use yii\db\ActiveRecord;

class Tasks
FormModule extends ActiveRecord{
	
	public function attributeLabels()
    {
        return [
            'categories' => 'Категории',
            'addition' => 'Дополнительно',
            'period' => 'Период',
            'search' => 'Поиск по названию',
        ];
    }
    public function rules()
    {
        return [
            [['categories', 'addition', 'period', 'search'], 'safe']
        ];
    }
}