<?php
/* Smarty version 3.1.29, created on 2016-07-18 11:04:13
  from "/home/lucie/amidex/templates/default/templates/admin/index.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_578c9b8d9930b1_90436003',
  'file_dependency' => 
  array (
    '296b19df94def446ecfd6b386b948224fbb2e766' => 
    array (
      0 => '/home/lucie/amidex/templates/default/templates/admin/index.tpl',
      1 => 1467990371,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_578c9b8d9930b1_90436003 ($_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['manager']->value) {?>
    <?php
$_from = $_smarty_tpl->tpl_vars['manager']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_project_0_saved_item = isset($_smarty_tpl->tpl_vars['project']) ? $_smarty_tpl->tpl_vars['project'] : false;
$_smarty_tpl->tpl_vars['project'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['project']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['project']->value) {
$_smarty_tpl->tpl_vars['project']->_loop = true;
$__foreach_project_0_saved_local_item = $_smarty_tpl->tpl_vars['project'];
?>
        <p><?php echo $_smarty_tpl->tpl_vars['project']->value;?>
</p>
    <?php
$_smarty_tpl->tpl_vars['project'] = $__foreach_project_0_saved_local_item;
}
if ($__foreach_project_0_saved_item) {
$_smarty_tpl->tpl_vars['project'] = $__foreach_project_0_saved_item;
}
}?>

<ul class="accordion" data-accordion>

	<?php
$_from = $_smarty_tpl->tpl_vars['projects']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_project_1_saved_item = isset($_smarty_tpl->tpl_vars['project']) ? $_smarty_tpl->tpl_vars['project'] : false;
$_smarty_tpl->tpl_vars['project'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['project']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['project']->value) {
$_smarty_tpl->tpl_vars['project']->_loop = true;
$__foreach_project_1_saved_local_item = $_smarty_tpl->tpl_vars['project'];
?>

	<li id="accordion_project<?php echo $_smarty_tpl->tpl_vars['project']->value->id;?>
" class="accordion-navigation">

		<a href="#project<?php echo $_smarty_tpl->tpl_vars['project']->value->id;?>
"><?php echo $_smarty_tpl->tpl_vars['project']->value->name;?>
</a>

		<div id="project<?php echo $_smarty_tpl->tpl_vars['project']->value->id;?>
" class="content">

			<?php if ($_smarty_tpl->tpl_vars['is_admin']->value == true) {?><a href="/<?php echo $_smarty_tpl->tpl_vars['module']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['class']->value;?>
/edit/?id=<?php echo $_smarty_tpl->tpl_vars['project']->value->id;?>
" class="button tiny warning">Edit <?php echo $_smarty_tpl->tpl_vars['project']->value->name;?>
</a><?php }?>
			<?php
$_from = $_smarty_tpl->tpl_vars['project']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_v_2_saved_item = isset($_smarty_tpl->tpl_vars['v']) ? $_smarty_tpl->tpl_vars['v'] : false;
$__foreach_v_2_saved_key = isset($_smarty_tpl->tpl_vars['k']) ? $_smarty_tpl->tpl_vars['k'] : false;
$_smarty_tpl->tpl_vars['v'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['k'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['v']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
$__foreach_v_2_saved_local_item = $_smarty_tpl->tpl_vars['v'];
?>

			<div class="row">

				<?php if ($_smarty_tpl->tpl_vars['k']->value == 'available_users') {?>

				<?php } elseif ($_smarty_tpl->tpl_vars['k']->value == 'users') {?>

					<div class="small-2 columns text-right subheader"><?php echo $_smarty_tpl->tpl_vars['k']->value;?>
</div>

					<?php if (count($_smarty_tpl->tpl_vars['v']->value) == 0) {?>

						<div class="user_list small-10 columns">
							<div class='noUsers'>No Assigned Users</div> 
						</div>

						
                        
						<?php ob_start();
echo $_smarty_tpl->tpl_vars['project']->value->name;
$_tmp1=ob_get_clean();
if ($_smarty_tpl->tpl_vars['is_admin']->value == true || in_array($_tmp1,$_smarty_tpl->tpl_vars['manager']->value)) {?><div><a href="#" class="addProjectUser button small info" data-reveal-id="addUserModal-projectID_<?php echo $_smarty_tpl->tpl_vars['project']->value->id;?>
" projectID="<?php echo $_smarty_tpl->tpl_vars['project']->value->id;?>
">Add new user</a></div><?php }?>

					<?php } else { ?>
						<div class="small-10 columns">

							<div class="user_list">
						<?php
$_from = $_smarty_tpl->tpl_vars['v']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_project_user_3_saved_item = isset($_smarty_tpl->tpl_vars['project_user']) ? $_smarty_tpl->tpl_vars['project_user'] : false;
$_smarty_tpl->tpl_vars['project_user'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['project_user']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['project_user']->value) {
$_smarty_tpl->tpl_vars['project_user']->_loop = true;
$__foreach_project_user_3_saved_local_item = $_smarty_tpl->tpl_vars['project_user'];
?>

								<div id="project<?php echo $_smarty_tpl->tpl_vars['project']->value->id;?>
_user<?php echo $_smarty_tpl->tpl_vars['project_user']->value->id;?>
" >
									<span class="secondary radius label"><?php echo $_smarty_tpl->tpl_vars['project_user']->value->name;?>
</span> <?php ob_start();
echo $_smarty_tpl->tpl_vars['project_user']->value->id;
$_tmp2=ob_get_clean();
ob_start();
echo $_smarty_tpl->tpl_vars['user']->value->id;
$_tmp3=ob_get_clean();
if ($_smarty_tpl->tpl_vars['is_admin']->value == true && $_tmp2 != $_tmp3) {?><a href="#" class="removeUser" id="removeProjectUser-<?php echo $_smarty_tpl->tpl_vars['project']->value->id;?>
-<?php echo $_smarty_tpl->tpl_vars['project_user']->value->id;?>
" userID="<?php echo $_smarty_tpl->tpl_vars['project_user']->value->id;?>
" projectID="<?php echo $_smarty_tpl->tpl_vars['project']->value->id;?>
"><span class="alert radius label"> Remove </span></a><?php }?>
								</div>

						<?php
$_smarty_tpl->tpl_vars['project_user'] = $__foreach_project_user_3_saved_local_item;
}
if ($__foreach_project_user_3_saved_item) {
$_smarty_tpl->tpl_vars['project_user'] = $__foreach_project_user_3_saved_item;
}
?>

							</div>

							<?php if ($_smarty_tpl->tpl_vars['is_admin']->value == true && count($_smarty_tpl->tpl_vars['project']->value->available_users) > 0) {?><div style="padding: 50px;"><a href="#" class="addProjectUser button small info" data-reveal-id="addUserModal-projectID_<?php echo $_smarty_tpl->tpl_vars['project']->value->id;?>
" projectID="<?php echo $_smarty_tpl->tpl_vars['project']->value->id;?>
">Invite a user to this project</a></div><?php }?>
						</div>

					<?php }?>

				<?php } else { ?>
					<div class="small-2 columns text-right subheader"><?php echo $_smarty_tpl->tpl_vars['k']->value;?>
</div>
					<div class="small-10 columns"><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</div>

				<?php }?>

			</div>



			<?php
$_smarty_tpl->tpl_vars['v'] = $__foreach_v_2_saved_local_item;
}
if ($__foreach_v_2_saved_item) {
$_smarty_tpl->tpl_vars['v'] = $__foreach_v_2_saved_item;
}
if ($__foreach_v_2_saved_key) {
$_smarty_tpl->tpl_vars['k'] = $__foreach_v_2_saved_key;
}
?>


		</div>
	</li>

<!-- available users for this project (project ID <?php echo $_smarty_tpl->tpl_vars['project']->value->id;?>
) -->
<div id="addUserModal-projectID_<?php echo $_smarty_tpl->tpl_vars['project']->value->id;?>
" projectID="<?php echo $_smarty_tpl->tpl_vars['project']->value->id;?>
" class="login reveal-modal medium" data-reveal aria-labelledby="login-medium-title" aria-hidden="true" role="dialog">
	<?php
$_from = $_smarty_tpl->tpl_vars['project']->value->available_users;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_user_4_saved_item = isset($_smarty_tpl->tpl_vars['user']) ? $_smarty_tpl->tpl_vars['user'] : false;
$_smarty_tpl->tpl_vars['user'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['user']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['user']->value) {
$_smarty_tpl->tpl_vars['user']->_loop = true;
$__foreach_user_4_saved_local_item = $_smarty_tpl->tpl_vars['user'];
?>
		<div class="available_users"><a href="#" id="project_<?php echo $_smarty_tpl->tpl_vars['project']->value->id;?>
_available_user_id_<?php echo $_smarty_tpl->tpl_vars['user']->value->id;?>
" class="addUser button small radius success" userID="<?php echo $_smarty_tpl->tpl_vars['user']->value->id;?>
" projectID="<?php echo $_smarty_tpl->tpl_vars['project']->value->id;?>
" userName="<?php echo $_smarty_tpl->tpl_vars['user']->value->name;?>
"><?php echo $_smarty_tpl->tpl_vars['user']->value->name;?>
</a></div>

	<?php
$_smarty_tpl->tpl_vars['user'] = $__foreach_user_4_saved_local_item;
}
if ($__foreach_user_4_saved_item) {
$_smarty_tpl->tpl_vars['user'] = $__foreach_user_4_saved_item;
}
?>
	<a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>

	<?php
$_smarty_tpl->tpl_vars['project'] = $__foreach_project_1_saved_local_item;
}
if ($__foreach_project_1_saved_item) {
$_smarty_tpl->tpl_vars['project'] = $__foreach_project_1_saved_item;
}
?>


</ul>




<?php echo '<script'; ?>
>


$(document).ready(function() {


	$(document).on('opened.fndtn.reveal', '[data-reveal]', function () {

		var modal = $(this);
		var project_id = $(this).attr('projectID');

		//alert("Modal projectID attribute value: "+project_id);


		$('.addUser').click(function (){

			var user_id = $(this).attr('userID');
			var project_id = $(this).attr('projectID');
			var user_name = $(this).attr('userName');

			$.ajax({
				url:"/api/projects/add_user",
				method:'POST',
				data:{user_id: user_id, project_id: project_id}
			})
			.done(function( data ) {
				//alert(data+" : userID="+user_id);
				if ( data == 'ok' ) { //user added to project in the database

					// 1. hide the user from the modal window (so we can't click them a second time
					$("#project_"+project_id+"_available_user_id_"+user_id).hide();

					// 2. refresh list of project users in the parent accordion user list
					$("#project"+project_id+" .user_list").append( '<span class="secondary radius label">'+user_name+'</span> <a href="#" class="removeUser" id="removeProjectUser-'+project_id+'-'+user_id+'" userID="'+user_id+'" projectID="'+project_id+'"><span class="alert radius label"> Remove </span></a>' );

					return false;

					//$("#project"+project_id+"_user"+user_id).hide();
				} else {
					alert(data);
				}

			});

		});

	});


	//open the modal window allowing selection of users to add to the project
	$('.addProjectUser').click(function (){

		//set the modal window projectID attribute to the correct project_id
		var project_id = $(this).attr('projectID');
		$("#addUserModal").attr("projectID", project_id);

	});





	$('.removeUser').click(function (){


		var user_id = $(this).attr('userID');
		var project_id = $(this).attr('projectID');

		//$("#removeProjectUser-"+project_id+"-"+user_id).hide();

		$.ajax({
			url:"/api/projects/remove_user",
			method:'POST',
			data:{user_id: user_id, project_id: project_id}

		})
		.done(function( data ) {
			//alert(data);
			if ( data == 'ok' ) {
				$("#project"+project_id+"_user"+user_id).hide();
			}
		});

	});



});


<?php echo '</script'; ?>
><?php }
}
