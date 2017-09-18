<?php
/* Smarty version 3.1.30, created on 2017-08-28 04:30:12
  from "F:\WWW\AdelePHP\application\admin\view\common\base.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59a39c546d89f1_08922638',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3d4b038b9fa6a39bdb09c75fd56fc587e8ac42ce' => 
    array (
      0 => 'F:\\WWW\\AdelePHP\\application\\admin\\view\\common\\base.html',
      1 => 1503497138,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59a39c546d89f1_08922638 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_2218259a39c54609943_38192454', "meta");
?>


    <title><?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_778459a39c5460d7c3_14006258', "title");
?>
</title>

    <link href="<?php echo $_smarty_tpl->tpl_vars['__PUBLIC__']->value;?>
/bootstrap/bootstrap.min.css" type="text/css" rel="stylesheet">
    <link href="<?php echo $_smarty_tpl->tpl_vars['__PUBLIC__']->value;?>
/css/base.css" type="text/css" rel="stylesheet">
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['__PUBLIC__']->value;?>
/js/jq3.2.1.js"><?php echo '</script'; ?>
>
    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_348559a39c5466b3e5_24654033', "css");
?>



</head>
<body>
<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_2163259a39c546d0cf4_49968809', "header");
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_3032459a39c546d4b74_57097595', "sidebar");
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_279859a39c546d4b78_16893339', "body");
?>

<div class="content">
    <div class="con_main">
        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_722159a39c546d89f8_24108207', "content");
?>

    </div>
</div>
<footer>
    <div class="copyright">©2017 iadele.cn iadele版权所有</div>
</footer>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['__PUBLIC__']->value;?>
/bootstrap/bootstrap.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['__PUBLIC__']->value;?>
/js/base.js"><?php echo '</script'; ?>
>
<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_81559a39c546d89f6_25611166', "javascript");
?>



</body>
</html>
<?php }
/* {block "meta"} */
class Block_2218259a39c54609943_38192454 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <meta name="Author" content="丁馀峰">
    <meta name="Keywords" content="adelephp">
    <meta name="Description" content="">
    <?php
}
}
/* {/block "meta"} */
/* {block "title"} */
class Block_778459a39c5460d7c3_14006258 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
测试<?php
}
}
/* {/block "title"} */
/* {block "css"} */
class Block_348559a39c5466b3e5_24654033 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block "css"} */
/* {block 'search'} */
class Block_492859a39c546d0cf8_10554233 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

            <form class="navbar-form navbar-left" method="get" action="">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search">
                </div>
                <button type="submit" class="btn btn-default">搜索</button>
            </form>
            <?php
}
}
/* {/block 'search'} */
/* {block "header"} */
class Block_2163259a39c546d0cf4_49968809 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<header class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">AdelePHP</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['navs']->value, 'nav');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['nav']->value) {
?>
                <li <?php if ($_smarty_tpl->tpl_vars['nav']->value['active'] == 1) {?>class="active"<?php }?> ><a href="<?php echo $_smarty_tpl->tpl_vars['nav']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['nav']->value['name'];?>
</a></li>
                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                <!--<li class="active"><a href="#">首页</a></li>-->
                <!--<li><a href="#">系统</a></li>-->
            </ul>
            <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_492859a39c546d0cf8_10554233', 'search', $this->tplIndex);
?>


            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">adele</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false"> <span class="glyphicon glyphicon-user"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">修改密码</a></li>
                        <li><a href="#">修改昵称</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#">登出</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</header>
<div class="handle-bug"></div>
<?php
}
}
/* {/block "header"} */
/* {block "sidebar"} */
class Block_3032459a39c546d4b74_57097595 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<div class="sidebar">
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['left_navs']->value, 'left_nav', false, 'group');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['group']->value => $_smarty_tpl->tpl_vars['left_nav']->value) {
?>
    <h3 class="subnav">
        <p class="gly"><span class="glyphicon glyphicon-minus"></span><span><?php echo $_smarty_tpl->tpl_vars['group']->value;?>
</span></p>
        <ul>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['left_nav']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
            <li <?php if ($_smarty_tpl->tpl_vars['v']->value['active'] == 1) {?>class="active"<?php }?> ><a href="<?php echo $_smarty_tpl->tpl_vars['v']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</a></li>
            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>


        </ul>
    </h3>
    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>


    <!--<h3 class="subnav">-->
        <!--<p class="gly"><span class="glyphicon glyphicon-minus"></span><span>列表2</span></p>-->
        <!--<ul>-->
            <!--<li><a href="#">lalala</a></li>-->
            <!--<li><a href="#">lalala</a></li>-->
        <!--</ul>-->
    <!--</h3>-->
</div>
<?php
}
}
/* {/block "sidebar"} */
/* {block "body"} */
class Block_279859a39c546d4b78_16893339 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block "body"} */
/* {block "content"} */
class Block_722159a39c546d89f8_24108207 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block "content"} */
/* {block "javascript"} */
class Block_81559a39c546d89f6_25611166 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block "javascript"} */
}
