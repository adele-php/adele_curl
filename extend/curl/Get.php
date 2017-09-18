<?php


/**
 * CURL 父类
 */
class Get {

    public $http_code403_num=0;
    public $error_info = [];
    public $link=['urls'=>[],'num'=>[]];
    //设置代理
    public function setProxy($ch,$proxy_info){
        $opts = [
            CURLOPT_PROXYTYPE=>CURLPROXY_HTTP,
            CURLOPT_PROXYAUTH=>CURLAUTH_BASIC,
            CURLOPT_USERAGENT=>"Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.95Safari/537.36 SE 2.X MetaSr 1.0",
            CURLOPT_CONNECTTIMEOUT=>3,
            CURLOPT_TIMEOUT=>5,
            CURLOPT_PROXY=>$this->$proxy_info['proxyServer'],
            CURLOPT_PROXYUSERPWD=> "{$this->$proxy_info['proxyUser']}:{$this->$proxy_info['proxyPass']}",
        ];
        curl_setopt_array($ch,$opts);
    }

    //模拟登录
    public function setCookie($ch,$cookie){
        curl_setopt($ch,CURLOPT_COOKIE,$cookie);

    }

    /*
   * 本次采集的所有url信息
   * array(
   *  'urls'=> array(0=>'xxx.html',.....,???=>'xxx9999.html')
   *   'num'=> array( url_key=>1  )
   * )
   * */
    protected function _linkStorage( $url ){

        if( ($key = array_search( $url , $this->link['urls'] )) !== false  ){
            $this->link['num'][$key] +=1 ;
        }else{
            $this->link['urls'][] = $url;
            $key = array_search( $url , $this->link['urls'] );
            $this->link['num'][$key]=1;
        }
        return $key;

    }


    protected  function _errorLog($info){
        $filename = __DIR__.'/error_log.txt';
        file_put_contents($filename,$info."\r\n",FILE_APPEND);
    }

    /*
     * 处理curl资源的http_code
     * @return  url,http_code,redirect_url|true
     * */
    protected function _httpCodeHandle($resource,$url){
        $curl_info = curl_getinfo( $resource ) ;
        if ($curl_info['http_code'] == 200) {
            //采集成功
            return true;
        }else{
            // 如果是301、302跳转, 抓取跳转后的网页内容
            if ($curl_info['http_code'] == 301 || $curl_info['http_code'] == 302) {
                if (!isset($curl_info['redirect_url'])) {
                    return [
                        'url'=>$url,
                        'http_code'=>$curl_info['http_code']
                    ];
                }
                $redirect_url = $curl_info['redirect_url'];
                return [
                    'url'=>$url,
                    'http_code'=>$curl_info['http_code'],
                    'redirect_url'=>$redirect_url
                ];
            }elseif( in_array($curl_info['http_code'], array('0','502','503','429','403')) ){
                return [
                    'url'=>$url,
                    'http_code'=>$curl_info['http_code']
                ];
            }
        }

    }

}

