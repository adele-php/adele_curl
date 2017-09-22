<?php


namespace resource\adele;

/*
    根据不同数据库来加载响应驱动
*/
class Db{
    // 数据库连接参数配置
    public static $config = [
        // 数据库类型
        'type'            => 'mysql',
        // 服务器地址
        'host'        => '192.168.18.121',
        // 数据库名
        'database'        => 'test',
        // 用户名
        'username'        => 'root',
        // 密码
        'password'        => 'wowoyoo',
        // 端口
        'port'        => '3306',
        // 数据库连接参数
        'params'          => [],
        // 数据库编码默认采用utf8
        'charset'         => 'utf8',
        // 数据库表前缀
        'prefix'          => 'adelephp_',
        // 数据库调试模式
        'debug'           => false,
        // 数据返回类型
        'result_type'     => \PDO::FETCH_ASSOC,
        // 时间字段取出后的默认时间格式
        'datetime_format' => 'Y-m-d H:i:s',
        'instances'             =>['pdos'=>[],'dsns'=>[]],
    ];


    public static function connect( $config = [] ){
        $key = false;

        self::$config = array_merge(self::$config,$config);
        $dsn = self::parseDsn();
        if( false === $key = array_search($dsn,self::$config['instances']['dsns']) ){
            //dsn不同  需要创建新连接
            try{
                $pdo = new \PDO($dsn,self::$config['username'],self::$config['password']);
                $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, self::$config['result_type']);
                $pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false); //禁用prepared statements的仿真效果
                self::setException($pdo);
            }catch( \PDOException $e ){
                var_dump( '<pre>', $e->getMessage() );exit;
            }
            self::$config['instances']['dsns'][] = $dsn;
            self::$config['instances']['pdos'][] = $pdo;
            return $pdo;
        }
        return self::$config['instances']['pdos'][$key];


    }

    private static function parseDsn(){
        $dsn = 'mysql:host='.self::$config['host'].';dbname='.self::$config['database'];

        $dsn .= empty(self::$config['port'])?'':';port='.self::$config['port'];
        $dsn .= empty(self::$config['charset'])?'':';charset='.self::$config['charset'];

        return $dsn;
    }

    private static function setException( &$pdo){
        $pdo->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
    }

}
