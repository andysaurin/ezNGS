<style>
.ui-draggable-dragging{
    box-shadow:0 0 2px #000;
}
.drop-hover {
	border:3px solid green;
}
.drop-active {
	border:3px solid orange;
}
.drop-hover-unassigned {
	background: rgba(222, 255, 226, 0.57)
}
.drop-active-unassigned {
	background: rgba(232, 232, 232, 0.5)
}

.sample_container {
	margin: 1px; padding:10px 0 0 0; border:1px solid rgba(226, 223, 223, 0.89);
}
.complete {
	background:#E6FFE8
}
.incomplete {
	background:#FFE6E6
}
.file {
	z-index:9999;
}
</style>

{debug}
<h2>Sequenced sample files</h2>

<fieldset>
    <legend>Description</legend>
    <div class="small-12 columns">

		<h4 class="subheader">Here, you will assign your imported sequence files into experimental samples.</h4>

		<ul class="no-bullet">
			<li>Imported and unassigned sequence files will appear in the left column.</li>
			<br>
			<li>If the sequenced sample has already been mapped to the genome :
				<ul class="no-bullet">
					<li>add the mapped BAM file to the "File 1" column (and leave the "File 2" column empty).</li>
				</ul>
			</li>
			<br>
			<li>If you have unmapped fastq sequence files for the sample :
				<ul class="circle">
					<li>If the sample was sequenced as <strong>single-end reads</strong>:
						<ul class="no-bullet">
							<li> drag a fastq sequence file into the "File 1" column (and leave the "File 2" column empty).</li>
						</ul>
					</li>
					<li>If the sample was sequenced as <strong>paired-end reads</strong>:
						<ul class="no-bullet">
								<li>  drag a fastq sequence file into the "File 1" column </li>
								<li> and it's paired/reverse fastq file into the "File 2" column.</li>
						</ul>
					</li>
				</ul>
			</li>

		</ul>

		<span class="radius label warning"><h5 style="color: white">Only files that have been attributed to samples will be available for use in the available workflows.</h5></span>

    </div>
</fieldset>

<form id="sample-attribution" action="/{$module}/{$class}/save_samples"  method="POST" autocomplete="off" >
	<input type="hidden" id="Project_id" name="project_id" value="{$project->id}">

<fieldset id="dragZone">
    <legend>Sample files</legend>

    <div class="small-3 columns">

		<fieldset>

			<legend>Unassigned files<br>(Drag to assign)</legend>

			<div class="row">

				<ul class="no-bullet" id="unassigned-files">

{foreach $unassigned_files as $id=>$file_obj}

<li id="div_id_{$file_obj->file_id}" class="unassigned-file-container unassigned-draggable text-center">&nbsp;<a id="file_id_{$file_obj->file_id}" fileID="{$file_obj->file_id}" class="file unassigned-draggable round label secondary" style="margin-left:10px"><i class="fi-page-export size-16"> {$file_obj->file_name}</i></a></li>
{/foreach}
{* create space for the assigned files in case we want to unassign the,m *}
{foreach $assigned_files as $id=>$file_obj}

<li id="div_id_{$file_obj->file_id}" class="unassigned-file-container unassigned-droppable text-center">&nbsp;</li>
{/foreach}

				</ul>
			</div>

		</fieldset>


    </div>


    <div class="small-9 columns">

		<fieldset>

			<legend>Samples {* <a href="#" title="Add New Sample" class="round label success" style="margin-left:10px"><i class="fi-plus size-16"> new sample</i></a> *}</legend>


			<div class="row">
			    <div class="small-3 columns text-center">
				    <strong>Sample Name</strong>
			    </div>
			    <div class="small-2 columns text-center">
				    <strong>Sample Type</strong>
			    </div>
			    <div class="small-3 columns text-center">
				     <strong>File 1</strong>
			    </div>
			    <div class="small-3 columns text-center">
				     <strong>File 2</strong>
			    </div>
			</div>
{assign var="num_samples" value=$sampletable|@count}

{if $num_samples > 0 }

{* the samples already saved in the database *}
{for $real_sample_number=1 to $sampletable|@count}
{assign var="sample_number" value=($real_sample_number-1)}{* human readable sample number - if we already have any *}
{assign var="sample_id" value=$sampletable[$sample_number]->sample_id}
{assign var="sample_name" value=$sampletable[$sample_number]->sample_name}
{assign var="sample_type" value=$sampletable[$sample_number]->sample_type}
{assign var="file_1_id" value=$sampletable[$sample_number]->file_1_id}
{assign var="file_1_name" value=$sampletable[$sample_number]->file_1_info->file_name}

{assign var="file_2_id" value=$sampletable[$sample_number]->file_2_id}
{assign var="file_2_name" value=$sampletable[$sample_number]->file_2_info->file_name}

			<div id="sample_{$sample_number}_container" sample_number="{$sample_number}" class="row sample_container complete">

				<input type="hidden" name="sample[{$sample_number}][sample_id]" value="{$sample_id}" />

			    <div class="small-3 columns">
				    <input class="sample_name_input" id="sample_{$sample_number}_name" name="sample[{$sample_number}][sample_name]" sample_number="{$sample_number}" type=text placeholder="sample {$real_sample_number} name here" value="{$sample_name}" />
			    </div>
			    <div class="small-2 columns">

					<select class="sample_type_selector" id="sample_{$sample_number}_type" name="sample[{$sample_number}][sample_type]" sample_number="{$sample_number}" >
{foreach $data_type_used as $data_type_key=>$data_type}

						<option value="{$data_type_key}"{if $sample_type == $data_type_key} selected {/if}>{$data_type}</option>
{/foreach}

					</select>

			    </div>
			    <div class="small-3 columns" id="dropzone_no" >
					<div class="drop text-center" id="sample_{$sample_number}_file_1_dropzone" style="padding:5px;" sample_number="{$sample_number}" >
				    	<input id="sample_{$sample_number}_file_1_id" name="sample[{$sample_number}][file_1_id]" value="{$file_1_id}" type=hidden />
{if $sampletable[$sample_number]->file_1_info->file_id > 0} {*only show the green label if we have an assigned file*}
<a id="file_id_{$file_1_id}" fileID="{$file_1_id}" class="file assigned-draggable round label success" style="margin-left:10px"><i class="fi-page-export size-16"> {$file_1_name}</i></a>
{/if}
				    	&nbsp;
				    </div>
			    </div>
			    <div class="small-3 columns">
					<div class="drop text-center" id="sample_{$sample_number}_file_2_dropzone" style="padding:5px;" sample_number="{$sample_number}" >
				    	<input id="sample_{$sample_number}_file_2_id" name="sample[{$sample_number}][file_2_id]" value="{$file_2_id}" type=hidden />
{if $sampletable[$sample_number]->file_2_info->file_id > 0} {*only show the green label if we have an assigned file*}
<a id="file_id_{$file_2_id}" fileID="{$file_2_id}" class="file assigned-draggable round label success" style="margin-left:10px"><i class="fi-page-export size-16"> {$file_2_name}</i></a>
{/if}
				    	&nbsp;
				    </div>
			    </div>
			</div>
{/for}
{else}
	{assign var="sample_number" value=0}
{/if}


{*sample placeholders for files not yet assigned*}
{assign var="num_assigned_samples" value = $sampletable|@count} {*how many samples have all ready been assigned *}

{for $real_sample_number=1 to $unassigned_files|@count}

{assign var="sample_number" value=($num_assigned_samples+$real_sample_number)}{* human readable sample number - if we already have  *}

{* 			<div class="row" style="margin: 1px; padding:10px 0 0 0; border:1px solid rgba(226, 223, 223, 0.89);background:rgba(171, 255, 0, 0.06)"> *}
			<div id="sample_{$sample_number}_container" sample_number="{$sample_number}" class="row sample_container incomplete">
{* we are going to have as many new sample fields as there are unassigned files *}

				<input type="hidden" name="sample[{$sample_number}][sample_id]" value="" /> {*new samples won't yet have an ID attributed*}

			    <div class="small-3 columns">
				    <input class="sample_name_input" id="sample_{$sample_number}_name" name="sample[{$sample_number}][sample_name]" type=text placeholder="sample {$sample_number} name here" sample_number="{$sample_number}" />
			    </div>
			    <div class="small-2 columns">

					<select class="sample_type_selector" id="sample_{$sample_number}_type" name="sample[{$sample_number}][sample_type]"  sample_number="{$sample_number}">
{foreach $data_type_used as $data_type_key=>$data_type}

						<option value="{$data_type_key}">{$data_type}</option>
{/foreach}

					</select>

			    </div>
			    <div class="small-3 columns" id="dropzone_no" >
					<div class="drop" id="sample_{$sample_number}_file_1_dropzone" style="padding:5px;" sample_number="{$sample_number}" >
				    	<input id="sample_{$sample_number}_file_1_id" name="sample[{$sample_number}][file_1_id]" value="" type=hidden />
				    	&nbsp;
				    </div>
			    </div>
			    <div class="small-3 columns">
					<div class="drop" id="sample_{$sample_number}_file_2_dropzone" style="padding:5px;" sample_number="{$sample_number}" >
				    	<input id="sample_{$sample_number}_file_2_id" name="sample[{$sample_number}][file_2_id]"  value="" type=hidden />
				    	&nbsp;
				    </div>
			    </div>
			</div>
{/for}

		</fieldset>

    </div>

	<div class="row text-center">
		<input id="form_submit" name="form_submit" class="button small round" type="submit" value="Submit Samples" />
	</div>

</fieldset>
</form>

<script>

$(document).ready(function() {

	var is_sample_assigned = function( sample_number ) {
		/* verifies whether a sample has been fully filled in upon form interaction. If so, turns the background green. If not, background red */

		var incomplete = 0; //any missing required field will set this value to 1

		var sample_name = $("#sample_"+sample_number+"_name").val();
		var sample_type = $("#sample_"+sample_number+"_type").val();
		var sample_file_1_id = $("#sample_"+sample_number+"_file_1_id").val();
		var sample_file_2_id = $("#sample_"+sample_number+"_file_2_id").val();

		if ( sample_name.length < 1 || sample_type < 1 || ( sample_file_1_id < 1 && sample_file_2_id < 1) ) {
			incomplete = 1;
		}

		if ( incomplete != 0 ) {

			if ( $("#sample_"+sample_number+"_container").hasClass("complete") ) {
				$("#sample_"+sample_number+"_container").removeClass("complete").addClass("incomplete");
			}

		} else {

			if ( $("#sample_"+sample_number+"_container").hasClass("incomplete") ) {
				$("#sample_"+sample_number+"_container").removeClass("incomplete").addClass("complete");
			}

		}

/*
		console.log("sample_number["+sample_number+"][sample_name] = "+sample_name);
		console.log("sample_number["+sample_number+"][sample_type] = "+sample_type);
		console.log("sample_number["+sample_number+"][sample_file_1_id] = "+sample_file_1_id);
		console.log("sample_number["+sample_number+"][sample_file_2_id] = "+sample_file_2_id);
*/

	}

	$(".sample_type_selector").change(function() {
		is_sample_assigned( $(this).attr("sample_number") );
	});
	$(".sample_name_input").change(function() {
		is_sample_assigned( $(this).attr("sample_number") );
	});

	//droppable drop function
	var dropFn = function(event, ui) {

		var dropped = ui.draggable;
		var droppedOn = $(this);
		var parent = $(dropped).parent();


		//remove the dropped element from the draggable DOM and add to the droppedOn DOM, making it again draggable. Without this, the dragged element loses the ability to be dragged
		$(dropped).detach().css("top", 0).css("left", 0).appendTo(droppedOn);

		//center the dropped element in the droppedOn element
		$(dropped).position({
			my: "center",
			at: "center",
			of: $(droppedOn),
			using: function(pos) {
				$(this).animate(pos, 200, "linear");
			}
		});

		/***
		Handlers for the dropped element
		***/

		//if the dropped element was grey, make it green
		if ( $(dropped).hasClass("secondary") ) {
			$(dropped).removeClass("secondary").addClass("success");
		}
		//if the dropped element was green and it's come back to the unassigned-file-container, make it grey
		if ( $(dropped).hasClass("success") ) {

			if ( $(droppedOn).hasClass("unassigned-file-container") ) {
				$(dropped).removeClass("success").addClass("secondary");
			}
		}
		//if the dropped element was an unassigned file, assign it to the "assigned-draggable" class
		if ( $(dropped).hasClass("unassigned-draggable") ) {
			$(dropped).removeClass("unassigned-draggable").addClass("assigned-draggable");
		}


		/***
		Handlers for the dropped parent element
		***/

		if ( $(parent).hasClass("drop") ) { // the parent is a sample file selection element, not the unassigned files column

			// the parent is a sample file selection element (ie we removed a file from the sample), so we need to reset it's file_id value
			$(parent).find('input').val("");

			$(droppedOn).droppable( 'enable' );
			$(parent).droppable( 'enable' );

			var sample_number = $(parent).attr('sample_number');
			is_sample_assigned( sample_number );


/*
classList = $(parent).attr('class').split(/\s+/);
$.each(classList, function(index, item) {
console.log("Drop Parent class: "+item);
});
*/

		} else { // the parent is the unassigned files column

/*
classList = $(parent).attr('class').split(/\s+/);
$.each(classList, function(index, item) {
console.log("Unassigned Parent class: "+item);
});
*/
			if ( $(parent).hasClass("unassigned-droppable") ) {
				//the parent was already made droppable, so inactivate it
				$(parent).removeClass("unassigned-droppable").addClass("unassigned-draggable");
				$(parent).droppable( 'enable' );

			} else {
				//make it droppable
				$(parent).removeClass("unassigned-draggable").addClass("unassigned-droppable");

				if ( $(parent).hasClass("ui-droppable-disabled") ) {
					$(parent).droppable( 'enable' );

				} else {
					$(parent).droppable({
						activeClass: "drop-active-unassigned",
						accept: ".assigned-draggable",
				        over: function(event, elem) {
					    	$(this).addClass("drop-hover-unassigned");
					    	$(this).removeClass("drop-active-unassigned");
					    },
					    out: function(event, elem) {
					    	$(this).removeClass("drop-hover-unassigned");
					    	$(this).addClass("drop-active-unassigned");
					    },
				        snap: true,
						drop: dropFn,
					});
				}
			}

		}


		/***
		Handlers for the dropped on element
		***/

		if ( $(droppedOn).hasClass("drop-hover") ) {
			$(droppedOn).removeClass("drop-hover");
		}
		if ( $(droppedOn).hasClass("drop-hover-unassigned") ) {
			$(droppedOn).removeClass("drop-hover-unassigned");
		}
		if ( $(droppedOn).hasClass("drop") ) { //the dropped on element is a sample file dropzone (eg not the unassigned file list)

			//console.log( "droppedOn hidden ID: "+$(droppedOn).find('input').attr('id'));
			//console.log( "droppedOn hidden val pre-drop: "+$(droppedOn).find('input').val() );

			var fileID = $(dropped).attr('fileID');
			$(droppedOn).find('input').val( fileID );

/*
			console.log( "droppedOn hidden val post-drop: "+$(droppedOn).find('input').val() );
			console.log( "droppedOn ID: "+$(droppedOn).attr('id' ) );
			console.log( "droppedOn sample_number: "+$(droppedOn).attr('sample_number' ) );
*/

			var sample_number = $(droppedOn).attr('sample_number');
			is_sample_assigned( sample_number );

			if ( $(parent).hasClass("drop") ) { //the parent was also a sample file dropzone

			}
		}

		$(droppedOn).droppable( 'disable' );
/*
classList = $(droppedOn).attr('class').split(/\s+/);
$.each(classList, function(index, item) {
console.log("Dropped on element class: "+item);
});
*/
	};


	$('.unassigned-draggable').draggable({
		revert: 'invalid',
		//revert: true,
		cursor: 'move'
	});

	$('.assigned-draggable').draggable({
		revert: 'invalid',
		cursor: 'move'
	});

	$('.drop').droppable({

		accept: ".unassigned-draggable .assigned-draggable .unassigned-droppable",
		activeClass: "drop-active",
        over: function(event, elem) {
	    	$(this).addClass("drop-hover");
	    	$(this).removeClass("drop-active");
	    },
	    out: function(event, elem) {
	    	$(this).removeClass("drop-hover");
	    	$(this).addClass("drop-active");
	    },
        snap: true,
		drop: dropFn,
		accept: function(dropElem) {
			//dropElem was the dropped element, return true accept it
			return true;
		}
    });

	$(".unassigned-droppable").droppable({

		accept: ".assigned-draggable",
		activeClass: "drop-active-unassigned",
        over: function(event, elem) {
	    	$(this).addClass("drop-hover-unassigned");
	    	$(this).removeClass("drop-active-unassigned");
	    },
	    out: function(event, elem) {
	    	$(this).removeClass("drop-hover-unassigned");
	    	$(this).addClass("drop-active-unassigned");
	    },
        snap: true,
		drop: dropFn,
	});

	/* doeasn't work
	$('#unassigned-files').sortable();
	*/

});

</script>