<?php
include 'Curls.php';

$urls = [
    'http://www.iadele.cn/home/html/content/1525147.html',
    'http://www.iadele.cn/home/html/content/1525146.html'
];

//ob_start();
$curls = new Curls();

$return_content = $curls->run($urls);
//$return_content = ob_get_contents ();

var_dump($return_content);
