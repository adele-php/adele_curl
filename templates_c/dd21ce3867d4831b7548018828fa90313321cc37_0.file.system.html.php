<?php
/* Smarty version 3.1.30, created on 2017-08-11 12:12:32
  from "F:\WWW\AdelePHP\application\admin\view\admin\system.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_598d9f30afd5b3_63240579',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'dd21ce3867d4831b7548018828fa90313321cc37' => 
    array (
      0 => 'F:\\WWW\\AdelePHP\\application\\admin\\view\\admin\\system.html',
      1 => 1502415338,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_598d9f30afd5b3_63240579 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_18342598d9f30af58b1_09092656', "title");
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1801598d9f30af9737_28491499', "css");
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_29147598d9f30af9733_97156703', 'search');
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_6441598d9f30afd5b6_15802703', "content");
?>

<?php $_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['VIEW']->value)."/common/base.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block "title"} */
class Block_18342598d9f30af58b1_09092656 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
系统<?php
}
}
/* {/block "title"} */
/* {block "css"} */
class Block_1801598d9f30af9737_28491499 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<link href="<?php echo $_smarty_tpl->tpl_vars['__PUBLIC__']->value;?>
/admin/admin/system.css" type="text/css" rel="stylesheet">
<?php
}
}
/* {/block "css"} */
/* {block 'search'} */
class Block_29147598d9f30af9733_97156703 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


<?php
}
}
/* {/block 'search'} */
/* {block "content"} */
class Block_6441598d9f30afd5b6_15802703 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


<?php
}
}
/* {/block "content"} */
}
