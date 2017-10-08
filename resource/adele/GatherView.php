<?php

namespace resource\adele;
/**
 * 采集
 */
class GatherView{

    //浏览器输出数据
	public static function info($select,$info,$append=false,$env='browser'){
        //TODO $info存入唯一id的文本中 某个链接可以通过唯一id 实时显示采集详细信息 可以放在curl中完成 包括页面大小、时间
        if($env=='test'){
            return;
        }elseif($env=='normal'){
            self::browser($select,$info,$append);
        }



    }

    //浏览器环境
    public static function browser($select,$infos,$append){
        $info = $infos;

        $str = '<div class="js"><script>';

        if(is_array($infos)){
            foreach($infos as $info){
                if($append===true){
                    //插入模式
                    $str .= '$("'.$select.'").append(\'<p>'.$info.'</p>\');';
                }else{
                    $str .='$("'.$select.'").text(\''.$info.'\');';
                }
            }
        }else{
            if($append===true){
                //插入模式
                $str .= '$("'.$select.'").append(\'<p>'.$info.'</p>\');';
            }else{
                $str .='$("'.$select.'").text(\''.$info.'\');';
            }
        }


        $str .='$(".end_time").text(\''.date('H:i:s',time()).'\');</script></div>';
        echo $str;
    }



}



