<?php
/* Smarty version 3.1.29, created on 2016-07-18 11:18:13
  from "/home/lucie/amidex/templates/default/templates/common/page.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_578c9ed53fb7c3_88079926',
  'file_dependency' => 
  array (
    'eb57149f96fb0035278ef3c96e46d78864bbd6ad' => 
    array (
      0 => '/home/lucie/amidex/templates/default/templates/common/page.tpl',
      1 => 1465473172,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:common/header_admin.tpl' => 1,
    'file:common/header_user.tpl' => 1,
    'file:common/header_main_website.tpl' => 1,
    'file:common/denied.tpl' => 1,
    'file:common/footer.tpl' => 1,
  ),
),false)) {
function content_578c9ed53fb7c3_88079926 ($_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['ShowBodyOnly']->value == 1) {
$_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, $_smarty_tpl->tpl_vars['tplFile']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php } else {
if ($_smarty_tpl->tpl_vars['session']->value->id > 0) {
if ($_smarty_tpl->tpl_vars['session']->value->is_admin == 1) {
$_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:common/header_admin.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
} else {
$_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:common/header_user.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
} else {
$_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:common/header_main_website.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}?>

<?php if (($_smarty_tpl->tpl_vars['user']->value->session->access_denied)) {
$_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:common/denied.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php } else {
$_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, $_smarty_tpl->tpl_vars['tplFile']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
}
$_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:common/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php }
}
}
