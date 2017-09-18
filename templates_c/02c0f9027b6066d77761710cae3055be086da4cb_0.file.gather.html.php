<?php
/* Smarty version 3.1.30, created on 2017-08-26 05:27:30
  from "F:\WWW\AdelePHP\application\admin\view\gather\gather.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59a106c29b5e17_59387919',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '02c0f9027b6066d77761710cae3055be086da4cb' => 
    array (
      0 => 'F:\\WWW\\AdelePHP\\application\\admin\\view\\gather\\gather.html',
      1 => 1503724786,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59a106c29b5e17_59387919 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="Author" content="丁馀峰">
    <meta name="Keywords" content="adelephp">
    <meta name="Description" content="">

    <title>采集页面</title>

    <link href="<?php echo $_smarty_tpl->tpl_vars['__PUBLIC__']->value;?>
/bootstrap/bootstrap.min.css" type="text/css" rel="stylesheet">
    <link href="<?php echo $_smarty_tpl->tpl_vars['__PUBLIC__']->value;?>
/admin/gather/gather.css" type="text/css" rel="stylesheet">
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['__PUBLIC__']->value;?>
/js/jq3.2.1.js"><?php echo '</script'; ?>
>



</head>
<body>
<div class="body">
    <div class="navbar navbar-inverse " >
        <span class="mgl50">欢迎来到adelephp采集页面</span>
        <span class="mgl50">开始时间:</span><span class="start_time">2017/8/24 3:42</span>
        <span class="mgl50">结束时间:</span><span class="end_time">2017/8/24 3:42</span>
    </div>

    <div class="content">

        <div class="alert " >书名：<span class="book_name">正在获取</span></div>
        <div class="alert " >书籍信息采集：<span class="book_status">wait</span></div>
        <div class="alert " >进度：<span class="now">0</span>/<span class="all">？</span></div>
        <div class="alert " >状态：<span class="mgl50 status">采集ing</span></div>
        <div class="alert " >正在采集：<span class="mgl50 now_section">正在获取</span></div>


        <div class="alert error info" >
            <div>错误信息：</div>
          </div>
        <div class="alert other info" >
            <div>其他信息：</div>
        </div>

    </div>
</div>

<!--<footer>-->
    <!--<div class="copyright">©2017 iadele.cn iadele版权所有</div>-->
<!--</footer>-->
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['__PUBLIC__']->value;?>
/bootstrap/bootstrap.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['__PUBLIC__']->value;?>
/js/gather.js"><?php echo '</script'; ?>
>



</body>
</html>
<?php }
}
