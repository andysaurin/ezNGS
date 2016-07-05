<?php
/* Smarty version 3.1.29, created on 2016-07-05 17:02:25
  from "/home/lucie/amidex/templates/default/templates/users/projects.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_577bcc01639ff5_60621535',
  'file_dependency' => 
  array (
    'd5f057b0d1bb45d2d3c942b6667dd489d16408a5' => 
    array (
      0 => '/home/lucie/amidex/templates/default/templates/users/projects.tpl',
      1 => 1467724925,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:admin/index.tpl' => 1,
  ),
),false)) {
function content_577bcc01639ff5_60621535 ($_smarty_tpl) {
?>
<h1>All My Projects</h1>

<a href="/<?php echo $_smarty_tpl->tpl_vars['module']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['class']->value;?>
/create" class="button tiny success">Create new project</a>

<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:admin/index.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php }
}
