<?php
/* Smarty version 3.1.30, created on 2017-08-12 11:35:04
  from "F:\WWW\AdelePHP\application\admin\view\admin\index.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_598ee7e80615b6_13934786',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2f25537485cd657f1f3cbc200d32a691d2b43968' => 
    array (
      0 => 'F:\\WWW\\AdelePHP\\application\\admin\\view\\admin\\index.html',
      1 => 1502505152,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_598ee7e80615b6_13934786 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_8843598ee7e80598b1_96232994', "title");
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_4446598ee7e805d732_64264816', "css");
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_27951598ee7e805d734_95933390', "sidebar");
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_5643598ee7e80615b7_08516468', 'search');
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1792598ee7e80615b2_79571139', "content");
?>

<?php $_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['VIEW']->value)."/common/base.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block "title"} */
class Block_8843598ee7e80598b1_96232994 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
哈哈<?php
}
}
/* {/block "title"} */
/* {block "css"} */
class Block_4446598ee7e805d732_64264816 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<link href="<?php echo $_smarty_tpl->tpl_vars['__PUBLIC__']->value;?>
/admin/admin/index.css" type="text/css" rel="stylesheet">
<?php
}
}
/* {/block "css"} */
/* {block "sidebar"} */
class Block_27951598ee7e805d734_95933390 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block "sidebar"} */
/* {block 'search'} */
class Block_5643598ee7e80615b7_08516468 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


<?php
}
}
/* {/block 'search'} */
/* {block "content"} */
class Block_1792598ee7e80615b2_79571139 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<div class="show-info">
    <button class="btn btn-primary" type="button">
        <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
        <span>用户数</span>
        <span class="badge">4</span>
    </button>

    <button class="btn btn-primary" type="button">
        <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
        <span>用户数</span>
        <span class="badge">4</span>
    </button>

    <button class="btn btn-primary" type="button">
        <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
        <span>用户数</span>
        <span class="badge">4</span>
    </button>

</div>
<table class="table table-hover">
    <tr>
        <th colspan="2" class="info">系统信息</th>
    </tr>
    <tr>
        <td>AdelePHP版本</td>
        <td>1.0</td>
    </tr>
    <tr>
        <td>服务器操作系统</td>
        <td>1.0</td>
    </tr>
    <tr>
        <td>运行环境</td>
        <td>1.0</td>
    </tr>
    <!--<tr>-->
        <!--<td class="active">...</td>-->
        <!--<td class="success">...</td>-->
        <!--<td class="warning">...</td>-->
        <!--<td class="danger">...</td>-->
        <!--<td class="info">...</td>-->
    <!--</tr>-->
</table>
<table class="table table-hover">
    <tr>
        <th colspan="2" class="info">产品团队</th>
    </tr>
    <tr>
        <td>总策划</td>
        <td>丁馀峰</td>
    </tr>
    <tr>
        <td>产品设计及研发团队</td>
        <td>丁馀峰</td>
    </tr>
    <tr>
        <td>官方QQ群</td>
        <td>1.0</td>
    </tr>

</table>

<?php
}
}
/* {/block "content"} */
}
