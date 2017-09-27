$(function(){
    $('.submit').click(function(){
        var url = $('.CONTROLLER').val();
        $.ajax({
            url:url+'/edit',
            type:"POST",
            data:$('form').serialize(),
            success:function(data){
                if(data == 1){
                    location.href=$('.CONTROLLER').val()+'/index';
                }
            }
        });
    });

    $('.test').click(function(){
        var url = $('.CONTROLLER').val();
        var type = $(this).attr('_type');
        var data = {};
        if( type=='detail'){
            data = {
                type:type,
                detail_url:$('.detail_url').val(),
                detail_start:$('.detail_start').val(),
                detail_end:$('.detail_end').val(),
                detail_pattern:$('.detail_pattern').val(),
                hid_type:$('.hid_type').val(),
                iconv:$('.iconv').val()
            }
        }else if( type=='section'){
            data = {
                type:type,
                section_url:$('.section_url').val(),
                section_start:$('.section_start').val(),
                section_end:$('.section_end').val(),
                section_pattern:$('.section_pattern').val(),
                hid_type:$('.hid_type').val(),
                iconv:$('.iconv').val(),
                section_page:0
            }
            if( $('input:radio:checked').val() == 1 ){
                data.section_page_start = $('.section_page_start').val();
                data.section_page_end = $('.section_page_end').val();
                data.section_page_pattern = $('.section_page_pattern').val();
                data.section_page =1;
            }
        }else{
            data = {
                type:type,
                section_url:$('.section_url').val(),
                section_start:$('.section_start').val(),
                section_end:$('.section_end').val(),
                section_pattern:$('.section_pattern').val(),

                content_start:$('.content_start').val(),
                content_end:$('.content_end').val(),
                content_pattern:$('.content_pattern').val(),
                hid_type:$('.hid_type').val(),
                iconv:$('.iconv').val(),
                section_page:0
            }
            if( $('input:radio:checked').val() == 1 ){
                data.section_page_start = $('.section_page_start').val();
                data.section_page_end = $('.section_page_end').val();
                data.section_page_pattern = $('.section_page_pattern').val();
                data.section_page =1;
            }
        }

        $.ajax({
            url:url+'/test',
            type:"POST",
            dataType:'json',
            data:data,
            success:function(data){
                $('.fade').show().css('opacity',1).css('top','80px').css('overflow','scroll');
                var status = ['success','info','warning','danger'];
                var html ='<ul class="list-group">';

                if( typeof data =='object'){
                    for(var i in data){
                        if(typeof data[i] == "object" ){
                            for(var j in data[i]){
                                html += '<li class="list-group-item list-group-item-'+status[Math.round(Math.random()*2+1)]+'">'+j+':'+data[i][j]+'</li>'
                            }
                        }else{
                            html += '<li class="list-group-item list-group-item-'+status[Math.round(Math.random()*2+1)]+'">'+i+':'+data[i]+'</li>'
                        }
                    }
                }else{
                    html += '<li class="list-group-item list-group-item-'+status[Math.round(Math.random()*2+1)]+'">'+data+'</li>'
                }

                html += '</ul>';
                $('.modal-body p').html(html);

            }
        });

    });
    $('.close').click(function(){
        $('.modal').hide();
    });

    $(':radio[name="section_page"]').click(function(){
        if( $(this).val() == 1){
            $('.section_page').css('display','block');
        }else{
            $('.section_page').css('display','none');
        }
    });
});