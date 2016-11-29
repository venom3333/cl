<?php
/* Smarty version 3.1.30, created on 2016-11-30 00:03:09
  from "D:\domens\localhost\custom-light\views\default\index.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_583ded0d8c6dd7_86478074',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f33a286af42a5a8cba59fdff8d3742eb41b3b60f' => 
    array (
      0 => 'D:\\domens\\localhost\\custom-light\\views\\default\\index.tpl',
      1 => 1480453388,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_583ded0d8c6dd7_86478074 (Smarty_Internal_Template $_smarty_tpl) {
?>

<div id="centerColumn">

    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['items']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
    <div>
        <?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>

    </div>
    <div>
        <?php echo $_smarty_tpl->tpl_vars['item']->value['brand'];?>

    </div>
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['item']->value['images'], 'image');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['image']->value) {
?>
            <div>
                <img src="<?php echo $_smarty_tpl->tpl_vars['image']->value['image'];?>
" alt="">
            </div>
        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['item']->value['colors'], 'color');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['color']->value) {
?>
            <div>
                <?php echo $_smarty_tpl->tpl_vars['color']->value['color'];?>

            </div>
        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['item']->value['categories'], 'category');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['category']->value) {
?>
            <div>
                <?php echo $_smarty_tpl->tpl_vars['category']->value['category'];?>

            </div>
        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
}
}
