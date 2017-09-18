<?php
/* Smarty version 3.1.30, created on 2017-08-23 14:05:40
  from "F:\WWW\AdelePHP\application\admin\view\common\base.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_599d8bb48b54f3_30039082',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'aafd0446daea30394141efc8845555c0bbf8cb1c' => 
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
function content_599d8bb48b54f3_30039082 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_19090599d8bb486efe9_86657503', "meta");
?>


    <title><?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1772599d8bb486efe9_53108293', "title");
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
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_18071599d8bb4899f61_35600865', "css");
?>



</head>
<body>
<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_4585599d8bb48a9976_41676929', "header");
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_7325599d8bb48ad7f8_45222290', "sidebar");
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_2726599d8bb48b1678_52564635', "body");
?>

<div class="content">
    <div class="con_main">
        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_7758599d8bb48b1671_36011188', "content");
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
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_29052599d8bb48b1676_16659518', "javascript");
?>



</body>
</html>
<?php }
/* {block "meta"} */
class Block_19090599d8bb486efe9_86657503 extends Smarty_Internal_Block
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
class Block_1772599d8bb486efe9_53108293 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
测试<?php
}
}
/* {/block "title"} */
/* {block "css"} */
class Block_18071599d8bb4899f61_35600865 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block "css"} */
/* {block 'search'} */
class Block_21149599d8bb48a9973_16107536 extends Smarty_Internal_Block
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
class Block_4585599d8bb48a9976_41676929 extends Smarty_Internal_Block
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
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_21149599d8bb48a9973_16107536', 'search', $this->tplIndex);
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
class Block_7325599d8bb48ad7f8_45222290 extends Smarty_Internal_Block
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
class Block_2726599d8bb48b1678_52564635 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block "body"} */
/* {block "content"} */
class Block_7758599d8bb48b1671_36011188 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block "content"} */
/* {block "javascript"} */
class Block_29052599d8bb48b1676_16659518 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block "javascript"} */
}
