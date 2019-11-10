<?php
namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
use Yii;
/**
 * UploadForm is the model behind the upload form.
 */
class UploadForm extends Model
{

    public $file;
    public $type;
    public $anyFiles;
    public $anyDocuments;
    /**
     * @return array the validation rules.
     */
    public function rules() 
    {
        return [
            [['file'], 'file'],
            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'xls, xlsx',],
            [['anyFiles'], 'file', 'skipOnEmpty' => true, 'maxFiles' => 20],
            [['anyDocuments'], 'file', 'skipOnEmpty' => true, 'maxFiles' => 10],
        ];
    }

    public function attributeLabels()
    {
        return [
            'file' => 'Файл',
            'anyFiles' => 'Файлы',
            'anyDocuments' => 'Документы',
        ];
    } 
    public function upload(Directory $directory, $order_id)
    {
        if ($this->validate()) {

            $path = $directory->createDirectory($order_id);

            $file = $this->anyFiles[0];
            $filename = Yii::$app->security->generateRandomString(8) . '.' . $file->extension;
            $file->saveAs($path . $filename);

            return $path . $filename;
        } else {
            return false;
        }
    }
    public function uploadDocuments(Directory $directory, $order_id)
    {
        if ($this->validate()) {

            $path = $directory->createDirectoryDocuments($order_id);

            $file = $this->anyDocuments[0];
            $filename = Yii::$app->security->generateRandomString(8) . '.' . $file->extension;
            $file->saveAs($path . $filename);

            return $path . $filename;
        } else {
            return false;
        }
    }
}
?>