<?php


namespace application\admin\controller;

use resource\adele\Model;
/**
 * 后台首页控制器 
 */
class Menu extends \resource\Controller{
	public function __construct(){
        parent::__construct();
	}

    public function index(){
        $top_navs = M('nav')->where('pid=0')->select();

        $this->registerPlugin("function","is_hide", [$this,'is_hide']);

        $this->assign('all_nav',$top_navs);
        $this->display('index.html');
    }

    public function subMenu($id=null){

        $top_navs = M('nav')->where('pid='.$id)->select();

        $this->registerPlugin("function","is_hide", [$this,'is_hide']);
        $this->assign('all_nav',$top_navs);
        $this->display('submenu.html');
    }

    public function is_hide($parm){
        $hide = $parm['hide'];
        $id   = $parm['id'];

        $url = __ROOT__.'/index.php/admin/menu/change';
        if($hide==0){
            echo '<a href="javascript:void(0)" class="change" _url="'.$url.'" is_hide="'.$hide.'" id="'.$id.'">点击隐藏</a>';
        }else{
            echo '<a href="javascript:void(0)" class="change" _url="'.$url.'" is_hide="'.$hide.'" id="'.$id.'">点击显示</a>';
        }
    }

    public function change(){
        $is_hide = ($_POST['is_hide']==0)?1:0;
        $id = $_POST['id'];
        $id = $_POST['id'];
        M('nav')->where('id='.$id)->update(['is_hide'=>$is_hide]);
        echo $is_hide;
    }

    public function add(){

        if( $_SERVER['REQUEST_METHOD'] !='GET'){
            $_POST['group'] = empty($_POST['group'])?'默认分组':$_POST['group'];
            echo M('nav')->insert($_POST);
            die;
        }
        $hl = M('nav')->field('id,name')->where('pid=0 and is_hide=0')->select();
        $this->assign('hl',$hl);
        $this->display('add.html');
    }

    public function del($id=null){

        if(empty($id)){
            $id = $_GET['id'];
        }
        echo M('nav')->where('id='.$id)->delete();
    }

    public function edit($id=null){
        if( $_SERVER['REQUEST_METHOD'] !='GET'){
            echo M('nav')->where('id='.$_POST['id'])->update($_POST);
            die;
        }
        $hl = M('nav')->field('id,name')->where('pid=0 and is_hide=0')->select();
        $this->assign('hl',$hl);
        $nav = M('nav')->where('id='.$id)->select();
        foreach( $nav[0] as $k=>$v){
            htmlentities( $nav[0][$k],ENT_QUOTES);
        }
        $this->assign('nav',$nav[0]);

        $this->display('edit.html');
    }


}

