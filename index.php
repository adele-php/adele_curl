<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c)2017 iadele.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 553475725@qq.com
// +----------------------------------------------------------------------
// 定义__ROOT__
date_default_timezone_set('Asia/Shanghai');

if (!defined('__ROOT__')) {
    $_root = rtrim(dirname(rtrim($_SERVER['SCRIPT_NAME'], '/')), '/');
    define('__ROOT__', (('/' == $_root || '\\' == $_root) ? '' : $_root));
}

// 加载框架引导文件
require __DIR__ . '/resource/start.php';



