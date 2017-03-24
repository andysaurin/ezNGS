{if $event == 'go'}

{include file="users/projects_users/go.tpl"}

{/if}

<ul class="accordion" data-accordion>

	{foreach $projects as $project}

	<li id="accordion_project{$project->id}" class="accordion-navigation">

		<a href="#project{$project->id}">{$project->name}</a>

		<div id="project{$project->id}" class="content">
			{*button to enter in the project with a GET request*}
            <a href="/{$module}/{$class}/go/?id={$project->id}&name={$project->name}" class="button tiny warning">Open project {$project->name}</a>

			{*button to edit project only for admin*}
			{if $is_admin == true}<a href="/{$module}/{$class}/edit/?id={$project->id}" class="button tiny warning">Edit {$project->name}</a>{/if}
			{foreach $project as $k=>$v}

			<div class="row">

				{if $k == 'available_users'}

				{elseif $k == 'users'}

					<div class="small-2 columns text-right subheader">{$k}</div>

					{if $v|@count == 0}

						<div class="user_list small-10 columns">
							<div class='noUsers'>No Assigned Users</div> {* this div will get hidden if we add a user *}
						</div>

					{else}
						<div class="small-10 columns">

							<div class="user_list">
						{foreach $v as $project_user}

								<div id="project{$project->id}_user{$project_user->id}" >
									<span class="secondary radius label">{$project_user->name}</span> {if $is_admin == true OR $project->name|in_array:$manager && {$project_user->id} != {$user->id} }<a href="#" class="removeUser" id="removeProjectUser-{$project->id}-{$project_user->id}" userID="{$project_user->id}" projectID="{$project->id}"><span class="alert radius label"> Remove </span></a>{/if}
								</div>

						{/foreach}

							</div>
							{if $is_admin == true  OR $project->name|in_array:$manager && $project->available_users|count > 0 }<div style="padding: 50px;"><a href="#" class="addProjectUser button small info" data-reveal-id="addUserModal-projectID_{$project->id}" projectID="{$project->id}">Invite a user to this project</a></div>{/if}
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

<!-- available users for this project (project ID {$project->id}) -->
<div id="addUserModal-projectID_{$project->id}" projectID="{$project->id}" class="login reveal-modal medium" data-reveal aria-labelledby="login-medium-title" aria-hidden="true" role="dialog">
	{foreach $project->available_users as $user}
		<div class="available_users"><a href="#" id="project_{$project->id}_available_user_id_{$user->id}" class="addUser button small radius success" userID="{$user->id}" projectID="{$project->id}" userName="{$user->name}">{$user->name}</a></div>

	{/foreach}
	<a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>

	{/foreach}


</ul>




<script>

{literal}
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

{/literal}
</script>