<?php
use app\models\utils\DateUtil;
use app\models\utils\EtapaUtil;
use yii\helpers\Html;
use yii\helpers\BaseUrl;
use Yii;
/* @var $this yii\web\View */
/* @var $projeto app\models\negocio\Projeto */
?>

<div class="detalhes-projeto">
    <div class="row">
        <div class="col-xs-12 text-right">
            <small>Por: em <strong><?=DateUtil::getDateTimeFromTimeStamp($projeto->created_at->sec, 'America/Sao_Paulo')->format('d/m/y H:i')?></strong></small>
        </div>
    </div>
    
    <div class="row">
        <div class="col-xs-12 text-right">
            <strong>Fase do projeto: </strong> <span id="fase-projeto" class="projeto"><?= EtapaUtil::getEtapasForDropDown()[$projeto->etapa]?></span>
        </div>
    </div>
    <?php if(!empty($projeto->resumo)){ ?> 
    <div class="row margin-top-20">
        <div class="col-xs-12">
            <h3>Resumo do projeto</h3>
            <div id="resumo-projeto">
                <?=$projeto->resumo?>
            </div>
        </div>
    </div>
    <?php } ?>
    <div class="row margin-top-20">
        <div class="col-xs-12">
            <h3>Descrição do projeto</h3>
            <div id="descricao-projeto">
                <?=$projeto->descricao?>
            </div>
        </div>
    </div>
    <div class="row margin-top-20">
        <div class="col-xs-12">
            <h3>Saiba mais</h3>
            <div>
                <?php if($projeto->url_externa){
                    echo Html::a($projeto->url_externa,"http://".$projeto->url_externa, ["target" => "_blank"]);
                } ?>
                
            </div>
            <div>
                <?php if($projeto->anexo){
                    echo Html::a((!empty($projeto->anexo_titulo))?$projeto->anexo_titulo:'Anexo',"/".$projeto->anexo, ["target" => "_blank"]);
                }?>
            </div>
        </div>
    </div>
</div>