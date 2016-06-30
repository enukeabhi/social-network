<?php
namespace frontend\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    
    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
            ['imageFile', 'required'],
        ];
    }
    
    public function upload()
    {
        //print_r($this->imageFile); exit;
        if ($this->validate()) {
            $this->imageFile->saveAs('themes/sakuti/images/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }
}
?>