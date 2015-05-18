<?php



namespace app\models\utils;
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Yii;
use yii\web\View;

class FacebookUtil{
    
    private static $APP_ID = "1074886019192932";
    private static $APP_SECRET = "3d65c63165ccfd4200602d75887a2660";
    private $redirectUrl;
    private $baseUrl = "http://localhost";
    
    public function __construct() {
        $session = Yii::$app->session;
        if (!$session->isActive){
            $session->open();
        }
        $this->initFBSession();
        $this->redirectUrl = $this->baseUrl.Yii::$app->request->BaseUrl."/site/fblogin";
    }
    
    public function getLoginUrl(){
        $loginHelper = new FacebookRedirectLoginHelper($this->redirectUrl);
        return $loginHelper->getLoginUrl();
    }
    
    private function initFBSession(){
        FacebookSession::setDefaultApplication(self::$APP_ID, self::$APP_SECRET);
    }
    
    public function postRedirect(){
        $loginHelper = new FacebookRedirectLoginHelper($this->redirectUrl);
        $session = $loginHelper->getSessionFromRedirect();
        $token = $session->getToken();
        return $token;
    }
    
    public function getUserData($token){
        $session = new FacebookSession($token);
        $request = new FacebookRequest($session, 'GET', '/me');
        $response = $request->execute();
        $graphObject = $response->getGraphObject(GraphUser::className());
        return $graphObject->asArray();
    }
    
    public function getUserFriends($token){
        $session = new FacebookSession($token);
        $request = new FacebookRequest($session,'GET','/me/friends');
        $response = $request->execute();
        $graphObject = $response->getGraphObject();
        return $graphObject->asArray();
    }
    
    private function getUserProfilePicture($token,$large = FALSE){
        $params = ["redirect"=>"false"];
        if($large){
            $params["type"] = "large";                        
        }
        $session = new FacebookSession($token);
        $request = new FacebookRequest($session,'GET','/me/picture',$params);
        $response = $request->execute();
        $graphObject = $response->getGraphObject();
        return $graphObject->asArray();
    }
    
    public function downloadUserLargePicture($token,$id){
        $pictureData = $this->getUserProfilePicture($token,TRUE);
        if($pictureData){
            return $this->downloadFacebookPicture($pictureData['url'], $id,"fb-large");
        }
        return FALSE;
    }
    
    public function downloadUserSmallPicture($token,$id){
        $pictureData = $this->getUserProfilePicture($token,FALSE);
        if($pictureData){
            return $this->downloadFacebookPicture($pictureData['url'], $id,"fb-small");
        }
        return FALSE;
    }
    
    private function downloadFacebookPicture($url,$id,$prefix){
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
    
    public static function prepareOpenGraphHeader(View $view, $titulo, $descricao, $slug){
        $view->registerMetaTag(['property'=>'fb:app_id','content' => self::$APP_ID]);
        $view->registerMetaTag(['property'=>'og:site_name','content' => 'C3 - Projetos']);
        $view->registerMetaTag(['property'=>'og:url ','content' => Yii::$app->request->getHostInfo().Yii::$app->request->getBaseUrl()."/projetos/visualizar/".$slug]);
        $view->registerMetaTag(['property'=>'og:title','content' => $titulo]);
        $view->registerMetaTag(['property'=>'og:description','content' => $descricao]);
        $view->registerMetaTag(['property'=>'og:type','content' => 'article']);
    }
    
    public static function loadJavaScriptSDK(){
        return "<div id='fb-root'></div>
                <script type='text/javascript'>
                window.fbAsyncInit = function() {
                    FB.init({
                      appId      : '".self::$APP_ID."',
                      xfbml      : true,
                      version    : 'v2.3'
                    });
                };
                (function(d, s, id){
                   var js, fjs = d.getElementsByTagName(s)[0];
                   if (d.getElementById(id)) {return;}
                   js = d.createElement(s); js.id = id;
                   js.src = '//connect.facebook.net/pt_BR/sdk.js';
                   fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));
                </script>";
    }
}