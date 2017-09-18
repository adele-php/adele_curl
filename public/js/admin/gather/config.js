$(function(){
    $('.submit').click(function(){
        var url = $('.CONTROLLER').val();
        $.ajax({
            url:url+'/config',
            type:"POST",
            dataType:'json',
            data:$('form').serialize(),
            success:function(data){
                //if(data.error==1){
                //    $('.alert-warning').css('display','block').find('strong').eq(0).text(data.info);
                //}
                //if(data == 1){
                //    location.href=$('.CONTROLLER').val()+'/index';
                //}
            }
        });
    });


    $(':radio[name="proxy"]').click(function(){
        if( $(this).val() == 1){
            $('.proxy_info').css('display','block');
        }else{
            $('.proxy_info').css('display','none');
        }
    });


});