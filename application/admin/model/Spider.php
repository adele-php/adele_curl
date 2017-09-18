<?php


namespace application\admin\model;

use application\admin\controller\Gather;
use resource\adele\GatherView;
use resource\adele\Model;
/**
 * 爬虫模块
 */
class Spider extends Model{
    /*  执行采集
    $config:
        'multi':0|1  //curl 或 curl_multi                          //是否开启curl_multi
        'num':5                                                    //并行进程数 默认5
        'proxy':0|1                                                //是否开启代理
        'proxy_info':[$proxyServer,$proxyUser,$proxyPass]
        'type':Spider::NOVEL|                                      //采集类型
        'novel' =>[
            'url'=>    ['detail_url'=>'',    'section_url'=>'',    'content_url'=>''],
            'start'=>  ['detail_start'=>'',  'section_start'=>'',  'content_start'=>''],
            'end'=>    ['detail_end'=>'',    'section_end'=>'',    'content_end'=>''],
            'pattern'=>['detail_pattern'=>[],'section_pattern'=>'','content_pattern'=>''],
            'page'=>['start'=>'','end'=>'','pattern'=>''],          //分页
        ]
        'iconv':
        'cookie':
 * */
    public $config=[];
    public $ch;             //curl 资源
    public $mch;            //multicurl资源
    public $chs=[];
    public $link=['urls'=>[],'num'=>[]];
    public $http_code403_num=0;
    public $error_url=[];   //multicurl采集失败url
    public $redirect_url=[];   //multicurl采集失败url

    const NOVEL=-1;
    //小说
    const SECTION_GATHER=1;             //章节采集
    const CONTENT_GATHER=2;             //内容采集
    const DETAIL_GATHER =3;             //详情采集



	public function __construct( $config ){
        parent::__construct();
        $this->_iniConfig($config);
        $this->_init();                    //初始化curl
        $this->_proxy();                   //设置代理
        $this->_setCookie();
	}
    private function _iniConfig($config){
        $config['multi'] = isset($config['multi'])?$config['multi']:0;      //是否开启多线程
        $config['num'] = isset($config['num'])?$config['num']:5;            //同时采集数量
        $config['proxy'] = isset($config['proxy'])?$config['proxy']:0;      //是否开启代理
        $config['iconv'] = isset($config['iconv'])?$config['iconv']:'utf-8';//编码
        $config['type'] = isset($config['type'])?$config['type']:'default'; //采集类型
        $config['cookie'] = isset($config['cookie'])?$config['cookie']:'';  //cookie

        if($config['proxy']==1 && !isset($config['proxy_info'])){
            die('请设置代理信息[$proxyServer,$proxyUser,$proxyPass]');
        }
        $this->config = $config;
    }
    private function _init(){

//        $this->_foreground('init');             //浏览器执行采集初始化数据
        $opts=[
            CURLOPT_RETURNTRANSFER=>1,
            CURLOPT_HEADER        =>true,                   //返回头信息
            CURLOPT_NOSIGNAL      =>true,                   //解决毫秒级bug
            CURLOPT_HTTP_VERSION  =>CURL_HTTP_VERSION_1_0
        ];
        $this->ch = curl_init();
        curl_setopt_array($this->ch,$opts);

        if( $this->config['multi'] == 1){
            $this->mch = curl_multi_init();

            for($i=1;$i<=$this->config['num'];$i++){
                $ch = curl_init();
                curl_setopt_array($ch,$opts);
                $this->chs[]=$ch;
            }
        }
    }


    private function _proxy(){
        if( $this->config['proxy']==0 ){
            return;
        }
        // 隧道身份信息
//        $proxyServer='http://proxy.abuyun.com:9020';
//        $proxyUser   = "HAR45CEF4S7N2B5D";
//        $proxyPass   = "BA9C4024D5ED689E";

        $opts = [
            CURLOPT_PROXYTYPE=>CURLPROXY_HTTP,
            CURLOPT_PROXYAUTH=>CURLAUTH_BASIC,
            CURLOPT_USERAGENT=>"Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.95Safari/537.36 SE 2.X MetaSr 1.0",
            CURLOPT_CONNECTTIMEOUT=>3,
            CURLOPT_TIMEOUT=>5,
            CURLOPT_PROXY=>$this->config['proxyServer'],
            CURLOPT_PROXYUSERPWD=> "{$this->config['proxyUser']}:{$this->config['proxyPass']}",
        ];
        if( $this->config['multi']==1){
            foreach( $this->chs as $ch){
                curl_setopt_array($ch,$opts);
            }
        }
        curl_setopt_array($this->ch,$opts);

        /*
        // 设置代理服务器
        curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
        curl_setopt($ch, CURLOPT_PROXY, $proxyServer);

        // 设置隧道验证信息
        curl_setopt($ch, CURLOPT_PROXYAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, "{$proxyUser}:{$proxyPass}");

        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.95Safari/537.36 SE 2.X MetaSr 1.0");

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        */

    }

    private function _setCookie(){
        if(empty($this->config['cookie'])){
            return ;
        }
        if( $this->config['multi']==1){
            foreach( $this->chs as $ch){
                curl_setopt($ch,CURLOPT_COOKIE,$this->config['cookie']);
            }
        }
        curl_setopt($this->ch,CURLOPT_COOKIE,$this->config['cookie']);

    }

    public function run(){
        GatherView::info('.start_time',date('Y-m-d H:i:s',time()));
        switch($this->config['type']){
            case self::NOVEL:       //小说类型
                $this->_gatherNovel();
                $this->_errorHandle();
                break;

            case 'default':
                $content = $this->_curl('http://www.iadele.cn/index.php/Admin/Index/index.html');
                var_dump($content);
        }
    }

    /*
        'novel'=>[
            'url'=>['detail_url'=>'http://www.iadele.cn/home/html/2228_1_0.html',    'section_url'=>'',    'content_url'=>''],
            'start'=>['detail_start'=>$detail_start,  'section_start'=>'',  'content_start'=>''],
            'end'=>    ['detail_end'=>$detail_end,    'section_end'=>'',    'content_end'=>''],
            'pattern'=>['detail_pattern'=>$detail_pattern,'section_pattern'=>'','content_pattern'=>''],
            'page'=>['start'=>'','end'=>'','pattern'=>''],          //分页
        ],
     * */
    private function _gatherNovel(){
        GatherView::info('.status','正在获取书籍详情采集...');

        $detail  = $this->novelDetail();

        GatherView::info('.book_name',$detail['name']);
        GatherView::info('.book_status','OK');
        GatherView::info('.status','正在获取章节...');

        $section = $this->novelSection();

        GatherView::info('.status','采集内容ing');
        GatherView::info('.all',count($section['url']));
        if( $this->config['multi']==1 ){
            $contents=[];$key=0;
            while(1==1){
                if( count($section['url'])>10 ){
                    $this->config['novel']['url']['content_url']=array_slice($section['url'],$key,10);
                    $key+=10;
                    $contents = array_merge($contents,$this->novelContent());
                    GatherView::info('.now',$key);

                }else{
                    $this->config['novel']['url']['content_url']=array_slice($section['url'],$key);
                    array_merge($contents,$this->novelContent());
                    break;
                }
            }
        }else{
            foreach( $section['url'] as $k => $url ){

                GatherView::info('.now',$k+1);
                GatherView::info('.now_section',$section['title'][$k]);

                $this->config['novel']['url']['content_url']=$url;
                $content['title'] = $section['title'][$k];
                $content['content'] = $this->novelContent();
            }
        }
    }

    private function _errorHandle(){

    }

    public function getConfig($type){
        $config=[];
        switch($type){
            case 'detail':
                $config = [
                    'url'    =>$this->config['novel']['url']['detail_url'],
                    'start'  =>$this->config['novel']['start']['detail_start'],
                    'end'    =>$this->config['novel']['end']['detail_end'],
                    'pattern'=>$this->config['novel']['pattern']['detail_pattern']
                ];
                $config = $this->_parseConfig($config);
                break;
            case 'section':
                $config = [
                    'url'    =>$this->config['novel']['url']['section_url'],
                    'start'  =>$this->config['novel']['start']['section_start'],
                    'end'    =>$this->config['novel']['end']['section_end'],
                    'pattern'=>$this->config['novel']['pattern']['section_pattern'],
                    'children'=>isset($this->config['novel']['children'])?$this->config['novel']['children']:[],
                ];
                break;
            case 'content':
                $config = [
                    'url'    =>$this->config['novel']['url']['content_url'],
                    'start'  =>$this->config['novel']['start']['content_start'],
                    'end'    =>$this->config['novel']['end']['content_end'],
                    'pattern'=>$this->config['novel']['pattern']['content_pattern']
                ];
                break;
        }
        return $config;
    }
    private function _parseConfig($config){
        foreach( $config['pattern'] as $k=>$pattern){
            $patterns = explode(':',$pattern);
            $key=array_shift($patterns);
            $key_len = strlen($key)+1;
            $pattern = implode('',$patterns);

            unset($config['pattern'][$k]);
            $config['pattern'][$key]=$pattern;

            $config['start'][$key] = substr($config['start'][$k+1],$key_len);
            unset($config['start'][$k+1]);

            $config['end'][$key] = substr($config['end'][$k+1],$key_len);
            unset($config['end'][$k+1]);

        }
        return $config;
    }

    //采集小说详情
    public function novelDetail(){
        $detailConfig = $this->getConfig('detail');
        $result = [];
        $content = $this->_gatherHandle($detailConfig['url'],$detailConfig['start'][0],$detailConfig['end'][0],$this->config['iconv']);
        foreach($detailConfig['pattern'] as $k=>$pattern){
            $str = $this->_substr($content,$detailConfig['start'][$k],$detailConfig['end'][$k]);
            preg_match($pattern,$str,$res);
            $result[$k]=$res[1];
        }
        return $result;
    }

    //采集小说章节
    public function novelSection(){
        $result = ['url'=>[],'title'=>[]];
        $sectionConfig = $this->getConfig('section');

        //得到内容
        $content = $this->_curl($sectionConfig['url']);
        $all_content = $this->_convertEncode($content,$this->config['iconv']);              //改变编码

        //存在分页
        if(!empty($sectionConfig['children'])){
            $content = $this->_substr($all_content,$sectionConfig['children']['start'],$sectionConfig['children']['end']);
            preg_match_all($sectionConfig['children']['pattern'],$content,$page_url);
            //分页处理
            foreach($page_url[1] as $u){
                $sectionConfig['url'] = $this->_handleUrl($sectionConfig['url'],$u);;
                $res = $this->_gatherSection($sectionConfig);
                $result['url']=array_merge($result['url'],$res['url']);
                $result['title']=array_merge($result['title'],$res['title']);
            }
        }else{
            $result = $this->_gatherSection($sectionConfig);
        }
        return $result;

    }
    private function _gatherSection($sectionConfig){
        $result = [];

        //得到内容
        $content = $this->_gatherHandle($sectionConfig['url'],$sectionConfig['start'],$sectionConfig['end'],$this->config['iconv']);
        preg_match_all($sectionConfig['pattern'],$content,$res);
        $result['url']=$res[1];
        foreach($result['url'] as $k=>$url){
            $result['url'][$k] = $this->_handleUrl($sectionConfig['url'],$url);
        }
        $result['title']=$res[2];

        return $result;
    }

    //采集小说内容
    public function novelContent(){
        $contentConfig = $this->getConfig('content');
        $content=[];
        $contents = $this->_gatherHandle($contentConfig['url'],$contentConfig['start'],$contentConfig['end'],$this->config['iconv']);
        if( is_array($contentConfig['url']) ){
            foreach($contents as $k=>$v){
                preg_match($contentConfig['pattern'],$v,$result);
                $content[$k] = isset($result[1])?$result[1]:'';
            }
        }else{
            preg_match($contentConfig['pattern'],$contents,$result);
            $content = $result[1];
        }
        return $content;

    }

    private function _gatherHandle($url,$start,$end,$iconv=null){
        if(is_array($url)){
            $contents = $this->_multipleCurl($url);

            foreach($contents as $url=>$content){
                $contents[$url] = $this->_convertEncode($content,$iconv);              //改变编码
                $contents[$url] = $this->_substr($content,$start,$end);
            }
            $content = $contents;
        }else{
            $content = $this->_curl($url);
            $content = $this->_convertEncode($content,$iconv);              //改变编码
            $content = $this->_substr($content,$start,$end);
        }

        return $content;
    }

    private function _substr($str , $start,$end){
        $start_pos = strpos($str,$start);
        $end_pos   = strpos($str,$end,$start_pos);
        return substr($str,$start_pos,$end_pos-$start_pos);
    }

    /*
   * 将编码转变为UTF-8  ,默认自动识别
   * 识别不到 return false
   */
    private function _convertEncode( $str,$now_encode = null  ){
        if( $now_encode == 'utf-8'){
            return $str ;
        }
        if( !$now_encode ){
            $now_encode = mb_detect_encoding($str, array("ASCII","UTF-8","GB2312","GBK") );
        }
        $str = $now_encode?mb_convert_encoding($str ,'utf-8',$now_encode):false;
        return $str ;
    }

    private function _curl($url ){
        $key = $this->_linkStorage($url);
        curl_setopt($this->ch,CURLOPT_URL,$url );
        $result = curl_exec($this->ch);
        $curl_info = curl_getinfo( $this->ch ) ;


        if ($curl_info['http_code'] != 200) {
            // 如果是301、302跳转, 抓取跳转后的网页内容
            if ($curl_info['http_code'] == 301 || $curl_info['http_code'] == 302) {
                if (isset($curl_info['redirect_url'])) {
                    $url = $curl_info['redirect_url'];
                    $result = $this->_curl($url);
                } else {
                    return false;
                }
            }else{
                if (in_array($curl_info['http_code'], array('0','502','503','429','403'))) {

                    // 抓取次数 小于 允许抓取失败次数
                    if ( $this->link['num'][$key] <= 3 ) {
                        GatherView::info('.error','http_code:'.$curl_info['http_code'].',重新采集本url:'.$url.  '，1s后尝试第'.($this->link[$key]['num']+1).'次');
                        sleep(1);
//                        $this->_changeUA();

                        $result = $this->_curl($url);
                    }else{
                        GatherView::info('.error','http_code:'.$curl_info['http_code'].'，已尝试4次，url:'.$url);
                        if ($curl_info['http_code'] == 403 && !$this->config['proxy'] ) {
                            $this->http_code403_num ++;
                            if( $this->http_code403_num >= 10){
                                GatherView::info('.status','stop!   由于http_code：403！ 10次，停止采集采集');
                                die;
                            }
                        }
                        return false;
                    }
                } else {
                    GatherView::info('.error','http_code:'.$curl_info['http_code'].',采集失败!');
                    return false;
                }

            }
        }

        return $result;
    }
    /*
     * 本次采集的所有url信息
     * array(
     *  'urls'=> array(0=>'xxx.html',.....,???=>'xxx9999.html')
     *   'num'=> array( url_key=>1  )
     * )
     * */
    private function _linkStorage( $url ){

        if( ($key = array_search( $url , $this->link['urls'] )) !== false  ){
            $this->link['num'][$key] +=1 ;
        }else{
            $this->link['urls'][] = $url;
            $key = array_search( $url , $this->link['urls'] );
            $this->link['num'][$key]=1;
        }
        return $key;

    }
    /*
     * curl_multi_exec
        第一个循环， $mrc == CURLM_CALL_MULTI_PERFORM（-1）表明了还有句柄资源没有处理，于是就继续$mrc = curl_multi_exec($mh, $active)
        要特别说明的是$mrc和$active都是integer类型的；当$mrc== CURLM_OK（0），就表明了还有资源，但还没有到达。这是就到第二个循环了：
        while）要是有资源还没有到达(if)如果cURL批处理连接中有活动连接--也就是说句柄有事干了（具体可以参考php手册）
        (do-while）处理句柄资源
        curl并发处理因为官方文档比较简练，我自己也查了好多英文文档才略懂。
     * */
    //多进程采集
    private function _multipleCurl( $urls ){
        $map = array();
        $responses = array();
        $this->mch = curl_multi_init();

        $key = 0;
        while(1==1){
            $url = array_pop($urls);

            curl_setopt($this->chs[$key],CURLOPT_URL,$url );
            // 把当前 curl resources 加入到 curl_multi_init 队列
            curl_multi_add_handle($this->mch, $this->chs[$key]);
            $map[$url] = $key++;

            if( $key == count($this->chs) ){
                $this->_execMultipleCurl();
                foreach ($map as $url=>$k) {
                    $content=curl_multi_getcontent($this->chs[$k]);
                    curl_multi_remove_handle($this->mch, $this->chs[$k]);

                    if(strlen($content)<1000){
                        $content = $this->_httpCodeHandle($this->chs[$k],$url,$content);
                    }

                    if( false !== $content ){
                        $responses[$url] = $content;
                    }


                }
                $map=[];
                $key=0;
            }

            if( count($urls)==0 ){
                if($key !=0 ){
                    $this->_execMultipleCurl();
                    foreach ($map as $url=>$ch) {
                        $responses[$url] = curl_multi_getcontent($ch);
                        curl_multi_remove_handle($this->mch, $ch);
                    }
                }
                break;
            }
        }

        return  $responses ;
    }
    private function _execMultipleCurl(){
        $active = null;
        do {
            $mrc = curl_multi_exec($this->mch, $active);
        } while ($mrc == CURLM_CALL_MULTI_PERFORM);

        while ($active > 0 && $mrc == CURLM_OK) {
            while (curl_multi_exec($this->mch, $active) === CURLM_CALL_MULTI_PERFORM);
            // 这里 curl_multi_select 一直返回 -1，所以这里就死循环了，CPU就100%了
            if (curl_multi_select($this->mch, 0.5) != -1)
            {
                do {
                    $mrc = curl_multi_exec($this->mch, $active);
                } while ($mrc == CURLM_CALL_MULTI_PERFORM);
            }
        }
    }

    private function _httpCodeHandle($resource,$url,$content=''){
        $is_recurl = 0;     //是否进行重新采集
        $curl_info = curl_getinfo( $resource ) ;
        if ($curl_info['http_code'] != 200) {
            // 如果是301、302跳转, 抓取跳转后的网页内容
            if ($curl_info['http_code'] == 301 || $curl_info['http_code'] == 302) {
                if (isset($curl_info['redirect_url'])) {
                    GatherView::info('.other','重定向url：'.$url.'---->'.$curl_info['redirect_url']);
                    $url = $curl_info['redirect_url'];
                }
            }
            GatherView::info('.other','url：'.$url.'----http-code:：'.$curl_info['http_code'].'--正在重新采集');
            $content = $this->_curl($url);
            $is_recurl=1;
//            return strlen($content<=1000)?false:$content;
        }
        if(strlen($content)<=1000){
            GatherView::info('.other','url：'.$url.'字数太少被忽略：'.strlen($content));
            return false;
        }
        $is_recurl==1 && GatherView::info('.other','url：'.$url.'----重新采集成功！');
        return $content;
    }

    //将相对路径变为绝对路径
    private function _handleUrl( $now_url ,$son_url ){

        preg_match('/^http/',$son_url,$res);
        if( !$res ){
            $parse_purl = parse_url( $now_url );

            $first = substr($son_url,0,1) ;
            if( $first == '/'){
                $son_url =$parse_purl['scheme']."://".$parse_purl['host'].$son_url;

            }elseif($first == '.' ){
                if( substr($parse_purl['path'],-1) == '/' ){
                    $son_url = substr( $son_url,2);
                    $son_url =$parse_purl['scheme']."://".$parse_purl['host'].$parse_purl['path'].$son_url;
                }else{
                    $son_url = substr( $son_url,1);
                    $son_url =$parse_purl['scheme']."://".$parse_purl['host'].$parse_purl['path'].$son_url;
                }
            }else{
                $son_url =$parse_purl['scheme']."://".$parse_purl['host'].$parse_purl['path'].$son_url;
            }
        }

        return $son_url;
    }
}
