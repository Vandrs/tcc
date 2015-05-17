<?php

namespace app\models\utils;
use app\models\utils\StringUtil;

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
}