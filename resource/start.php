<?php
namespace resource;

// AdelePHP 引导文件
// 加载基础文件
require __DIR__ . '/base.php';
require __DIR__ . '/smarty/Smarty.class.php';

// 执行应用
\resource\adele\App::run();