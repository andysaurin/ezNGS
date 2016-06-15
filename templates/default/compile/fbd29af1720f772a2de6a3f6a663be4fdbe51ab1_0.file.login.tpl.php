<?php
/* Smarty version 3.1.29, created on 2016-06-14 16:20:34
  from "/home/lucie/amidex/templates/default/templates/home/login.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_576012b2f03cc8_89556142',
  'file_dependency' => 
  array (
    'fbd29af1720f772a2de6a3f6a663be4fdbe51ab1' => 
    array (
      0 => '/home/lucie/amidex/templates/default/templates/home/login.tpl',
      1 => 1465477698,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_576012b2f03cc8_89556142 ($_smarty_tpl) {
if (!$_smarty_tpl->tpl_vars['modal']->value) {?><div class="row">&nbsp;</div><?php }?>

			<div class="row">
				<?php if ($_smarty_tpl->tpl_vars['modal']->value) {?><div class="small-12 small-centered columns"><?php } else { ?><div class="medium-6 medium-centered large-4 large-centered columns"><?php }?>

					<form method="post" action="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
/login/<?php if ($_GET['ret']) {?>?ret=<?php echo $_GET['ret'];
}?>">
						<div class="text-center column log-in-form">
							<h4>Login</h4>
							<div class="drop">

								<div class="row collapse">
									<div class="small-2 columns">
										<span class="prefix"><i class="fi-torso" style="font-size: 1.2rem;"></i></span>
									</div>
									<div class="small-10 columns">
										<input name="username" type="text" placeholder="Username" value="<?php echo $_REQUEST['username'];?>
" />
									</div>
								</div>
								<div class="row collapse">
									<div class="small-2 columns">
										<span class="prefix"><i class="fi-lock" style="font-size: 1.2rem;"></i></span>
									</div>
									<div class="small-10 columns">
										<input name="password" type="password" placeholder="Password" />
									</div>
								</div>

								<div class="small" style="text-align: left">
								<a href="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
/home/iforgot/<?php if ($_GET['ret']) {?>?ret=<?php echo $_GET['ret'];
}?>">Forgot your password ?</a><br />
								</div>
							</div>

							<div style="padding-top:10px;<?php if ($_smarty_tpl->tpl_vars['modal']->value) {?>text-align:right;<?php }?>">
								<input type="submit" class="success button radius tiny" style="border-radius: 0.6rem;height:2rem;" value="Sign in"  />
								<?php if ($_smarty_tpl->tpl_vars['modal']->value) {?><a class="secondary tiny button radius close-modal" style="border-radius: 0.6rem;height:2rem;" aria-label="Cancel">Cancel</a><?php }?>
							</div>

						</div>
					</form>

				</div>
			</div><?php }
}
