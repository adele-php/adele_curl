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

/**
 * 获取输入参数 支持过滤和默认值
 * 使用方法:
 * <code>
 * I('id',0); 获取id参数 自动判断get或者post
 * I('post.name','','htmlspecialchars'); 获取$_POST['name']
 * I('get.'); 获取$_GET
 * </code>
 * @param string $name 变量的名称 支持指定类型
 * @param mixed $default 不存在的时候默认值
 * @param mixed $filter 参数过滤方法
 * @return mixed
 */
function I($name,$default='',$filter=null) {
    if(strpos($name,'.')) { // 指定参数来源
        list($method,$name) =   explode('.',$name,2);
    }else{ // 默认为自动判断
        $method =   'param';
    }
    switch(strtolower($method)) {
        case 'get'     :   $input =& $_GET;break;
        case 'post'    :   $input =& $_POST;break;
        case 'put'     :   parse_str(file_get_contents('php://input'), $input);break;
        case 'param'   :
            switch($_SERVER['REQUEST_METHOD']) {
                case 'POST':
                    $input  =  $_POST;
                    break;
                case 'PUT':
                    parse_str(file_get_contents('php://input'), $input);
                    break;
                default:
                    $input  =  $_GET;
            }
            break;
        case 'request' :   $input =& $_REQUEST;   break;
        case 'session' :   $input =& $_SESSION;   break;
        case 'cookie'  :   $input =& $_COOKIE;    break;
        case 'server'  :   $input =& $_SERVER;    break;
        case 'globals' :   $input =& $GLOBALS;    break;
        default:
            return NULL;
    }
    if(empty($name)) { // 获取全部变量
        $data       =   $input;
        //过滤
    }elseif(isset($input[$name])) { // 取值操作
        $data       =   $input[$name];

    }else{ // 变量默认值
        $data       =    isset($default)?$default:NULL;
    }
    return $data;
}

function myDate(){
    return date('H:i:s',time());
}

//字节转兆
function byteToGiga($byte){
    $giga = ($byte/1024)/1024;
    $giga = round($giga,3);
    return $giga;
}

function save_image($img_url,$filename='',$dir='./public/img/'){
    if($img_url == ""){
        return false;
    }

    // 检查路径是否存在，如不存在则创建
    if (!is_dir($dir)){
        //第三个参数是“true”表示能创建多级目录，iconv防止中文目录乱码
        $is_create_success=mkdir(iconv("UTF-8", "GBK", $dir),0777,true);
        if(!$is_create_success){
            return false;
        }
    }

    //判断文件夹是否可写
    if( !is_writable($dir) ){
        echo '文件夹不可写';
        return false;
    }
    //随机文件名
    if($filename==''){
        $ext_arr = explode('.',$img_url);
        $ext = array_pop($ext_arr);
        $filename = time().mt_rand(0,500).'.'.$ext;
    }

    ob_start();

    readfile($img_url);
    $img=ob_get_contents();
    ob_end_clean();


    $file_real_path = $dir.$filename;
    $fp2=fopen($file_real_path,"a");
    if(fwrite($fp2,$img) === false){
        echo '无法打开文件'.$file_real_path;
        exit();
    }
    fclose($fp2);

//    if(function_exists('finfo_open')){
//        $finfo   =  finfo_open ( FILEINFO_MIME_TYPE );
//        $type = finfo_file ( $finfo ,  $file_real_path );
//        var_dump($type);die;
//
//    }

    return $file_real_path;
}




/**
 * 获取客户端IP地址
 * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
 * @return mixed
 */
function get_client_ip($type = 0) {
    $type       =  $type ? 1 : 0;
    static $ip  =   NULL;
    if ($ip !== NULL) return $ip[$type];
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $pos    =   array_search('unknown',$arr);
        if(false !== $pos) unset($arr[$pos]);
        $ip     =   trim($arr[0]);
    }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ip     =   $_SERVER['HTTP_CLIENT_IP'];
    }elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip     =   $_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $long = sprintf("%u",ip2long($ip));
    $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
    return $ip[$type];
}













