 <script type="text/javascript" src="/js/browser/ajax.js"></script>
 <script type="text/javascript" src="/js/browser/browser.js"></script>
{debug}

<script type="text/javascript">
{literal}

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
                            data: {"path": utf8_to_b64(item.path), "project_id": {/literal} {$project->id} {literal} }//test with number value ok now how to use project id
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

{/literal}
</script>

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

{*
	<p class="pfilter">File types filter
		<input type="text" id="txtFilter" value=""/>
		<input type="button" value="Refresh" id="btnrefresh"/>
	</p>
*}
	<div class="row" >
		<div id="pPathDisplay" class="pPathDisplay" style="min-height:40px;padding-left:10px">Loading...</div>
	</div>
	<div class="row">
		<div id="dvContents" class="dvContents">&nbsp;</div>
	</div>
</div>


{* <script> browser_init(); </script> *}