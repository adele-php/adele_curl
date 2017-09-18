<?php
/* Smarty version 3.1.30, created on 2017-09-05 03:23:32
  from "F:\WWW\AdelePHP\application\admin\view\gather\config.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59ae18b4c64dc5_20015228',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4084e40df5a2e4690c28beae12b5b98cfe4906b8' => 
    array (
      0 => 'F:\\WWW\\AdelePHP\\application\\admin\\view\\gather\\config.html',
      1 => 1504581692,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59ae18b4c64dc5_20015228 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1217259ae18b4c64dc1_48858272', "title");
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_2500859ae18b4c64dc8_09599342', "css");
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_2726759ae18b4c64dc3_68943694', "content");
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_686959ae18b4c64dc4_09373603', "javascript");
?>




<?php $_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['VIEW']->value)."/common/base.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block "title"} */
class Block_1217259ae18b4c64dc1_48858272 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
add菜单<?php
}
}
/* {/block "title"} */
/* {block "css"} */
class Block_2500859ae18b4c64dc8_09599342 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<link href="<?php echo $_smarty_tpl->tpl_vars['__PUBLIC__']->value;?>
/admin/gather/config.css" type="text/css" rel="stylesheet">
<?php
}
}
/* {/block "css"} */
/* {block "body"} */
class Block_2487359ae18b4c64dc7_35847276 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<div class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="width:80%;top:80px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" ><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">采集测试</h4>
            </div>
            <div class="modal-body">
                <p style="height: 269px;overflow-y:scroll">


                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php
}
}
/* {/block "body"} */
/* {block "content"} */
class Block_2726759ae18b4c64dc3_68943694 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


<div class="form">
    <form>

        <div class="form-group">
            <label>multiple数目(并行进程数)</label>
            <input type="text" class="form-control multi"  name="multi">
        </div>

        <div class="radio">
            <label>
                <input type="radio" name="proxy" value="0" checked>
                不开启代理
            </label>
        </div>
        <div class="radio">
            <label>
                <input type="radio" name="proxy" value="1">
                开启代理
            </label>
        </div>
        <div class="proxy_info">
            <div class="form-group ">
                <label>proxyServer</label>
                <input type="text" class="form-control proxyServer"  name="proxyServer">
            </div>
            <div class="form-group ">
                <label>proxyUser</label>
                <input type="text" class="form-control proxyUser "  name="proxyUser">
            </div>
            <div class="form-group ">
                <label>proxyPass</label>
                <input type="text" class="form-control proxyPass " name="proxyPass">
            </div>
        </div>

        <div class="form-group">
            <label>cookie(用于模拟登录)</label>
            <input type="text" class="form-control cookie"  name="cookie">
        </div>


        <button type="button" class="btn btn-default submit">确定</button>
    </form>
    <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['__CONTROLLER__']->value;?>
" class="CONTROLLER">

</div>
<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_2487359ae18b4c64dc7_35847276', "body", $this->tplIndex);
?>

<?php
}
}
/* {/block "content"} */
/* {block "javascript"} */
class Block_686959ae18b4c64dc4_09373603 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['__PUBLIC__']->value;?>
/js/admin/gather/config.js"><?php echo '</script'; ?>
>
<?php
}
}
/* {/block "javascript"} */
}
