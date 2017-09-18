<?php
/* Smarty version 3.1.30, created on 2017-08-28 04:30:14
  from "F:\WWW\AdelePHP\application\admin\view\common\base.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59a39c56dddb87_81849963',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '18daf50e441e93f00cdd7acc194f14e29708b73c' => 
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
function content_59a39c56dddb87_81849963 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_2606259a39c56dddb81_45539330', "meta");
?>


    <title><?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1059159a39c56dddb86_08450710', "title");
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
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_884859a39c56dddb86_04219911', "css");
?>



</head>
<body>
<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_2524759a39c56dddb80_81682520', "header");
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_132459a39c56dddb84_70782236', "sidebar");
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1962459a39c56dddb86_97429772', "body");
?>

<div class="content">
    <div class="con_main">
        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1688759a39c56dddb88_98961362', "content");
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
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1310859a39c56dddb85_93633809', "javascript");
?>



</body>
</html>
<?php }
/* {block "meta"} */
class Block_2606259a39c56dddb81_45539330 extends Smarty_Internal_Block
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
class Block_1059159a39c56dddb86_08450710 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
测试<?php
}
}
/* {/block "title"} */
/* {block "css"} */
class Block_884859a39c56dddb86_04219911 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block "css"} */
/* {block 'search'} */
class Block_550259a39c56dddb81_73492791 extends Smarty_Internal_Block
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
class Block_2524759a39c56dddb80_81682520 extends Smarty_Internal_Block
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
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_550259a39c56dddb81_73492791', 'search', $this->tplIndex);
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
class Block_132459a39c56dddb84_70782236 extends Smarty_Internal_Block
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
class Block_1962459a39c56dddb86_97429772 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block "body"} */
/* {block "content"} */
class Block_1688759a39c56dddb88_98961362 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block "content"} */
/* {block "javascript"} */
class Block_1310859a39c56dddb85_93633809 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block "javascript"} */
}
