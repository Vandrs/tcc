<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\negocio\Projeto */

$this->registerCssFile(Yii::$app->request->BaseUrl.'/css/inputstyle.css');
$this->registerJsFile(Yii::$app->request->BaseUrl.'/js/inputstyle.js',["depends"=>'app\assets\AppAsset']);

$this->title = $model->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Projetos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->titulo, 'url' => ['/projetos/visualizar/'.$model->slug]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="projeto-update container-content">
    <?= $this->render('partials/_form', [
        'model' => $model,
    ]) ?>
</div>
