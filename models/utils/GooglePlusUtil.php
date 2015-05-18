<?php

namespace app\models\utils;
use Yii;


require Yii::$app->basePath."/vendor/google/apiclient/src/Google/autoload.php";

class GooglePlusUtil{
    
    /** @property \Google_Client  $this->googleClient */
    private static $client_id = "200852812540-fng5l9cpehdbn7b4g5te5ah7uhlitjq8.apps.googleusercontent.com";
    private static $client_secret = "Z5mgrSvACt0e1D6vwCqLPS3H";
    private static $api_key = "AIzaSyA5TFCbXXf4XzKn8WQT1tixhlMxp2X3Vtw";
    private static $app_name = "C3 - Projetos";
    private $redirectUrl;
    private $googleClient;
    private $baseUrl = "http://localhost";
    
    public function __construct() {
        $this->redirectUrl = $this->baseUrl.Yii::$app->request->BaseUrl."/site/gpluslogin";
        $this->initGoogleClient();
    }
    
    private function initGoogleClient(){
        $this->googleClient = new \Google_Client();
        $this->googleClient->setClientId(static::$client_id);
        $this->googleClient->setClientSecret(static::$client_secret);
        $this->googleClient->setDeveloperKey(static::$api_key);
        $this->googleClient->setRedirectUri($this->redirectUrl);
    }
    
    public function getUrlLogin(){
        $this->googleClient->setScopes(array('https://www.googleapis.com/auth/plus.login'));
        return $this->googleClient->createAuthUrl();
    }
    
    public function requireUserToken($code){
        $this->googleClient->setScopes(array('https://www.googleapis.com/auth/plus.login'));
        $this->googleClient->authenticate($code);
        return  $this->googleClient->getAccessToken();
    }
    
    public function requireUserInfo($token){
        $this->googleClient->setAccessToken($token);
        $plus = new \Google_Service_Plus($this->googleClient);  
        return $plus->people->get('me');
    }
    
    public function downloadUserImage($imageObject,$id,$large = FALSE){
        if($large){
            $url = str_replace("?sz=50", "", $imageObject->getUrl());
            $prefix = "gp-large";
        } else {
            $url = $imageObject->getUrl();
            $prefix = "gp-small";
        }
        return $this->downloadPicture($url, $id, $prefix);
    }
    
    private function downloadPicture($url,$id,$prefix){
        $imgName = FALSE;
        try{
            $img = file_get_contents($url);
            $imgName = $prefix."-".$id.".jpg";
            $imgPath = $this->getPicturePath()."/".$imgName;
            file_put_contents($imgPath, $img);
        } catch (Exception $e){
            $imgName = FALSE;
        }        
        return $imgName;
    }
    
    private function getPicturePath(){
        return Yii::$app->basePath."/web/upload";
    }
    
    public static function loadScriptShareButton(){
        return  '<script src="https://apis.google.com/js/platform.js" async defer>'.
                    '{lang: "pt-BR"}'.
                '</script>';
    }
}