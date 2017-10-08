<?php


namespace application\admin\model;

use resource\adele\GatherView;
/**
 * 爬虫模块
 */
class Novel extends Spider{
    //小说
    const DETAIL_GATHER =1;             //详情采集
    const SECTION_GATHER=2;             //章节采集
    const CONTENT_GATHER=3;             //内容采集
    const MIN_WORD=1000;                //采集最少字数

    public $last_force_gather_time = null;

    public $book_put_in=null;        //书籍入库操作
    public $content_put_in=null;     //内容章节入库操作

    public function __construct( $config ){
        $this->_iniConfig($config);

        parent::__construct();

    }

    private function _iniConfig($config=[]){
        $default_config = [
            'thread_num'=>1,//线程数
            'proxy'=>[
                'proxy_status'=>0,      //是否开启代理
                'proxy_info'=>[
                    'proxy_server'=>null,
                    'proxy_username'=>null,
                    'proxy_password'=>null,
                ]
            ],
            'cookie'=>null,
            'novel' =>[
                'url'=>    ['detail_url'=>'',    'section_url'=>''],
                'start'=>  ['detail_start'=>'',  'section_start'=>'',  'content_start'=>''],
                'end'=>    ['detail_end'=>'',    'section_end'=>'',    'content_end'=>''],
                'pattern'=>['detail_pattern'=>[],'section_pattern'=>'','content_pattern'=>''],
                'section_page'=>['start'=>'','end'=>'','pattern'=>''],          //章节分页
            ],
            'type'=>'normal',   //   normal正常采集  |  test采集测试
            'test'=>null,   // DETAIL_GATHER|SECTION_GATHER|CONTENT_GATHER
            'iconv'=>'utf-8',
        ];

        $this->config = array_merge($default_config,$config);
    }

    public function run(){
        $bid = 0;

        //curls自定义函数
        if($this->config['thread_num']>1){
            $this->engine->strlen_handle = function($content){
                if(strlen($content)<self::MIN_WORD){
                    return false;
                }
                return true;
            };
        }

        //采集测试
        if(!empty($this->config['test'])){
            return $this->gatherCheckout($this->config['test']);
        }

        //采集小说详情
        $detail_info = $this->novelDetail();
        //TODO 处理图片
        $detail_info['img'] = $this->handleUrl($this->config['novel']['url']['detail_url'],$detail_info['img']);
        $detail_info['img'] = save_image($detail_info['img']);
        GatherView::info('.book_name',$detail_info['name'],false,$this->config['type']);
        //书籍入库
        if($this->book_put_in){
            $bid = call_user_func($this->book_put_in,$detail_info,$this->config['gather_id']);
        }



        //采集小说章节链接 return ['url'=>[],'title'=>[]]
        $section_info = $this->novelSection();
        GatherView::info('.other',myDate().'发现章节链接数：'.count($section_info['url']),true,$this->config['type']);
        GatherView::info('.all',count($section_info['url']),false,$this->config['type']);

        //章节链接入队列
        foreach($section_info['url'] as $k=>$url){
            $url = $this->handleUrl($this->config['novel']['url']['section_url'],$url);
            $url_info = ['url'=>$url,'title'=>$section_info['title'][$k]];
            $this->engine->enqueue($url_info);
        }


        //采集小说内容 return ['url'=>,'title'=>[],'content'=>[]]
        $content = [];
        $i=0;
        $section_num=count($this->engine->queue);
        $contentConfig = $this->parseConfig('content');
        while(count($this->engine->queue)!=0){
            $content_info = $this->novelContent($contentConfig,$section_num);

            if($this->config['thread_num']>1){
                // url=>[0=>..,1=>..]
                foreach($content_info['title'] as $k=>$v ){
                    $content[] = [
                        'title'=>$v,
                        'section'=>$this->getSection($v),
                        'content'=>$content_info['content'][$k],
                        'bid'=>$bid,

                        'target_id'=>'',    //用于特殊书籍的排序(分卷)
                    ];
                }
            }else{
                $content = [
                    'title'=>$content_info['title'],
                    'section'=>$this->getSection($content_info['title']),
                    'content'=>$content_info['content'],
                    'bid'=>$bid,
                ];
            }

            //章节内容入库
            if($this->content_put_in){
                call_user_func($this->content_put_in,$content,$this->config['thread_num']);
            }


        }


    }

    /*
     * 采集小说详情
     * @return array(
     *  field=>val
     * )
     */
    public function novelDetail(){
        GatherView::info('.other',myDate().' 开始采集小说详情',true,$this->config['type']);

        $detailConfig = $this->parseConfig('detail');
        $result = [];

        //得到详情页内容
        $content = $this->forceGather($detailConfig['url']);

        //采集成功
        GatherView::info('.other',myDate().'小说详情采集成功！耗时:'.$this->engine->last_curl_info['total_time'],true,$this->config['type']);
        GatherView::info('.book_status','OK',false,$this->config['type']);

        //网页内容进行 转码+截取
        $content = $this->contentHandle($detailConfig['start'][0],$detailConfig['end'][0],$content,$this->config['iconv']);
        if(strlen($content)<self::MIN_WORD){
            GatherView::info('.error',myDate()."编码后内容偏少，停止采集，请检查编码",true,$this->config['type']);
            $this->fatalErrorHandle();
        }
        //匹配信息
        foreach($detailConfig['pattern'] as $k=>$pattern){
            $str = $this->substr($content,$detailConfig['start'][$k],$detailConfig['end'][$k]);
            // TODO 匹配失败
            if(!preg_match($pattern,$str,$res)){
                GatherView::info('.error',myDate()."{$k}匹配失败，停止采集，请检查正则",true,$this->config['type']);
                $this->fatalErrorHandle();
            }
            $result[$k]=$res[1];
        }
        return $result;
    }


    //采集小说章节
    public function novelSection(){
        GatherView::info('.other',myDate().' 开始采集小说章节',true,$this->config['type']);
        $result = ['url'=>[],'title'=>[]];
        $sectionConfig = $this->parseConfig('section');

        //得到章节页内容 并判断内容大小
        $content = $this->forceGather($sectionConfig['url']);
        //采集成功
        GatherView::info('.other',myDate().'小说章节采集成功！耗时:'.$this->last_force_gather_time,true,$this->config['type']);

        //存在分页
        if(!empty($sectionConfig['section_page'])){
            GatherView::info('.other',myDate().'发现分页！',true,$this->config['type']);
            //得到分页链接
            $page_content = $this->contentHandle($sectionConfig['section_page']['start'],$sectionConfig['section_page']['end'],$content,$this->config['iconv']);
            // 匹配失败
            if(!preg_match_all($sectionConfig['section_page']['pattern'],$page_content,$page_url)){
                GatherView::info('.error',myDate()."匹配失败，停止采集，请检查分页正则",true,$this->config['type']);
                $this->fatalErrorHandle();
            }
            //分页处理
            foreach($page_url[1] as $u){
                $sectionConfig['url'] = $this->handleUrl($sectionConfig['url'],$u);
                $res = $this->gatherSection($sectionConfig);
                $result['url']=array_merge($result['url'],$res['url']);
                $result['title']=array_merge($result['title'],$res['title']);

                GatherView::info('.other',myDate().'分页:'.$u.'采集成功！耗时:'.$this->last_force_gather_time,true,$this->config['type']);
            }
        }else{
            $result = $this->gatherSection($sectionConfig);
            GatherView::info('.other',myDate().'章节采集成功！耗时:'.$this->last_force_gather_time,true,$this->config['type']);
        }
        return $result;

    }
    private function gatherSection($sectionConfig){
        $result = [];

        //得到内容+排除垃圾章节
        $content = $this->forceGather($sectionConfig['url']);
        //截取并转码
        $content = $this->contentHandle($sectionConfig['start'],$sectionConfig['end'],$content,$this->config['iconv']);
        if(!preg_match_all($sectionConfig['pattern'],$content,$res)){
            GatherView::info('.error',myDate().'小说章节匹配失败！请检查正则',true,$this->config['type']);
            $this->fatalErrorHandle();
        }
        $result['url']=$res[1];
        $result['title']=$res[2];

        return $result;
    }
    //采集小说内容
    public function novelContent($contentConfig=[],$section_num=0){
        $show_title = null;     //用于浏览显示的
        $url_info   = [];
        $other_info = [];
        $thread_num = $this->config['thread_num'];

        if(empty($contentConfig)){
            $contentConfig = $this->parseConfig('content');
        }



        //出队
        if($thread_num>1){
            //多线程
            for($i=1;$i<=$this->config['thread_num'];$i++){
                $url_info_temporary = $this->engine->dequeue();
                $url_info['url'][]   = $url_info_temporary['url'];
                $url_info['title'][] = $url_info_temporary['title'];
                $other_info[]=['title'=>$url_info_temporary['title']];
            }
        }else{
            $url_info = $this->engine->dequeue();
            $other_info=['title'=>$url_info['title']];
        }

        //当前章节title + 进度
        if($thread_num>1){
            $show_title = $other_info;
            foreach($show_title as $k=>$v){
                $show_title[$k] = myDate().': '.$v['title'].'采集失败,加入队列';
            }

            GatherView::info('.now_section','《'.$other_info[0]['title'].'》等其他'.($thread_num-1).'章',false,$this->config['type']);

        }else{
            $show_title = $other_info['title'];

            GatherView::info('.now_section',$show_title,false,$this->config['type']);
        }

        GatherView::info('.now',$section_num-count($this->engine->queue),false,$this->config['type']);


        $content  = $this->engine->run($url_info['url'],$other_info);


        if(false===$content){
            GatherView::info('.error',$show_title,true,$this->config['type']);
            GatherView::info('.now',$section_num-count($this->engine->queue),false,$this->config['type']);
            return false;
        }
//        $content = $this->contentHandle($contentConfig['start'],$contentConfig['end'],$content,$this->config['iconv']);

        if(is_array($content)){
            foreach($content as $url=>$v){
                preg_match($contentConfig['pattern'],$v,$result);
                $key = array_search($url,$url_info['url']);
                $url_info['content'][$key]=$result[1];
            }
        }else{
            preg_match($contentConfig['pattern'],$content,$result);
            $url_info['content']=$result[1];
        }

        if($thread_num>1){
            //去除失败章节
            foreach($url_info['title'] as $k=>$v){
                if(!isset($url_info['content'][$k])){
                    unset($url_info['title'][$k] );
                    unset($url_info['url'][$k] );
                }

            }
        }

        return $url_info;




    }


    //采集测试
    public function gatherCheckout($gather_type){
        switch($gather_type){
            case self::DETAIL_GATHER:
                $info = $this->novelDetail();
                break;
            case self::SECTION_GATHER:
                $info = $this->novelSection();
                break;
            case self::CONTENT_GATHER:
                //所有章节链接 标题
                $section  = $this->novelSection();
                //随机key
                $rand_key = mt_rand(0,count($section['url']));
                $url = $this->handleUrl($this->config['novel']['url']['section_url'],$section['url'][$rand_key]);
                $url_info = ['url'=>$url,'title'=>$section['title'][$rand_key]];

                $this->engine->enqueue($url_info);
                $info = $this->novelContent();
                break;
            default:
                $info = false;
        }
        return $info;
    }


    /*
     *  1.采集$url直到成功 或 达采集次数上限
     *  2.判断采集内容字数 排除垃圾章节
     */
    protected function forceGather($url){
        $start = time();
        $content = $this->engine->run($url);

        if( $content===false ){
            GatherView::info('.error',myDate().'--'.$url.'--http_code:'.$this->engine->last_curl_info['http_code'],true,$this->config['type']);
            //采集失败
            while($url_info = $this->engine->dequeue()){
                $num = $this->engine->getLinkGatherNum($url_info['url']);
                GatherView::info('.error',myDate()."尝试第{$num}次采集",true,$this->config['type']);
                $content = $this->engine->run($url_info['url']);
            }
            //达到采集次数上限
            if($content===false){
                GatherView::info('.error',myDate()."采集次数上限，停止采集,请检查规则",true,$this->config['type']);
                $this->fatalErrorHandle();
            }
        }

        if($this->config['thread_num']>1){
            $content = array_pop($content);
        }

        //判断采集内容字数 排除垃圾章节
        if(strlen($content)<self::MIN_WORD){
            GatherView::info('.error',myDate()."详情页面内容太少，停止采集，请检查",true,$this->config['type']);
            $this->fatalErrorHandle();
        }

        $this->last_force_gather_time = date('H:i:s',time()-$start);
        return $content;
    }


    public function parseConfig($type){
        $config=[];
        switch($type){
            case 'detail':
                /*  数据库字段名:正则
                detail_pattern
                    name:/<em>(.*)<\/em>/U;
                    author:/<span><a href=.*>(.*)<\/a>/U;
                    img:/<img src="(.*)">/U;
                    desc:/<p class="intro">(.*)/;

                detail_start | detail_end
                    <div class="detail">;
                    name:<h1>;
                    author:<h1>;
                    img:<div class="book-img">;
                    desc:<p class="intro">;
                */
                $config = [
                    'url'    =>$this->config['novel']['url']['detail_url'],
                    'start'  =>[],
                    'end'    =>[],
                    'pattern'=>[],
                ];
                //字符串按 \r\n或; 分割成数组，并将数组中值为false的过滤
                $pattern = array_filter(preg_split('/[;\r\n]+/s',$this->config['novel']['pattern']['detail_pattern']));
                $start = array_filter(preg_split('/[;\r\n]+/s',$this->config['novel']['start']['detail_start']));
                $end = array_filter(preg_split('/[;\r\n]+/s',$this->config['novel']['end']['detail_end']));

                //pattern
                foreach( $pattern as $val ){
                    $p = explode(':',$val);
                    $key = array_shift($p);
                    $config['pattern'][$key] = implode('',$p);
                }

                //start
                $config['start'][0]=array_shift($start);
                foreach( $start as $val ){
                    $s = explode(':',$val);
                    $key = array_shift($s);
                    $config['start'][$key] = implode('',$s);
                }

                //end
                $config['end'][0]=array_shift($end);
                foreach( $end as $val ){
                    $s = explode(':',$val);
                    $key = array_shift($s);
                    $config['end'][$key] = implode('',$s);
                }

                // TODO 判断配置是否正确(数量)

                break;
            case 'section':
                $config = [
                    'url'    =>$this->config['novel']['url']['section_url'],
                    'start'  =>$this->config['novel']['start']['section_start'],
                    'end'    =>$this->config['novel']['end']['section_end'],
                    'pattern'=>$this->config['novel']['pattern']['section_pattern'],
                ];
                if( isset($this->config['novel']['section_page']) ){
                    $config['section_page'] = $this->config['novel']['section_page'];
                }
                break;
            case 'content':
                $config = [
                    'start'  =>$this->config['novel']['start']['content_start'],
                    'end'    =>$this->config['novel']['end']['content_end'],
                    'pattern'=>$this->config['novel']['pattern']['content_pattern']
                ];
                break;
        }
        return $config;
    }


    //从标题中得到章节数  TODO  第一百零六章 封禅之地(上)
    private function getSection( $title ){
        //计算加成
        $addition = $this->getAddition($title);

//        preg_match('/第([^\s]*)章/U',$title,$arr);
        preg_match('/第([零一二三四五六七八九十百千万]*)章/U',$title,$arr);     //第一章
        $arr || preg_match('/第(\d*)章/U',$title,$arr);                       //第1章
        if( !$arr ){  return (float)($title+$addition); }

        if( preg_match('/[一二三四五六七八九十]/',$arr[1]) == 1 ) {
//            var_dump( $arr[1]);/
//            preg_match_all('/([一二三四五六七八九]*)千?([一二三四五六七八九]*)百?([一二三四五六七八九]*)十?([一二三四五六七八九]*)/',$arr[1] , $res );
            $patterns = array('/零/','/一/', '/二/', '/三/', '/四/', '/五/', '/六/', '/七/', '/八/', '/九/', '/十/', '/百/', '/千/');
            $replaces = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 'a', 'b', 'q');
            $str = preg_replace($patterns, $replaces, $arr[1]);

            preg_match_all('/(\d)?([abq])?/u', $str, $res);

            $num = 0;
            //第一百零六章 封禅之地  有十百千
            if( preg_match('/[abq]/',$str ) == 1 ){
                foreach ($res[1] as $k => $v) {
                    switch ($res[2][$k]) {
                        case 'a':
                            $figure = 10;
                            break;
                        case 'b':
                            $figure = 100;
                            break;
                        case 'q':
                            $figure = 1000;
                            break;
                        case '':
                            $figure = 1;
                            break;
                        default:
                            $figure = 1;
                    }
                    //第十章
                    if ($v == '' && $res[2][$k] != '') $v = 1;
                    $num += $v * $figure;
                }
                $result = $num;
                //第一五二零章 群英荟萃  无十百千
            }else{
                $result = implode( '',$res[1]);
            }

        }else{
            //第1024章
            $result = (float)$arr[1];
        }

        return ($result+$addition);

    }


    /*
       *  第十六章 骗（上）第十六章 xx（下）
       *  第十六章 骗（2）第十六章 xx（3）  (10)：
       *  第十六章 骗 上
       * */
    public function getAddition($title,$mb_start=-4,$mb_length=4){
        $score = [
            'patterns'=>['/上/','/中/','/下/'],
            'replaces'=>[0.01,0.02,0.03]
        ];

        //得到括号内的  上|2|二
        $addition = mb_substr($title,$mb_start,$mb_length,'utf-8' );
        if(!preg_match('/[\(（].*[\)）]/',$addition,$result)){
            return 0;
        }
        $addition = preg_replace('/[\(（\)）]/','',$result[0]);

        if(!preg_match('/\d+/',$addition,$res)){
            $patterns = array('/零/','/一/', '/二/', '/三/', '/四/', '/五/', '/六/', '/七/', '/八/', '/九/', '/十/');
            $replaces = array(0, 0.01, 0.02, 0.03, 0.04, 0.05, 0.06, 0.07, 0.08, 0.09, 0.10);
            $addition = preg_replace($patterns, $replaces, $addition);

            $addition = preg_replace($score['patterns'], $score['replaces'], $addition);
        }else{
            $addition = $res[0]*0.01;
        }

        return $addition?$addition:0;


    }




}

