$(function(){


    $('.change').click(function(){

        var url = $(this).attr('_url');
        var id = $(this).attr('id');
        var is_hide = $(this).attr('is_hide');

        $.ajax({
            url:url,
            type:"POST",
            data:{'is_hide':is_hide,'id':id},
            success:function(){
                location.reload();
            }
        });
    });

    $('.add').click(function(){
        location.href=$('.CONTROLLER').val()+'/add';
    });

    $('.del').click(function(){
        $.ajax({
            url:$('.CONTROLLER').val() +'/del',
            type:"GET",
            data:{'id':$(this).attr('_id')},
            success:function($data){
                if($data==1)
                    location.reload();
            }
        });
    });

    $('.setTemplet').click(function(){
        $.ajax({
            url:$(this).attr('_href'),
            type:"GET",
            data:{
                'id':$(this).attr('_id'),
                'val':$(this).attr('_val')
            },
            success:function($data){
                if($data==1)
                    location.reload();
            }
        });
    });
});