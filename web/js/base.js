$(document).ready(function(){
    $(document).on("click","#socialLoginButton a",function(e){
        e.preventDefault();
        $('#loginSocialModal').modal('show');
    });
});