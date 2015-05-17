<?php

namespace app\models\collections;
use app\models\collections\MasterCollection;

class UsuarioCollection extends MasterCollection{
    public function getCollectionName() {
        return "usuario";
    }
}