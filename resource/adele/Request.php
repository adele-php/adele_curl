<?php


namespace resource\adele;
use resource\Config;

class Request{
    //单例
    private static $instance;

    private $path;

    private function __construct(){

    }

    //得到单例
    public static function instance(){
        if( !self::$instance ){
            self::$instance = new self;
        }
        return self::$instance;
    }

    //处理响应
    public function handle(){
        $mca = $this->path()->mca();

//        var_dump( $mca);exit;
        define('MODEL_NAME',$mca[0]);
        define('CONTROLLER_NAME',$mca[1]);
        define('ACTION_NAME',$mca[2]);

        $class='\\application\\'.strtolower($mca[0]).'\\controller\\'.ucfirst(strtolower($mca[1]));

        if( !class_exists( $class ) ){
            //类不存在
            echo $class.'类不存在';
            return ;
        }

        $class = new $class;

        if( !is_callable( [ $class,$mca[2] ]) ){
            //方法不存在
            echo $mca[2].'方法不存在';
            return ;
        }

        call_user_func_array( [ $class,$mca[2] ],isset($mca['p'])?$mca['p']:[] );


    }

    //返回 pathinfo
    public function path( $param=true ){
        if( !empty($_SERVER['PATH_INFO']) ){
            $this->path= ltrim($_SERVER['PATH_INFO'] ,'/');
        }else{
            $this->path='/';
        }
        return $param?$this:$this->path;
    }

    //返回 [model,controller,action,'p'=>[]]
    //   /AdelePHP/index.php/admin/menu/index
    public function mca( $path=null ,$type=true ){
        $path = empty($path)?$this->path:$path;
        if( $path == '/'){
            return Config::get(['default_module','default_controller','default_action']);
        }

        if( (0=== $pos=strpos($path,__ROOT__))  && (__ROOT__!='')){
            if(0=== $pos=strpos($path,__ROOT__.'/index.php')){
                $path = substr( $path ,strlen(__ROOT__.'/index.php'));
            }else{
                $path = substr( $path ,strlen(__ROOT__));
            }
            $path = ltrim( $path ,'/');
        }
        // home/index/index/id/1
        $path       = explode('/',$path);

        if( $type){
            $model      = isset($path[0])&&!empty($path[0]) ?$path[0] : Config::get('default_module');
            $controller = isset($path[1])&&!empty($path[1]) ?$path[1] : Config::get('default_controller');
            $action     = isset($path[2])&&!empty($path[2]) ?$path[2] : Config::get('default_action');
        }else{
            $model      = isset($path[0])&&!empty($path[0]) ?$path[0] : '';
            $controller = isset($path[1])&&!empty($path[1]) ?$path[1] : '';
            $action     = isset($path[2])&&!empty($path[2]) ?$path[2] : '';
        }

        if( count( $path ) >3 ){
            //有参数
            $p = $this->getParam(array_slice($path,3));
            return [$model,$controller,$action,'p'=>$p];
        }

        return [$model,$controller,$action];
    }


    //解析参数  ['id',1,'name',2]=>['id'=>1,'name'=>2]
    private function getParam( $params ){
        $p=[];
        for( $i=0;$i<count($params);$i+=2){
            if( empty($params[$i])){
                continue;
            }
            $p = array_merge($p, [$params[$i]=> isset($params[$i+1])?$params[$i+1]:false] );
        }
        return $p;
    }

    /**
     * Parse command.
     * php yourfile.php id
     *
     * @return void
     */
    public static function parseCommand(){
        // 检查运行命令的参数
        global $argv;
        $command = $argv[1];

        switch($command) {
            // 启动 phpspider
            case 'start':
                // TODO
                break;
//            case 'stop':
//                exec("ps aux | grep $start_file | grep -v grep | awk '{print $2}'", $info);
//                if (count($info) <= 1) {
//                    echo "PHPSpider[$start_file] not run\n";
//                } else {
//                    //echo "PHPSpider[$start_file] is stoping ...\n";
//                    echo "PHPSpider[$start_file] stop success";
//                    exec("ps aux | grep $start_file | grep -v grep | awk '{print $2}' |xargs kill -SIGINT", $info);
//                }
//                exit;
//                break;
//            case 'kill':
//                exec("ps aux | grep $start_file | grep -v grep | awk '{print $2}' |xargs kill -SIGKILL");
//                break;
//            // 显示 phpspider 运行状态
//            case 'status':
//                exit(0);
//            // 未知命令
//            default :
//                exit("Usage: php yourfile.php {start|stop|status|kill}\n");
        }

    }


    //清屏
    public static function clearEcho(){
        $arr = array(27, 91, 72, 27, 91, 50, 74);
        foreach ($arr as $a) {
            print chr($a);
        }
    }












}
