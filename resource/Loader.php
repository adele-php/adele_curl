<?php

namespace resource;

class Loader
{
    // 自动加载
    public static function autoload($class)
    {
        if ($file = self::findFile($class)) {

            if (IS_WIN && pathinfo($file, PATHINFO_FILENAME) != pathinfo(realpath($file), PATHINFO_FILENAME)) {
                return false;
            }
            require_once($file);
            return true;
        }
    }

    /**
     * 查找文件
     * @param $class
     * @return bool
     */
    private static function findFile($class)
    {
        $filepath = ROOT_PATH.$class.EXT;
        if( !is_file(  $filepath )  ){
            $filepath = ROOT_PATH.$class.'.class'.EXT;
            return is_file(  $filepath ) ?$filepath : false;
        }
        return $filepath;

    }



    // 注册自动加载机制
    public static function register()
    {
        // 注册系统自动加载
        spl_autoload_register('\\resource\\Loader::autoload', true, true);

    }


}














