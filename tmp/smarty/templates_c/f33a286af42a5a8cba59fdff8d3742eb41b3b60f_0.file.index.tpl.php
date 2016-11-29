<?php
/* Smarty version 3.1.30, created on 2016-11-30 00:42:59
  from "D:\domens\localhost\custom-light\views\default\index.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_583df66311d898_61529803',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f33a286af42a5a8cba59fdff8d3742eb41b3b60f' => 
    array (
      0 => 'D:\\domens\\localhost\\custom-light\\views\\default\\index.tpl',
      1 => 1480455777,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_583df66311d898_61529803 (Smarty_Internal_Template $_smarty_tpl) {
?>

<div id="centerColumn">

    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['items']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
        <div id="item">
            <p>
                Наименование: <?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>

            </p>
            <p>
                Бренд: <?php echo $_smarty_tpl->tpl_vars['item']->value['brand'];?>

            </p>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['item']->value['images'], 'image');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['image']->value) {
?>
                <div>
                    <img src="<?php echo $_smarty_tpl->tpl_vars['image']->value['image'];?>
" alt="Изображение товара">
                </div>
            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

            <div class="list">
                <p>Цвета: </p>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['item']->value['colors'], 'color');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['color']->value) {
?>
                    <p>
                        <?php echo $_smarty_tpl->tpl_vars['color']->value['color'];?>

                    </p>
                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

            </div>
            <div class="clear"></div>
            <div class="list">
                <p>Категории:</p>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['item']->value['categories'], 'category');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['category']->value) {
?>
                    <p>
                        <?php echo $_smarty_tpl->tpl_vars['category']->value['category'];?>

                    </p>
                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

            </div>
        </div>
    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

<?php }
}
