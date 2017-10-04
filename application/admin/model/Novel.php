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
        //采集测试
        if(!empty($this->config['test'])){
            return $this->gatherCheckout($this->config['test']);
        }

        //采集小说详情
        $detail_info = $this->novelDetail();
        GatherView::info('.book_name',$detail_info['name'],false,$this->config['type']);

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
        $content_info = $this->novelContent();

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

    //采集小说详情
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
    public function novelContent(){
        $contentConfig = $this->parseConfig('content');

        $section_num = count($this->engine->queue);

        //出队
        $url_info = $this->engine->dequeue();
        //当前章节title + 进度
        GatherView::info('.now_section',$url_info['title'],false,$this->config['type']);
        GatherView::info('.now',$section_num-count($this->engine->queue),false,$this->config['type']);

        $content  = $this->engine->run($url_info['url']);
        if(false===$content){
            GatherView::info('.error',myDate().': '.$url_info['url'].'采集失败,加入队列',true,$this->config['type']);
            GatherView::info('.now',$section_num-count($this->engine->queue),false,$this->config['type']);
        }
        $content = $this->contentHandle($contentConfig['start'],$contentConfig['end'],$content,$this->config['iconv']);

        preg_match($contentConfig['pattern'],$content,$result);
        $url_info['content']=$result[1];

        return $url_info;

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
                $num = $this->engine->getLinkNum($url_info['url']);
                GatherView::info('.error',myDate()."尝试第{$num}次采集",true,$this->config['type']);
                $content = $this->engine->run($url_info['url']);
            }
            //达到采集次数上限
            if($content===false){
                GatherView::info('.error',myDate()."采集次数上限，停止采集,请检查规则",true,$this->config['type']);
                $this->fatalErrorHandle();
            }
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









}

