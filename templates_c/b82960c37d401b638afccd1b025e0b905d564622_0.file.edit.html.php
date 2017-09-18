<?php
/* Smarty version 3.1.30, created on 2017-08-23 04:12:19
  from "F:\WWW\AdelePHP\application\admin\view\gather\edit.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_599d00a3ae8c95_41031126',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b82960c37d401b638afccd1b025e0b905d564622' => 
    array (
      0 => 'F:\\WWW\\AdelePHP\\application\\admin\\view\\gather\\edit.html',
      1 => 1503461538,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_599d00a3ae8c95_41031126 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_15185599d00a3aa2781_82089012', "title");
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_19526599d00a3ab9e83_22872736', "css");
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_18711599d00a3ae4e09_26507454', "content");
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_18309599d00a3ae8c98_71450844', "body");
?>



<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_8651599d00a3ae8c97_48018144', "javascript");
?>




<?php $_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['VIEW']->value)."/common/base.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block "title"} */
class Block_15185599d00a3aa2781_82089012 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
add菜单<?php
}
}
/* {/block "title"} */
/* {block "css"} */
class Block_19526599d00a3ab9e83_22872736 extends Smarty_Internal_Block
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
class Block_18711599d00a3ae4e09_26507454 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<div class="form">
    <form>
        <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['hid_type']->value;?>
" class="hid_type" name="hid_type">
        <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['gather']->value['id'];?>
" name="id">
        <div class="form-group">
            <label>编码</label>
            <input type="text" class="form-control iconv" placeholder="utf-8" name="iconv" value='<?php echo $_smarty_tpl->tpl_vars['gather']->value['iconv'];?>
'>
        </div>
        <!--小说详情-->
        <div class="form-group">
            <label>小说详情页地址</label>
            <input type="text" class="form-control detail_url"  name="detail_url"  value='<?php echo $_smarty_tpl->tpl_vars['gather']->value['detail_url'];?>
' required="required">
        </div>
        <div class="form-group">
            <label>详情开始</label>
            <textarea name="detail_start" class="form-control detail_start" style="resize: none;height: 140px;" ><?php echo $_smarty_tpl->tpl_vars['gather']->value['detail_start'];?>
</textarea>
        </div>
        <div class="form-group">
            <label>详情结束</label>
            <textarea name="detail_end" class="form-control detail_end" style="resize: none;height: 140px;"><?php echo $_smarty_tpl->tpl_vars['gather']->value['detail_end'];?>
</textarea>
        </div>
        <div class="form-group">
            <label>详情正则</label>
            <textarea name="detail_pattern" class="form-control detail_pattern" style="resize: none;height: 140px;"><?php echo $_smarty_tpl->tpl_vars['gather']->value['detail_pattern'];?>
</textarea>
        </div>
        <button type="button" class="btn btn-warning test" _type="detail">小说详情采集测试</button><br/><br/>

        <!--小说章节-->
        <div class="form-group">
            <label>章节url(如何和详情url一样则不填)</label>
            <input type="text" class="form-control section_url"  name="section_url" value='<?php echo $_smarty_tpl->tpl_vars['gather']->value['section_url'];?>
'>
        </div>
        <div class="form-group">
            <label>章节开始</label>
            <input type="text" class="form-control section_start"  name="section_start" value='<?php echo $_smarty_tpl->tpl_vars['gather']->value['section_start'];?>
'>
        </div>
        <div class="form-group">
            <label>章节结束</label>
            <input type="text" class="form-control section_end"  name="section_end" value='<?php echo $_smarty_tpl->tpl_vars['gather']->value['section_end'];?>
'>
        </div>
        <div class="form-group">
            <label>章节正则</label>
            <input type="text" class="form-control section_pattern"  name="section_pattern" value='<?php echo $_smarty_tpl->tpl_vars['gather']->value['section_pattern'];?>
'>
        </div>
        <button type="button" class="btn btn-warning test" _type="section">小说章节采集测试</button><br/><br/>

        <div class="form-group">
            <label>内容开始</label>
            <input type="text" class="form-control content_start"  name="content_start" value='<?php echo $_smarty_tpl->tpl_vars['gather']->value['content_start'];?>
'>
        </div>
        <div class="form-group">
            <label>内容结束</label>
            <input type="text" class="form-control content_end"  name="content_end" value='<?php echo $_smarty_tpl->tpl_vars['gather']->value['content_end'];?>
'>
        </div>
        <div class="form-group">
            <label>内容正则</label>
            <input type="text" class="form-control content_pattern" name="content_pattern" value='<?php echo $_smarty_tpl->tpl_vars['gather']->value['content_pattern'];?>
'>
        </div>
        <button type="button" class="btn btn-warning test" _type="content">小说任意章节内容采集测试</button><br/><br/>


        <button type="button" class="btn btn-default submit">确定</button>
    </form>
    <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['__CONTROLLER__']->value;?>
" class="CONTROLLER">
</div>
<?php
}
}
/* {/block "content"} */
/* {block "body"} */
class Block_18309599d00a3ae8c98_71450844 extends Smarty_Internal_Block
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
/* {block "javascript"} */
class Block_8651599d00a3ae8c97_48018144 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['__PUBLIC__']->value;?>
/js/admin/gather/edit.js"><?php echo '</script'; ?>
>
<?php
}
}
/* {/block "javascript"} */
}
