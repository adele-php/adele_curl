var size =20;
var height = $('.content').height();

var default_height = 16*size;
var info_height = height-default_height-size;

$('.info').height(info_height);
