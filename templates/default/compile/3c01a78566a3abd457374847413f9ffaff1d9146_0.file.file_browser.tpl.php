<?php
/* Smarty version 3.1.29, created on 2016-08-16 15:50:14
  from "/home/lucie/amidex/templates/default/templates/users/projects_users/file_browser.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_57b31a1688faf1_80160849',
  'file_dependency' => 
  array (
    '3c01a78566a3abd457374847413f9ffaff1d9146' => 
    array (
      0 => '/home/lucie/amidex/templates/default/templates/users/projects_users/file_browser.tpl',
      1 => 1471355410,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_57b31a1688faf1_80160849 ($_smarty_tpl) {
?>
 <?php echo '<script'; ?>
 type="text/javascript" src="/js/browser/ajax.js"><?php echo '</script'; ?>
>
 <?php echo '<script'; ?>
 type="text/javascript" src="/js/browser/browser.js"><?php echo '</script'; ?>
>
<?php $_smarty_debug = new Smarty_Internal_Debug;
 $_smarty_debug->display_debug($_smarty_tpl);
unset($_smarty_debug);
?>

<?php echo '<script'; ?>
 type="text/javascript">


	function browser_init(){
		browser({
			contentsDisplay:document.getElementById("dvContents"),
			refreshButton:document.getElementById("btnrefresh"),
			pathDisplay:document.getElementById("pPathDisplay"),
			filter:document.getElementById("txtFilter"),
			openFolderOnSelect:true,
			onSelect:function(item,params){
				if(item.type=="folder")
					return true; //confirm("Do you want to open this Folder : "+item.path);
				else {
					if (confirm("Are you sure you want to import the file:\n"+item.path)){
                        $.ajax({
                            type:"POST",
                            url: " /api/import",
                            data: {"path": utf8_to_b64(item.path), "project_id":  <?php echo $_smarty_tpl->tpl_vars['project']->value->id;?>
  }//test with number value ok now how to use project id
                        });
                    }

					alert(" POSTing to /api/import/?path="+utf8_to_b64(item.path) )

				}
			},
			currentPath:"../"
		});
	}

	function utf8_to_b64( str ) {
	  return window.btoa(unescape(encodeURIComponent( str )));
	}

	function b64_to_utf8( str ) {
	  return decodeURIComponent(escape(window.atob( str )));
	}

// Usage:
//utf8_to_b64(' à la mode'); // "4pyTIMOgIGxhIG1vZGU="
//b64_to_utf8('4pyTIMOgIGxhIG1vZGU='); // " à la mode"


<?php echo '</script'; ?>
>

<div class="browser">

      <div class="row">
        <div class="small-3 columns">
          <label for="txtFilter" class="right" value="">File types filter</label>
        </div>
        <div class="small-6 columns">
          <input type="text" id="txtFilter">
        </div>
         <div class="small-3 columns">
          <input type="button" value="Refresh" id="btnrefresh"/>
        </div>

      </div>


	<div class="row" >
		<div id="pPathDisplay" class="pPathDisplay" style="min-height:40px;padding-left:10px">Loading...</div>
	</div>
	<div class="row">
		<div id="dvContents" class="dvContents">&nbsp;</div>
	</div>
</div>


<?php }
}
