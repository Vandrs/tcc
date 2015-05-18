<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\forms\LoginForm;
use app\models\forms\ContactForm;
use app\models\utils\FacebookUtil;
use app\models\utils\GooglePlusUtil;
use app\models\negocio\User;
use app\models\enum\EnumLoginType;
use Exception;
use app\models\utils\DateUtil;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');
            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
    
    public function actionFblogin(){
    
        try{
            $fbUtil = new FacebookUtil();
            $userToken = $fbUtil->postRedirect();
            $userData = $fbUtil->getUserData($userToken);
            $user = User::findBySocialId($userData['id'], EnumLoginType::FACEBOOK);
            if($user){
                $user->social_token = $userToken; 
                $lastUpdateSystem = DateUtil::getDateTimeFromTimeStamp($user->updated_at->sec,'America/Sao_Paulo');
                $lastUpdateFB = DateUtil::getDateTimeFromTimeStamp(strtotime($userData['updated_time']),'America/Sao_Paulo');
                if($lastUpdateSystem->getTimestamp() < $lastUpdateFB->getTimestamp()){
                    $user->setScenario("socialLogin");
                    $user->nome = $userData["name"];
                    $user->email = (isset($userData["email"]))?$userData["email"]:"";
                    $user->url = $userData["link"];
                    $user->social_token = $userToken;
                    
                    @unlink(Yii::$app->basePath."/upload/".$user->foto_grande);
                    if($foto_large = $fbUtil->downloadUserLargePicture($userToken, $userData['id'])){
                        $user->foto_grande = $foto_large;
                    }
                    @unlink(Yii::$app->basePath."/upload/".$user->foto_pequena);
                    if($foto_small = $fbUtil->downloadUserSmallPicture($userToken, $userData['id'])){
                        $user->foto_pequena = $foto_small;
                    }
                    
                    if(!$user->save()){
                        throw new Exception("Error innesperado");
                    }
                } else {
                    $user->updateAttributes(["social_token"=>$userToken]);
                }
            } else {
                $user = new User(["scenario"=>"socialLogin"]);
                $user->nome = $userData["name"];
                $user->social_id = $userData["id"];
                $user->email = (isset($userData["email"]))?$userData["email"]:"";
                $user->url = $userData["link"];
                $user->login_type = EnumLoginType::FACEBOOK;
                $user->social_token = $userToken;
                if($foto_large = $fbUtil->downloadUserLargePicture($userToken, $userData['id'])){
                    $user->foto_grande = $foto_large;
                }
                if($foto_small = $fbUtil->downloadUserSmallPicture($userToken, $userData['id'])){
                    $user->foto_pequena = $foto_small;
                }
                if(!$user->save()){
                    throw new Exception("Error innesperado");
                }
            }
            Yii::$app->user->login($user,0);
            return $this->goHome();
        } catch(Exception $e){
            return $this->render('/site/error',["name"=>"Ops!!!","message"=>"Ocorreu um erro inesperado ao tentar realizar a ação solicidata."]);
        }
    }
    
    public function actionGpluslogin(){
        try{
            $gpUtil = new GooglePlusUtil();
            $userToken = $gpUtil->requireUserToken(Yii::$app->request->get('code'));
            $userdata  = $gpUtil->requireUserInfo($userToken);
            
            $user = User::findBySocialId($userdata->getId(), EnumLoginType::GOOGLE_PLUS);
            
            if($user){
                $user->updateAttributes(["social_token"=>$userToken]);
            } else {
                $user = new User();
                $user->nome = $userdata->getDisplayName();
                $user->social_id = $userdata->getId();
                /** @TODO buscar Emails do usuário */
    //            $user->email = (isset($userData["email"]))?$userData["email"]:"";
    //            print_r($userdata->getEmails());
                $user->url = $userdata->getUrl();
                $user->login_type = EnumLoginType::GOOGLE_PLUS;
                $user->social_token = $userToken;
                
                if($foto_large = $gpUtil->downloadUserImage($userdata->getImage(), $userdata->getId(), TRUE)){
                    $user->foto_grande = $foto_large;
                }
                
                if($foto_small = $gpUtil->downloadUserImage($userdata->getImage(), $userdata->getId(), FALSE)){
                    $user->foto_pequena = $foto_small;
                }
                
                if(!$user->save()){
                    throw new Exception("Error innesperado");
                }
            }
            
            Yii::$app->user->login($user,0);
            return $this->goHome();
        } catch(Exception $e){
            return $this->render('/site/error',["name"=>"Ops!!!","message"=>"Ocorreu um erro inesperado ao tentar realizar a ação solicidata."]);
        }
    }
    
    public function actionTeste(){
        return Yii::$app->request->BaseUrl."<br />".Yii::$app->basePath;
    }

}
