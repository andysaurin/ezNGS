{debug}
<form id="form-define-groups" action="/{$module}/{$class}/ChIP_define_groups" method="POST">

    <fieldset>
        <legend>Group definitions</legend>
        <div class="large-5 columns left">

            <div class=" row left">
                <div class="medium-2 columns">
                    <label for="Project_id"class="right inline">Project_id</label>
                </div>
                <div class="small-3 columns">
                    <input type="text" id="Project_id" name="project_id" value="{$project->id}" readonly>
                </div>
            </div>

            <table id="group_definition_chip">
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
                Please choose the name of groups wisely, without blankspace.</p>
        </div>

    </fieldset>
    <input class="button small round" type="submit" value="Save new(s) group(s)" />
</form>

{if $chip_groups|@count > 0}
    <fieldset>
        <legend>Groups available</legend>
        <div class="large-12 columns left">

            <table id="group_available_chip">
                <tr>
                    <th>Group_ID</th>
                    <th>Group_name</th>
                    <th>Group_description</th>
                </tr>
                <tr id="group_available_clone_chip">
                    <td class="large-2 Group_ID_available_chip"><input id="Group_ID_availble" class="input_without_space" type="text" name="Group_ID_available[]" readonly/></td>
                    <td class="large-2 Group_name_available_chip"><input id="Group_name_availble" class="input_without_space" type="text" name="Group_name_available[]" readonly/></td>
                    <td class="large-8 Group_description_available_chip"><input id="Group_description_available" class="input_with_space" type="text" name="Group_description_available[]" readonly/></td>
                    <td id="action"><a href="#!" id="deleteGroup" class="inline">Delete this Group</a>
                </tr>
                <tr id="group_definition_available_chip1">
                    <td class="large-2 Group_ID_available_chip"><input id="Group_ID_availble" class="input_without_space" type="text" name="Group_ID_available[]" readonly/></td>
                    <td class="large-2 Group_name_available_chip"><input id="Group_name_available1" class="input_without_space" type="text" name="Group_name_available[]" readonly/></td>
                    <td class="large-8 Group_description_available_chip"><input id="Group_description_available1" class="input_with_space" type="text" name="Group_description_available[]" readonly/></td>
                    <td id="action"><a href="#!" id="deleteGroup" class="inline">Delete this Group</a>
                </tr>
            </table>

        </div>
    </fieldset>
{/if}

{if $all_annotations && chip_groups|@count > 0 && in_array("ChIP-seq",$data_type_used)}

<fieldset>
    <legend>Sample-Group assignation</legend>

    <form id="form-assignation-groups" action="/{$module}/{$class}/save_chip_sample_type" method="POST">
        <fieldset>
            <legend>Sample type</legend>

            <div class="small-1 columns">
                <label for="Project_id"class="right inline">Project_id</label>
            </div>
            <div class="small-1 columns">
                <input type="text" id="Project_id" name="project_id" value="{$project->id}" readonly>
            </div>

            <table id="group_assignation_chip">
                <tr>
                    <th>md5sum</th>
                    <th>Sample_name</th>
                    <th>Sample_type</th>
                </tr>
                <tr id="group_sample_type_clone">
                    <td class="md5sum2_chip"><input id="md5sum" type="text" name="chip_groups_assignation[md5sum][]" readonly/></td>
                    <td class="Sample_name2_chip"><input id="Sample_name" type="text" name="chip_groups_assignation[Sample_name][]" readonly/></td>
                    <td class="Groups_available2_chip">
                        <select id="Sample_type" name="chip_groups_assignation[Sample_type][]" class="large-12 columns ">
                            <option id="Empty1" value=" "> </option>
                            {foreach $chip_type as $type}
                                <option id="{$type}" value={$type}>{$type}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>
                <tr id="group_sample_type1">
                    <td class="md5sum2_chip"><input id="md5sum1" type="text" name="chip_groups_assignation[md5sum][]" readonly/></td>
                    <td class="Sample_name2_chip"><input id="Sample_name1" type="text" name="chip_groups_assignation[Sample_name][]" readonly/></td>
                    <td class="Groups_available2_chip">
                        <select id="Sample_type1" name="chip_groups_assignation[Sample_type][]" class="large-12 columns ">
                            <option id="Empty1" value=" "> </option>
                            {foreach $chip_type as $type}
                                <option id="{$type}" value={$type}>{$type}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>

            </table>


        </fieldset>
        <input class="button small round" type="submit" value="Save" />
    </form>
{/if}



{*Il faut mettre une condition du style si data_type_used est présent   $all_chip_sample_type*}
{if $all_chip_sample_type|@count > 0 && in_array("ChIP-seq",$data_type_used)}
<form id="form_chip_coupling_samples" action="/{$module}/{$class}/save_chip_sample_pair" method="POST">
    <fieldset>
        <legend>Coupling samples</legend>

        <div class="small-1 columns">
            <label for="Project_id"class="right inline">Project_id</label>
        </div>
        <div class="small-1 columns">
            <input type="text" id="Project_id" name="project_id" value="{$project->id}" readonly>
        </div>

        <table id="coupling_samples">
            <tr>
                <th>treated samples</th>
                <th>input samples</th>
            </tr>
            <tr id="coupling_samples_clone">
                <td class="coupling_samples_treated">
                    <select id="coupling_samples" name="coupling_sample[]" class="large-12 columns ">
                        {foreach $all_chip_sample_type_treated as $treated}
                            <option id="{$treated->file_name}" value={$treated->md5sum}>{$treated->file_name}</option>
                        {/foreach}
                    </select>
                </td>

                <td class="coupling_samples_input">
                    <select id="coupling_samples" name="coupling_sample[]" class="large-12 columns ">
                        {foreach $all_chip_sample_type_input as $input}
                            <option id="{$input->file_name}" value={$input->md5sum}>{$input->file_name}</option>
                        {/foreach}
                    </select>
                </td>
                <td id="action"><a href="#!" id="deleteChipPair" class="inline">Delete this pair</a>
            </tr>


            <tr id="coupling_samples1">
                <td class="coupling_samples_treated">
                    <select id="coupling_samples1" name="coupling_sample1[]" class="large-12 columns ">
                        {foreach $all_chip_sample_type_treated as $treated}
                            <option id="{$treated->file_name}" value={$treated->md5sum}>{$treated->file_name}</option>
                        {/foreach}
                    </select>
                </td>

                <td class="coupling_samples_input">
                    <select id="coupling_samples1" name="coupling_sample1[]" class="large-12 columns ">
                        {foreach $all_chip_sample_type_input as $input}
                            <option id="{$input->file_name}" value={$input->md5sum}>{$input->file_name}</option>
                        {/foreach}
                    </select>
                </td>
                <td id="action"><a href="#!" id="deleteChipPair" class="inline">Delete this pair</a>
            </tr>
            <tfoot>
            <tr>
                <td><a href="#!" id="add_coupling_sample">Addition of a sample pair</a></td>
            </tr>
            </tfoot>

        </table>


    </fieldset>
    <input class="button small round" type="submit" value="Save" />
</form>
</fieldset>

{/if}


{if $all_chip_pair_already_defined|@count > 0 && $chip_groups|@count > 0}
    <form id="form-group_association_chip" action="/{$module}/{$class}/save_chip_assignation" method="POST">
        <fieldset>
            <legend>Sample-Group assignation</legend>

            <div class="small-1 columns">
                <label for="Project_id"class="right inline">Project_id</label>
            </div>
            <div class="small-1 columns">
                <input type="text" id="Project_id" name="project_id" value="{$project->id}" readonly>
            </div>

            <table id="group_association_chip">
                <tr>
                    <th>treated samples</th>
                    <th>input samples</th>
                    <th>Groups_available</th>
                </tr>
                <tr id="group_association_chip_clone">
                    <td class="treated_sample_chip"><input id="treated_sample_chip" type="text" name="group_association_chip[]" readonly/></td>
                    <td class="input_sample_chip"><input id="input_sample_chip" type="text" name="group_association_chip[]" readonly/></td>
                    <td class="Groups_available_chip"></td>
                </tr>
                <tr id="group_association_chip1">
                    <td class="treated_sample_chip"><input id="treated_sample_chip1" type="text" name="group_association_chip1[]" readonly/></td>
                    <td class="input_sample_chip"><input id="input_sample_chip1" type="text" name="group_association_chip1[]" readonly/></td>
                    <td class="Groups_available_chip"></td>
                </tr>

            </table>


        </fieldset>
        <input class="button small round" type="submit" value="Save Assignation" />
    </form>
{/if}

{if $chip_group_already_assigned|@count > 0}
    <form id="form-chip_design" action="/{$module}/{$class}/save_chip_design" method="POST">
        <fieldset>
            <legend>Design description</legend>

            <div class="small-1 columns">
                <label for="Project_id"class="right inline">Project_id</label>
            </div>
            <div class="small-1 columns">
                <input type="text" id="Project_id" name="project_id" value="{$project->id}" readonly>
            </div>

            <p>Select groups/conditions you want to analyze, if some are not available it's because they are not associated with any sample pair.
                Every sample pair associate to conditions choose at this step will be analysed</p>

                <table id="desing_chip">
                    <tr>
                        <th>Group_name</th>
                    </tr>
                    <tr id="group_available_chip_design">
                        {*créer une fonction quipopule ce tr à parti d'un array smarty*}
                    </tr>

                </table>

        </fieldset>
        <input class="button small round" type="submit" value="Save Design" />
    </form>
{/if}


{if $design_chip|@count > 0}
    <form id="form-chip_design_write_sample_file" action="/{$module}/{$class}/write_sample_chip" method="POST">

        <fieldset>
            <legend>Sample To analyse</legend>

            <div class="small-1 columns">
                <label for="Project_id"class="right inline">Project_id</label>
            </div>
            <div class="small-1 columns">
                <input type="text" id="Project_id" name="project_id" value="{$project->id}" readonly>
            </div>

            <table id="sample_to_analyse_chip">
                <tr>
                    <th>treated samples</th>
                    <th>input samples</th>
                    <th>Group_associated</th>
                </tr>
                <tr id="sample_to_analyse_chip_clone">
                    <td class="treated_sample_to_analyse_chip"><input id="treated_sample_to_analyse_chip" type="text" name="sample_to_analyse_chip[]" readonly/></td>
                    <td class="input_sample_to_analyse_chip"><input id="input_sample_to_analyse_chip" type="text" name="sample_to_analyse_chip[]" readonly/></td>
                    <td class="group_associated_chip"><input id="group_associated_sample_to_analyse" type="text" name="sample_to_analyse_chip[]" readonly/></td>
                </tr>
                <tr id="group_association_chip1">
                    <td class="treated_sample_to_analyse_chip"><input id="treated_sample_to_analyse_chip1" type="text" name="sample_to_analyse_chip1[]" readonly/></td>
                    <td class="input_sample_to_analyse_chip"><input id="input_sample_to_analyse_chip1" type="text" name="sample_to_analyse_chip1[]" readonly/></td>
                    <td class="group_associated_chip"><input id="group_associated_sample_to_analyse1" type="text" name="sample_to_analyse_chip1[]" readonly/></td>
                </tr>

            </table>

        </fieldset>
        <input class="button small round" type="submit" value="Validate" />
    </form>
{/if}

{*Insertion partie rna concernant config*}

{if $chip_group_already_assigned && $design_chip|@count > 0}

    <form id="form-chip_Workflow_design" action="/{$module}/{$class}/save_chip_config"  method="POST">
        <fieldset>
            <legend>Design the workflow</legend>

            <div class="row left">
                <div class="medium-2 columns">
                    <label for="Project_id"class="right inline">Project_id</label>
                </div>
                <div class="small-3 columns">
                    <input type="text" id="Project_id" name="project_id" value="{$project->id}" readonly>
                </div>
            </div>

            <fieldset class="large-12">
                <legend>Genome</legend>

                <div class="row left">
                    <div class="large-1 columns">
                        <label for="organism" class="right inline"><span data-tooltip aria-haspopup="true" class="has-tip" title="Organism's name">Organism</span></label>
                    </div>
                    <div id="genome_organism" class="large-11 columns">
                        {*<input type="text" id="organism" name="genome[organism]" value="" required>*}

                        <select id="chip_organism" name="genome[organism]" required>
                            <option id="Empty" value=" "> </option>
                            {foreach from=$all_genome key=$name item=$pair}
                                <option id="{$name}" value="{$name}">{$name}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>

                <div class=" row left">
                    <div class="large-1 columns">
                        <label for="version" class="right inline"><span data-tooltip aria-haspopup="true" class="has-tip" title="version's name">Version</span></label>
                    </div>
                    <div class="large-11 columns">
                        {*<input type="text" id="version" name="genome[version]" value="" required>*}
                        <select id="chip_version" name=genome[version]" required>
                            <option id="Empty" value=" "> </option>
                            {foreach from=$all_genome key=$name item=$pair}
                                <option id="{$name}" value="{$name}">{$name}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>

                <div class=" row left">
                    <div class="large-1 columns">
                        <label for="size" class="right inline"><span data-tooltip aria-haspopup="true" class="has-tip" title="genome's size">Size</span></label>
                    </div>
                    <div class="large-11 columns">
                        <input type="text" id="size" name="genome[size]" value="" required>
                    </div>
                </div>

                <div class=" row left">
                    <div class="large-1 columns">
                        <label for="fasta_file" class="right inline"><span data-tooltip aria-haspopup="true" class="has-tip" title="fasta_file's name">fasta_file</span></label>
                    </div>
                    <div class="large-11 columns">
                        {*<input type="text" id="fasta_file" name="genome[fasta_file]" value="" required>*}

                        <select id="chip_fasta_file" name=genome[fasta_file]" required>
                            <option id="Empty" value=" "> </option>

                        </select>
                    </div>
                </div>

                <div class=" row left">
                    <div class="large-1 columns">
                        <label for="gff3_file" class="right inline"><span data-tooltip aria-haspopup="true" class="has-tip" title="gff3_file's name">gff3_file</span></label>
                    </div>
                    <div class="large-11 columns">
                        {*<input type="text" id="chip_gff3_file" name="genome[gff3_file]" value="" required>*}

                        <select id="chip_gff3_file" name=genome[gff3_file]" required>
                            <option id="Empty" value=" "> </option>

                        </select>
                    </div>
                </div>

                <div class=" row left">
                    <div class="large-1 columns">
                        <label for="gtf_file" class="right inline"><span data-tooltip aria-haspopup="true" class="has-tip" title="gtf_file's name">gtf_file</span></label>
                    </div>
                    <div class="large-11 columns">
                        <input type="text" id="gtf_file" name="genome[gtf_file]" value="" required>
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

                        <select id="seq_type" name="metadata[seq_type]" required>
                            <option id="Single-end" value="se">Single-End</option>
                            <option id="Paired-end" value="pe">Paired-End</option>
                        </select>

                    </div>
                </div>

            </fieldset>

            {if $tools_available|@count > 0}
                <fieldset class="large-12" id="tools_available_chip">
                    <legend>Tools Available</legend>
                </fieldset>
            {/if}
            <input class="button small round" type="submit" value="Validate" />
    </form>
    </fieldset>

    {*
        faut mettre un if du style si config existe
    *}
    <fieldset class="large-12" id="set_parameters">
        <legend>Set parameters</legend>
        <form id="form_execute_rna_Workflow_default" action="/{$module}/{$class}/execute_chip_workflow_default"  method="POST">
            <input type="hidden" id="Project_id" name="project_id" value="{$project->id}">
            <input class="button large" type="submit" value="Use default parameters" />
        </form>
        <form id="form_execute_rna_Workflow_custom_parameters" action="/{$module}/{$class}/execute_chip_workflow_custom_parameters"  method="POST">
            <input type="hidden" id="Project_id" name="project_id" value="{$project->id}">
            <a href="#!" class="button large" id="SetCustomParamChIP">Set custom parameter for workflow steps</a>

            <div id="CustomParamChIP">

            </div>

        </form>



    </fieldset>
{/if}



{*END*}








<script>
    {*javascript part*}
    {literal}
    $(document).ready(function() {

        /*Javascript function for the Add group possibility in the group definition table*/
        $indexGroup = 1;
        $("#group_definition_chip").on("click","#add_group",function () {
            $indexGroup++;
            var $newTr = $("#group_definition_clone").clone().attr("id", "group_definition"+ $indexGroup);
            $newTr.find("input").each(function() {
                $(this).val('').attr("id",function(_, id) { return id + $indexGroup });
            }).end().appendTo("#group_definition_chip");
        });

        /*Javascript function for the Add group possibility in the group definition table*/
        $indexGroup = 1;
        $("#coupling_samples").on("click","#add_coupling_sample",function () {
            $indexGroup++;
            var $newTr = $("#coupling_samples_clone").clone().attr("id", "coupling_samples"+ $indexGroup);
            $newTr.find("select").each(function() {
                $(this).val('').attr("id",function(_, id) { return id + $indexGroup });
                //$(this).val('').attr("name",function(_, id) { return id + $indexGroup });
                $(this).val('').attr("name",function(_, id) {
                    var $name = id.split("[");
                    var $newId = $name[0] + $indexGroup + "[]";
                    return $newId;
                });
            }).end().appendTo("#coupling_samples");
        });

        /*Javascript function for the delete line possibility in the Group definitions table*/
        $("#group_definition_chip").on("click","#deleteLine",function () {
            $(this).parents().eq(1).remove();
        });

        /*Javascript function for the delete pair possibility in the Coupling_sample table*/
        $("#coupling_samples").on("click","#deleteChipPair",function () {

            //Find a way to delete in the database this pair a AJAX request ?
            //But before need to have some info
            //$(this).parents().eq(1).css( "background", "yellow" ); get the line to remove
            //$(this).parents().children().eq(2).children().css( "background", "yellow" );

            var $md5sumTreatedSample = $(this).parents().eq(1).children().first().children().first().val();
            var $md5sumInputSample = $(this).parents().children().eq(2).children().val();

            $.ajax({
                type:"POST",
                url: " /users/projects_users/delete_pair",//these info are send to the default function
                data: {"md5sum_treated_sample": $md5sumTreatedSample, "md5sum_input_sample": $md5sumInputSample,"project_id":  {/literal} {$project->id} {literal} }
            });

            $(this).parents().eq(1).remove();

        });


        $("#SetCustomParamChIP").one( "click", function() {
            var $customConfigToolsRna = {/literal}{$custom_config_tools_chip|json_encode}{literal};
            //$("#CustomParam").append("<strong>Hello</strong>" );
            //$("#CustomParam").append($customConfigToolsRna );

            for (var $key1 in $customConfigToolsRna) {
                for (var $key2 in $customConfigToolsRna[$key1]) {
                    //console.log($key2);
                    for (var $key3 in $customConfigToolsRna[$key1][$key2]) {
                        $("#CustomParamChIP").append("<div class='large columns'><h3>" + $key2 + "</h3></div>" );
                        $("#CustomParamChIP").append("<div class='large-1 columns'><label class='left inline' for=" + $key3 +">" + $key3 + "</label></div>" );
                        $("#CustomParamChIP").append("<div class='large-11 columns'><input type=text id=" + $key3 + " name=" + $key2 + "[" + $key3 +"]" + " value=''></div>");
                    }
                }
            }

            $("#CustomParamChIP").after("<div class='large columns'><input class='button small round '  type='submit' value='Validate' /></div>");

        });


        function loadGroupAvailableChIP(){

            var tableId = {/literal}{$chip_groups|json_encode}{literal};
            var $indexSample = 0;
            //first create lines
            var $numberOfLineToAdd = tableId.length -1 ;
            while ($numberOfLineToAdd != 0) {
                $indexSample++;
                var $newTr = $("#group_available_chip tr:eq(1)").clone().attr("id", "group_definition_available_chip" + $indexSample);
                $newTr.find("input").each(function () {
                    $(this).val('').attr("id", function (_, id) {
                        return id + $indexSample
                    });
                }).end().appendTo("#group_available_chip");

                $numberOfLineToAdd--;
            }
            //Fill these lines
            var indexFile = 0;
            $("td.Group_ID_available_chip input:not(td.Group_ID_available_chip input:eq(0))").each(function(){
                //console.log(tableId[indexFile]["group_id"]);
                $(this).val(tableId[indexFile]["group_id"]);
                $(this).attr("placeholder",tableId[indexFile]["group_id"]);
                $(this).attr("value",tableId[indexFile]["group_id"]);
                indexFile++;
            });
            var indexFile = 0;
            $("td.Group_name_available_chip input:not(td.Group_name_available_chip input:eq(0))").each(function(){
                $(this).val(tableId[indexFile]["group_name"]);
                $(this).attr("placeholder",tableId[indexFile]["group_name"]);
                $(this).attr("value",tableId[indexFile]["group_name"]);
                indexFile++;
            });
            var indexFile = 0;
            $("td.Group_description_available_chip input:not(td.Group_description_available_chip input:eq(0))").each(function(){
                $(this).val(tableId[indexFile]["group_description"]);
                $(this).attr("value",tableId[indexFile]["group_description"]);
                $(this).attr("placeholder",tableId[indexFile]["group_description"]);
                indexFile++;
            });

        };

        $("#group_available_chip").on("click","#deleteGroup",function () {

            //Find a way to delete in the database this group a AJAX request ?
            //But before need to have some info
            //$(this).parents().eq(1).children().first().children().first().css( "background", "yellow" );
            var $Group_id = $(this).parents().eq(1).children().first().children().first().val();

            $.ajax({
                type:"POST",
                url: " /users/projects_users",//these info are send to the default function
                data: {"group_id": $Group_id, "project_id":  {/literal} {$project->id} {literal} }
            });
            $(this).parents().eq(1).remove();
        });

        function loadFileCHIP(){

            var AllFile = {/literal}{$all_annotations}{literal};
            var tableId2 = new Array;
            var $indexSample2 = 1;
            for (var $key1 in AllFile) {
                for (var $key2 in AllFile[$key1]) {
                    var $Index = 0;
                    if (Array.isArray(AllFile[$key1][$key2])) {
                        for (var $key3 in AllFile[$key1][$key2]) {

                            if (AllFile[$key1][$key2][$key3] == "ChIP-seq") {
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
                var $newTr = $("#group_assignation_chip tr:eq(1)").clone().attr("id", "group_assignation_chip" + $indexSample2);
                $newTr.find("input").each(function () {
                    $(this).val('').attr("id", function (_, id) {
                        return id + $indexSample2
                    });

                });

                $newTr.find("select").each(function () {
                    $(this).val('').attr("id", function (_, id) {
                        return id + $indexSample2
                    });

                }).end().appendTo("#group_assignation_chip");

                $numberOfLineToAdd--;
            }
            //Fill these lines
            var indexFile = 0;
            $("td.md5sum2_chip input:not(td.md5sum2_chip input:eq(0))").each(function(){
                $(this).val(tableId2[indexFile]["md5sum"]);
                $(this).attr("placeholder",tableId2[indexFile]["md5sum"]);
                $(this).attr("value",tableId2[indexFile]["md5sum"]);
                indexFile++;
            });

            var indexFile = 0;
            $("td.Sample_name2_chip input:not(td.Sample_name2_chip input:eq(0))").each(function(){
                $(this).val(tableId2[indexFile]["Sample_name"]);
                $(this).attr("value",tableId2[indexFile]["Sample_name"]);
                $(this).attr("placeholder",tableId2[indexFile]["Sample_name"]);
                indexFile++;
            });
        };

        function loadAndPushGroupsAvailableChip(){
            var all_chip_pair_already_defined = {/literal}{$all_chip_pair_already_defined|json_encode}{literal};
            //console.log(Object.keys(all_chip_pair_already_defined).length); get the number of pair
            //console.log(Object.keys(all_chip_pair_already_defined)); get all key in an array

            var $indexSample = 1;
            var $indexGroup = 1;
            //first create lines
            var $numberOfLineToAdd = Object.keys(all_chip_pair_already_defined).length -1 ;
            while ($numberOfLineToAdd != 0) {
                $indexSample++;
                $indexGroup++;
                var $newTr = $("#group_association_chip tr:eq(1)").clone().attr("id", "group_association_chip" + $indexSample);
                $newTr.find("input").each(function() {
                    $(this).val('').attr("id",function(_, id) { return id + $indexGroup });
                    $(this).val('').attr("name",function(_, id) {
                        var $name = id.split("[");
                        var $newId = $name[0] + $indexGroup + "[]";
                        return $newId;
                    });
                }).end().appendTo("#group_association_chip");

                $numberOfLineToAdd--;
            }

            //fill these lines

            {/literal}
             var $i = 1;
            {foreach from=$all_chip_pair_already_defined key=$name item=$pair}
            {*console.log("{$pair[0][0]->file_name}"); Get treated sample name*}
            //input_sample_chip1
            $("#treated_sample_chip" + $i ).val("{$pair[0][0]->file_name}");
            $("#input_sample_chip" + $i ).val("{$pair[1][0]->file_name}");
            //$("#"+"{$name}").find("td.coupling_samples_input").find("select").val("{$pair[1][0]->md5sum}");
            $i++;
            {/foreach}


            {literal}


            //Groups part

            var ChipGroups = {/literal}{$chip_groups|json_encode}{literal};
            ChipGroups.forEach(function (entry) {

                {/literal}
                var $step = 0;
                {foreach from=$all_chip_pair_already_defined key=$name item=$pair}
                {*console.log("{$pair[0][0]->file_name}"); Get treated sample name*}

                //name = group_association_chip[ + md5_treated + _vs_ + md5_input + ][]
                //var name = "group_association_chip[" + "{$pair[0][0]->md5sum}"+"_vs_"+ "{$pair[1][0]->md5sum}" +"][]";
                var name = "group_association_chip[" + "{$pair[2]}" +"][]";

                var selectTd = "td.Groups_available_chip:eq("+($step+1)+")";

                $(selectTd).append('<input type=checkbox name=' + name +' value=' + entry["group_name"] + '>' + entry["group_name"] );
                $step ++;
                {/foreach}
                {literal}

            });
        }

        function loadAssignationChIP() {
            {/literal}
            {foreach from=$chip_group_already_assigned key=$name item=$pair}
            {*//console.log("{$pair->group_name}"); get the group_name*}

            var name = "group_association_chip[" + "{$pair->chip_pair_id}" +"][]";
            var value= "{$pair->group_name}";

            $("[name ='" + name + "'][value='"+value+"']").prop( "checked", true );
            {/foreach}
            {literal}

        }

        /*test part input to select for the genome section*/
        function loadGenomes() {
            {/literal}
            {foreach from=$all_genome key=$name item=$pair}
            /*//console.log("{$name}");*/
            {/foreach}
            {literal}

            {/literal}
            /*//console.log("{$all_genome["dm3"][1]}");*/
            {literal}

        }
        $("#chip_organism").change(function () {
            var val = $(this).val();
            //no if we are sur of the value
            var AllGenome = {/literal}{$all_genome|json_encode}{literal};
            //console.log(AllGenome[val][1]);
            for(var item in AllGenome[val] ){
                if($.isNumeric(item)){//if is numeric this correpond to a file not a folder
                    //console.log( AllGenome[val][item]);
                    var ext = AllGenome[val][item].split(".");
                    //console.log(ext[ext.length -1]);

                    //Test extension file to create the good option at the good place on the genome config file
                    //chip_fasta_file

                    if(ext[ext.length -1] == "fa"){
                        $("#chip_fasta_file option").remove();
                        //$("#chip_fasta_file").append("<option id= 'empty' value=' '></option>");
                        $("#chip_fasta_file").append("<option id= '"+ AllGenome[val][item] +" value='" + AllGenome[val][item] +" > "+ AllGenome[val][item]+ "</option>");
                    }
                    //exploiter le else pour le cas ou ya pas


                    if(ext[ext.length -1] == "gff3"){
                        $("#chip_gff3_file option").remove();
                        $("#chip_gff3_file").append("<option id= '"+ AllGenome[val][item] +" value='" + AllGenome[val][item] +" > "+ AllGenome[val][item]+ "</option>");
                    }


                }
            }

        });

        function loadDesignChIPAlreadyDefined() {
            {/literal}
            {foreach from=$design_chip key=$name item=$pair}
            {*//console.log("{$pair[2]}");*}

            $("[name ='" + '{$pair[2]}' + "'][value='"+'{$pair[2]}'+"']").prop( "checked", true );

            {/foreach}
            {literal}
        }

        function loadSummaryDesignChip() {

            {/literal}
            var SummaryChipDesign = new Array;
            {foreach from=$chip_group_already_assigned key=$name item=$pair}
            {*//console.log("{$pair->group_name}"); get the group_name*}

            SummaryChipDesign.push("{$pair->group_name}");
            {/foreach}
            {literal}

            $.unique(SummaryChipDesign);
            SummaryChipDesign.forEach(function (group_name) {
                $("#group_available_chip_design").append('<td><input type=checkbox name=' + group_name +' value=' + group_name + '>' + group_name +'</td>');
            })
        }

        /*function loadAssignationAndSetDesignChIP() {
            //$("#desing_rna")
            var AllFileAlreadyAssigned = {/literal}{$chip_group_already_assignated|json_encode}{literal};
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

        }*/

        function loadSummaryDesignChIP() {
            var all_chip_pair_already_defined = {/literal}{$all_chip_pair_already_defined|json_encode}{literal};

            var $indexSample = 1;
            var $indexGroup = 1;
            //first create lines
            var $numberOfLineToAdd = Object.keys(all_chip_pair_already_defined).length -1 ;
            while ($numberOfLineToAdd != 0) {
                $indexSample++;
                $indexGroup++;
                var $newTr = $("#sample_to_analyse_chip tr:eq(1)").clone().attr("id", "group_associated_chip" + $indexSample);
                $newTr.find("input").each(function() {
                    $(this).val('').attr("id",function(_, id) { return id + $indexGroup });
                    //$(this).val('').attr("name",function(_, id) { return id + $indexGroup });
                    $(this).val('').attr("name",function(_, id) {
                        var $name = id.split("[");
                        var $newId = $name[0] + $indexGroup + "[]";
                        return $newId;
                    });
                }).end().appendTo("#sample_to_analyse_chip");

                $numberOfLineToAdd--;
            }

            //Fill these lines
            //treated samples and input samples
            {/literal}
            var $line = 1;
            {foreach from=$all_chip_pair_already_defined key=$name item=$pair}
            {*console.log("{$pair[0][0]->file_name}"); Get treated sample name*}

            var $treated = "#treated_sample_to_analyse_chip" + $line;

            //$("#treated_sample_to_analyse_chip1").css("background-color","red");
            $($treated).val("{$pair[0][0]->md5sum}");
            $($treated).hide();
            $($treated).parent().append("{$pair[0][0]->file_name}");

            var $input = "#input_sample_to_analyse_chip" + $line;
            $($input).val("{$pair[1][0]->md5sum}");
            $($input).hide();
            $($input).parent().append("{$pair[1][0]->file_name}");

            $line++;
            {/foreach}

            var $couple = 1;
            {foreach from=$design_chip key=$name item=$pair}
            //$("[name ='" + '{$pair[2]}' + "'][value='"+'{$pair[2]}'+"']").prop( "checked", true );
                var $treated = "#treated_sample_to_analyse_chip" + $couple;
                var $value = $($treated).val();
                if ("{$pair[0]}" == $value){
                    //console.log("toto");
                    var $name = "#group_associated_sample_to_analyse" + $couple;
                    console.log("{$pair[2]}");
                    $($name).val("{$pair[2]}");
                    $($name).hide();
                    $($name).parent().append("{$pair[2]}");
                }


            $couple++;
            {/foreach}


            {literal}

        }

        function loadChipSampleType(){
            var all_chip_sample_type = {/literal}{$all_chip_sample_type|json_encode}{literal};
            var index = 1;
            for (var $key1 in all_chip_sample_type) {
                //console.log(all_chip_sample_type[$key1]["md5sum"]);
                $("td.md5sum2_chip input").each(function(){
                    if ($(this).val() == all_chip_sample_type[$key1]["md5sum"]){
                        $("#Sample_type" + index).val(all_chip_sample_type[$key1]["sample_type"]);
                        index++;
                    }
                });
            }
        }

        function load_tools_available_ChIP() {
            var toolsAvailableRNATable = {/literal}{$tools_available|json_encode}{literal};
            //console.log(toolsAvailableRNATable["RNA-seq"]);

            for (var $key1 in toolsAvailableRNATable){
                //console.log($key1);
                if ($key1 == "ChIP-seq"){
                //console.log($key1);
                    for (var $key2 in toolsAvailableRNATable[$key1]){
                        //console.log($key2);
                        $("#tools_available_chip").append("<div id='" + $key2 +"ChIP'></div>" );
                        $("#" + $key2+"ChIP").append("<h3>" + $key2 + "</h3>");
                        
                        for (var $key3 in toolsAvailableRNATable[$key1][$key2]){
                            var nameTool = toolsAvailableRNATable[$key1][$key2][$key3]
                            $("#" + $key2+"ChIP").append("<input type=checkbox name=" + $key2 + "[]" + " value=" + nameTool + ">" + nameTool );
                        }

                    }

                }
            }
        }


        function loadChipPairs() {
            var all_chip_pair_already_defined = {/literal}{$all_chip_pair_already_defined|json_encode}{literal};
            //console.log(all_chip_pair_already_defined);
            //console.log(all_chip_pair_already_defined.length);
            //console.log(Object.keys(all_chip_pair_already_defined).length); get the number of pair
            //console.log(Object.keys(all_chip_pair_already_defined)); get all key in an array

            var $indexSample = 1;
            var $indexGroup = 1;
            //first create lines
            var $numberOfLineToAdd = Object.keys(all_chip_pair_already_defined).length -1 ;
            while ($numberOfLineToAdd != 0) {
                $indexSample++;
                $indexGroup++;
                var $newTr = $("#coupling_samples tr:eq(1)").clone().attr("id", "coupling_samples" + $indexSample);
                $newTr.find("select").each(function() {
                    $(this).val('').attr("id",function(_, id) { return id + $indexGroup });
                    //$(this).val('').attr("name",function(_, id) { return id + $indexGroup });
                    $(this).val('').attr("name",function(_, id) {
                        var $name = id.split("[");
                        var $newId = $name[0] + $indexGroup + "[]";
                        return $newId;
                    });
                }).end().appendTo("#coupling_samples");

                $numberOfLineToAdd--;
            }

            //Fill these lines
            //try in smarty
            {/literal}
            {foreach from=$all_chip_pair_already_defined key=$name item=$pair}
                {*//console.log("{$name}"); Get tr name *}
            {*console.log("{$pair[0][0]->file_name}"); Get treated sample name*}
            $("#"+"{$name}").find("td.coupling_samples_treated").find("select").val("{$pair[0][0]->md5sum}");
            $("#"+"{$name}").find("td.coupling_samples_input").find("select").val("{$pair[1][0]->md5sum}");
        {/foreach}


            {literal}

        }




        {/literal}
        {if $chip_groups|@count > 0}
            loadGroupAvailableChIP();
        {/if}
        {if $all_annotations && chip_groups|@count > 0 && in_array("ChIP-seq",$data_type_used)}
            loadFileCHIP();
        {/if}

        {if $all_chip_sample_type|@count > 0}
            loadChipSampleType();
        {/if}

        {if $all_chip_sample_type|@count > 0 && $all_chip_pair_already_defined|@count > 0}
            loadChipPairs();
        {/if}

        {if $all_chip_sample_type|@count > 0 && $all_chip_pair_already_defined|@count > 0 && $chip_groups|@count > 0}
        loadAndPushGroupsAvailableChip();
        {/if}

        {if $all_chip_sample_type|@count > 0 && $all_chip_pair_already_defined|@count > 0 && $chip_groups|@count > 0 && $chip_group_already_assigned|@count > 0}
        loadAssignationChIP();
        loadSummaryDesignChip();
        {/if}

        {if $all_chip_sample_type|@count > 0 && $all_chip_pair_already_defined|@count > 0 && $chip_groups|@count > 0 && $chip_group_already_assigned|@count > 0 && $design_chip|@count > 0}
        loadDesignChIPAlreadyDefined();
        loadSummaryDesignChIP();
        {/if}

        {if $chip_group_already_assigned && $design_chip|@count > 0}
        load_tools_available_ChIP();
        loadGenomes();
        {/if}

        {if $design_chip && $chip_group_already_assigned && $design_chip|@count > 0}
        //loadDesignChipFile();
        {/if}

        {*{if $design_rna|@count > 0}
            loadDesignRnaAlreadyDefined();
            loadSummaryDesign();
        {/if}

        {if $rna_group_already_assignated|@count > 0}
        loadAssignationChIP();
        loadAssignationAndSetDesign();
        {/if}
        {if $design_rna|@count > 0}
        loadDesignRnaAlreadyDefined();
        loadSummaryDesign();
        {/if}
        {if $tools_available|@count > 0}
        load_tools_available_RNA();
        {/if}*}

        {literal}

    });

    {/literal}
</script>