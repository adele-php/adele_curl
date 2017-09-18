<?php
/* Smarty version 3.1.30, created on 2017-09-01 08:28:37
  from "F:\WWW\AdelePHP\application\admin\view\menu\submenu.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59a91a354a6794_30455281',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '34ee1840519472a7295d1a584e60dd9494852943' => 
    array (
      0 => 'F:\\WWW\\AdelePHP\\application\\admin\\view\\menu\\submenu.html',
      1 => 1504254516,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59a91a354a6794_30455281 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1762359a91a3548b218_48218773', "title");
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1195859a91a35492f18_27125933', "css");
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_2750659a91a354a2914_12932273', "content");
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_2851659a91a354a2915_81667404', "javascript");
?>




<?php $_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['VIEW']->value)."/common/base.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block "title"} */
class Block_1762359a91a3548b218_48218773 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
系统<?php
}
}
/* {/block "title"} */
/* {block "css"} */
class Block_1195859a91a35492f18_27125933 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<link href="<?php echo $_smarty_tpl->tpl_vars['__PUBLIC__']->value;?>
/admin/menu/index.css" type="text/css" rel="stylesheet">
<?php
}
}
/* {/block "css"} */
/* {block "content"} */
class Block_2750659a91a354a2914_12932273 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <div class="main">
        <div class="btns">
            <button type="button" class="btn btn-primary add">新增</button>
            <button type="button" class="btn btn-primary ret" >返回父菜单</button>
        </div>
        <div class="main-table">
            <table class="table table-hover">
                <tr>
                    <th class="info">ID</th>
                    <th class="info">名称</th>
                    <th class="info">上级菜单</th>
                    <th class="info">分组</th>
                    <th class="info">URL</th>
                    <th class="info">排序</th>
                    <th class="info">隐藏</th>
                    <th class="info">操作</th>
                </tr>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['all_nav']->value, 'nav', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['nav']->value) {
?>
                <tr>
                    <td><?php echo $_smarty_tpl->tpl_vars['nav']->value['id'];?>
</td>
                    <td>
                        <a title="编辑" href="<?php echo $_smarty_tpl->tpl_vars['__CONTROLLER__']->value;?>
/subMenu"><?php echo $_smarty_tpl->tpl_vars['nav']->value['name'];?>
</a>
                    </td>
                    <td><?php echo $_smarty_tpl->tpl_vars['nav']->value['pid'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['nav']->value['group'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['nav']->value['url'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['nav']->value['order'];?>
</td>
                    <td><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['is_hide'][0][0]->is_hide(array('hide'=>$_smarty_tpl->tpl_vars['nav']->value['is_hide'],'id'=>$_smarty_tpl->tpl_vars['nav']->value['id']),$_smarty_tpl);?>
</td>
                    <td>
                        <a title="编辑" href="<?php echo $_smarty_tpl->tpl_vars['__CONTROLLER__']->value;?>
/edit/id/<?php echo $_smarty_tpl->tpl_vars['nav']->value['id'];?>
">编辑</a>
                        <a title="删除" href="<?php echo $_smarty_tpl->tpl_vars['__CONTROLLER__']->value;?>
/del/id/<?php echo $_smarty_tpl->tpl_vars['nav']->value['id'];?>
">删除</a>
                    </td>
                </tr>
                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

            </table>
        </div>

    </div>
<input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['__CONTROLLER__']->value;?>
" class="con_hid">
<?php
}
}
/* {/block "content"} */
/* {block "javascript"} */
class Block_2851659a91a354a2915_81667404 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['__PUBLIC__']->value;?>
/js/admin/menu/submenu.js"><?php echo '</script'; ?>
>
<?php
}
}
/* {/block "javascript"} */
}
