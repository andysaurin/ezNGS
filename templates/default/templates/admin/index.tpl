

<ul class="accordion" data-accordion>

	{foreach $projects as $project}

	<li id="accordion_project{$project->id}" class="accordion-navigation">

		<a href="#project{$project->id}">{$project->name}</a>

		<div id="project{$project->id}" class="content">

			{if $is_project_manager == true}<a href="/{$module}/{$class}/edit/?id={$project->id}" class="button tiny warning">Edit {$project->name}</a>{/if}
			{foreach $project as $k=>$v}

			<div class="row">

				{if $k == 'users'}

					<div class="small-2 columns text-right subheader">{$k}</div>

					{if $v|@count == 0}

						<div class="user_list small-10 columns">
							<div class='noUsers'>No Assigned Users</div> {* this div will get hidden if we add a user *}
						</div>

						{*{if $is_project_manager == true}<div><a href="/{$module}/{$class}/edit/?id={$project->id}&add_user" class="button tiny radius success">Add new user</a></div>{/if}*}
                        {if $is_project_manager == true}<div><a href="#" class="addProjectUser button small info" data-reveal-id="addUserModal" projectID="{$project->id}">Add new user</a></div>{/if}

					{else}
						<div class="small-10 columns">

							<div class="user_list">
						{foreach $v as $user}

								<div id="project{$project->id}_user{$user->id}" >
									<span class="secondary radius label">{$user->name}</span> {if $is_project_manager == true}<a href="#" class="removeUser" id="removeProjectUser-{$project->id}-{$user->id}" userID="{$user->id}" projectID="{$project->id}"><span class="alert radius label"> Remove </span></a>{/if}
								</div>

						{/foreach}

							</div>

							{if $is_project_manager == true}<div style="padding: 50px;"><a href="#" class="addProjectUser button small info" data-reveal-id="addUserModal" projectID="{$project->id}">Invite a user to this project</a></div>{/if}
						</div>

					{/if}

				{else}
					<div class="small-2 columns text-right subheader">{$k}</div>
					<div class="small-10 columns">{$v}</div>

				{/if}

			</div>

			{/foreach}


		</div>
	</li>

	{/foreach}


</ul>


<div id="addUserModal" projectID="" class="login reveal-modal medium" data-reveal aria-labelledby="login-medium-title" aria-hidden="true" role="dialog">
	<div id="NewUserTitle" style="padding-bottom:50px;">Select a user to add to this project</div>

	{foreach $all_users as $user}
		<div class="available_users"><a href="#" id="available_user_id_{$user->id}" class="addUser button small radius success" userID="{$user->id}" projectID="" userName="{$user->name}">{$user->name}</a></div>

	{/foreach}

	<a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>


<script>

{literal}
$(document).ready(function() {


	$(document).on('opened.fndtn.reveal', '[data-reveal]', function () {

		var modal = $(this);
		var project_id = $(this).attr('projectID');

		//alert("Modal projectID attribute value: "+project_id);


		$('.addUser').click(function (){

			var user_id = $(this).attr('userID');
			var user_name = $(this).attr('userName');

			$.ajax({
				url:"/api/projects/add_user",
				method:'POST',
				data:{user_id: user_id, project_id: project_id}
			})
			.done(function( data ) {
				//alert(data);
				if ( data == 'ok' ) { //user added to project in the database

					// 1. hide the user from the modal window (so we can't click them a second time
					$("#available_user_id_"+user_id).hide();

					// 2. refresh list of project users in the parent accordion user list
					$("#project"+project_id+" .user_list").append( '<span class="secondary radius label">'+user_name+'</span> <a href="#" class="removeUser" id="removeProjectUser-'+project_id+'-'+user_id+'" userID="'+user_id+'" projectID="'+project_id+'"><span class="alert radius label"> Remove </span></a>' );


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

{/literal}
</script>