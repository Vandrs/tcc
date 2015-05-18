<?php 
    use app\models\utils\FacebookUtil;
    use app\models\utils\GooglePlusUtil;
    $fbUtil = new FacebookUtil();
    $fbLoginUrl = $fbUtil->getLoginUrl();
    $gpUtil = new GooglePlusUtil();
    $gpUrl = $gpUtil->getUrlLogin();
?>

<div class="modal fade" id="loginSocialModal" tabindex="-1" role="dialog" aria-labelledby="loginSocialLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="loginSocialLabel">Login social</h4>
      </div>
      <div class="modal-body text-center">
          <a class="btn btn-facebook" href="<?=$fbLoginUrl?>">Entrar com o Facebook</a>
          <span class="display-block margin-top-10 margin-bottom-10"> ou </span>
          <a class="btn btn-googleplus" href="<?=$gpUrl?>">Entrar com o Google+</a>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>