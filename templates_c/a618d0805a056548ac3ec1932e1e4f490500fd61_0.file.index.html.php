<?php
/* Smarty version 3.1.30, created on 2017-08-24 03:50:48
  from "F:\WWW\AdelePHP\application\admin\view\gather\index.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_599e4d189b1347_29541714',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a618d0805a056548ac3ec1932e1e4f490500fd61' => 
    array (
      0 => 'F:\\WWW\\AdelePHP\\application\\admin\\view\\gather\\index.html',
      1 => 1503546647,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_599e4d189b1347_29541714 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_28379599e4d18947bb6_10842559', "title");
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_26442599e4d1894ba36_48754993', "css");
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_8981599e4d189b1340_88328273', "content");
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_5279599e4d189b1342_43955974', "javascript");
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['VIEW']->value)."/common/base.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block "title"} */
class Block_28379599e4d18947bb6_10842559 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
系统<?php
}
}
/* {/block "title"} */
/* {block "css"} */
class Block_26442599e4d1894ba36_48754993 extends Smarty_Internal_Block
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
class Block_8981599e4d189b1340_88328273 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <div class="main">
        <div class="btns">
            <button type="button" class="btn btn-primary add">新增</button>
        </div>
        <div class="main-table">
            <table class="table table-hover">
                <tr>
                    <th class="info">ID</th>
                    <th class="info">书籍详情链接</th>
                    <th class="info">是否为模板</th>
                    <th class="info">编码</th>
                    <th class="info">操作</th>
                </tr>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['gather']->value, 'v', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['v']->value) {
?>
                <tr>
                    <td><?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['v']->value['detail_url'];?>
</td>
                    <td><a class='setTemplet' href="javascript:void(0)" _href="<?php echo $_smarty_tpl->tpl_vars['__CONTROLLER__']->value;?>
/setTemplet" _id="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" _val="<?php echo $_smarty_tpl->tpl_vars['v']->value['templet'];?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['num2str'][0][0]->num2str(array('num'=>$_smarty_tpl->tpl_vars['v']->value['templet']),$_smarty_tpl);?>
</a></td>
                    <td><?php echo $_smarty_tpl->tpl_vars['v']->value['iconv'];?>
</td>

                    <td>
                        <a title="编辑" href="<?php echo $_smarty_tpl->tpl_vars['__CONTROLLER__']->value;?>
/edit/id/<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" >编辑</a>
                        <a title="删除" href="javascript:void(0)" class="del" _id="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">删除</a>
                        <a title="删除" href="<?php echo $_smarty_tpl->tpl_vars['__CONTROLLER__']->value;?>
/gather/id/<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" >采集</a>
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
" class="CONTROLLER">
<?php
}
}
/* {/block "content"} */
/* {block "javascript"} */
class Block_5279599e4d189b1342_43955974 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['__PUBLIC__']->value;?>
/js/admin/gather/index.js"><?php echo '</script'; ?>
>
<?php
}
}
/* {/block "javascript"} */
}
