<?php

namespace app\models\utils;
use app\models\utils\StringUtil;
use yii\helpers\StringHelper;

class UrlUtil{
    public static function parseToUrlSlug($string){
        $string = StringUtil::removerAcentos($string);
        $string = StringUtil::tolower($string);
        $string = str_replace("/", "-", $string);
        $string = str_replace(" ", "-", $string);
        $string = str_replace("?", "-", $string);
        $string = str_replace("!", "-", $string);
        $string = str_replace("=", "-", $string);
        $string = str_replace("+", "-", $string);
        $string = str_replace(":", "-", $string);
        $string = str_replace(";", "-", $string);
        return $string;
    }
    
    public static function tratarHttpLink($link){
        if(StringHelper::startsWith($link, "http://", FALSE)){
            return $link;
        } else if(StringHelper::startsWith($link, "https://", FALSE)){
            return $link;
        }
        return "http://".$link;
    }
}