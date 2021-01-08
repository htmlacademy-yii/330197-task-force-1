<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "stored_files".
 *
 * @property int $idtask
 * @property string|null $file_path
 * @property int $id
 *
 * @property Tasks $idtask0
 */
class StoredFiles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stored_files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idtask'], 'required'],
            [['idtask'], 'integer'],
            [['file_path'], 'string', 'max' => 255],
            [['idtask'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::className(), 'targetAttribute' => ['idtask' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idtask' => 'Idtask',
            'file_path' => 'File Path',
            'id' => 'ID',
        ];
    }

    /**
     * Gets query for [[Idtask0]].
     *
     * @return \yii\db\ActiveQuery|TasksQuery
     */
    public function getTasksId()
    {
        return $this->hasOne(Tasks::className(), ['id' => 'idtask']);
    }

    /**
     * {@inheritdoc}
     * @return StoredFilesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StoredFilesQuery(get_called_class());
    }
}
