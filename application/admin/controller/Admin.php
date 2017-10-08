<?php


namespace application\admin\controller;

use resource\adele\Model;
/**
 * 后台首页控制器 
 */
class Admin extends \resource\Controller{
	public function __construct(){
        parent::__construct();
	}

    public function index(){
        $system_info = [
            'AdelePHP版本'=>ADELE_VERSION,
            'php版本'=>PHP_VERSION,
            'zend版本'=>zend_version(),
            '上传文件大小'=>get_cfg_var ("upload_max_filesize")?get_cfg_var ("upload_max_filesize"):"不允许上传附件",
            '系统时间'=>date("Y-m-d G:i:s"),
            '操作系统'=>PHP_OS,
            '服务器端信息'=>$_SERVER ['SERVER_SOFTWARE'],
            '脚本运行占用最大内存'=>get_cfg_var ("memory_limit")?get_cfg_var("memory_limit"):"无",
            '客户端ip'=>get_client_ip(),
            '服务器ip'=>isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ''),
        ];


        $this->assign('system_info',$system_info);
        $this->display('index.html');
    }









    public function test(){
        $model = new Model();
        $res = $model->table('book')->where(['id','<=',1])->select();
        var_dump( $res) ;
    }



}

