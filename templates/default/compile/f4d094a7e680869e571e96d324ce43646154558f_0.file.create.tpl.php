<?php
/* Smarty version 3.1.29, created on 2016-07-05 14:18:57
  from "/home/lucie/amidex/templates/default/templates/admin/projects/create.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_577ba5b17536a4_57875890',
  'file_dependency' => 
  array (
    'f4d094a7e680869e571e96d324ce43646154558f' => 
    array (
      0 => '/home/lucie/amidex/templates/default/templates/admin/projects/create.tpl',
      1 => 1465985437,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_577ba5b17536a4_57875890 ($_smarty_tpl) {
?>

<h1>Create New Project</h1>

<form method="POST">
    <div class="row left">
        <div class="large-6 columns">
            <div class="row collapse prefix-radius ">
                <div class="small-3 columns">
                    <span class="prefix">Project name</span>
                </div>
                <div class="small-9 columns">
                    <input type="text" name="project_name" placeholder="Enter the name project">
                </div>
            </div>
           <input class="button success small round" type="submit" name="create_project" value="Create New Project" />
        </div>

  </div>
</form>

<?php }
}
