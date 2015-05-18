<?php
/* @var $this yii\web\View */
/* @var $projeto app\models\negocio\Projeto */
use Yii;
?>

<div class="row">
    <?php if(!Yii::$app->user->isGuest && $projeto->userBelongsToProject(Yii::$app->user->identity)){ ?>
    <div class="col-xs-12">
        <?=$this->render("/projetos/partials/_gerenciar_projeto.php",["projeto"=>$projeto])?>
    </div>    
    <?php } ?>
    <div class="col-xs-12">
        <?=$this->render("/projetos/partials/_integrantes_projeto.php",["projeto"=>$projeto])?>
    </div>
    <div class="col-xs-12">
        <?=$this->render("/projetos/partials/_social_share.php",["projeto"=>$projeto])?>
    </div>
</div>

