<?php

namespace app\models\utils;

use DateTime;
use DateTimeZone;

class DateUtil{
    
    public static function getStringDate($format, $time = null ,$strTimeZone = null){
        if(empty($time)){
            $time = 'now';
        }
        
        $dateTime = self::getDateTimeFromDateString($time, $strTimeZone);
        return $dateTime->format($format);
    }
    
    public static function getDateTimeFromDateString($time = 'now',$strTimeZone = null){
        if($strTimeZone){
            $dateTimeZone = new DateTimeZone($strTimeZone);
            $dateTime = new DateTime($time, $dateTimeZone);    
            
        } else {
            $dateTime = new DateTime($time);    
        }
        return $dateTime;
    }
    
    public static function getDateTimeFromTimeStamp($timeStamp, $strTimeZone = null){
        if($strTimeZone){
            $dateTimeZone = new DateTimeZone($strTimeZone);
            $dateTime = new DateTime('now', $dateTimeZone);    
            
        } else {
            $dateTime = new DateTime('now');    
        }
        $dateTime->setTimestamp($timeStamp);
        return $dateTime;
    }
    
    
}