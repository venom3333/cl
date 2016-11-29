<?php
/* Smarty version 3.1.30, created on 2016-11-29 23:47:09
  from "D:\domens\localhost\custom-light\views\default\header.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_583de94d7ed305_53427264',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6a8e8dae8aab653f20230b0f6d4c461f35fe06ae' => 
    array (
      0 => 'D:\\domens\\localhost\\custom-light\\views\\default\\header.tpl',
      1 => 1480452428,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:leftcolumn.tpl' => 1,
  ),
),false)) {
function content_583de94d7ed305_53427264 (Smarty_Internal_Template $_smarty_tpl) {
?>
<html>

<head>
    <title><?php echo $_smarty_tpl->tpl_vars['pageTitle']->value;?>
</title>
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['templateWebPath']->value;?>
css/main.css">
</head>

<body>
<header id="header">
    <h1>my shop - интернет магазин</h1>
</header>

<?php $_smarty_tpl->_subTemplateRender("file:leftcolumn.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>



<?php }
}
