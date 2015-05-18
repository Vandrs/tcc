<?php
/* @var $this yii\web\View */
/* @var $projeto app\models\negocio\Projeto */

$this->registerMetaTag(["name"=>"description","content"=>(empty($projeto->resumo))?substr($projeto->descricao, 1000)."...":$projeto->resumo]);

$this->title = $projeto->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Projetos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="projeto-view">
    <div class="col-md-8 col-xs-12 container-content">
        <?= $this->render('/projetos/partials/_detalhe_projeto',['projeto' => $projeto])?>
    </div>
    <div class="col-md-4 col-xs-12 container-content">
        <?= $this->render('/projetos/partials/_coluna_b_projeto',['projeto' => $projeto])?>
    </div>
</div>
