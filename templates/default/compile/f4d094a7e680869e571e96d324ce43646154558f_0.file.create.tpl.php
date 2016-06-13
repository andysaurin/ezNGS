<?php
/* Smarty version 3.1.29, created on 2016-06-13 15:21:45
  from "/home/lucie/amidex/templates/default/templates/admin/projects/create.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_575eb369e3c997_87903481',
  'file_dependency' => 
  array (
    'f4d094a7e680869e571e96d324ce43646154558f' => 
    array (
      0 => '/home/lucie/amidex/templates/default/templates/admin/projects/create.tpl',
      1 => 1465822046,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_575eb369e3c997_87903481 ($_smarty_tpl) {
?>

<form method="POST">

  <div class="row">

    <div class="small-8">

      <div class="row">
        <div class="small-3 columns">
          <label for="right-label" class="right">Username</label>
        </div>
        <div class="small-9 columns">
          <input type="text" id="right-label" placeholder="Username">
        </div>
      </div>

    </div>

	<div class="small-8"><input type="submit" name="create_user" value="Create New User" /></div>
  </div>
</form><?php }
}
