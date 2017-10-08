<?php


/**
 * CURL 父类
 */
class CurlCommon {
    const FAIL_NUM = 3;     //采集失败次数上限

    public $http_code403_num=0;
    public $error_info = [];
    /*
     *  urls =>[5=>baidu ]
     *  info =>[5=>['num'=>1,http_code=>[]]    ]
     */
    public $link=['urls'=>[], 'info'=>[]];
    public $queue=[];

    /*
     * 入队列
     * $url_info
     *      'url'=>
     *      other..
     * $is_batch 是否批量插入
     */
    public function enqueue($url_info,$is_batch=false){
        if($is_batch==true){
            foreach($url_info as $v){
                $this->queue[]=$v;
            }
        }else{
            $this->queue[]=$url_info;
        }
    }

    /*
     * 出队列
     * @$dequeue_num 出队列个数
     */
    public function dequeue($dequeue_num=1){
        if(empty($this->queue)){
            die('队列为空，出队失败！');
        }

        if($dequeue_num==1){
            $url_info = array_shift($this->queue);
        }else{
            if( count($this->queue)<$dequeue_num ){
                $dequeue_num = count($this->queue);
            }
            $url_info = array_slice($this->queue,0,$dequeue_num);
        }

        $url_info = empty($url_info)?false:$url_info;

        return $url_info;
    }



    //设置代理
    public function setProxy($ch,$proxy_info){
        $opts = [
            CURLOPT_PROXYTYPE=>CURLPROXY_HTTP,
            CURLOPT_PROXYAUTH=>CURLAUTH_BASIC,
            CURLOPT_USERAGENT=>"Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.95Safari/537.36 SE 2.X MetaSr 1.0",
            CURLOPT_CONNECTTIMEOUT=>3,
            CURLOPT_TIMEOUT=>5,
            CURLOPT_PROXY=>$this->$proxy_info['proxy_server'],
            CURLOPT_PROXYUSERPWD=> "{$this->$proxy_info['proxy_username']}:{$this->$proxy_info['proxy_password']}",
        ];
        if(is_array($ch)){
            foreach($ch as $v){
                curl_setopt_array($v,$opts);
            }
        }else{
            curl_setopt_array($ch,$opts);
        }

    }

    //模拟登录
    public function setCookie($ch,$cookie){
        if(is_array($ch)){
            foreach($ch as $v){
                curl_setopt($v,CURLOPT_COOKIE,$cookie);
            }
        }else{
            curl_setopt($ch,CURLOPT_COOKIE,$cookie);
        }


    }


    /*
     *  本次采集的所有url信息
     *  urls =>[5=>baidu ]
     *  info =>[5=>[
         * 'num'=>1,
         * 'http_code'=>[],
         * 'other_info'=>null
     * ]]
     */
    protected function linkStorage( $url , $http_code , $other_info=null ){
        if( ($key = array_search( $url , $this->link['urls'] )) !== false  ){
            $this->link['info'][$key]['num'] +=1 ;
            $this->link['info'][$key]['http_code'][]=$http_code;
        }else{
            $this->link['urls'][] = $url;
            $key = array_search( $url , $this->link['urls'] );
            $this->link['info'][$key]=['num'=>1,'http_code'=>[$http_code],'other_info'=>$other_info ];
        }
        return $key;
    }

    //得到链接采集次数
    public function getLinkGatherNum($link){
        $key = array_search($link,$this->link['urls']);
        if(false===$key)
            return false;
        return $this->link['info'][$key]['num'];
    }


    protected  function errorLog($info){
        $filename = __DIR__.'/error_log.txt';
        file_put_contents($filename,$info."\r\n",FILE_APPEND);
    }

    /*
     * 处理curl_info
     * $other_info 插入队列的其他信息
     * http_code:
     * 1.  200 返回true
     * 2.  301|40x 插入队列 返回false
     * */
    protected function curlInfoHandle($curl_info,$other_info=[]){
        $url = $curl_info['url'];
        $key = $this->linkStorage($url,$curl_info['http_code']);

        $curl_info['size_download']  = byteToGiga($curl_info['size_download']).'M';       //下载数据总量
        $curl_info['speed_download'] = byteToGiga($curl_info['speed_download']).'M/s';    //平均下载速度

        $this->last_curl_info = $curl_info;
        if ($curl_info['http_code'] != 200) {
            if ($curl_info['http_code'] == 301 || $curl_info['http_code'] == 302) {
                // 如果是301、302跳转, 抓取跳转后的网页内容
                $this->errorLog('重定向from:'.$url.' to:'.$curl_info['redirect_url']);
                //重定向url加入队列
                $other_info['url']=$curl_info['redirect_url'];
                $this->enqueue($other_info);
            }elseif(in_array($curl_info['http_code'], array('0','502','503','429','403','407'))){
                if ( $this->link['info'][$key]['num'] <= self::FAIL_NUM ) {
                    // 抓取次数 小于 允许抓取失败次数
                    $this->errorLog('http_code:'.$curl_info['http_code'].',重新采集本url:'.$url.  '，1s后尝试第'.($this->link['info'][$key]['num']+1).'次');
                    //TODO url加入队列
                    $other_info['url']=$url;
                    $this->enqueue($other_info);
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
        return true;

    }







}

