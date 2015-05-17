<?php

namespace app\models\utils;
use yii\base\Model;
use yii\web\UploadedFile;
use app\models\utils\DateUtil;

class GenericFileUpload extends Model{
    
    const FILE_UPLOAD_DIRECTORY = 'upload/';
    public $anexo;
    public $foto_capa;

    public function rules(){
        return [
            [
                ['anexo'],'file','extensions' => ['pdf','ppt','pptx'], 'maxSize' => 5000000, 'maxFiles' => 1, 
                'message' => 'Ocorreu um erro ao tentar fazer upload do arquivo.', 'wrongExtension' => 'Arquivo com extensão não permitida.', 
                'tooBig' => 'O tamanho do arquivo excede o máximo permitido.'
            ],
            [
                ['foto_capa'],'file','extensions' => ['png','jpeg','jpg'], 'maxSize' => 1000000, 'maxFiles' => 1, 
                'message' => 'Ocorreu um erro ao tentar fazer upload do arquivo.', 'wrongExtension' => 'Arquivo com extensão não permitida.', 
                'tooBig' => 'O tamanho do arquivo excede o máximo permitido.'  
            ]
        ];
    }
    
    public function setFile($model, $field){
        $this->$field = UploadedFile::getInstance($model, $field);
        if($this->$field){
            return true;
        }
        return false;
    }
    
    public function saveFile($field){
        $filePath = self::FILE_UPLOAD_DIRECTORY . $this->$field->baseName . DateUtil::getStringDate('Y-m-d-His') .'.' . $this->$field->extension;
        if($this->$field->saveAs($filePath)){
            return $filePath;
        } else {
            return false;
        }
    }
    
    public function getUploadedFileErrorCode($field){
        return $this->$field->error;
    }
}