<?php
/* Smarty version 3.1.29, created on 2016-07-18 11:04:18
  from "/home/lucie/amidex/templates/default/templates/admin/projects.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_578c9b925b9e03_80889484',
  'file_dependency' => 
  array (
    '808b11508b9610d9198c34187ede48d4aee6b1f1' => 
    array (
      0 => '/home/lucie/amidex/templates/default/templates/admin/projects.tpl',
      1 => 1467990912,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:admin/projects/create.tpl' => 1,
    'file:admin/index.tpl' => 1,
  ),
),false)) {
function content_578c9b925b9e03_80889484 ($_smarty_tpl) {
?>

<?php if ($_smarty_tpl->tpl_vars['event']->value == 'create') {?>

<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:admin/projects/create.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>



<?php } else { ?> 

<h1>All Projects</h1>

<a href="/<?php echo $_smarty_tpl->tpl_vars['module']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['class']->value;?>
/create" class="button tiny success">Create new project</a>

<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:admin/index.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


<?php }
}
}
