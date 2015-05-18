$(document).ready(function(){
    $(document).on("click","#socialLoginButton a",function(e){
        e.preventDefault();
        $('#loginSocialModal').modal('show');
    });
    
    $(document).on("click",".unimplemeted-action",function(e){
        e.preventDefault();
        alert('Ação não implementada.');
    });
});