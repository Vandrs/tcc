<?php

use yii\helpers\Html;
use Yii;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>
<div class="site-error container-content">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>
    <p>
        Clique <strong><a href='<?=Yii::$app->request->BaseUrl?>/contato'>aqui</a></strong> para entrar em contato com o administrador do sistema.
    </p>
</div>
