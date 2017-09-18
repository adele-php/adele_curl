<?php

require_once 'Get.php';

/**
 * CURL 类
 */
class Curl extends Get{
    private $__ch;

    public function __construct($other_opts=array()){
        $this->__ch = curl_init();
        $opts=[
            CURLOPT_RETURNTRANSFER=>1,
            CURLOPT_HEADER        =>false,                    //返回头信息
            CURLOPT_NOSIGNAL      =>true,                   //设置为true可以解决毫秒级bug(超时时间在1000ms内)
        ];

        curl_setopt_array($this->__ch,$opts);
        curl_setopt_array($this->__ch,$other_opts);
    }

    public function run($url){
        $this->_errorLog("\r\n".'*****start:'.date('Y-m-d H:i:s',time()).'******');
        $result = $this->_curl($url);

        return $result;
    }

    protected function _curl($url){
        $key = $this->_linkStorage($url);
        curl_setopt($this->__ch,CURLOPT_URL,$url );
        $result = curl_exec($this->__ch);

        $curl_info = curl_getinfo( $this->__ch ) ;

        if ($curl_info['http_code'] != 200) {
            // 如果是301、302跳转, 抓取跳转后的网页内容
            if ($curl_info['http_code'] == 301 || $curl_info['http_code'] == 302) {
                $this->_errorLog('重定向from:'.$url.' to:'.$curl_info['redirect_url']);
                if (!isset($curl_info['redirect_url'])) {
                    return false;
                }
                $url = $curl_info['redirect_url'];
                $result = $this->_curl($url);
            }elseif(in_array($curl_info['http_code'], array('0','502','503','429','403'))){
                // 抓取次数 小于 允许抓取失败次数
                if ( $this->link['num'][$key] <= 3 ) {
                    $this->_errorLog('http_code:'.$curl_info['http_code'].',重新采集本url:'.$url.  '，1s后尝试第'.($this->link['num'][$key]+1).'次');
                    $result = $this->_curl($url);
                }else{
                    $this->_errorLog('http_code:'.$curl_info['http_code'].'，已尝试4次，url:'.$url.',放弃此条信息');
                    if ($curl_info['http_code'] == 403  ) {
                        $this->http_code403_num ++;
                        if( $this->http_code403_num >= 10){
                            $this->_errorLog('403已达10次，怀疑被拉黑，停止采集！');
                            die;
                        }
                    }
                    return false;
                }
            }else{
                return false;
            }
        }


        return $result;
    }



}

