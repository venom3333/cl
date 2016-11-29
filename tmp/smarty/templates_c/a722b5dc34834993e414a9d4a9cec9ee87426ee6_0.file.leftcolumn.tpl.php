<?php
/* Smarty version 3.1.30, created on 2016-11-29 22:28:37
  from "D:\domens\localhost\custom-light\views\default\leftcolumn.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_583dd6e54ed4a5_58843351',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a722b5dc34834993e414a9d4a9cec9ee87426ee6' => 
    array (
      0 => 'D:\\domens\\localhost\\custom-light\\views\\default\\leftcolumn.tpl',
      1 => 1480447716,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_583dd6e54ed4a5_58843351 (Smarty_Internal_Template $_smarty_tpl) {
?>

<div id="leftColumn">
    <nav id="leftMenu">
        <div class="menuCaption">Категории:</div>
        <ul>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['categories']->value, 'category');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['category']->value) {
?>
                <li><a href="#"><?php echo $_smarty_tpl->tpl_vars['category']->value['name'];?>
</a></li>
                
                    
                        
                            
                        
                    
                
            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

        </ul>
    </nav>
</div> 
<?php }
}
