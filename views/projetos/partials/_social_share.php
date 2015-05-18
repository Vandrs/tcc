<?php
use app\models\utils\FacebookUtil;
use app\models\utils\GooglePlusUtil;
use app\models\utils\TwitterUtil;

/* @var $this yii\web\View */
/* @var $projeto app\models\negocio\Projeto */
FacebookUtil::prepareOpenGraphHeader($this, $projeto->titulo, (empty($projeto->resumo))?substr($projeto->descricao, 1000)."...":$projeto->resumo, $projeto->slug);
?>
<?=FacebookUtil::loadJavaScriptSDK()?>
<?=GooglePlusUtil::loadScriptShareButton()?>
<?=TwitterUtil::loadShareButtonScript()?>

<div class="conter-social-share">
    <div class="social-buttons">
        <span class="social-button">
            <div class="fb-share-button" data-href="<?=$projeto->getPrettyUrl()?>" data-layout="button"></div>
        </span>
        <span class="social-button">
            <div class="g-plus" data-action="share" data-annotation="none" data-href="<?=$projeto->getPrettyUrl()?>"></div>
        </span>
        <span class="social-button">
            <a href="https://twitter.com/share" class="twitter-share-button" data-lang="pt">Tweetar</a>
        </span>
    </div>
</div>