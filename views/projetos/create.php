<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\negocio\Projeto */
$this->registerCssFile('/css/inputstyle.css');
$this->registerJsFile('/js/inputstyle.js',["depends"=>'app\assets\AppAsset']);

$this->title = 'Novo Projeto';
$this->params['breadcrumbs'][] = ['label' => 'Projetos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="projeto-create container-content">
    <?= $this->render('partials/_form', [
        'model' => $model
    ]) ?>
</div>
