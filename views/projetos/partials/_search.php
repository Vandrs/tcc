<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\ProjetoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="projeto-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, '_id') ?>

    <?= $form->field($model, 'titulo') ?>

    <?= $form->field($model, 'resumo') ?>

    <?= $form->field($model, 'descricao') ?>

    <?= $form->field($model, 'categoria_id') ?>
    
    <?= $form->field($model, 'slug') ?>

    <?php // echo $form->field($model, 'etapa') ?>

    <?php // echo $form->field($model, 'url_path') ?>

    <?php // echo $form->field($model, 'url_externa') ?>

    <?php // echo $form->field($model, 'owner_id') ?>

    <?php // echo $form->field($model, 'foto_capa') ?>

    <?php // echo $form->field($model, 'anexo_titulo') ?>

    <?php // echo $form->field($model, 'anexo_file_path') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
