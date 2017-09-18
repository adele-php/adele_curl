<?php

return  [

    'default_timezone'       => 'PRC',                         //时区

    //伪静态
    'rewrite'=>[
        'status'                 =>1,                          //是否开启
        'url_html_suffix'        => 'html',                    //伪静态后缀
    ],


    // 默认模块名
    'default_module'         => 'admin',
    // 默认控制器名
    'default_controller'     => 'admin',
    // 默认操作名
    'default_action'         => 'index',
];  

