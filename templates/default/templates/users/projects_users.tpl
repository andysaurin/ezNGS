{* 08/07/2016 <a href="/{$module}/{$class}/create" class="button tiny success">Create new project</a>*}


{if $event == 'go' && $smarty.get.id > 0}
    <h1>Welcome to {$smarty.get.name} project</h1>
    {include file="users/projects_users/go.tpl"}

{else}

    <h1>All My Projects</h1>
	{include file="admin/index.tpl"}

{/if}
