<?php
/* Smarty version 3.1.29, created on 2016-10-27 18:22:38
  from "/home/lucie/amidex/templates/default/templates/users/projects_users/RNA-seq.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_581229ce267069_07603164',
  'file_dependency' => 
  array (
    'c11ebdacf7df01dc792394224975c26e487e8793' => 
    array (
      0 => '/home/lucie/amidex/templates/default/templates/users/projects_users/RNA-seq.tpl',
      1 => 1477578731,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_581229ce267069_07603164 ($_smarty_tpl) {
?>
<h2>Sample grouping</h2>
<?php $_smarty_debug = new Smarty_Internal_Debug;
 $_smarty_debug->display_debug($_smarty_tpl);
unset($_smarty_debug);
?>

<form id="form-define-groups" action="/<?php echo $_smarty_tpl->tpl_vars['module']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['class']->value;?>
/define_groups" method="POST">

    <fieldset>
        <legend>Group definitions</legend>
        <div class="large-5 columns left">

            <div class=" row left">
                <div class="medium-2 columns">
                    <label for="Project_id"class="right inline">Project_id</label>
                </div>
                <div class="small-3 columns">
                    <input type="text" id="Project_id" name="project_id" value="<?php echo $_smarty_tpl->tpl_vars['project']->value->id;?>
" readonly>
                </div>
            </div>

        <table id="group_definition">
            <tr>
                <th>Group_name</th>
                <th>Group_description</th>
            </tr>
            <tr id="group_definition_clone">
                <td class="small-2 Group_name"><input id="Group_name" class="input_without_space" type="text" name="Group_name[]" /></td>
                <td class="large-9 Group_description"><input id="Group_description" class="input_with_space" type="text" name="Group_description[]" /></td>
                <td class="small-1" id="action"><a href="#!" id="deleteLine" class="inline">Delete this line</a>
            </tr>
            <tr id="group_definition1">
                <td class="small-2 Group_name"><input id="Group_name1" class="input_without_space" type="text" name="Group_name[]" /></td>
                <td class="large-9 Group_description"><input id="Group_description1" class="input_with_space" type="text" name="Group_description[]" /></td>
                <td class="small-1" id="action"><a href="#!" id="deleteLine" class="inline">Delete this line</a>
            </tr>
            <tfoot>
            <tr>
                <td><a href="#!" id="add_group"> Add Group</a></td>
            </tr>
            </tfoot>
        </table>
        </div>

        <div class="large-7 columns rigth ">

        <p>This part is devoted to the definition of "groups". Whatever the type of data samples corresponding to a group, a condition.
            In RNA-seq there are different conditions such as "KOnameGene" or "WildType". A sample can belong to several groups.
            Please choose the name of groups wisely, without blankspace.</p>
        </div>

    </fieldset>
    <input class="button small round" type="submit" value="Save new(s) group(s)" />
</form>


<?php if (count($_smarty_tpl->tpl_vars['rna_groups']->value) > 0) {?>
    <fieldset>
        <legend>Groups available</legend>
        <div class="large-12 columns left">

            <table id="group_available">
                <tr>
                    <th>Group_ID</th>
                    <th>Group_name</th>
                    <th>Group_description</th>
                </tr>
                <tr id="group_available_clone">
                    <td class="large-2 Group_ID_available"><input id="Group_ID_availble" class="input_without_space" type="text" name="Group_ID_available[]" readonly/></td>
                    <td class="large-2 Group_name_available"><input id="Group_name_availble" class="input_without_space" type="text" name="Group_name_available[]" readonly/></td>
                    <td class="large-8 Group_description_available"><input id="Group_description_available" class="input_with_space" type="text" name="Group_description_available[]" readonly/></td>
                    <td id="action"><a href="#!" id="deleteGroup" class="inline">Delete this Group</a>
                </tr>
                <tr id="group_definition_available1">
                    <td class="large-2 Group_ID_available"><input id="Group_ID_availble" class="input_without_space" type="text" name="Group_ID_available[]" readonly/></td>
                    <td class="large-2 Group_name_available"><input id="Group_name_available1" class="input_without_space" type="text" name="Group_name_available[]" readonly/></td>
                    <td class="large-8 Group_description_available"><input id="Group_description_available1" class="input_with_space" type="text" name="Group_description_available[]" readonly/></td>
                    <td id="action"><a href="#!" id="deleteGroup" class="inline">Delete this Group</a>
                </tr>
            </table>

        </div>
    </fieldset>
<?php }
if ($_smarty_tpl->tpl_vars['all_annotations']->value && count($_smarty_tpl->tpl_vars['rna_groups']->value) > 0) {?>
<form id="form-assignation-groups" action="/<?php echo $_smarty_tpl->tpl_vars['module']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['class']->value;?>
/save_assignation" method="POST">
    <fieldset>
        <legend>Sample-Group assignation</legend>

            <div class="small-1 columns">
                <label for="Project_id"class="right inline">Project_id</label>
            </div>
            <div class="small-1 columns">
                <input type="text" id="Project_id" name="project_id" value="<?php echo $_smarty_tpl->tpl_vars['project']->value->id;?>
" readonly>
            </div>

        <table id="group_assignation">
            <tr>
                <th>md5sum</th>
                <th>Sample_name</th>
                <th>Groups_available</th>
            </tr>
            <tr id="group_assignation_clone">
                <td class="md5sum2"><input id="md5sum" type="text" name="rna_groups_assignation[md5sum][]" readonly/></td>
                <td class="Sample_name2"><input id="Sample_name" type="text" name="rna_groups_assignation[Sample_name][]" readonly/></td>
                <td class="Groups_available2"></td>
            </tr>
            <tr id="group_assignation1">
                <td class="md5sum2"><input id="md5sum1" type="text" name="rna_groups_assignation[md5sum][]" readonly/></td>
                <td class="Sample_name2"><input id="Sample_name1" type="text" name="rna_groups_assignation[Sample_name][]" readonly/></td>
                <td class="Groups_available2"></td>
            </tr>

        </table>


    </fieldset>
    <input class="button small round" type="submit" value="Save Assignation" />
</form>
<?php }?>


<?php if (count($_smarty_tpl->tpl_vars['rna_group_already_assignated']->value) > 0) {?>
    <form id="form-rna_design" action="/<?php echo $_smarty_tpl->tpl_vars['module']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['class']->value;?>
/save_design" method="POST">
<fieldset>
    <legend>Design description</legend>

    <p>Select groups/conditions you want to analyze, if some are not available it's because they are not associated with any sample.</p>

        <div class="medium-2 left">

            <table id="desing_rna">
                <tr>
                    <th>Group_name</th>
                </tr>
                <tr id="group_available_design_clone">
                    <td class="small-3 Group_name_available_design"><input id="Group_name_availble_design" class="input_without_space" type="text" name="Group_name_available[]" readonly/></td>
                </tr>
                <tr id="group_available_design1">
                    <td class="small-3 Group_name_available_design"><input id="Group_name_available_design" class="input_without_space" type="text" name="Group_name_available[]" readonly/></td>
                </tr>
            </table>

        </div>

        <div class="medium-8 right">
            <h3>Design analysis</h3>

            <p>Complete the table with RNA-seq analysis you want to perform. Example: CondA/CondB write "CondA" in Group reference and "CondB" in Group test.</p>

            <div class="small-1 columns">
                <label for="Project_id"class="right inline">Project_id</label>
            </div>
            <div class="small-1 columns">
                <input type="text" id="Project_id" name="project_id" value="<?php echo $_smarty_tpl->tpl_vars['project']->value->id;?>
" readonly>
            </div>

            <table id="design_rna">
                <tbody>
                <tr>
                    <th>Group reference</th>
                    <th>Group test</th>

                </tr>
                <tr id="rna_design_clone">
                    <td class="small-4 Group_name_availble_ref_design"><input id="Group_name_availble_ref_design" class="input_without_space" type="text" name="Group_reference[]" /></td>
                    <td class="small-4 Group_name_availble_test_design"><input id="Group_name_availble_test_design" class="input_without_space" type="text" name="Group_test[]" /></td>
                    <td id="action"><a href="#!" id="deleteAnalysis" class="inline">Delete this analysis</a>

                </tr>
                <tr id="rna_design1">
                    <td class="small-4 Group_name_availble_ref_design"><input id="Group_name_available_ref_design1" class="input_without_space" type="text" name="Group_reference[]" /></td>
                    <td class="small-4 Group_name_availble_test_design"><input id="Group_name_availble_test_design1" class="input_without_space" type="text" name="Group_test[]" /></td>
                    <td id="action"><a href="#!" id="deleteAnalysis" class="inline">Delete this analysis</a>

                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="5"><a href="#!" id="addAnalysis">Add a analysis</a></th>
                </tr>
                </tfoot>
            </table>

        </div>

</fieldset>
<input class="button small round" type="submit" value="Save Design" />
    </form>
<?php }?>

<?php if (count($_smarty_tpl->tpl_vars['design_rna']->value) > 0) {?>
<form id="form-rna_design_write_sample_file" action="/<?php echo $_smarty_tpl->tpl_vars['module']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['class']->value;?>
/write_sample_rna" method="POST">

<fieldset>
    <legend>Sample To analyse</legend>

    <div class="small-1 columns">
        <label for="Project_id"class="right inline">Project_id</label>
    </div>
    <div class="small-1 columns">
        <input type="text" id="Project_id" name="project_id" value="<?php echo $_smarty_tpl->tpl_vars['project']->value->id;?>
" readonly>
    </div>

    <table id="sample_to_analyse">
        <tr>
            <th>md5sum/ID</th>
            <th>Sample_name</th>
            <th>Groups_associated</th>
        </tr>
        <tr id="sample_to_analyse_clone">
            <td class="md5sum3"><input id="md5sum_sample_to_analyse" type="text" name="sample_to_analyse[]" readonly/></td>
            <td class="Sample_name3"><input id="Sample_name_sample_to_analyse" type="text" name="sample_to_analyse[]" readonly/></td>
            <td class="Groups_associated"><input id="Groups_associated_sample_to_analyse" type="text" name="sample_to_analyse[]" readonly/></td>
        </tr>

    </table>

</fieldset>
    <input class="button small round" type="submit" value="Validate" />
</form>
<?php }?>

<?php if (count($_smarty_tpl->tpl_vars['design_rna']->value) > 0) {?>

<form id="form-rna_Workflow_design" action="/<?php echo $_smarty_tpl->tpl_vars['module']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['class']->value;?>
/save_rna_config"  method="POST">
    <fieldset>
        <legend>Design the workflow</legend>

        <div class="row left">
            <div class="medium-2 columns">
                <label for="Project_id"class="right inline">Project_id</label>
            </div>
            <div class="small-3 columns">
                <input type="text" id="Project_id" name="project_id" value="<?php echo $_smarty_tpl->tpl_vars['project']->value->id;?>
" readonly>
            </div>
        </div>

       

        <fieldset class="large-12">
            <legend>Genome</legend>

            <div class="row left">
                <div class="large-1 columns">
                    <label for="organism" class="right inline"><span data-tooltip aria-haspopup="true" class="has-tip" title="Organism's name">Organism</span></label>
                </div>
                <div class="large-11 columns">
                    <input type="text" id="organism" name="genome[organism]" value="">
                </div>
            </div>

            <div class=" row left">
                <div class="large-1 columns">
                    <label for="version" class="right inline"><span data-tooltip aria-haspopup="true" class="has-tip" title="version's name">Version</span></label>
                </div>
                <div class="large-11 columns">
                    <input type="text" id="version" name="genome[version]" value="">
                </div>
            </div>

            <div class=" row left">
                <div class="large-1 columns">
                    <label for="size" class="right inline"><span data-tooltip aria-haspopup="true" class="has-tip" title="genome's size">Size</span></label>
                </div>
                <div class="large-11 columns">
                    <input type="text" id="size" name="genome[size]" value="">
                </div>
            </div>

            <div class=" row left">
                <div class="large-1 columns">
                    <label for="fasta_file" class="right inline"><span data-tooltip aria-haspopup="true" class="has-tip" title="fasta_file's name">fasta_file</span></label>
                </div>
                <div class="large-11 columns">
                    <input type="text" id="fasta_file" name="genome[fasta_file]" value="">
                </div>
            </div>

            <div class=" row left">
                <div class="large-1 columns">
                    <label for="gff3_file" class="right inline"><span data-tooltip aria-haspopup="true" class="has-tip" title="gff3_file's name">gff3_file</span></label>
                </div>
                <div class="large-11 columns">
                    <input type="text" id="gff3_file" name="genome[gff3_file]" value="">
                </div>
            </div>

            <div class=" row left">
                <div class="large-1 columns">
                    <label for="gtf_file" class="right inline"><span data-tooltip aria-haspopup="true" class="has-tip" title="gtf_file's name">gtf_file</span></label>
                </div>
                <div class="large-11 columns">
                    <input type="text" id="gtf_file" name="genome[gtf_file]" value="">
                </div>
            </div>

        </fieldset>

        <fieldset class="large-12">
            <legend>Metadata</legend>

            <div class=" row left">
                <div class="large-1 columns">
                    <label for="seq_type" class="right inline"><span data-tooltip aria-haspopup="true" class="has-tip" title="seq_type's name">seq_type</span></label>
                </div>
                <div class="large-11 columns">

                    <select id="seq_type" name="metadata[seq_type]">
                        <option id="Single-end" value="se">Single-End</option>
                        <option id="Paired-end" value="pe">Paired-End</option>
                    </select>

                </div>
            </div>

        </fieldset>

<?php if (count($_smarty_tpl->tpl_vars['tools_available']->value) > 0) {?>
        <fieldset class="large-12" id="tools_available">
            <legend>Tools Available</legend>
        </fieldset>
<?php }?>

        <fieldset class="large-12" id="tools_available">
            <legend>Set parameters</legend>
            
            <input class="button large" type="submit" value="Use default parameters" />
            <a href="#" class="button large">set parameters</a>

        </fieldset>

        <input class="button small round" type="submit" value="Validate" />
</form>
    </fieldset>
<?php }
echo '<script'; ?>
>
    
    
    $(document).ready(function() {
        
        /*Javascript function for the delete line possibility in the Group definitions table*/
        $("#group_definition").on("click","#deleteLine",function () {
            $(this).parents().eq(1).remove();
        });

        /*Javascript function for the delete analysis possibility in the Design analysis table*/
        $("#design_rna").on("click","#deleteAnalysis",function () {
            $(this).parents().eq(1).remove();
        });

        /*Javascript function for the delete group possibility in the group_available table*/
        $("#group_available").on("click","#deleteGroup",function () {

            //Find a way to delete in the database this group a AJAX request ?
            //But before need to have some info
            //$(this).parents().eq(1).children().first().children().first().css( "background", "yellow" );
            var $Group_id = $(this).parents().eq(1).children().first().children().first().val();

            $.ajax({
                type:"POST",
                url: " /users/projects_users",
                data: {"group_id": $Group_id, "project_id":   <?php echo $_smarty_tpl->tpl_vars['project']->value->id;?>
  }
            });
            $(this).parents().eq(1).remove();
//            location.reload();
        });

        /*Javascript function for the Add group possibility in the group definition table*/
        $indexGroup = 1;
        $("#group_definition").on("click","#add_group",function () {
            $indexGroup++;
            var $newTr = $("#group_definition_clone").clone().attr("id", "group_definition"+ $indexGroup);
            $newTr.find("input").each(function() {
                $(this).val('').attr("id",function(_, id) { return id + $indexGroup });
            }).end().appendTo("#group_definition");
        });

        /*Javascript function for the Add a analysis possibility in the design_rna table*/
        $indexAnalysis = 1;
        $("#design_rna").on("click","#addAnalysis",function () {
            $indexAnalysis++;
            var $newTr = $("#rna_design_clone").clone().attr("id", "rna_design"+ $indexAnalysis);
            $newTr.find("input").each(function() {
                $(this).val('').attr("id",function(_, id) { return id + $indexAnalysis });
            }).end().appendTo("#design_rna");
        });

        function loadGroupAvailable(){

            var tableId = <?php echo json_encode($_smarty_tpl->tpl_vars['rna_groups']->value);?>
;
            var $indexSample = 0;
            //first create lines
            var $numberOfLineToAdd = tableId.length -1 ;
            while ($numberOfLineToAdd != 0) {
                $indexSample++;
                var $newTr = $("#group_available tr:eq(1)").clone().attr("id", "group_definition_available" + $indexSample);
                $newTr.find("input").each(function () {
                    $(this).val('').attr("id", function (_, id) {
                        return id + $indexSample
                    });
                }).end().appendTo("#group_available");

                $numberOfLineToAdd--;
            }
            //Fill these lines
            var indexFile = 0;
            $("td.Group_ID_available input:not(td.Group_ID_available input:eq(0))").each(function(){
                $(this).val(tableId[indexFile]["group_id"]);
                $(this).attr("placeholder",tableId[indexFile]["group_id"]);
                $(this).attr("value",tableId[indexFile]["group_id"]);
                indexFile++;
            });
            var indexFile = 0;
            $("td.Group_name_available input:not(td.Group_name_available input:eq(0))").each(function(){
                $(this).val(tableId[indexFile]["group_name"]);
                $(this).attr("placeholder",tableId[indexFile]["group_name"]);
                $(this).attr("value",tableId[indexFile]["group_name"]);
                indexFile++;
            });
            var indexFile = 0;
            $("td.Group_description_available input:not(td.Group_description_available input:eq(0))").each(function(){
                $(this).val(tableId[indexFile]["group_description"]);
                $(this).attr("value",tableId[indexFile]["group_description"]);
                $(this).attr("placeholder",tableId[indexFile]["group_description"]);
                indexFile++;
            });

        };

        function loadDesignRnaAlreadyDefined() {
            var designTable = <?php echo json_encode($_smarty_tpl->tpl_vars['design_rna']->value);?>
;
            //console.log(designTable.length);
            var $indexSample = 0;
            //first create lines
            var $numberOfLineToAdd = designTable.length -1 ;
            while ($numberOfLineToAdd != 0) {
                $indexSample++;
                var $newTr = $("#rna_design_clone").clone().attr("id", "rna_design" + $indexSample);
                $newTr.find("input").each(function () {
                    $(this).val('').attr("id", function (_, id) {
                        return id + $indexSample
                    });
                }).end().appendTo("#design_rna");

                $numberOfLineToAdd--;
            }
            //Fill these lines
            var indexFile = 0;
            $("td.Group_name_availble_ref_design input:not(td.Group_name_availble_ref_design input:eq(0))").each(function(){
                $(this).val(designTable[indexFile][0]);
                $(this).attr("placeholder",designTable[indexFile][0]);
                $(this).attr("value",designTable[indexFile][0]);
                indexFile++;
            });
            var indexFile = 0;
            $("td.Group_name_availble_test_design input:not(td.Group_name_availble_test_design input:eq(0))").each(function(){
                $(this).val(designTable[indexFile][1]);
                $(this).attr("value",designTable[indexFile][1]);
                $(this).attr("placeholder",designTable[indexFile][1]);
                indexFile++;
            });

        }

        function loadFileRNA(){

            var AllFile = <?php echo $_smarty_tpl->tpl_vars['all_annotations']->value;?>
;
            var tableId2 = new Array;
            var $indexSample2 = 1;
            for (var $key1 in AllFile) {
                for (var $key2 in AllFile[$key1]) {
                    var $Index = 0;
                    if (Array.isArray(AllFile[$key1][$key2])) {
                        for (var $key3 in AllFile[$key1][$key2]) {

                            if (AllFile[$key1][$key2][$key3] == "RNA-seq") {
                                //tableId2[$Compteur] = AllFile[$key1][$key2];
                                //console.log(tableId2[$Compteur]);
                                var tabInter = new Array;
                                for(var oneCol in AllFile["Samples_information"] ){
                                    tabInter[oneCol]=AllFile["Samples_information"][oneCol][$Index];
                                    //console.log(oneCol);
                                }
                                tableId2.push(tabInter);

                            }
                            $Index++;
                        }
                    }
                }
            }

            var $indexSample2 = 1;
            //first create lines
            var $numberOfLineToAdd = tableId2.length -1 ;
            //console.log($numberOfLineToAdd);
            while ($numberOfLineToAdd != 0) {
                $indexSample2++;
                var $newTr = $("#group_assignation tr:eq(1)").clone().attr("id", "group_assignation" + $indexSample2);
                $newTr.find("input").each(function () {
                    $(this).val('').attr("id", function (_, id) {
                    return id + $indexSample2
                    });
                }).end().appendTo("#group_assignation");

             $numberOfLineToAdd--;
             }
             //Fill these lines
             var indexFile = 0;
             $("td.md5sum2 input:not(td.md5sum2 input:eq(0))").each(function(){
             $(this).val(tableId2[indexFile]["md5sum"]);
             $(this).attr("placeholder",tableId2[indexFile]["md5sum"]);
             $(this).attr("value",tableId2[indexFile]["md5sum"]);
             indexFile++;
             });

             var indexFile = 0;
             $("td.Sample_name2 input:not(td.Sample_name2 input:eq(0))").each(function(){
             $(this).val(tableId2[indexFile]["Sample_name"]);
             $(this).attr("value",tableId2[indexFile]["Sample_name"]);
             $(this).attr("placeholder",tableId2[indexFile]["Sample_name"]);
             indexFile++;
             });
         };

        function loadAndPushGroupsAvailable(){
            var AllFile = <?php echo $_smarty_tpl->tpl_vars['all_annotations']->value;?>
;
            var tableId2 = new Array;
            var $indexSample2 = 1;
            for (var $key1 in AllFile) {
                for (var $key2 in AllFile[$key1]) {
                    var $Index = 0;
                    if (Array.isArray(AllFile[$key1][$key2])) {
                        for (var $key3 in AllFile[$key1][$key2]) {

                            if (AllFile[$key1][$key2][$key3] == "RNA-seq") {
                                //tableId2[$Compteur] = AllFile[$key1][$key2];
                                //console.log(tableId2[$Compteur]);
                                var tabInter = new Array;
                                for(var oneCol in AllFile["Samples_information"] ){
                                    tabInter[oneCol]=AllFile["Samples_information"][oneCol][$Index];
                                    //console.log(oneCol);
                                }
                                tableId2.push(tabInter);

                            }
                            $Index++;
                        }
                    }
                }
            }

            var tableGroupsDefined=<?php echo json_encode($_smarty_tpl->tpl_vars['rna_groups']->value);?>
;

            tableGroupsDefined.forEach(function (entry) {
                for (var i=0; i < tableId2.length; i++){
                    //console.log(i);
                    var name = "rna_groups_assignation[" + tableId2[i]["md5sum"] +"][]";
                    //console.log(name);
                    var selectTd = "td.Groups_available2:eq("+(i+1)+")";
                    //console.log(selectTd);
                    $(selectTd).append('<input type=checkbox name=' + name +' value=' + entry["group_name"] + '>' + entry["group_name"] );
                 }
             });
        }

        function load_tools_available_RNA() {
            var toolsAvailableRNATable = <?php echo json_encode($_smarty_tpl->tpl_vars['tools_available']->value);?>
;
//            console.log(toolsAvailableRNATable["RNA-seq"]);

            for (var $key1 in toolsAvailableRNATable){
//                console.log($key1);
                if ($key1 == "RNA-seq"){
//                console.log($key1);
                    for (var $key2 in toolsAvailableRNATable[$key1]){
//                        console.log($key2);
                        $("#tools_available").append("<div id='" + $key2 +"'></div>" );
                        $("#" + $key2).append("<h3>" + $key2 + "</h3>");
                        for (var $key3 in toolsAvailableRNATable[$key1][$key2]){
                            var nameTool = toolsAvailableRNATable[$key1][$key2][$key3]
                            $("#" + $key2).append("<input type=checkbox name=" + $key2 + "[]" + " value=" + nameTool + ">" + nameTool );
                        }

                    }

                }
            }
        }


        function loadSummaryDesign() {
            var designTable = <?php echo json_encode($_smarty_tpl->tpl_vars['design_rna']->value);?>
;
            /*store each group in an array*/
            var SummaryDesign = new Array;

            designTable.forEach(function (entry) {
                entry.forEach(function (cond) {
                    //console.log(cond);
                    SummaryDesign.push(cond);
                })
            });

            $.unique(SummaryDesign);
            //console.log(SummaryDesign);
            var AllFileAlreadyAssignated = <?php echo json_encode($_smarty_tpl->tpl_vars['rna_group_already_assignated']->value);?>
;

            var $compteur = 1;
            AllFileAlreadyAssignated.forEach(function (file) {
                //console.log(file["group_name"]);
                if ($.inArray(file["group_name"], SummaryDesign)>=0){
                    //console.log($.inArray(file["group_name"], SummaryDesign ));
                    //console.log(file["group_name"]);

                    //Add line
                    var $newTr = $("#sample_to_analyse tr:eq(1)").clone().attr("id", "sample_to_analyse" + $compteur);
                    $newTr.find("input").each(function () {
                        $(this).val('').attr("id", function (_, id) {
                            return id + $compteur
                        });
                        $(this).val('').attr("name", function (_, id) {
                            id_inter = id.split("[");
                            return id_inter[0] + $compteur  + "[]";
                        });
                    }).end().appendTo("#sample_to_analyse");

                    $("#md5sum_sample_to_analyse" + $compteur).val(file["md5sum"]);
                    $("#md5sum_sample_to_analyse" + $compteur).attr("placeholder",file["md5sum"]);

                    $("#Sample_name_sample_to_analyse" + $compteur).val(file["file_name"]);
                    $("#Sample_name_sample_to_analyse" + $compteur).attr("placeholder",file["file_name"]);

                    $("#Groups_associated_sample_to_analyse" + $compteur).val(file["group_name"]);
                    $("#Groups_associated_sample_to_analyse" + $compteur).attr("placeholder",file["group_name"]);

                    $compteur++;
                }
            });

        }

        function loadAssignation() {
            var AllFileAlreadyAssignated = <?php echo json_encode($_smarty_tpl->tpl_vars['rna_group_already_assignated']->value);?>
;

            AllFileAlreadyAssignated.forEach(function (entry) {
                var name= "rna_groups_assignation[" + entry["md5sum"] +"][]";
                var value= entry["group_name"];
                $("[name ='" + name + "'][value='"+value+"']").prop( "checked", true );
                //console.log(name);
            });


        }

        function loadAssignationAndSetDesign() {
            //$("#desing_rna")
            var AllFileAlreadyAssigned = <?php echo json_encode($_smarty_tpl->tpl_vars['rna_group_already_assignated']->value);?>
;
            var AllGroupsAssigned = new Array;

            AllFileAlreadyAssigned.forEach(function (entry) {
                AllGroupsAssigned.push(entry["group_name"]);
            });

            var AllGroupsAssignedUnique = new Array;
            AllGroupsAssignedUnique = $.unique(AllGroupsAssigned);

            var $indexSample2 = 1;
            //first create lines
            var $numberOfLineToAdd = AllGroupsAssignedUnique.length -1 ;
            //console.log($numberOfLineToAdd);
            while ($numberOfLineToAdd != 0) {
                $indexSample2++;
                var $newTr = $("#desing_rna tr:eq(1)").clone().attr("id", "group_available_design" + $indexSample2);
                $newTr.find("input").each(function () {
                    $(this).val('').attr("id", function (_, id) {
                        return id + $indexSample2
                    });
                }).end().appendTo("#desing_rna");

                $numberOfLineToAdd--;
            }
            //Fill these lines
            var indexFile = 0;
            $("td.Group_name_available_design input:not(td.Group_name_available_design input:eq(0))").each(function(){
                $(this).val(AllGroupsAssignedUnique[indexFile]);
                $(this).attr("placeholder",AllGroupsAssignedUnique[indexFile]);
                $(this).attr("value",AllGroupsAssignedUnique[indexFile]);
                indexFile++;
            });

        }

        
        <?php if (count($_smarty_tpl->tpl_vars['rna_groups']->value) > 0) {?>
            loadGroupAvailable();
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['all_annotations']->value && count($_smarty_tpl->tpl_vars['rna_groups']->value) > 0) {?>
            loadFileRNA();
            loadAndPushGroupsAvailable();
        <?php }?>
        <?php if (count($_smarty_tpl->tpl_vars['rna_group_already_assignated']->value) > 0) {?>
        loadAssignation();
        loadAssignationAndSetDesign();
        <?php }?>
        <?php if (count($_smarty_tpl->tpl_vars['design_rna']->value) > 0) {?>
        loadDesignRnaAlreadyDefined();
        loadSummaryDesign();
        <?php }?>
        <?php if (count($_smarty_tpl->tpl_vars['tools_available']->value) > 0) {?>
        load_tools_available_RNA();
        <?php }?>

        

    });

    
<?php echo '</script'; ?>
>
<?php }
}
