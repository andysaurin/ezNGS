<?php
/* Smarty version 3.1.29, created on 2016-08-16 17:00:46
  from "/home/lucie/amidex/templates/default/templates/common/header_main_website.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_57b32a9e35ebb4_49391053',
  'file_dependency' => 
  array (
    '6f0b90fc7bc77feb8973786e093a98f104bdfce1' => 
    array (
      0 => '/home/lucie/amidex/templates/default/templates/common/header_main_website.tpl',
      1 => 1465474052,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_57b32a9e35ebb4_49391053 ($_smarty_tpl) {
?>
<!doctype html>
<html class="no-js" lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title><?php if ($_smarty_tpl->tpl_vars['class_title']->value) {
echo $_smarty_tpl->tpl_vars['class_title']->value;
} else { ?>Home<?php }?></title>
		<link rel="shortcut icon" href="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
/favicon.ico" />
		<style>
			@import url(//fonts.googleapis.com/css?family=Karla:400,700|Lato);
		</style>

		<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
/stylesheets/app.css" />
 		<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
/stylesheets/main.css" />

		<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
/assets/icons/foundation-icons.css" />
		<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
/bower_components/modernizr/modernizr.js"><?php echo '</script'; ?>
>
 	    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
/bower_components/jquery/dist/jquery.min.js"><?php echo '</script'; ?>
>

		<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
/bower_components/highlight-js/src/highlight.js"><?php echo '</script'; ?>
>

		<?php if ($_smarty_tpl->tpl_vars['show_recaptcha']->value) {
echo '<script'; ?>
 src='https://www.google.com/recaptcha/api.js'><?php echo '</script'; ?>
><?php }?>

		<!--[if lte IE 8]><?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
/js/html5.js"><?php echo '</script'; ?>
><![endif]-->
		<?php echo '<script'; ?>
 type="text/javascript">
			<!--
				if (top.location!= self.location) {
					top.location = self.location.href
				}
			//-->
		<?php echo '</script'; ?>
>

	</head>
	<body>

	<div class="page-wrapper">

		<!-- Navigation Bar -->
		<div style="width:100% !important;border-bottom: 2px solid #FF6830">
			<nav class="top-bar" data-topbar role="navigation">


				<ul class="title-area">
					<li class="name">
						<a href="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
" title="Home">Homepage</a>
					</li>
					<!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
					<li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
				</ul>

				<section class="top-bar-section">
					<!-- Right Nav Section -->

					<ul class="right show-for-small-only">
						<li>
							<a href="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
/login" data-reveal-id="login-small">Sign in</a>
						</li>
					</ul>
					<ul class="nav right show-for-medium-up">
						<li>
							<a href="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
/login" class="show-for-medium-only" data-reveal-id="login-medium"><span class="tiny button radius default small" style="padding:5px;margin:0;">Sign in</span></a>
							<a href="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
/login" class="show-for-large-up" data-reveal-id="login-large"><span class="tiny button radius default"><i class="fi-torso"></i> Sign in</span></a>
						</li>
					</ul>

					<ul class="right" style="">

					      <li class="has-dropdown">
					        <a href="#" >Dropdown</a>
					        <ul class="dropdown">
					          <li ><a href="#">First link in dropdown</a></li>
					          <li class="active"><a href="#">Active link in dropdown</a></li>
					        </ul>
					      </li>


					</ul>

				</section>

			</nav>

		</div>

		<section id="main_body" style="margin:50px;padding:0px;">

<?php if ($_SESSION['message']) {?>
<div data-alert class="small right alert-box <?php echo $_SESSION['message']['type'];?>
 radius">
  <?php echo $_SESSION['message']['text'];?>

  <a href="#" class="close">&times;</a>
</div>
<?php }?>

<?php }
}
