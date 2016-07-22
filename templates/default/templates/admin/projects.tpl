
{if $event == 'create'}

{include file="admin/projects/create.tpl"}

{elseif $event == 'go' && $smarty.get.id > 0}
    <h1>Welcome to {$smarty.get.name} project</h1>
    {include file="users/projects_users/go.tpl"}

{else} {* $event not defined, therefore calling function __default() *}

<h1>All Projects</h1>

<a href="/{$module}/{$class}/create" class="button tiny success">Create new project</a>

{include file="admin/index.tpl"}

{/if}