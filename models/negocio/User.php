<?php

namespace app\models\negocio;
use yii\mongodb\ActiveRecord;
use app\models\collections\UsuarioCollection;
use MongoDate;
use MongoId;
use Yii;

class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    
    private $collection;
    
  
    public static function collectionName(){
        return 'usuario';
    }

    public function attributes(){
        return ["_id","social_id","login_type","username","email",
                "password","nome","foto_grande","foto_pequena","url","authKey","social_token",
                "created_at","updated_at"];
    }
    
    public function rules() {
        return [
            [["username","email","password"],'required','message'=>'Campo obrigatório', "on" => "login"],
            [["_id","social_id","login_type","username","email","password","nome","foto_grande","foto_pequena","url","social_token"],
              "safe","on"=>"socialLogin"]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return self::findOne(["_id" => $id]);
    }
    
    public static function findBySocialId($id,$loginType){
        return static::findOne(["social_id"=>$id,"login_type"=>$loginType]); 
    }

    public function beforeSave($insert) {
        if($insert){
            if(!empty($this->password)){
                $this->password = sha1($this->password);
            }
            $this->created_at = new MongoDate();
            $this->updated_at = $this->created_at;
        } else {
            $this->updated_at = new mongoDate();
        }
        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(["username" => $username]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return (string)$this->_id;
    }

    /**
         * @inheritdoc
         */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
         * @inheritdoc
         */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === sha1($password);
    }
    
    public function getCollectionObject(){
        if(empty($this->collection)){
            $this->collection = new UsuarioCollection();
        }
        return $this->collection;
    }
    
    public function getProfilePicture($small = TRUE){
        $profilePicture = ($small)?$this->foto_pequena:$this->foto_grande;
        if(empty($profilePicture)){
            return $this->getUploadWebPath()."profileDefault.png";
        } else {
            return $this->getUploadWebPath().$profilePicture;
        }
    }
    
    public function getUploadWebPath(){
        return Yii::$app->request->getHostInfo().Yii::$app->request->getBaseUrl()."/upload/";
    }
    
    public function getUploadRootPath(){
        return Yii::$app->basePath."/web/upload/";
    }
}
