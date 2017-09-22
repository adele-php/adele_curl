<?php


namespace resource\adele;


use application\admin\controller\Gather;

class App{

    public static function run(){
        //导入配置
        \resource\Config::load( APP_PATH.'common/config.php');

        //路由

        //响应
        if( PHP_SAPI == 'cli' ) {
            // TODO 解析命令
            Request::parseCommand();
            // 清屏
            Request::clearEcho();

            //显示基本信息

            //执行
            $gather = new \application\admin\controller\Gather();
            var_dump($gather);
        }else{
            Request::instance()->handle();
        }

    }
}
