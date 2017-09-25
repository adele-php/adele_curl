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
                'detail_page'=>['start'=>'','end'=>'','pattern'=>''],          //章节分页
            ],
            'type'=>'normal',   //   normal正常采集  |  test采集测试
            'test'=>self::DETAIL_GATHER,   // DETAIL_GATHER|SECTION_GATHER|CONTENT_GATHER
            'iconv'=>'utf-8',
        ];

        $this->config = array_merge($default_config,$config);
    }

    public function run(){
        //设置采集开始时间
        GatherView::info('.start_time',date('Y-m-d H:i:s',time()));

        //采集小说详情
        $this->novelDetail();

        //采集小说章节链接

        //采集小说内容


    }

    //采集小说详情
    public function novelDetail(){
        $detailConfig = $this->parseConfig('detail');
        $result = [];

        //得到详情页内容 TODO
        $content = $this->engine->run($detailConfig['url']);
        //网页内容进行 转码+截断
        $content = $this->contentHandle($detailConfig['start'][0],$detailConfig['end'][0],$content,$this->config['iconv']);
        //匹配信息
        foreach($detailConfig['pattern'] as $k=>$pattern){
            $str = $this->substr($content,$detailConfig['start'][$k],$detailConfig['end'][$k]);
            preg_match($pattern,$str,$res);
            // TODO 匹配失败

            $result[$k]=$res[1];
        }
        return $result;
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
                    $config['start'][$key] = implode('',$s);
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
                if( isset($this->config['novel']['detail_page']) ){
                    $config['detail_page'] = $this->config['novel']['detail_page']
                }
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



    //***********************没用到********************************






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
}

