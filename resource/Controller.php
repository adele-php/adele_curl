<?php
namespace resource;

class Controller extends \Smarty{
    public function __construct(){
        parent::__construct();
        require_once(APP_PATH.'common/function.php');             //加载公共函数
        if($_SERVER['REQUEST_METHOD'] !='GET'){
            return;
        }
        $this->_iniSmarty();        //smarty设置
        $this->_assign();           //初始化模板变量

        $this->_init();
    }

    private function _iniSmarty(){
        $path =APP_PATH.strtolower(MODEL_NAME).'\\view\\'.strtolower(CONTROLLER_NAME);
        $this->setTemplateDir($path);
    }

    private function _assign(){
        $this->assign('__PUBLIC__',__ROOT__.'/public');
        $this->assign('VIEW',APP_PATH.strtolower(MODEL_NAME).'/view');
        $this->assign('__CONTROLLER__',U(MODEL_NAME.'/'.CONTROLLER_NAME));

        $this->registerPlugin("function","U","U");//第二个参数是模板文件调用的函数名称，可变；第三个参数是上面自定义的函数名称；相应于一个对应关系
    }

    private function _init(){
        $left_navs=[];
        $mca = MODEL_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME;
        $now = M('nav')->field('id,pid')
//            ->where('is_hide=0 and url like "%'.$mca.'%"')
            ->where('is_hide=0 and url="'.$mca.'"')
            ->select();

        if( !$now ){
//            @$refer_url = $_SERVER['HTTP_REFERER'];
//            $mca = \resource\adele\Request::instance()->mca(parse_url($refer_url)['path'],false);
//            $mca = $mca[0].'/'.$mca[1].'/'.$mca[2];
            $mc = MODEL_NAME.'/'.CONTROLLER_NAME;
            $now = M('nav')->field('id,pid')
                ->where('is_hide=0 and pid=0 and url like "'.$mc.'%"')
//                ->where('is_hide=0 and url="'.$mca.'"')
                ->select();

            if(!$now){
                die('nav 获取不到');
            }
        }

        $active_id = [];
        //需要高亮的id
        foreach($now as $nav){
            $active_id[] = $nav['id'];
            //不是顶级id执行后半段
            ($nav['pid']==0) || $active_id[] = $nav['pid'];
        }
        array_unique($active_id);


        $navs = M('nav')->field('id,name,url,order,pid,group')
                        ->where('is_hide=0')
                        ->select();
        //得到左侧目录树
        foreach( $navs as $k => $v ){
            $navs[$k]['active']=0;
            if( in_array($v['id'],$active_id)){
                $navs[$k]['active']=1;
            }
            if( (isset($active_id[1])&&$active_id[1]==$v['pid']) || $active_id[0]==$v['pid'] ){
                $left_navs[] = $navs[$k];
            }

        }
        //左侧目录树分组
        $l_navs=[];
        foreach($left_navs as $k=>$v){
            $l_navs[$v['group']][]=$v;
        }

        $top_navs  = array_filter( $navs , [$this,'_getTopNav'] );


        array_walk($top_navs,[$this,'_handleUrl']);
        foreach( $l_navs as $k=>$l_nav){
            array_walk($l_navs[$k],[$this,'_handleUrl']);
        }
        $this->assign('navs' , $top_navs );
        $this->assign('left_navs' , $l_navs );
    }

    private function _getTopNav( $nav ){
        return ($nav['pid']==0)?true:false;
    }

    private function _handleUrl( &$nav ,$key ){
        $nav['url'] = U($nav['url']);
    }

}















