
<ul class="tabs" data-tab>
    <li class="tab-title"><a href="#fileBrowser" onClick="browser_init();">Upload new sequence files</a></li>
    <li class="tab-title"><a href="#sampleAnnotation">Manage project descriptions</a></li>
    <li class="tab-title"><a href="#panel3">ChIP-seq Workflow</a></li>
    <li class="tab-title"><a href="#RNA-seq">RNA-seq Workflow</a></li>
    <li class="tab-title"><a href="#panel5">ChIP-seq and RNA-seq Integration</a></li>
</ul>

<div class="tabs-content">
    <div class="content" id="fileBrowser">
			{include file="users/projects_users/file_browser.tpl"}
    </div>
    <div class="content" id="sampleAnnotation">
        {include file="users/projects_users/samples.tpl"}
    </div>
    <div class="content" id="panel3">
        <p>This is the third panel of the basic tab example. This is the third panel of the basic tab example.</p>
    </div>
    <div class="content" id="RNA-seq">
        {include file="users/projects_users/RNA-seq.tpl"}
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

//-->