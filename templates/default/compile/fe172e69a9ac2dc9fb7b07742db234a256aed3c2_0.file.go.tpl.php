<?php
/* Smarty version 3.1.29, created on 2016-10-27 18:22:38
  from "/home/lucie/amidex/templates/default/templates/users/projects_users/go.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_581229ce1aa1f2_00067859',
  'file_dependency' => 
  array (
    'fe172e69a9ac2dc9fb7b07742db234a256aed3c2' => 
    array (
      0 => '/home/lucie/amidex/templates/default/templates/users/projects_users/go.tpl',
      1 => 1473259684,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:users/projects_users/file_browser.tpl' => 1,
    'file:users/projects_users/samples.tpl' => 1,
    'file:users/projects_users/RNA-seq.tpl' => 1,
  ),
),false)) {
function content_581229ce1aa1f2_00067859 ($_smarty_tpl) {
?>

<ul class="tabs" data-tab>
    <li class="tab-title"><a href="#fileBrowser" onClick="browser_init();">Upload new sequence files</a></li>
    <li class="tab-title"><a href="#sampleAnnotation">Manage project descriptions</a></li>
    <li class="tab-title"><a href="#panel3">ChIP-seq Workflow</a></li>
    <li class="tab-title"><a href="#RNA-seq">RNA-seq Workflow</a></li>
    <li class="tab-title"><a href="#panel5">ChIP-seq and RNA-seq Integration</a></li>
</ul>

<div class="tabs-content">
    <div class="content" id="fileBrowser">
			<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:users/projects_users/file_browser.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

    </div>
    <div class="content" id="sampleAnnotation">
        <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:users/projects_users/samples.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

    </div>
    <div class="content" id="panel3">
        <p>This is the third panel of the basic tab example. This is the third panel of the basic tab example.</p>
    </div>
    <div class="content" id="RNA-seq">
        <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:users/projects_users/RNA-seq.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

    </div>
    <div class="content" id="panel5">
        <p>This is the five panel of the basic tab example. This is the fourth panel of the basic tab example.</p>
    </div>
</div>


<!--

<a href="#" data-reveal-id="myModal">Click Me For A Modal</a>

<div id="myModal" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
  <h2 id="modalTitle">Awesome. I have it.</h2>
  <p class="lead">Your couch.  It is mine.</p>
  <p>I'm a cool paragraph that lives inside of an even cooler modal. Wins!</p>
  <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>

//--><?php }
}
