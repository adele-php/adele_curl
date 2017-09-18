<?php
/* Smarty version 3.1.30, created on 2017-09-01 08:22:04
  from "F:\WWW\AdelePHP\application\admin\view\menu\edit.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59a918accda4a1_74298077',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '67cd065b90c2187d3ff6864882a1039b93460c14' => 
    array (
      0 => 'F:\\WWW\\AdelePHP\\application\\admin\\view\\menu\\edit.html',
      1 => 1504254124,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59a918accda4a1_74298077 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_645959a918accbb099_25435386', "title");
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_706659a918accbef19_95189905', "css");
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_852059a918accd6627_46388747', "content");
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_2669659a918accda4a7_51300200', "javascript");
?>




<?php $_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['VIEW']->value)."/common/base.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block "title"} */
class Block_645959a918accbb099_25435386 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
edit菜单<?php
}
}
/* {/block "title"} */
/* {block "css"} */
class Block_706659a918accbef19_95189905 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<link href="<?php echo $_smarty_tpl->tpl_vars['__PUBLIC__']->value;?>
/admin/menu/add.css" type="text/css" rel="stylesheet">
<?php
}
}
/* {/block "css"} */
/* {block "content"} */
class Block_852059a918accd6627_46388747 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<div class="form">
    <form>
        <input type="hidden" class="form-control" name="id" value="<?php echo $_smarty_tpl->tpl_vars['nav']->value['id'];?>
">
        <div class="form-group">
            <label>标题</label>
            <input type="text" class="form-control" name="name" value="<?php echo $_smarty_tpl->tpl_vars['nav']->value['name'];?>
">
        </div>
        <div class="form-group">
            <label>排序</label>
            <input type="text" class="form-control" value="0" name="order" value="<?php echo $_smarty_tpl->tpl_vars['nav']->value['order'];?>
">
        </div>
        <div class="form-group">
            <label>链接</label>
            <input type="text" class="form-control" placeholder="model/controller/action" name="url" value="<?php echo $_smarty_tpl->tpl_vars['nav']->value['url'];?>
">
        </div>
        <div class="btn-group">
            <label>上级菜单</label><br/>
            <select name="pid" class="form-control">
                <option value="0" <?php if ($_smarty_tpl->tpl_vars['nav']->value['pid'] == 0) {?>checked<?php }?>>顶级菜单</option>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['hl']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['nav']->value['pid'] == $_smarty_tpl->tpl_vars['v']->value['id']) {?>selected="selected"<?php }?> ><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</option>
                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

            </select>
        </div>
        <div class="form-group">
            <label>分组</label>
            <input type="text" class="form-control" placeholder="不填为默认分组" name="group" value="<?php echo $_smarty_tpl->tpl_vars['nav']->value['group'];?>
">
        </div>
        <div class="form-group">
            <label>是否隐藏</label>
            <label class="radio-inline">
                <input type="radio" name="is_hide" id="inlineRadio1" value="0" <?php if ($_smarty_tpl->tpl_vars['nav']->value['is_hide'] == 0) {?>checked<?php }?>> 0
            </label>
            <label class="radio-inline">
                <input type="radio" name="is_hide" id="inlineRadio2" value="1" <?php if ($_smarty_tpl->tpl_vars['nav']->value['is_hide'] == 1) {?>checked<?php }?> > 1
            </label>
        </div>
        <button type="button" class="btn btn-default submit">确定</button>
    </form>
    <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['CONTROLLER']->value;?>
/add" class="url_hid">
    <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['__CONTROLLER__']->value;?>
" class="CONTROLLER">
</div>

<?php
}
}
/* {/block "content"} */
/* {block "javascript"} */
class Block_2669659a918accda4a7_51300200 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['__PUBLIC__']->value;?>
/js/admin/menu/edit.js"><?php echo '</script'; ?>
>
<?php
}
}
/* {/block "javascript"} */
}
