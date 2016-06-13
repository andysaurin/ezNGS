<?php
/* Smarty version 3.1.29, created on 2016-06-13 10:38:54
  from "/home/lucie/amidex/templates/default/templates/home/hello.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_575e711ea289a1_59769136',
  'file_dependency' => 
  array (
    '837c9dcda943b5ebb66263c0fc2ff88395b1248a' => 
    array (
      0 => '/home/lucie/amidex/templates/default/templates/home/hello.tpl',
      1 => 1465807131,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_575e711ea289a1_59769136 ($_smarty_tpl) {
?>
<!--
<?php
$_from = $_SESSION;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_val_0_saved_item = isset($_smarty_tpl->tpl_vars['val']) ? $_smarty_tpl->tpl_vars['val'] : false;
$__foreach_val_0_saved_key = isset($_smarty_tpl->tpl_vars['key']) ? $_smarty_tpl->tpl_vars['key'] : false;
$_smarty_tpl->tpl_vars['val'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['key'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['val']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
$__foreach_val_0_saved_local_item = $_smarty_tpl->tpl_vars['val'];
?>

<div><?php echo $_smarty_tpl->tpl_vars['key']->value;?>
 = <?php echo $_smarty_tpl->tpl_vars['val']->value;?>
</div>



<?php
$_smarty_tpl->tpl_vars['val'] = $__foreach_val_0_saved_local_item;
}
if ($__foreach_val_0_saved_item) {
$_smarty_tpl->tpl_vars['val'] = $__foreach_val_0_saved_item;
}
if ($__foreach_val_0_saved_key) {
$_smarty_tpl->tpl_vars['key'] = $__foreach_val_0_saved_key;
}
?>
-->

<?php echo $_smarty_tpl->tpl_vars['toto']->value['key1'];?>


<div><?php echo $_smarty_tpl->tpl_vars['andy']->value->key1;?>
</div><?php }
}
