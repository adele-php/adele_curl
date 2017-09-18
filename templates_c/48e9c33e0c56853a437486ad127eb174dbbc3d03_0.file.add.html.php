<?php
/* Smarty version 3.1.30, created on 2017-09-01 08:29:34
  from "F:\WWW\AdelePHP\application\admin\view\menu\add.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59a91a6e236744_27571406',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '48e9c33e0c56853a437486ad127eb174dbbc3d03' => 
    array (
      0 => 'F:\\WWW\\AdelePHP\\application\\admin\\view\\menu\\add.html',
      1 => 1504254573,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59a91a6e236744_27571406 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_302159a91a6e226d44_73681279', "title");
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1095859a91a6e22abc0_87496684', "css");
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_2167959a91a6e236747_19996282', "content");
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_2709159a91a6e236747_16015966', "javascript");
?>




<?php $_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['VIEW']->value)."/common/base.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block "title"} */
class Block_302159a91a6e226d44_73681279 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
add菜单<?php
}
}
/* {/block "title"} */
/* {block "css"} */
class Block_1095859a91a6e22abc0_87496684 extends Smarty_Internal_Block
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
class Block_2167959a91a6e236747_19996282 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<div class="form">
    <form>
        <div class="form-group">
            <label>标题</label>
            <input type="text" class="form-control" name="name">
        </div>
        <div class="form-group">
            <label>排序</label>
            <input type="text" class="form-control" value="0" name="order">
        </div>
        <div class="form-group">
            <label>链接</label>
            <input type="text" class="form-control" placeholder="model/controller/action" name="url">
        </div>
        <div class="btn-group">
            <label>上级菜单</label><br/>
            <select name="pid" class="form-control">
                <option value="0">顶级菜单</option>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['hl']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
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
            <input type="text" class="form-control" placeholder="不填为默认分组" name="group">
        </div>
        <div class="form-group">
            <label>是否隐藏</label>
            <label class="radio-inline">
                <input type="radio" name="is_hide" id="inlineRadio1" value="0" checked> 0
            </label>
            <label class="radio-inline">
                <input type="radio" name="is_hide" id="inlineRadio2" value="1"> 1
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
class Block_2709159a91a6e236747_16015966 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['__PUBLIC__']->value;?>
/js/admin/menu/add.js"><?php echo '</script'; ?>
>
<?php
}
}
/* {/block "javascript"} */
}
