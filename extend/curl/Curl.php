<?php

require_once 'CurlCommon.php';

/**
 * CURL 类
 */
class Curl extends CurlCommon{
    private $ch;
    public $last_curl_info = null;

    public function __construct($other_opts=array()){
        $this->ch = curl_init();
        $opts=[
            CURLOPT_RETURNTRANSFER=>1,
            CURLOPT_HEADER        =>false,                    //返回头信息
            CURLOPT_NOSIGNAL      =>true,                   //设置为true可以解决毫秒级bug(超时时间在1000ms内)
        ];

        curl_setopt_array($this->ch,$opts);
        curl_setopt_array($this->ch,$other_opts);

        $this->errorLog("\r\n".'*****start:'.date('Y-m-d H:i:s',time()).'******');
    }

    public function run($url,$other_info=[]){
        $result = $this->curl($url,$other_info);

        return $result;
    }

    protected function curl($url,$other_info){
        //设置url
        curl_setopt($this->ch,CURLOPT_URL,$url );
        //采集
        $result = curl_exec($this->ch);
        //curl信息
        $curl_info = curl_getinfo( $this->ch ) ;
        //重定向跟踪等操作
        if(!$this->curlInfoHandle($curl_info,$other_info)){
            return false;
        }


        return $result;
    }

    public function getHandle(){
        return $this->ch;
    }


}

