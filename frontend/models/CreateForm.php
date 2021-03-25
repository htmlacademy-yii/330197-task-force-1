<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use frontend\models\Tasks;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property int $idcustomer
 * @property int|null $idexecuter
 * @property string $title
 * @property string|null $description
 * @property int $idcategory
 * @property int|null $budget
 * @property string|null $dt_add
 * @property string|null $deadline
 * @property string|null $current_status
 * @property int|null $idcity
 * @property string|null $address
 * @property float|null $latitude
 * @property float|null $longitude
 *
 * @property Categories $idcategory
 * @property Cities $idcity
 * @property Users $idcustomer
 * @property Users $idexecuter
 * @property StoredFiles[] $storedFiles
 */

/**
 * Create form
 */
class CreateForm extends ActiveRecord
{
    public $file;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title','description','idcategory'], 'trim'],
            [['title','description','idcategory'], 'required'],
            ['title', 'string', 'min' => 2, 'max' => 255],
            [['description'], 'string'],
            [['idcategory'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['idcategory' => 'id']],
            [['file', 'deadline'],'safe'],
            // [['file'], 'file', 'extensions' => 'png, jpg, jpeg, tft, doc, docx, txt, pdf, xsl, xslx, rtf'],
            [['file'], 'file'],
            [['latitude', 'longitude','budget'], 'number'],
            [['idcity'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['idcity' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Мне нужно',
            'description' => 'Подробности задания',
            'idcategory' => 'Категория',
            'budget' => 'Бюджет',
            'dt_add' => 'Dt Add',
            'deadline' => 'Сроки исполнения',
            'idcity' => 'Idcity',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'current_status' => 'Current Status',
            'file' => $this->file,
        ];
    }

    public function upload() {
        if ($this->file && $this->validate()) {
            $newname = uniqid('user_file') . '.' . $this->file->getExtension();
            $this->file->saveAs('@webroot/user_files/' . $newname);
            return $newname;
        }
    }
}
