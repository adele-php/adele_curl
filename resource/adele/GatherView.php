<?php

namespace resource\adele;
/**
 * 采集
 */
class GatherView{

    //浏览器输出数据
	public static function info($select,$info,$append=false){
        //TODO $info存入唯一id的文本中 某个链接可以通过唯一id 事实显示采集详细信息 可以放在curl中完成 包括页面大小、时间

        $str = '<div class="js"><script>';

        if($append===true){
            //插入模式
            $str .= '$("'.$select.'").append(\'<p>'.$info.'</p>\');';
        }else{
            $str .='$("'.$select.'").text(\''.$info.'\');';
        }

        $str .='$(".end_time").text(\''.date('H:i:s',time()).'\');</script></div>';
        echo $str;
    }

//    public static function



}



