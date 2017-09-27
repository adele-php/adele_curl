<?php
namespace application\admin\controller;

use application\admin\model\Novel;
use resource\adele\GatherView;
use resource\adele\Model;

/**
 * 采集
 */
class Gather extends \resource\Controller{

	public function __construct(){
        parent::__construct();
	}

    public function ding(){
        $this->run([]);
    }

    public function index(){
        $gather = M('gather')->field('id,detail_url,iconv,templet')->where('1=1')->select();
        $this->assign('gather',$gather);
        $this->registerPlugin("function","num2str",[$this,'num2str']);//第二个参数是模板文件调用的函数名称，可变；第三个参数是上面自定义的函数名称；相应于一个对应关系
        $this->display('index.html');
    }

    public function num2str($parm){
        return ($parm['num']==0)?'否':'是';
    }

    public function add(){
        if( $_SERVER['REQUEST_METHOD'] !='GET'){
            if( true!== $error=$this->_check(['detail_url'],$_POST) ){
                echo json_encode($error);
            }else{
                echo M('gather')->insert($_POST);
            }
            return;
        }
        $this->assign('tmps',M('gather')->field('detail_url,id')->where('templet=1')->select());
        $this->assign('hid_type',Spider::NOVEL);
        $this->display('add.html');
    }

    public function edit($id=null){
        if( $_SERVER['REQUEST_METHOD'] !='GET'){
            echo M('gather')->where('id='.$_POST['id'])->update($_POST);
            die;
        }
        $gather = M('gather')->where('id='.$id)->find();
        foreach( $gather as $k=>$v){
            $gather[$k] = htmlentities( $v,ENT_QUOTES);
        }
        //TODO 判断采集类型 小说|新闻 ...
        $this->assign('hid_type','0');
        $this->assign('gather',$gather);
        $this->display('edit.html');
    }

    public function del(){
        echo M('gather')->where('id='.$_GET['id'])->delete();
    }

    private function _check($check,$all_data){
        foreach($check as $v){
            if(!array_key_exists($v,$all_data)){
                return ['error'=>1,'info'=>$v.' 不能为空！'];
            }
        }
        return true;
    }

    public function getRule(){
        $gather_info = M('gather')->where('id='.$_GET['id'])->select();
        foreach( $gather_info[0] as $k=>$v){
            htmlentities( $gather_info[0][$k],ENT_QUOTES);
        }
        echo json_encode($gather_info[0]);
    }

    //采集配置页面
    public function config(){
        if( $_SERVER['REQUEST_METHOD'] !='GET'){
            $data = $_POST;
            if( empty($_POST['multi']) || $_POST['multi']<=1 ){
                $data['multi']=0;
            }else{
                $data['multi']=$_POST['multi'];
            }


            return;
        }
        $this->display('config.html');
    }


    //**********************采集相关************************

    public function gather($id){
        set_time_limit(0);                      //设置程序不超时
        ini_set('max_execution_time',0 );       //设置程序不超时
        @ob_end_clean();                         //关闭缓冲区
        @ob_implicit_flush(1);                   //打开绝对刷送,每次echo时会调用flush()刷新缓冲
        @header('X-Accel-Buffering: no');        //解决nginx下无法及时 刷新缓冲

        $this->assign('start_time',date('Y-m-d H:i:s',time()));
        $this->display('gather.html');die;

        $gather_info = M('gather')->where('id='.$id)->find();
        $config = $this->getNovelConfig($gather_info);
        $this->run($config);


//        echo '<div class="js"><script>$(".content").text(2222)</script></div>';
    }

    public function getNovelConfig($gather_info){
        $config = [
            'novel' =>[
                'url'=>    [
                    'detail_url'=>$gather_info['detail_url'],
                    'section_url'=>$gather_info['section_url']
                ],
                'start'=>  [
                    'detail_start'=>$gather_info['detail_start'],
                    'section_start'=>$gather_info['section_start'],
                    'content_start'=>$gather_info['content_start']
                ],
                'end'=>    [
                    'detail_end'=>$gather_info['detail_end'],
                    'section_end'=>$gather_info['section_end'],
                    'content_end'=>$gather_info['content_end']
                ],
                'pattern'=>[
                    'detail_pattern'=>$gather_info['detail_pattern'],
                    'section_pattern'=>$gather_info['section_pattern'],
                    'content_pattern'=>$gather_info['content_pattern']
                ],
                'section_page'=>['start'=>'','end'=>'','pattern'=>''],          //章节分页
            ],
            'type'=>'normal',   //   normal正常采集  |  test采集测试
            'test'=>null,   // DETAIL_GATHER|SECTION_GATHER|CONTENT_GATHER
            'iconv'=>'utf-8',
        ];
        if( $gather_info['section_page']==1 ){
            $config['novel']['section_page']=[
                'start'=>$gather_info['section_page_start'],
                'end'=>$gather_info['section_page_end'],
                'pattern'=>$gather_info['section_page_pattern'],
            ];
        }
        return $config;
    }

    public function setTemplet(){
        $templet = ($_GET['val']==0)?1:0;
        echo M('gather')->where('id='.$_GET['id'])->update(['templet'=>$templet]);
    }

    //采集测试测试
    public function test(){
        $config = [
            'thread_num'=>1,//线程数
            'novel' =>[
                'url'=>    ['detail_url'=>'',    'section_url'=>''],
                'start'=>  ['detail_start'=>'',  'section_start'=>'',  'content_start'=>''],
                'end'=>    ['detail_end'=>'',    'section_end'=>'',    'content_end'=>''],
                'pattern'=>['detail_pattern'=>[],'section_pattern'=>'','content_pattern'=>''],
                'section_page'=>['start'=>'','end'=>'','pattern'=>''],          //章节分页
            ],
            'type'=>'test',   //   normal正常采集  |  test采集测试
            'test'=>null,   // DETAIL_GATHER|SECTION_GATHER|CONTENT_GATHER
            'iconv'=>'utf-8',
        ];
//        var_dump( $config );die;
        switch($_POST['type']){
            case 'detail':
                $config['novel']['url']['detail_url'] = I('post.detail_url');
                $config['novel']['start']['detail_start'] = I('post.detail_start');
                $config['novel']['end']['detail_end'] = I('post.detail_end');
                $config['novel']['pattern']['detail_pattern'] = I('post.detail_pattern');
                $config['iconv'] = I('post.iconv');
                $config['test'] = Novel::DETAIL_GATHER;
                break;
            case 'section':
                $config['novel']['url']['section_url'] = I('post.section_url');
                $config['novel']['start']['section_start'] = I('post.section_start');
                $config['novel']['end']['section_end'] = I('post.section_end');
                $config['novel']['pattern']['section_pattern'] = I('post.section_pattern');
                $config['iconv'] = I('post.iconv');
                $config['test'] = Novel::SECTION_GATHER;

                if( I('post.section_page')==1 ){
                    $config['novel']['section_page']['start'] = I('post.section_page_start');
                    $config['novel']['section_page']['end'] = I('post.section_page_end');
                    $config['novel']['section_page']['pattern'] = I('post.section_page_pattern');
                }

                break;
            case 'content':
                $config['novel']['start']['content_start'] = I('post.content_start');
                $config['novel']['end']['content_end'] = I('post.content_end');
                $config['novel']['pattern']['content_pattern'] = I('post.content_pattern');
                $config['test'] = Novel::CONTENT_GATHER;

                $config['novel']['url']['section_url'] = I('post.section_url');
                $config['novel']['start']['section_start'] = I('post.section_start');
                $config['novel']['end']['section_end'] = I('post.section_end');
                $config['novel']['pattern']['section_pattern'] = I('post.section_pattern');
                $config['iconv'] = I('post.iconv');

                if( I('post.section_page')==1 ){
                    $config['novel']['section_page']['start'] = I('post.section_page_start');
                    $config['novel']['section_page']['end'] = I('post.section_page_end');
                    $config['novel']['section_page']['pattern'] = I('post.section_page_pattern');
                }
                break;
        }

        $result = $this->run($config);
        echo json_encode($result);
    }


    public function run($config,$func='run'){

        $novel_obj = new Novel($config);
        $result = $novel_obj->$func();              //执行采集

        return $result;
    }


    /********************************************************/
//    private $log_analysis    = false;           //采集分析
//    private $simulated_human = false;           //模拟人类
//    private $foreground_log  = true;            //前台显示日志
//
//    private $ch=null;
//    private $proxy=false;
//    /*
//     *   urls =>
//     * */
//    private $link = array('urls'=>array());
//    private $link_key = 0;
//    private $link_count = 0;
//    private $user_agent = array(
//        'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_8; en-us) AppleWebKit/534.50 (KHTML, like Gecko) Version/5.1 Safari/534.50',
//        'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-us) AppleWebKit/534.50 (KHTML, like Gecko) Version/5.1 Safari/534.50',
//        'Opera/9.80 (Macintosh; Intel Mac OS X 10.6.8; U; en) Presto/2.8.131 Version/11.11',
//        'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_0) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.56 Safari/535.11',
//        'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; Maxthon 2.0)',
//    );
//
//
//
//
//
//    /*
//     * @param $filename         缓存文件名
//     * @param $pages            分页总数
//     * @param $url              分页url
//     * @param $preg             列表正则
//     * @param $code             编码
//     * @param $suffix           后缀
//     */
//    private function _getPagesUrls( $filename ,$pages ,$url ,$preg ,$code=null,$suffix='' ){
//        $detail_urls = array();
//        $books_detail = array();
//        for( $i=1;$i<=$pages;$i++){
//            if($detail_urls = writeTxt( '' ,$filename,2 )) {
//                break;
//            }
//            //匹配出 书本详情页
//            $u = $url.$i.$suffix;
//            $str = $this->curl($u);
//            $str = $this->_convertEncode( $str ,$code );
//            if(empty( $str )){$this->_foreground('info','<br/>采集URL'.$url.'返回为空<br/>');continue;}
//            $str = $this->_substr( $str , $preg['start'],$preg['end']);
//            //当前页所有 书本详情页链接
//            preg_match_all($preg['pattern'] , $str , $middle_result );
//            $books_detail = array_merge( $books_detail,$middle_result[1] );
//
//            if( $i == $pages ) writeTxt($books_detail , $filename ,1 );
//        }
//
//        return $detail_urls;
//    }
//
//
//
//    //顶点
//    public function dingdian( $proxy = 0  ,$id = null){
//        $start_time = time();
//        $proxy_info = null ;
//        if( $proxy ){
//            $proxy_info = M('caiji')->field('proxyServer,proxyPass,proxyUser')->where('id='.$id)->find();
//            $this->proxy = true;
//        }
//
//        $this->run( $proxy_info );
//
//        //得到分页里 每页列表所有链接
//        $preg = array('start'=>'<table','end'=>'</table>','pattern'=>'/<a href="(.*)" title=".*">.*<\/a>/Ui') ;
//        $books_detail = $this->_getPagesUrls('dingdian.txt',690 ,'http://www.23us.com/quanben/',$preg ,'gbk');
//
//        //循环所有小说
//        $book_data = array();$gid = '9999';
//        $book_key =writeTxt('' , 'caiji_log.txt' , 2);
//
//        if( $book_key !== false &&  $book_key !==0 ){
//            $books_detail = array_slice($books_detail ,$book_key ,null,true );
//        }
//        foreach( $books_detail as $k=>$detail_url ){
//
//            writeTxt( $k , 'caiji_log.txt' , 1);
//            $str = $this->curl($detail_url  );
//
//            $str = mb_convert_encoding($str ,'utf-8','gbk');
//            if(empty( $str )){echo '<br/>未采集成功URL'.$detail_url.'<br/>' ;continue;}
//
//            $str = $this->_substr($str,'<dl id="content">','</dl>' );
//
//            preg_match_all('/<h1>(.*)<\/h1>/Uis' , $str , $name );
//            preg_match_all('/<img .* src="(.*)"/Uis' , $str , $img );
//            preg_match_all('/<th>文章类别<\/th>.*<a href=".*">(.*)<\/a><\/td>/Uis' , $str , $type );
//            preg_match_all('/<th>文章作者<\/th><td>(.*)<\/td>/Uis' , $str , $author );
//            preg_match_all('/<a .* href="(.*)" .*>章节列表<\/a>/Ui' , $str , $url );
//
//            $str_desc = $this->_substr($str,'<table width="740px" border="0" cellspacing="0" cellpadding="0" style="padding:5px 5px 5px 5px;">','</p>' );
//            preg_match_all('/<p>(.*)/i' , $str_desc , $desc );
//
//            $book_data['name'] = trim(str_replace('全文阅读','',$name[1][0]));
//            $book_data['type'] = $type[1][0];
//            $book_data['author'] = $author[1][0];
//            $book_data['desc'] = strip_tags($desc[1][0]);
//            $book_data['url'] = $url[1][0];
//
//
//            if( $bk = M('book')->field('id,gid')->where('name like "%'.$book_data['name'].'%"'   )->find() ){
//                //书本存在
//                $this->_foreground('info','小说：'.$book_data['name'].' 已存在，将为您更新章节');
//                $gid = $bk['gid'];
//            }else{
//
//                //书本不存在
//                $img_name = '/Uploads/Picture/ding/'.getImage( $img[1][0] , array_pop(explode('/',$img[1][0]))  , __DIR__.'/../../../Uploads/Picture/ding/'  );
//                $book_data['img'] =$img_name;
//
//                switch( $book_data['type'] ) {
//                    case '玄幻':
//                        $book_data['type'] = 0;
//                        break;
//                    case '都市':
//                        $book_data['type'] = 1;
//                        break;
//                    case '科幻':
//                        $book_data['type'] = 2;
//                        break;
//                    case '武侠':
//                        $book_data['type'] = 3;
//                        break;
//                }
//
//                if($book_id = M('book')->add( $book_data ) ){
//                    $this->_foreground('info','采集小说：'.$book_data['name'].'OK后将采集其内容');
//                    $this->_foreground('ok');
//
//                    $gid = M('gather')->add( array('title'=> $book_data['name'] ));
//                    M('book')->where('id='.$book_id)->save(array('gid'=>$gid));
//                }else{
//                    $this->_foreground('info','插入小说失败：'.$book_data['name'].$detail_url);
//                    continue;
//                }
//            }
//
//
//            //循环小说所有章节链接 并采集里面的内容
//            $datas = array();
//
//            $details = $this->_gatherHandle( $book_data['url'] ,'<div class="read_share">' , '<div class="hot">' ,'/<a href="(.*)">(.*)<\/a>/Uis','gbk' );
//
//            foreach( $details[1] as $k1=>$detail ){
//                //判断链接是否正常
//                $detail = $this->_handleUrl( $book_data['url'] , $detail );
//                //过滤已经插入的
//                if( $this->_filter($details[2][$k1] ,$gid )) continue;
//                $contents = $this->_gatherHandle( $detail ,'<dd id="contents">' , '</dd>' ,'/(.*)/', 'gbk' );
//
//
//                if( $contents === true ) continue;
//                $content = '';
//                if( isset($contents[1]) ){
//                    foreach( $contents[1] as $key => $val ){
//                        if( strlen( $val ) >1000){
//                            $content .= $val;
//                            break;
//                        }
//                    }
//                }else{
//                    foreach( $contents[0] as $key => $val ){
//                        if( strlen( $val ) >1000){
//                            $content .= $val;
//                            break;
//                        }
//                    }
//                }
//
//                if(strlen( $content ) <1000 ) {
//                    $this->_foreground('info','采集内容偏少<br/>');
//                    continue;
//                }
//
//                $data['content'] = $content;
//                $data['pid'] = $gid;
//                $data['title'] = $details[2][$k1];
//                $data['section'] =  $this->_getSection($details[2][$k1]);
//
//
//                $datas[] = $data;
//
//                $data = array();
//
//
//                if( count( $datas ) >5 ){
//                    $this->_gatherStorage( $datas);
//                    $datas = array();
//                }
//            }
//
//            $this->_gatherStorage( $datas);
//
//
//        }
//
//
//        echo date('H:i:s',time()-$start_time );
//    }
//
//
//
//    private function _handleContent( $contents ){
//        if( $contents === true ) return 'continue';
//        $content = '';
//        if( isset($contents[1]) ){
//            foreach( $contents[1] as $key => $val ){
//                if( strlen( $val ) >1000){
//                    $content .= $val;
//                    break;
//                }
//            }
//        }else{
//            foreach( $contents[0] as $key => $val ){
//                if( strlen( $val ) >1000){
//                    $content .= $val;
//                    break;
//                }
//            }
//        }
//
//        if(strlen( $content ) <1000 ) {
//            $this->_foreground('info','采集内容偏少<br/>');
//            return 'continue';
//        }
//        return $content;
//    }
//
//    public  function test($targetUrl = "http://test.abuyun.com/proxy.php"  ){
//
//        $targetUrl='http://www.iadele.cn/home/index/classify/id/0.html';
//
//
//        // 代理服务器
//        $proxyServer = "http://proxy.abuyun.com:9020";
//
//
//        // 隧道身份信息
//        $proxyUser   = "HALX357731D18LJD";
//        $proxyPass   = "2FAFF18EF86FDF0B";
//
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, $targetUrl);
//        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
//        curl_setopt($ch, CURLOPT_POST, true);
//        if( !empty($data )){
//            curl_setopt($ch, CURLOPT_POSTFIELDS, array('no_cache'=>1,'type'=>$data['type']));
//        }else{
//            curl_setopt($ch, CURLOPT_POSTFIELDS, array('no_cache'=>1));
//        }
//
////        // 设置代理服务器
////        curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
////        curl_setopt($ch, CURLOPT_PROXY, $proxyServer);
////
////        // 设置隧道验证信息
////        curl_setopt($ch, CURLOPT_PROXYAUTH, CURLAUTH_BASIC);
////        curl_setopt($ch, CURLOPT_PROXYUSERPWD, "{$proxyUser}:{$proxyPass}");
////
////        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 2.0.50727;)");
////
////        curl_setopt($this->ch, CURLOPT_USERAGENT, $this->user_agent[mt_rand(0,4)]);
//
//        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
//        curl_setopt($ch, CURLOPT_TIMEOUT, 100);
//        curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
//        curl_setopt($ch, CURLOPT_HEADER, true);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//
//        $result = curl_exec($ch);
//        //$info = curl_getinfo($ch);
//
//
//        var_dump(curl_error($ch) ,$result);
//        curl_close($ch);
//
//    }
//
//
//
//
//
//
//    /****************      公用*****************************/
//    /****************      公用*****************************/
//    /****************      公用*****************************/
//    /****************      公用*****************************/
//    /****************      公用*****************************/
//    public function run($proxy = null ){
//        $this->_start();
//        if( $this->proxy ){
//            $this->_proxy( $proxy['proxyServer'],$proxy['proxyUser'],$proxy['proxyPass'] );
//        }
//
//    }
//
//    //
//    private function _start(){
//        set_time_limit(0);
//        ini_set('max_execution_time',0 );
//        ob_end_clean();
//        ob_implicit_flush(1);
//        header('X-Accel-Buffering: no');
//
//
//        $this->_foreground('init');
//
//        $this->ch = curl_init();
//        curl_setopt($this->ch,CURLOPT_RETURNTRANSFER,1);
//        curl_setopt($this->ch, CURLOPT_HEADER, true);
//        curl_setopt($this->ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
//
//    }
//    private function _proxy( $proxyServer,$proxyUser,$proxyPass){
//        // 隧道身份信息
////        $proxyServer='http://proxy.abuyun.com:9020';
////        $proxyUser   = "HAR45CEF4S7N2B5D";
////        $proxyPass   = "BA9C4024D5ED689E";
//
//        // 设置代理服务器
//        curl_setopt($this->ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
//        curl_setopt($this->ch, CURLOPT_PROXY, $proxyServer);
//
//        // 设置隧道验证信息
//        curl_setopt($this->ch, CURLOPT_PROXYAUTH, CURLAUTH_BASIC);
//        curl_setopt($this->ch, CURLOPT_PROXYUSERPWD, "{$proxyUser}:{$proxyPass}");
//
//        curl_setopt($this->ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.95Safari/537.36 SE 2.X MetaSr 1.0");
//
//        curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, 3);
//        curl_setopt($this->ch, CURLOPT_TIMEOUT, 5);
//
//    }
//    private function _changeUA(){
//        curl_close($this->ch );
//
//        $this->ch = curl_init();
//        curl_setopt($this->ch,CURLOPT_RETURNTRANSFER,1);
//        curl_setopt($this->ch, CURLOPT_HEADER, true);
//    }
//
//    //前台显示信息
//    private function _foreground($type,$info=null){
//        if( !$this->foreground_log ){
//            return;
//        }
//        switch($type){
//            case 'info':
//                echo $info.'<br/>'.'<script>ku();</script>';
//                break;
//            case 2:
//                echo '采集:'.$info.'<script>ku();</script>';
//                break;
//            case 'ok':
//                echo '&nbsp&nbsp&nbsp <span style="color:rgb(0,255,0)">OK</span><br/>';
//                break;
//            case 'error':
//                echo '&nbsp&nbsp&nbsp <span style="color:rgb(255,0,0)">error &nbsp;&nbsp;&nbsp;</span>'.$info.'<br/>'.'<script>ku();</script>';
//                break;
//
//            case 'init':
//                echo '开始采集<br/>';
//                $str =  '<script type="text/javascript" src="'.__ROOT__ .'/Public/static/jquery-2.0.3.min.js"></script>';
//                $str.='<script>$("body").css("background","#000");$("body").css("color","rgb(0,255,0)");';
//                $str.='function ku(){$("body").scrollTop( $("body")[0].scrollHeight )};';
//                $str .='</script>';
//                echo $str;
////                $this->assign( 'src' , __ROOT__.'/Public/static/jquery-2.0.3.min.js');
////                $this->display('Feedback/empty');
//                break;
//        }
//    }
//    //日志信息
//    private function _log( $type ){
//        //分析每一百条时间
//
//
//
//    }
//    /*
//     * 本次采集的所有url信息
//     * array(
//     *  'urls'=> array(0=>'xxx.html',.....,???=>'xxx9999.html')
//     *   0=> array( 'num'=>1  )
//     * )
//     * */
//    private function _linkStorage( $url ){
//
//        if( ($key = array_search( $url , $this->link['urls'] )) !== false  ){
//            $this->link[$key]['num'] +=1 ;
//
//        }else{
//            $this->link[$this->link_key]['num'] = 1;
//            $key = $this->link_key;
//            $this->link['urls'][$this->link_key] = $url;
//            $this->link_key++;
//        }
//
//        return $key;
//
//    }
//    public function curl($url){
//        static $http_code403_num= 0;
//        static $sleep_time = 0;
//
//        curl_setopt($this->ch,CURLOPT_URL,$url );
//        $link_key = $this->_linkStorage( $url );
//
//        //模拟人类采集
//        if( $this->simulated_human ){
//            $rand = mt_rand( 2 , 5);
//            $sleep_time += $rand ;
//            sleep( $rand );
//        }
//        $result = curl_exec($this->ch);
//
//        if( $this->log_analysis ){
//            $this->link_count ++ ;
//            if( $this->link_count == 1 ){
//                $this->start_time = time();
//                writeTxt('开始时间：'.date( 'H:i:s',$this->start_time )."\r\n" ,'',3 );
//            }elseif($this->link_count == 1001){
//                $this->end_time = time();
//                $time = $this->end_time-$this->start_time ;
//
//                writeTxt('采集一千条的所用时间：'.($time/60).'分,模拟人类睡眠时间:'.($sleep_time/60)."分\r\n"."\r\n".'结束时间：'.date( 'H:i:s',$this->end_time )."\r\n" ,'',3 );
//                writeTxt('当前内存：'.memory_get_usage()."\r\n" ,'',4 );
//                die('ok!!!!');
//                $this->link_count=0;
//            }
//        }
//
//        $curl_info = curl_getinfo( $this->ch ) ;
//
//
//        if ($curl_info['http_code'] != 200) {
//            // 如果是301、302跳转, 抓取跳转后的网页内容
//            if ($curl_info['http_code'] == 301 || $curl_info['http_code'] == 302) {
//                if (isset($curl_info['redirect_url'])) {
//                    $url = $curl_info['redirect_url'];
//                    $result = $this->curl($url);
//                } else {
//                    return false;
//                }
//            } else {
//                if (in_array($curl_info['http_code'], array('0','502','503','429','403'))) {
//
//                    // 抓取次数 小于 允许抓取失败次数
//                    if ( $this->link[$link_key]['num'] <= 3 ) {
//                        $this->_foreground('error','http_code:'.$curl_info['http_code'].',重新采集本url:'.$url.  '，1s后尝试第'.($this->link[$link_key]['num']+1).'次');
//                        sleep(1);
////                        $this->_changeUA();
//
//                        $result = $this->curl($url);
//                    }else{
//                        $this->_foreground('error','http_code:'.$curl_info['http_code'].'，已尝试4次，url:'.$url);
//                        if ($curl_info['http_code'] == 403 && !$this->proxy ) {
//                            $http_code403_num ++;
//                            if( $http_code403_num >= 10){
//                                $this->end_time = time();
//                                $time = $this->end_time - $this->start_time;
//                                writeTxt('由于http_code：403！ 10次，停止采集。采集'.$this->link_count.'条的所用时间：'.($time/60).'分,模拟人类睡眠时间:'.($sleep_time/60)."分\r\n".'结束时间：'.date( 'H:i:s',$this->end_time )."\r\n" ,'',3 );
//                                die;
//                            }
//                        }
//                        return false;
//                    }
//
//                } else {
//                    $this->_foreground('error','http_code:'.$curl_info['http_code'].',采集失败!');
//                    return false;
//                }
//
//            }
//        }
//
//        return $result;
//    }
//
//
//
//    /*
//     * 将编码转变为UTF-8  ,默认自动识别
//     * 识别不到 return false
//     */
//    private function _convertEncode( $str,$now_encode = null  ){
//        if( $now_encode == 'utf-8'){
//            return $str ;
//        }
//        if( !$now_encode ){
//            $now_encode = mb_detect_encoding($str, array("ASCII","UTF-8","GB2312","GBK") );
//        }
//        $str = $now_encode?mb_convert_encoding($str ,'utf-8',$now_encode):false;
//        return $str ;
//    }
//    private function _substr( $str , $start,$end ){
//        $start_pos = strpos( $str ,$start  );
//        $end_pos   = strpos( $str ,$end ,$start_pos);
//        $length = $end_pos-$start_pos;
//
//        return substr( $str ,$start_pos , $length );
//    }
//
//    private function _gatherHandle($url,$start,$end,$pattern,$iconv=null){
//
//        $this->_foreground('2' ,$url );
//        $str = $this->curl($url);
//        $str = $this->_convertEncode( $str , $iconv );
//
//        if(empty( $str )){
//            $this->_foreground('info' ,'未采集成功URL'.$url.'<br/>' );
//            return true;
//        }
//
//        $this->_foreground( 'ok' );
//        $str = $this->_substr( $str , $start , $end );
//        preg_match_all($pattern , $str , $result );
//        return $result;
//    }
//    private function _gatherMultiHandle($urls,$start,$end,$pattern,$iconv=null,$proxy_info=null){
//        $data = array();
//        $this->_foreground('info' ,'批量采集url：<br/>'.implode('<br/>',$urls) );
//        $strs = $this->multipleCurl($urls,$proxy_info);
//        foreach( $strs as $url =>$str ){
//            $str = $this->_convertEncode( $str , $iconv );
//            if(empty( $str )){
//                $this->_foreground('info' ,'未采集成功URL'.$url.'<br/>' );
//                continue;
//            }
//            $str = $this->_substr( $str , $start , $end );
//            preg_match_all($pattern , $str , $result );
//            $data[$url] = $result;
//        }
//        $this->_foreground('info' ,'其余URL采集成功！<br/>' );
//        return $data;
//    }

//
//    private function _filter( $title ,$pid ){
//        $condition = array('pid'=>$pid,'title'=>$title);
//        $result = M('novel')->where($condition)->find();
//
//        return $result?true:false;
//    }
//    //批量存储
//    private function _gatherStorage( $data ){
//        M('novel')->addAll($data);
//    }
//
//    //从标题中得到章节数
//    private function _getSection( $title ){
////        preg_match('/第([^\s]*)章/U',$title,$arr);
//        preg_match('/第([零一二三四五六七八九十百千万]*)章/U',$title,$arr);     //第一章
//        $arr || preg_match('/第(\d*)章/U',$title,$arr);                       //第1章
//        if( !$arr ){  return (int)$title; }
//
//        if( preg_match('/[一二三四五六七八九十]/',$arr[1]) == 1 ) {
////            var_dump( $arr[1]);/
////            preg_match_all('/([一二三四五六七八九]*)千?([一二三四五六七八九]*)百?([一二三四五六七八九]*)十?([一二三四五六七八九]*)/',$arr[1] , $res );
//            $patterns = array('/一/', '/二/', '/三/', '/四/', '/五/', '/六/', '/七/', '/八/', '/九/', '/十/', '/百/', '/千/');
//            $replaces = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 'a', 'b', 'q');
//            $str = preg_replace($patterns, $replaces, $arr[1]);
//
//            preg_match_all('/(\d)?([abq])?/u', $str, $res);
//
//            $num = 0;
//            //第一百零六章 封禅之地
//            if( preg_match('/[abq]/',$str ) == 1 ){
//                foreach ($res[1] as $k => $v) {
//                    switch ($res[2][$k]) {
//                        case 'a':
//                            $figure = 10;
//                            break;
//                        case 'b':
//                            $figure = 100;
//                            break;
//                        case 'q':
//                            $figure = 1000;
//                            break;
//                        case '':
//                            $figure = 1;
//                            break;
//                    }
//                    if ($v == '' && $res[2][$k] != '') $v = 1;
//                    $num += $v * $figure;
//                }
//                return $num;
//                //第一五二零章 群英荟萃
//            }else{
//                return implode( '',$res[1]);
//            }
//
//        }else{
//
//            return  (int)$arr[1];
//        }
//
//    }



}



