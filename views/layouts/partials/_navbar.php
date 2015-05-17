<?php

/* @var $view \yii\web\View */
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\BaseHtml;





if(Yii::$app->user->isGuest){
$navbarItems = [    
        ['label' => 'Entrar', 'url' => ['#'], 'options' => ["id" => "socialLoginButton"]],
        ['label' => 'Sobre', 'url' => ['/site/about']],
        ['label' => 'Contato', 'url' => ['/site/contact']]
    ];
} else {
$navbarItems = [    
        ['label' => BaseHtml::img(Yii::$app->request->BaseUrl."/upload/".Yii::$app->user->identity->foto_pequena,["id"=>"navProfileImage"]).Yii::$app->user->identity->nome, 'url' => '/usuario/perfil','encode'=>false],   
        ['label' => 'Sobre', 'url' => ['/site/about']], 
        ['label' => 'Contato', 'url' => ['/site/contact']],
        ['label' => '(Sair)', 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']]
        
    ];
}

NavBar::begin([
        'brandLabel' => 'C3 - Projetos',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $navbarItems,
    ]);
NavBar::end();

if(Yii::$app->user->isGuest){
    echo $view->render('/site/modais/socialLoginModal');
}

