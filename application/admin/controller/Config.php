<?php


namespace application\admin\controller;

use resource\adele\Model;
/**
 * 后台首页控制器 
 */
class Config extends \resource\Controller{
	public function __construct(){
        parent::__construct();
	}

    public function base(){
        $this->display('base.html');
    }





}

