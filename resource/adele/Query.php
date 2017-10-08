<?php


namespace resource\adele;

/*
    curd操作
*/
class Query{
    private $pdo;
    private $pso;
    private $where='';
    private $order='';

    public function __construct( $config = []){
        $this->pdo = Db::connect($config);
    }

    /*
     * 查询
     */
    public function select($data=true){
        $field = isset($this->field)?$this->field:'*';
        $table = isset($this->table)?$this->table:'false';          //表不存在
        if(!empty($this->where) ){
            $this->where = ' WHERE '.$this->where;
        }

        if(!empty($this->order) ){
            $this->order = ' order by '.$this->order;
        }

        $sql='SELECT '.$field.' FROM '.$table.$this->where.$this->order;
        if( $data===false ){
            return $sql;
        }
        $this->exec( $sql );
        $result = $this->pso->fetchAll();
        return $result;
    }

    //返回单一数据
    public function find($data=true){
        $field = isset($this->field)?$this->field:'*';
        $table = isset($this->table)?$this->table:'false';          //表不存在
        if(!empty($this->where) ){
            $this->where = ' WHERE '.$this->where;
        }

        $sql='SELECT '.$field.' FROM '.$table.$this->where.' limit 1';

        if( $data===false ){
            return $sql;
        }
        $this->exec( $sql );
        $result = $this->pso->fetchAll();

        return isset($result[0])?$result[0]:false;
    }

    /*
     * 修改 $condition=[ 'id'=>1  ]
     */
    public function update($condition=[]){
        $table = isset($this->table)?$this->table:'false';
        $where = !empty($this->where)?' WHERE '.$this->where:'';

        $con = '';
        $condition = $this->filterField($condition);
        foreach($condition as $k =>$v){
            $con .= '`'.$k.'`=\''.$v.'\',';
        }
        $con = substr( $con ,0,-1 );
        $sql = 'UPDATE '.$table.' SET '.$con.$where;
//        echo $sql;die;
        $this->exec( $sql );
        $result = $this->pso->rowCount();
        return $result;
    }

    /*
     * 删除
     */
    public function delete(){
        $table = isset($this->table)?$this->table:'false';
        $where = !empty($this->where)?' WHERE '.$this->where:'';
        $sql = 'DELETE FROM '.$table.$where;
        $this->exec( $sql );
        $result = $this->pso->rowCount();
        return $result;
    }

    /*
     * 新增
     */
    public function insert($data=[]){
        $table = isset($this->table)?$this->table:'false';
        $field=$value='';
        $data = $this->filterField($data);
        foreach( $data as $k=>$v ){
            $field .='`'.$k.'`,';
            $value .='\''.$v.'\',';
        }
        $field = substr( $field ,0,-1 );
        $value = substr( $value ,0,-1 );
        $sql = 'INSERT INTO '.$table.' ('.$field.') values('.$value.');';
//        echo $sql;die;
        $this->exec( $sql );
        $result = $this->pso->rowCount();
        return $result;
    }

    /*
     * 批量新增 insert into {table} (`a`,`b`,`c`) values (a1,b1,c1),(a2,b2,c2),(a3,b3,c3)
     * [
     *      0=>['name'=>'aa',...]
     * ]
     */
    public function insertBatch($datas=[]){

        $table = isset($this->table)?$this->table:'false';
        $field=$sql=null;
        $f='';
        $value=[];

        foreach($datas as $key=>$data){
            $val = [];
            $data = $this->filterField($data);
            foreach( $data as $k=>$v ){
                if(empty($field)){
                    // 如果是第一个数组，把k当做字段
                    $f .='`'.$k.'`,';
                }
                $val[]='\''.$v.'\'';
            }
            $field=$f;
            $value[]=implode(',',$val);     // 0=>[a,b,c,d]

        }

        $field = substr( $field ,0,-1 );

        $sql = 'INSERT INTO '.$table.' ('.$field.') VALUES('.implode('),(',$value).');';


//        echo $sql;die;
        $this->exec( $sql );
        $result = $this->pso->rowCount();
        return $result;

    }

    /*
     * where(mixed $field, string $op = null, mixed $condition = null)  查询条件
     * $focs =[0=>[$field,$op,$condition]]
     */
    public function where( $focs ,$link='and'){

        if( is_string($focs) ){ //id=1
            //字符串
            $this->where = $focs;
        }elseif( count($focs) === count($focs,1)){
            //一维数组
            if( empty($this->where) ){
                $link='';
            }
            $this->where .= ' '.$link.' '.$focs[0].$focs[1].$focs[2];
        }else{
            //多维数组
            foreach( $focs as $foc ){
                $this->where .= ' '.$foc[0].$foc[1].$foc[2].' '.$link;
            }
            $this->where = substr( $this->where ,0,-strlen($link));
        }

        return $this;

    }

    public function table($name){
        $this->table = Db::$config['prefix'].$name;
        return $this;
    }

    //name desc
    public function order($str){
        $this->order = $str;
        return $this;
    }

    //'id,name,pid'
    public function field( $field ){
        $fields = explode(',',$field);
        $field = '';
        foreach($fields as $v ){
            $field .= '`'.$v.'`,';
        }
        $this->field = substr($field,0,-1);
        return $this;
    }

    private function exec( $sql ,$param=[]  ){
        try{
            $this->pso = $this->pdo->prepare( $sql );
            $this->pso->execute( $param );
            /*
            $result = $this->pdo->exec( $sql );
            return $result ;*/
        }catch( \PDOException $e ){
            //将错误信息写到log日志文件
            var_dump($e->getMessage(),$sql );
            die;
        }
    }

    private function descTable($type=null){
        $info=[];

        $table = isset($this->table)?$this->table:'false';
        $this->exec('DESC '.$table);
        $table_info = $this->pso->fetchAll();

        if( !empty($type)){
            foreach($table_info as $v){
                $info[] = $v[$type];
            }
        }else{
            $info = $table_info;
        }
        return $info;
    }

    private function filterField($condition,$primary_key='id'){
        $fields = $this->descTable('Field');
        foreach( $condition as $field => $v ){
            if(!in_array($field,$fields) || $field==$primary_key){
                unset($condition[$field]);continue;
            }
            $condition[$field] = $this->handleSpecialStr($v);
        }
        return $condition;
    }

    private  function handleSpecialStr($str){
        return str_replace('\\','\\\\',$str);
    }

}
