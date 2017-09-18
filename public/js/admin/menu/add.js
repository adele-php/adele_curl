$(function(){
    $('.submit').click(function(){
        var url = $('.CONTROLLER').val();
        $.ajax({
            url:url+'/add',
            type:"POST",
            data:$('form').serialize(),
            success:function(data){
                if(data == 1){
                    location.href=$('.CONTROLLER').val()+'/index';
                }
            }
        });
    });


});