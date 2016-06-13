
{if $event == 'create'}

{include file="admin/projects/create.tpl"}


{else} {* $event not defined, therefore calling function __default() *}

<h1>All Projects</h1>

<a href="/{$module}/{$class}/create" class="button tiny success">Create new project</a>

{include file="admin/index.tpl"}


{/if}