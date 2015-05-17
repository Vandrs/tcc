<?php

namespace app\models\negocio;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for collection "categoria".
 *
 * @property \MongoId|string $_id
 * @property mixed $nome
 * @property mixed $descricao
 * @property mixed $created_at
 * @property mixed $updated_at
 */
class Categoria extends \yii\mongodb\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return 'categoria';
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id','nome','descricao','created_at','updated_at'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome', 'descricao', 'created_at', 'updated_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => 'ID',
            'nome' => 'Nome',
            'descricao' => 'Descricao',
            'created_at' => 'Criado em',
            'updated_at' => 'Atualizado em',
        ];
    }
    
    public static function getCategoriasForDropDown($orderBy = null){
        if(empty($orderBy)){
            $categorias =  self::find()->all();
        } else {
            $categorias =  self::find()->orderBy($orderBy)->all();
        }
        return self::mapArray($categorias);
    }
    
    public static function mapArray($categorias){
        $dropdownList = [];
        foreach($categorias as $categoria){
            $dropdownList[(string)$categoria->_id] = $categoria->nome;
        }
        return $dropdownList;
    }
}