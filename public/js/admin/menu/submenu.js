$(function(){
    $('.ret').click(function(){
        location.href=$('.con_hid').val()+"/index"
    });


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
});