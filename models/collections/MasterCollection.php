<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace app\models\collections;
use yii\mongodb\Query;

abstract class MasterCollection{
    abstract protected function getCollectionName();
    
    public function findAll($orderBy = null){
        $query = new Query();
        if(isset($orderBy) && !empty($orderBy)){
            return $query->from($this->getCollectionName())->orderBy(["nome" => SORT_ASC])->all();
        } else {
            return $query->from($this->getCollectionName())->all();
        }
        
    }
}