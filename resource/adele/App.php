<?php


namespace resource\adele;


class App{
    public static function run(){
        //导入配置
        \resource\Config::load( APP_PATH.'common/config.php');

        //路由

        //响应
        Request::instance()->handle();
    }
}
