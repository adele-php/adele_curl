<?php

namespace resource\adele;
/**
 * 采集
 */
class GatherView{

    //浏览器输出数据
	public static function info($select,$info,$append=false){

        $str = '<div class="js"><script>';

        if($append===true){
            //插入模式
            $str .= '$("'.$select.'").append(\'<p>'.$info.'</p>\');';
        }else{
            $str .='$("'.$select.'").text(\''.$info.'\');';
        }

        $str .='$(".end_time").text(\''.date('Y-m-d H:i:s',time()).'\');</script></div>';
        echo $str;
    }

//    public static function



}



