<?php
/* Smarty version 3.1.29, created on 2016-09-12 10:49:40
  from "/home/lucie/amidex/templates/default/templates/home/index.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_57d66c24847207_73732540',
  'file_dependency' => 
  array (
    'ae7cb4152b167ac816218cebe4012c2060472c35' => 
    array (
      0 => '/home/lucie/amidex/templates/default/templates/home/index.tpl',
      1 => 1465981874,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:home/login.tpl' => 3,
  ),
),false)) {
function content_57d66c24847207_73732540 ($_smarty_tpl) {
?>

	<div>
		Welcome !
			
	</div>

	<div id="login-small" class="login reveal-modal" data-reveal aria-labelledby="login-small-title" aria-hidden="true" role="dialog">
 		<div id="login-small-title">&nbsp;</div>
	<?php $_smarty_tpl->tpl_vars['modal'] = new Smarty_Variable(1, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'modal', 0);?>
	<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:home/login.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


		<a class="close-reveal-modal" aria-label="Close">&#215;</a>
	</div>

	<div id="login-medium" class="login reveal-modal medium" data-reveal aria-labelledby="login-medium-title" aria-hidden="true" role="dialog">
 		<div id="login-medium-title">&nbsp;</div>
	<?php $_smarty_tpl->tpl_vars['modal'] = new Smarty_Variable(1, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'modal', 0);?>
	<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:home/login.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>


		<a class="close-reveal-modal" aria-label="Close">&#215;</a>
	</div>

	<div id="login-large" class="login reveal-modal small" data-reveal aria-labelledby="login-large-title" aria-hidden="true" role="dialog">
 		<div id="login-large-title">&nbsp;</div>
	<?php $_smarty_tpl->tpl_vars['modal'] = new Smarty_Variable(1, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'modal', 0);?>
	<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:home/login.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>


		<a class="close-reveal-modal" aria-label="Close">&#215;</a>
	</div>

<?php }
}
