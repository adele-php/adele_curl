<?php
/* Smarty version 3.1.30, created on 2017-08-31 01:23:49
  from "F:\WWW\AdelePHP\application\admin\view\gather\add.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59a76525bc8990_95505355',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3a7d5b4db283b62c0788b7f56440f5c30cbeeb1c' => 
    array (
      0 => 'F:\\WWW\\AdelePHP\\application\\admin\\view\\gather\\add.html',
      1 => 1504142629,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59a76525bc8990_95505355 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1975059a76525bb5113_91214189', "title");
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_249359a76525bb8f95_82726691', "css");
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_3213759a76525bc8997_49874967', "content");
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_3095959a76525bc8998_65146931', "javascript");
?>




<?php $_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['VIEW']->value)."/common/base.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block "title"} */
class Block_1975059a76525bb5113_91214189 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
add菜单<?php
}
}
/* {/block "title"} */
/* {block "css"} */
class Block_249359a76525bb8f95_82726691 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<link href="<?php echo $_smarty_tpl->tpl_vars['__PUBLIC__']->value;?>
/admin/gather/add.css" type="text/css" rel="stylesheet">
<?php
}
}
/* {/block "css"} */
/* {block "body"} */
class Block_1271159a76525bc4b13_77804095 extends Smarty_Internal_Block
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
class Block_3213759a76525bc8997_49874967 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


<div class="form">
    <form>
        <div class="form-group">
            <label>选择模板(可选)</label>
            <select class="form-control" id="select">
                <option >不选</option>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['tmps']->value, 'tmp');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['tmp']->value) {
?>
                    <option _id="<?php echo $_smarty_tpl->tpl_vars['tmp']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['tmp']->value['detail_url'];?>
</option>
                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>


            </select>
        </div>

        <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['hid_type']->value;?>
" class="hid_type">
        <div class="form-group">
            <label>编码</label>
            <input type="text" class="form-control iconv" placeholder="utf-8" name="iconv">
        </div>
        <!--小说详情-->
        <div class="form-group">
            <label>小说详情页地址</label>
            <input type="text" class="form-control detail_url"  name="detail_url" required="required">
        </div>
        <div class="form-group">
            <label>详情开始-演示</label>
            <textarea class="form-control" style="resize: none;height: 140px;"  readonly>
<div class="detail">;
name:<h1>;
author:<h1>;
img:<div class="book-img">;
desc:<p class="intro">;
            </textarea>
        </div>
        <div class="form-group">
            <label>详情结束-演示</label>
            <textarea class="form-control" style="resize: none;height: 140px;"  readonly>
<div class="book-comment">;
name:</h1>;
author:</h1>;
img:</div>;
desc:</p>;
            </textarea>
        </div>
        <div class="form-group">
            <label>详情正则-演示</label>
            <textarea class="form-control" style="resize: none;height: 140px;"  readonly>
name:/<em>(.*)<\/em>/U;
author:/<span><a href=.*>(.*)<\/a>/U;
img:/<img src="(.*)">/U;
desc:/<p class="intro">(.*)/;
            </textarea>
        </div>
        <div class="form-group">
            <label>详情开始</label>
            <textarea name="detail_start" class="form-control detail_start" style="resize: none;height: 140px;"></textarea>
        </div>
        <div class="form-group">
            <label>详情结束</label>
            <textarea name="detail_end" class="form-control detail_end" style="resize: none;height: 140px;"></textarea>
        </div>
        <div class="form-group">
            <label>详情正则</label>
            <textarea name="detail_pattern" class="form-control detail_pattern" style="resize: none;height: 140px;"></textarea>
        </div>
        <button type="button" class="btn btn-warning test" _type="detail">小说详情采集测试</button><br/><br/>

        <!--小说章节-->
        <div class="form-group">
            <label>章节url(如何和详情url一样则不填)</label>
            <input type="text" class="form-control section_url"  name="section_url">
        </div>
        <div class="form-group">
            <label>章节开始</label>
            <input type="text" class="form-control section_start"  name="section_start">
        </div>
        <div class="form-group">
            <label>章节结束</label>
            <input type="text" class="form-control section_end"  name="section_end">
        </div>
        <div class="form-group">
            <label>章节正则</label>
            <input type="text" class="form-control section_pattern"  name="section_pattern">
        </div>
        <div class="radio">
            <label>
                <input type="radio" name="section_page" value="0" checked>
                无分页
            </label>
        </div>
        <div class="radio">
            <label>
                <input type="radio" name="section_page" value="1">
                有分页
            </label>
        </div>
        <div class="section_page">
            <div class="form-group ">
                <label>章节分页开始</label>
                <input type="text" class="form-control section_page_start"  name="section_page_start">
            </div>
            <div class="form-group ">
                <label>章节分页结束</label>
                <input type="text" class="form-control section_page_end "  name="section_page_end">
            </div>
            <div class="form-group ">
                <label>章节分页正则</label>
                <input type="text" class="form-control section_page_pattern " name="section_page_pattern">
            </div>
        </div>

        <button type="button" class="btn btn-warning test" _type="section">小说章节采集测试</button><br/><br/>

        <div class="form-group">
            <label>内容开始</label>
            <input type="text" class="form-control content_start"  name="content_start">
        </div>
        <div class="form-group">
            <label>内容结束</label>
            <input type="text" class="form-control content_end"  name="content_end">
        </div>
        <div class="form-group">
            <label>内容正则</label>
            <input type="text" class="form-control content_pattern" name="content_pattern">
        </div>
        <button type="button" class="btn btn-warning test" _type="content">小说任意章节内容采集测试</button><br/><br/>
        <div class="alert alert-warning alert-dismissible " role="alert" style="display: none;">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            <strong>Holy guacamole!</strong>
        </div>
        <button type="button" class="btn btn-default submit">确定</button>
    </form>
    <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['__CONTROLLER__']->value;?>
" class="CONTROLLER">

</div>
<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1271159a76525bc4b13_77804095', "body", $this->tplIndex);
?>

<?php
}
}
/* {/block "content"} */
/* {block "javascript"} */
class Block_3095959a76525bc8998_65146931 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['__PUBLIC__']->value;?>
/js/admin/gather/add.js"><?php echo '</script'; ?>
>
<?php
}
}
/* {/block "javascript"} */
}
