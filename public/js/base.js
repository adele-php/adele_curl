$(function(){
    $('.gly').click(function(){
        var iconv =$(this).find('.glyphicon').eq(0);
        var ul =$(this).parent().find('ul').eq(0);
        var exist =  $(this).find('.glyphicon-plus').eq(0).attr('class');
        if( exist ){
            iconv.removeClass('glyphicon-plus').addClass('glyphicon-minus')
            ul.slideDown()
        }else{
            iconv.removeClass('glyphicon-minus').addClass('glyphicon-plus')
            ul.slideUp()
        }

    });
});
