<?php
/* Smarty version 3.1.29, created on 2016-09-06 15:57:43
  from "/home/lucie/amidex/templates/default/templates/admin/projects/create.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_57cecb57b44e12_18083291',
  'file_dependency' => 
  array (
    'f4d094a7e680869e571e96d324ce43646154558f' => 
    array (
      0 => '/home/lucie/amidex/templates/default/templates/admin/projects/create.tpl',
      1 => 1467985820,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_57cecb57b44e12_18083291 ($_smarty_tpl) {
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
                    <input type="text" name="project_name" placeholder="Enter the name project" required oninvalid="this.setCustomValidity('Please enter a name project for create it')" >
                </div>
            </div>
           <input class="button success small round" type="submit" name="create_project" value="Create New Project" />
        </div>

  </div>
</form>

<?php }
}
