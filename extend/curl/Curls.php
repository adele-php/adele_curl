<?php

require_once 'CurlCommon.php';
/**
 * CURL 类
 */
class Curls extends CurlCommon{
    const CURL_NUM=5;                   //并发数 设置代理最大为5
    private $multi_curl_handle;
    private $curl_handles = [];

    public function __construct($other_opts=array()){
        $this->multi_curl_handle = curl_multi_init();

        for($i=1;$i<=self::CURL_NUM;$i++){
            $curl_handle = curl_init();
            $opts=[
                CURLOPT_RETURNTRANSFER=>1,
                CURLOPT_HEADER        =>true,                    //返回头信息
                CURLOPT_NOSIGNAL      =>false,                   //设置为true可以解决毫秒级bug(超时时间在1000ms内)
            ];
            curl_setopt_array($curl_handle,$opts);
            curl_setopt_array($curl_handle,$other_opts);
            $this->curl_handles[]=$curl_handle;
        }
    }

    /*
     *
     */
    public function run($urls){

        // TODO $urls > CURL_NUM

        $res = $this->curls($urls);

        // TODO
        if( !is_array($urls) ){

        }
        return $res;
    }


    protected function curls($urls){
        $key       = 0;
        $map       = array();
        $responses = array();

        //设置url
        while( null !== $url = array_pop($urls)){

            curl_setopt($this->curl_handles[$key],CURLOPT_URL,$url );
            // 把当前 curl resources 加入到 curl_multi_init 队列
            curl_multi_add_handle($this->multi_curl_handle, $this->curl_handles[$key]);

            $map[$url]=$key;
            $key++;
        }

        //执行采集
        $this->execMultipleCurl();
        //获取数据
        foreach($map as $url => $k){
            //TODO 错误处理
            $this->httpCodeHandle($this->curl_handles[$k],$url);


            $responses[$url] = curl_multi_getcontent($this->curl_handles[$k]);
            curl_multi_remove_handle($this->multi_curl_handle, $this->curl_handles[$k]);
        }


        return $responses;

    }

    private function execMultipleCurl(){
        $active = null;
        do {
            $mrc = curl_multi_exec($this->multi_curl_handle, $active);
        } while ($mrc == CURLM_CALL_MULTI_PERFORM);

        while ($active > 0 && $mrc == CURLM_OK) {
            while (curl_multi_exec($this->multi_curl_handle, $active) === CURLM_CALL_MULTI_PERFORM);
            // 这里 curl_multi_select 一直返回 -1，所以这里就死循环了，CPU就100%了
            if (curl_multi_select($this->multi_curl_handle, 0.5) != -1)
            {
                do {
                    $mrc = curl_multi_exec($this->multi_curl_handle, $active);
                } while ($mrc == CURLM_CALL_MULTI_PERFORM);
            }
        }
    }


    public function getHandle(){
        return $this->curl_handles;
    }
}

