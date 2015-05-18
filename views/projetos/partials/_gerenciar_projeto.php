<?php
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $projeto app\models\negocio\Projeto */

?>
<div class="conter-gerenciar-projeto">
    <div class="actions">
        <a href="#" class="unimplemeted-action" id="novo-post" data-toogle="tooltip" title="Novo Post"><icon class="glyphicon glyphicon-file" /></a>
        <a href="<?=Url::to(["projetos/update", "id" => (string)$projeto->_id])?>"  id="editar-projeto" data-toogle="tooltip" title="Editar Projeto"><icon class="glyphicon glyphicon-pencil" /></a>
        <a href="#" class="unimplemeted-action" data-toogle="tooltip" title="Excluir Projeto" ><icon class="glyphicon glyphicon-trash"/></a>
    </div>
</div>