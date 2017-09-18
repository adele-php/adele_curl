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
        $this->display('index.html');
    }


    public function system(){
        $this->display('system.html');
    }






    public function test(){
        $model = new Model();
        $res = $model->table('book')->where(['id','<=',1])->select();
        var_dump( $res) ;
    }



}

