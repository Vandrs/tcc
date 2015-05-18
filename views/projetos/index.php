<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ProjetoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Projetos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="projeto-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Projeto', ['novo'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            '_id',
            'titulo',
            'resumo',
            'descricao',
            'categoria_id',
            'slug',
            // 'etapa',
            // 'url_path',
            // 'url_externa',
            // 'owner_id',
            // 'foto_capa',
            // 'anexo_titulo',
            // 'anexo_file_path',
            // 'created_at',
            // 'updated_at',
        ],
    ]); ?>

</div>
