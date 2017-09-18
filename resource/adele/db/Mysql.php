<?php


namespace resource\adele\db;


    /**
     * Class Db
     * @package think
     * @method Query table(string $table) static 指定数据表（含前缀）
     * @method Query name(string $name) static 指定数据表（不含前缀）
     * @method Query where(mixed $field, string $op = null, mixed $condition = null) static 查询条件
     * @method Query join(mixed $join, mixed $condition = null, string $type = 'INNER') static JOIN查询
     * @method Query union(mixed $union, boolean $all = false) static UNION查询
     * @method Query limit(mixed $offset, integer $length = null) static 查询LIMIT
     * @method Query order(mixed $field, string $order = null) static 查询ORDER
     * @method Query cache(mixed $key = null , integer $expire = null) static 设置查询缓存
     * @method mixed value(string $field) static 获取某个字段的值
     * @method array column(string $field, string $key = '') static 获取某个列的值
     * @method Query view(mixed $join, mixed $field = null, mixed $on = null, string $type = 'INNER') static 视图查询
     * @method mixed find(mixed $data = null) static 查询单个记录
     * @method mixed select(mixed $data = null) static 查询多个记录
     * @method integer insert(array $data, boolean $replace = false, boolean $getLastInsID = false, string $sequence = null) static 插入一条记录
     * @method integer insertGetId(array $data, boolean $replace = false, string $sequence = null) static 插入一条记录并返回自增ID
     * @method integer insertAll(array $dataSet) static 插入多条记录
     * @method integer update(array $data) static 更新记录
     * @method integer delete(mixed $data = null) static 删除记录
     * @method boolean chunk(integer $count, callable $callback, string $column = null) static 分块获取数据
     * @method mixed query(string $sql, array $bind = [], boolean $fetch = false, boolean $master = false, mixed $class = null) static SQL查询
     * @method integer execute(string $sql, array $bind = [], boolean $fetch = false, boolean $getLastInsID = false, string $sequence = null) static SQL执行
     * @method Paginator paginate(integer $listRows = 15, mixed $simple = null, array $config = []) static 分页查询
     * @method mixed transaction(callable $callback) static 执行数据库事务
     * @method void startTrans() static 启动事务
     * @method void commit() static 用于非自动提交状态下面的查询提交
     * @method void rollback() static 事务回滚
     * @method boolean batchQuery(array $sqlArray) static 批处理执行SQL语句
     */
/**
 * mysql数据库驱动
 */
class Mysql{
    private $instance;

    /**
     * 解析pdo连接的dsn信息
     * @access protected
     * @param array $config 连接信息
     * @return string
     */
    protected function parseDsn($config)
    {
        $dsn = 'mysql:dbname=' . $config['database'] . ';host=' . $config['hostname'];
        if (!empty($config['hostport'])) {
            $dsn .= ';port=' . $config['hostport'];
        } elseif (!empty($config['socket'])) {
            $dsn .= ';unix_socket=' . $config['socket'];
        }
        if (!empty($config['charset'])) {
            $dsn .= ';charset=' . $config['charset'];
        }
        return $dsn;
    }

    public function connection( $config ){
        $dsn = $this->parseDsn($config);
        new \PDO($dsn, $config['username'], $config['password'], $options);
    }



}
