<?php


namespace resource;

class Config{
    public static $config = [];

    public static function load( $file ){
        if( is_file($file) ){
            self::set( include $file );
        }
    }

    /**
     * 设置配置参数 name为数组则为批量设置
     * @param string|array  $name 配置参数名（支持二级配置 .号分割）
     * @param mixed         $value 配置值
     * @return mixed
     */
    public static function set( $name , $value=null ){
        //批量设置
        if( is_array($name) ){
            self::$config = array_merge( self::$config , $name  );
        }elseif( is_string( $name )){
            //rewrite.url_html_suffix
            if( strpos( $name , '.') ){
                $name = explode('.' , $name );
                self::$config[$name[0]][$name[1]]=$value;
            }else{
                self::$config[$name]=$value;
            }
        }
    }


    /**
     * 获取配置参数
     * @param string|array  $name 配置参数名（支持二级配置 .号分割）
     * @return mixed
     */
    public static function get( $name  ){
        if( is_array($name) ){
            $_config = [];
            foreach( $name as $v){
                $_config[] = self::get( $v );
            }
            return $_config;
        }elseif( is_string( $name )){
            if( strpos( $name , '.') ){
                $name = explode('.' , $name );
                if( isset(self::$config[$name[0]][$name[1]]) ){
                    return self::$config[$name[0]][$name[1]];
                }
            }else{
                if( isset(self::$config[$name]) ){
                    return self::$config[$name];
                }
            }
        }

        return false;
    }







}
