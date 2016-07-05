<?php
/* Smarty version 3.1.29, created on 2016-07-05 14:42:59
  from "/home/lucie/amidex/templates/default/templates/home/iforgot.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_577bab539928c4_40108333',
  'file_dependency' => 
  array (
    '09ca053d802af6dd4d83594435fe6fe6d3dbf152' => 
    array (
      0 => '/home/lucie/amidex/templates/default/templates/home/iforgot.tpl',
      1 => 1464076644,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_577bab539928c4_40108333 ($_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['email']->value && $_smarty_tpl->tpl_vars['who']->value) {?>

<div class="row">
	<div class="medium-6 medium-centered large-4 large-centered columns">

		<form method="post" action="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['module']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['class']->value;?>
/reset/?who=<?php echo $_smarty_tpl->tpl_vars['who']->value;?>
" autocomplete="off">
			<div class="row column log-in-form">
				<h4 class="text-center">Please choose a new password.</h4>
				&nbsp;
				<label>Password
				<input name="password" id="password" type="password" placeholder="" value="" autocomplete="off" />
				</label>
				<label>Renter Password
				<input name="password2" id="password2" type="password" placeholder="" value="" autocomplete="off" />
				</label>

				<div class="row centered"><input type="submit" class="medium-6 button expanded tiny" value="Reset Password" /></div>

			</div>
		</form>

	</div>
</div>

<?php } else { ?>

<div class="row">
	<div class="medium-6 medium-centered large-4 large-centered columns">

		<form method="post" action="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['module']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['class']->value;?>
/">
			<div class="row column log-in-form">
				<h4 class="text-center">To reset your password,<br />please enter the account email address</h4>
				&nbsp;
				<label>Email
				<input name="email" type="text" placeholder="email@address.com" value="<?php echo $_POST['email'];?>
">
				</label>
				
				<div class="g-recaptcha" data-sitekey="<?php echo $_smarty_tpl->tpl_vars['reCaptcha_key']->value;?>
"></div>
				<br />
				<div class="row centered"><input type="submit" class="medium-6 button expanded tiny" value="Reset Password" /></div>

			</div>
		</form>

	</div>
</div>

<?php }
}
}
