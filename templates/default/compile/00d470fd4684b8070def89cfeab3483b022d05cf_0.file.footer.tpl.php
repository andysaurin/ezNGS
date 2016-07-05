<?php
/* Smarty version 3.1.29, created on 2016-07-05 11:35:38
  from "/home/lucie/amidex/templates/default/templates/common/footer.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_577b7f6a4ab851_31185228',
  'file_dependency' => 
  array (
    '00d470fd4684b8070def89cfeab3483b022d05cf' => 
    array (
      0 => '/home/lucie/amidex/templates/default/templates/common/footer.tpl',
      1 => 1465541095,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_577b7f6a4ab851_31185228 ($_smarty_tpl) {
?>


		</section>

	</div> <!-- end page wrapper //-->

	<div class="site-footer">
		<div class="page_footer_leader">


		</div>
		<div class="page_footer">

		</div>


	    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
/bower_components/foundation/js/foundation.min.js"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
/js/app.js"><?php echo '</script'; ?>
>

<?php if ($_SESSION['message'] && $_SESSION['message']['delay'] > 0) {?>
		<?php echo '<script'; ?>
>
			$(document).ready(function() {
				var $alert = $('.alert-box');
				$alert.delay(<?php echo $_SESSION['message']['delay'];?>
).fadeOut(1000);
			});
		<?php echo '</script'; ?>
>
<?php }?>

		<?php echo '<script'; ?>
>
			$(document).ready(function() {

				$('#main_body').click(function() {
					//fix for topbar expanded menu not closing on mobile
					'.top-bar ul.right li'
				});


				$('.close-modal').on('click', function() {
					$('.login').foundation('reveal', 'close');
				});

				function isValidTime(expires) {

					var date = Math.floor( $.now() /1000 );
					if ( date > expires ) {
						alert("The session for this action has expired.\nThe page will now reload to allow\nyou to complete your request.");
						return null;
					} else {
						return true;
					}
				}

			});


		<?php echo '</script'; ?>
>

	</div>


	</body>
</html>
<?php }
}
