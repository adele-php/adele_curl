<?php

define('ADELE_VERSION','1.0');
define('ADELE_START_TIME',microtime(true));
define('ADELE_START_MEM',memory_get_usage());
define('EXT','.php');
define('DS',DIRECTORY_SEPARATOR);
defined('ROOT_PATH') or define('ROOT_PATH',dirname($_SERVER['SCRIPT_FILENAME']) .DS);
defined('APP_PATH') or define('APP_PATH',dirname($_SERVER['SCRIPT_FILENAME']) .DS.'application'.DS);
defined('RUNTIME_PATH') or define('RUNTIME_PATH',dirname($_SERVER['SCRIPT_FILENAME']) .DS.'runtime'.DS);
defined('RESOURCE_PATH') or define('RESOURCE_PATH',dirname($_SERVER['SCRIPT_FILENAME']) .DS.'resource'.DS);
defined('PUBLIC_PATH') or define('PUBLIC_PATH',dirname($_SERVER['SCRIPT_FILENAME']) .DS.'public'.DS);
defined('EXTEND_PATH') or define('EXTEND_PATH',dirname($_SERVER['SCRIPT_FILENAME']) .DS.'extend'.DS);

// 环境常量
define('IS_CLI', PHP_SAPI == 'cli' ? true : false);
define('IS_WIN', strpos(PHP_OS, 'WIN') !== false);

// 载入Loader类
require RESOURCE_PATH . 'Loader.php';


// 注册自动加载
\resource\Loader::register();

//// 注册错误和异常处理机制
//\think\Error::register();
//
//// 加载惯例配置文件
//\think\Config::set(include THINK_PATH . 'convention' . EXT);
