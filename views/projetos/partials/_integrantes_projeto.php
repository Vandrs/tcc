<?php

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $projeto app\models\negocio\Projeto */
/* @var $owner app\models\negocio\User */

$this->registerJsFile(Yii::$app->request->BaseUrl.'/js/activate-tooltip.js',["depends"=>'app\assets\AppAsset']);

$integrantes = $projeto->getIntegrantes();
$owner = $integrantes["owner"];

?>
<div class="conter-integrantes">
    <h3 class="titulo">Integrantes</h3>
    <div class="integrante">
        <a href="<?=Url::to(['usuario/perfil', 'id' => $owner->getId()])?>">
            <img class="img-responsive" data-toogle="tooltip" title="<?=$owner->nome?>" src="<?=$owner->getProfilePicture()?>" />
        </a>
    </div>
</div>