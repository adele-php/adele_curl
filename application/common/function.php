<?php


function C( $name , $value ){

}

function M( $table ){
    $model = new resource\adele\Model;
    return $model->table($table);

}

/**
 * URL组装 支持不同URL模式
 * @param string $url URL表达式，格式：'[模块/控制器/操作]?参数1=值1&参数2=值2...'
 * @param string|array $vars 传入的参数，支持数组和字符串
 * @param string $suffix 伪静态后缀，默认为true表示获取配置值
 * @param boolean $domain 是否显示域名
 * @return string
 */
function U($url='',$vars='',$suffix=true) {
    // 解析URL
    $url = is_array($url)?$url['url']:$url;
    $info   =  parse_url($url);
    $url    =  !empty($info['path'])?$info['path']:ACTION_NAME;

    // 解析参数
    if(is_string($vars)) { // aaa=1&bbb=2 转换成数组
        parse_str($vars,$vars);
    }elseif(!is_array($vars)){
        $vars = array();
    }
    if(isset($info['query'])) { // 解析地址里面参数 合并到vars
        parse_str($info['query'],$params);
        $vars = array_merge($params,$vars);
    }

    $depr = '/';

    if(!empty($vars)) { // 添加参数
        foreach ($vars as $var => $val){
            if('' !== trim($val))   $url .= $depr . $var . $depr . urlencode($val);
        }
    }
//    if($suffix) {
//        $suffix   =  $suffix===true?C('URL_HTML_SUFFIX'):$suffix;
//        if($pos = strpos($suffix, '|')){
//            $suffix = substr($suffix, 0, $pos);
//        }
//        if($suffix && '/' != substr($url,-1)){
//            $url  .=  '.'.ltrim($suffix,'.');
//        }
//    }

    $url = __ROOT__.'/index.php/'.$url;
    return $url;
}



//查找extend目录下的文件
function vendor($class) {

    $filepath = EXTEND_PATH.$class.EXT;
    if( is_file(  $filepath )  ){
        require_once($filepath);
    }else{
        return false;
    }


}























