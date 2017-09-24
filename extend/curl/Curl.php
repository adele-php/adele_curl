<?php

require_once 'CurlCommon.php';

/**
 * CURL 类
 */
class Curl extends CurlCommon{
    private $ch;

    public function __construct($other_opts=array()){
        $this->ch = curl_init();
        $opts=[
            CURLOPT_RETURNTRANSFER=>1,
            CURLOPT_HEADER        =>false,                    //返回头信息
            CURLOPT_NOSIGNAL      =>true,                   //设置为true可以解决毫秒级bug(超时时间在1000ms内)
        ];

        curl_setopt_array($this->ch,$opts);
        curl_setopt_array($this->ch,$other_opts);
    }

    public function run($url){
        $this->errorLog("\r\n".'*****start:'.date('Y-m-d H:i:s',time()).'******');
        $result = $this->curl($url);

        return $result;
    }

    protected function curl($url){
        curl_setopt($this->ch,CURLOPT_URL,$url );
        $result = curl_exec($this->ch);
        $curl_info = curl_getinfo( $this->ch ) ;

        $key = $this->linkStorage($url,$curl_info['http_code']);

        if ($curl_info['http_code'] != 200) {
            // 如果是301、302跳转, 抓取跳转后的网页内容
            if ($curl_info['http_code'] == 301 || $curl_info['http_code'] == 302) {
                $this->errorLog('重定向from:'.$url.' to:'.$curl_info['redirect_url']);
                $this->enqueue($curl_info['redirect_url']);
            }elseif(in_array($curl_info['http_code'], array('0','502','503','429','403'))){
                // 抓取次数 小于 允许抓取失败次数
                if ( $this->link['info'][$key]['num'] <= parent::FAIL_NUM ) {
                    $this->errorLog('http_code:'.$curl_info['http_code'].',重新采集本url:'.$url.  '，1s后尝试第'.($this->link['num'][$key]+1).'次');
                    $this->enqueue($curl_info['redirect_url']);
                }else{
                    $this->errorLog('http_code:'.$curl_info['http_code'].'，已尝试4次，url:'.$url.',放弃此条信息');
                    if ($curl_info['http_code'] == 403  ) {
                        $this->http_code403_num ++;
                        if( $this->http_code403_num >= 10){
                            $this->errorLog('403已达10次，怀疑被拉黑，停止采集！');
                            die;        //停止脚本
                        }
                    }
                }
            }
            return false;
        }
        return $result;
    }



}

