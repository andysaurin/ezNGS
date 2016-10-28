<?php
/* Smarty version 3.1.29, created on 2016-10-27 18:23:01
  from "/home/lucie/amidex/templates/default/templates/users/projects_users.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_581229e5b98a79_90898993',
  'file_dependency' => 
  array (
    'f43fdda0369fa2dc020f3827ea321f6f349e6f16' => 
    array (
      0 => '/home/lucie/amidex/templates/default/templates/users/projects_users.tpl',
      1 => 1473257928,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:users/projects_users/go.tpl' => 1,
    'file:admin/index.tpl' => 1,
  ),
),false)) {
function content_581229e5b98a79_90898993 ($_smarty_tpl) {
?>



<?php if ($_smarty_tpl->tpl_vars['event']->value == 'go' && $_GET['id'] > 0) {?>
    <h1>Welcome to <?php echo $_GET['name'];?>
 project</h1>
    <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:users/projects_users/go.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


<?php } else { ?>

    <h1>All My Projects</h1>
	<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:admin/index.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


<?php }
}
}
