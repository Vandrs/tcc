<?php

namespace app\models\negocio;

use app\models\utils\GenericFileUpload;
use MongoDate;
use app\models\utils\DateUtil;
use app\models\utils\UrlUtil;
use yii\mongodb\Query;

/**
 * This is the model class for collection "projeto".
 *
 * @property \MongoId|string $_id
 * @property string $titulo
 * @property string $resumo
 * @property string $descricao
 * @property \MongoId|string$categoria_id
 * @property string $etapa
 * @property string $slug
 * @property string $url_externa
 * @property \MongoId|string $owner_id
 * @property string $foto_capa
 * @property string $anexo_titulo
 * @property string $anexo
 * @property \MongoDate $created_at
 * @property \MongoDate $updated_at
 */
class Projeto extends \yii\mongodb\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return ['c3','projeto'];
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id','titulo','resumo','descricao','categoria_id','etapa','slug','url_externa',
            'owner_id','foto_capa','anexo_titulo','anexo','created_at','updated_at',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['titulo', 'resumo', 'descricao', 'categoria_id', 'etapa', 'slug', 'url_externa', 'owner_id', 'foto_capa', 'anexo_titulo', 'anexo', 'created_at', 'updated_at'], 'safe'],
            [['titulo','descricao','categoria_id', 'etapa'], 'required', 'on' => 'novoProjeto', 'message' => 'Campo obrigatório']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => 'ID',
            'titulo' => 'Título*',
            'resumo' => 'Resumo',
            'descricao' => 'Descrição*',
            'categoria_id' => 'Categoria*',
            'etapa' => 'Etapa*',
            'slug' => 'Url parcial do projeto.',
            'url_externa' => 'Url para mais informações',
            'owner_id' => 'Owner ID',
            'foto_capa' => 'Foto de capa',
            'anexo' => 'Anexo',
            'anexo_titulo' => 'Título do anexo',
            'created_at' => 'Criado em',
            'updated_at' => 'Atualizado em',
        ];
    }
    
    public function beforeSave($insert) {
        if($insert){
            if(!$this->createAndValidateSlug($insert)){
                return false;
            }
            $this->created_at = new MongoDate();
        } else {
            $this->updated_at = new MongoDate();
        }
        return parent::beforeSave($insert);
    }
    
    private function createAndValidateSlug($insert){
        $strDate = DateUtil::getStringDate("d-m-Y");
        $strSlug = UrlUtil::parseToUrlSlug($this->titulo.'-'.$strDate);
        $this->slug = $strSlug;
        return $this->validateSlug($insert);
    }
    
    private function validateSlug($insert){
        $query = new Query();
        if($insert){
            $exist = $query->select(["_id"])->from(self::collectionName())->where(["slug"=>$this->slug])->one();
        } else {
            $exist = $query->select(["_id"])->from(self::collectionName())->where(["slug"=>$this->slug])->andWhere(['<>','_id',$this->_id])->one();
        }

        if(!empty($exist)){
            $this->addError('titulo','Este título já está sendo utilizado por outro projeto.');
            return false;
        }
        
        return true;
    }

    public function uploadFile($field){
        $fileUpload = new GenericFileUpload();
        if($fileUpload->setFile($this, $field)){
            if($fileUpload->validate($field) && ($filePath = $fileUpload->saveFile($field)) ){
                $this->$field = $filePath;
            } else {
                $errors = $fileUpload->getErrors($field);
                if(!empty($errors)){
                    $this->addError($field, $this->stringfySingleError($errors, "<br />"));
                } else if(empty($filePath)){
                    $this->addError($field, "Ocorreu um erro inesperado ao realizar o upload do arquivo.");
                }
            }
        }
    }
    
    private function stringfySingleError($errors,$glue){
        return implode($glue, $errors);
    }
    
    public function getStringfiedFieldErrors($field,$glue){
        return $this->stringfySingleError($this->getErrors($field), $glue);
    }
    
    public static function findBySlug($slug){
        return self::findOne(['slug' => $slug]);
    }
}