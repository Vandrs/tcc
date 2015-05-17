<?php

namespace app\models\collections;
use app\models\collections\MasterCollection;

class ProjetoCollection extends MasterCollection{
    public function getCollectionName() {
        return "projeto";
    }
}