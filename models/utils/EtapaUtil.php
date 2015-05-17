<?php

namespace app\models\utils;

class EtapaUtil{
    const RASCUNHO = 1;
    const DEFINICAO = 2;
    const ANDAMENTO = 3;
    const CONLUIDO = 4;
    
    public static function getEtapasForDropDown(){
        return [
            self::RASCUNHO  => "Rascunho",
            self::DEFINICAO => "Em definição",
            self::ANDAMENTO => "Em andamento",
            self::CONLUIDO  => "Conluído"
        ];
    }
}