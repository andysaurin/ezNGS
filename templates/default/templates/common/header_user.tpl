<!doctype html>
<html class="no-js" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>{if $class_title}{$class_title}{else}Home{/if}</title>
		<link rel="shortcut icon" href="{$host}/favicon.ico" />
		<style>
			@import url(//fonts.googleapis.com/css?family=Karla:400,700|Lato);
		</style>

		<link rel="stylesheet" href="{$host}/stylesheets/app.css" />
 		<link rel="stylesheet" href="{$host}/stylesheets/main.css" />

		<link rel="stylesheet" href="{$host}/assets/icons/foundation-icons.css" />
		<script src="{$host}/bower_components/modernizr/modernizr.js"></script>
 	    <script src="{$host}/bower_components/jquery/dist/jquery.min.js"></script>
 		<script src="{$host}/bower_components/jquery-ui/jquery-ui.min.js"></script>

		<script src="{$host}/bower_components/highlight-js/src/highlight.js"></script>

		{if $show_recaptcha}<script src='https://www.google.com/recaptcha/api.js'></script>{/if}

		<!--[if lte IE 8]><script src="{$host}/js/html5.js"></script><![endif]-->
		<script type="text/javascript">
			<!--
				if (top.location!= self.location) {
					top.location = self.location.href
				}
			//-->
		</script>

	</head>
	<body>

	<div class="page-wrapper">

		<!-- Navigation Bar -->
		<div style="width:100% !important;border-bottom: 2px solid #FF6830">
			<nav class="top-bar" data-topbar role="navigation">


				<ul class="title-area">
					<li class="name">
						<a href="{$host}" title="Home" class="tiny button radius info small">ezNGS</a>
					</li>
					<!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
					<li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
				</ul>

				<section class="top-bar-section">
					<!-- Right Nav Section -->

					<ul class="right show-for-small-only">
						<li>
							<a href="{$host}/" data-reveal-id="login-small">{$username}</a>
						</li>
					</ul>
					<ul class="nav right show-for-medium-up">
						<li>
							<a href="{$host}/" class="show-for-medium-only" ><span class="tiny button radius default small" style="padding:5px;margin:0;">{$smarty.session.username}</span></a>
							<a href="{$host}/" class="show-for-large-up" ><span class="tiny button radius default"><i class="fi-torso"></i> {$smarty.session.username}</span></a>
						</li>
					</ul>

					<ul class="right show-for-small-only">
						<li>
							<a href="{$host}/logout" data-reveal-id="login-small">Logout</a>
						</li>
					</ul>
					<ul class="nav right show-for-medium-up">
						<li>
							<a href="{$host}/logout" class="show-for-medium-only" ><span class="tiny button radius warning small" style="padding:5px;margin:0;">Logout</span></a>
							<a href="{$host}/logout" class="show-for-large-up" ><span class="tiny button warning default"><i class="fi-torso"></i> Logout</span></a>
						</li>
					</ul>

					<!-- Left Nav Section -->
					<ul class="left" style="">

						<li class="has-dropdown">
							<a href="/users/projects_users">All My Projects</a></li>
					</ul>

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


<!-- Placeholder for user header //-->


		<section id="main_body" style="margin:50px;padding:0px;">

{if $smarty.session.message}
<div data-alert class="small right alert-box {$smarty.session.message.type} radius">
  {$smarty.session.message.text}
  <a href="#" class="close">&times;</a>
</div>
{/if}

