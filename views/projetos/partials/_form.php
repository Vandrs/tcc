<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\negocio\Categoria;
use app\models\utils\EtapaUtil;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model app\models\negocio\Projeto */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="projeto-form">
    
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    
    <input type="hidden" id="projeto-_id" class="form-control" name="Projeto[_id]" value="<?=(string)$model->_id?>" />
    
    <?= $form->field($model, 'titulo') ?>

    <?= $form->field($model, 'resumo')->textarea(["maxlength"=>300,"rows"=>"3"])->hint("Máximo 300 caracteres.") ?>

    <?= $form->field($model, 'descricao')->widget(CKEditor::className(),["preset"=>"basic"]) ?>

    <?= $form->field($model, 'categoria_id')->dropDownList(Categoria::getCategoriasForDropDown(["nome"=> SORT_ASC ]),[ "prompt" => "Selecione uma categoria" ]) ?>

    <?= $form->field($model, 'etapa')->dropDownList(EtapaUtil::getEtapasForDropDown(),["prompt" => "Selecione a etapa do projeto"]) ?>

    <?= $form->field($model, 'url_externa') ?>

    
    <div class="form-group field-projeto-foto_capa <?=$model->hasErrors("foto_capa")?"has-error":""?>">
        <label class="control-label" for="projeto-foto_capa"><?= $model->attributeLabels()["foto_capa"] ?></label>
        <div class="input-group input-file-content">
            <span class="input-group-btn">
                <span class="btn btn-warning btn-file">
                    Selecionar arquivo<input type="file" name="Projeto[foto_capa]" id="projeto-foto_capa" />
                </span>
            </span>
            <input class="form-control feed-back-input" readonly="" type="text" /> 
        </div>
        <div class="help-block">Extensões permitidas: png, jpeg, jpg.</div>
        <div class="help-block">Tamanho máximo: 1MB.</div>
        <?php if($model->hasErrors("foto_capa")){ ?>
        <div class="help-block"><?=$model->getStringfiedFieldErrors("foto_capa","<br />")?></div>
        <?php } ?>
    </div>
    
    <div class="form-group field-projeto-foto_capa <?=$model->hasErrors("anexo")?"has-error":""?>">
        <label class="control-label" for="projeto-anexo"><?= $model->attributeLabels()["anexo"] ?></label>
        <div class="input-group input-file-content">
            <span class="input-group-btn">
                <span class="btn btn-warning btn-file">
                    Selecionar arquivo<input type="file" name="Projeto[anexo]" id="projeto-anexo" />
                </span>
            </span>
            <input class="form-control feed-back-input" readonly="" type="text" /> 
        </div>
        <div class="help-block">Extensões permitidas: pdf , ppt, pptx.</div>
        <div class="help-block">Tamanho máximo: 5MB.</div>
        <?php if($model->hasErrors("anexo")){ ?>
        <div class="help-block"><?=$model->getStringfiedFieldErrors("anexo","<br />")?></div>
        <?php } ?>
    </div>
    
    <?= $form->field($model, 'anexo_titulo') ?>

    <div class="form-group text-right">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    
</div>
