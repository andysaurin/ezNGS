<h2>Samples Descriptions</h2>

<div>
    <form id="form-descriptions" action="write_yaml.php"  method="post">

        <fieldset>
            <legend>Series</legend>
            <p>This section describes the overall experiment</p>

            {* 10/08/2016 for input sections class="input_with_space" we have to think about special character*}

            <div class=" row left">
                <div class="medium-2 columns">
                    <label for="Title_sreries" class="right inline"><span data-tooltip aria-haspopup="true" class="has-tip" title="Unique title (less than 255 characters) that describes the overall study.">Title_sreries</span></label>
                </div>
                <div class="small-10 columns">
                    <input type="text" id="Title_sreries" name="Series_information[Title_sreries]" value="" >
                </div>
            </div>

            <div class="row left">
                <div class="medium-2 columns">
                    <label for="Summary" class="right inline"><span data-tooltip aria-haspopup="true" class="has-tip" title="Thorough description of the goals and objectives of this study. The abstract from the associated publication may be suitable. Include as much text as necessary.">Summary</span></label>
                </div>
                <div class="small-10 columns">
                    <input type="text" id="Summary" name="Series_information[Summary]" value="" >
                </div>
            </div>

            <div class="row left">
                <div class="medium-2 columns">
                    <label for="Overall_design" class="right inline"><span data-tooltip aria-haspopup="true" class="has-tip" title="Indicate how many Samples are analyzed, if replicates are included, are there control and/or reference Samples, etc...">Overall_design</span></label>
                </div>
                <div class="small-10 columns">
                    <input type="text" id="Overall_design" name="Series_information[Overall_design]" value="" >
                </div>
            </div>

            <div class="row left">
                <div class="medium-2 columns">
                    <label for= "Supplementary_file"><span data-tooltip aria-haspopup="true" class="has-tip" title="[optional] If you submit a matrix table containing processed data for all samples, include the file name here.">Supplementary file</span></label>
                </div>
                <div class="small-10 columns">
                    <input type='text'  name="Series_information[Supplementary_file]" id="Supplementary_file" value="" >
                </div>
            </div>

            <div class="row left">
                <div class="medium-2 columns">
                    <label for= "SRA_center_name_code"><span data-tooltip aria-haspopup="true" class="has-tip" title="[optional] If you submit a matrix table containing processed data for all samples, include the file name here.">SRA_center_name_code</span></label>
                </div>
                <div class="small-10 columns">
                    <input type='text' name="Series_information[SRA_center_name_code]" id="SRA_center_name_code" value="" >
                </div>
            </div>

            {* 10/08/2016 a copy/adaptation Lucie's code to create the possibility to add/delete contributor's name in informations saved*}
            <div class="row rigth ">
                <table class="dTable " id='Contributor_table'>
                    <tbody>
                    <tr id="Contributor_clone_td" class="">
                        <td  class="Contributor "><label for= "Contributor_clone"  ><span data-tooltip aria-haspopup="true" class="has-tip" title='"Firstname,Initial,Lastname".Example: "John,H,Smith" or "Jane,Doe". Each contributor on a separate case, add as many contributor cases as required.'>Contributor</span></label> <input type='text' name="Series_information[Contributor][]" id="Contributor_clone" value="" ></td>
                        <td id="action"><a href="#!" id="deleteContributor" class="inline">Delete this contributor</a>
                    </tr>
                    <tr id="tr_Contributor1">
                        <td class="Contributor"><label for= "Contributor1" ><span data-tooltip aria-haspopup="true" class="has-tip" title='"Firstname,Initial,Lastname".Example: "John,H,Smith" or "Jane,Doe". Each contributor on a separate case, add as many contributor cases as required.'>Contributor</span></a></label> <input type='text' name="Series_information[Contributor][]" id="Contributor1" value="" ></td>
                        <td id="action"><a href="#!" id="deleteContributor">Delete this contributor</a>
                    </tr>
                    </tbody>

                    <tfoot>
                    <tr>
                        <th colspan="5"><a href="#!" id="addContributor">Add a contributor</a></th>
                    </tr>
                    </tfoot>

                </table>
            </div>

        </fieldset>

        <fieldset>
            <legend>Samples</legend>
            <p>This section lists and describes each of the biological Samples under investigation, as well as any protocols that are specific to individual Samples.</p>
            <p>Additional "processed data file" or "raw file" columns may be included.</p>

            <table class="dynatable" id="sample_table">
                <thead>
                <tr>
                    <th><span data-tooltip aria-haspopup="true" class="has-tip" title="Is the MD5 footprint file">md5sum</span></th>
                    <th><span data-tooltip aria-haspopup="true" class="has-tip" title="An arbitrary and unique identifier for each sample. This information will not appear in the final records and is only used as an internal reference. Each row represents a GEO Sample record.">Sample_name</span></th>
                    <th><span data-tooltip aria-haspopup="true" class="has-tip" title="Data from <?php echo $dataTypesSupportedPlaceholder ?">Data_type</span></th>
                    <th><span data-tooltip aria-haspopup="true" class="has-tip" title="Unique title that describes the Sample.">Title</span></th>
                    <th><span data-tooltip aria-haspopup="true" class="has-tip" title="Briefly identify the biological material e.g., vastus lateralis muscle.">Source_name</span></th>
                    <th><span data-tooltip aria-haspopup="true" class="has-tip" title="Identify the organism(s) from which the sequences were derived.">Organism</span></th>
                    <th><span data-tooltip aria-haspopup="true" class="has-tip" title="Type of molecule that was extracted from the biological material. Include one of the following: total RNA, polyA RNA, cytoplasmic RNA, nuclear RNA, genomic DNA, protein, or other.">Molecule</span></th>
                    <th><span data-tooltip aria-haspopup="true" class="has-tip" title="Type of molecule that was extracted from the biological material. Include one of the following: total RNA, polyA RNA, cytoplasmic RNA, nuclear RNA, genomic DNA, protein, or other.">Description</span></th>
                    <th><span data-tooltip aria-haspopup="true" class="has-tip" title="Name of the file containing the processed data. Multiple 'processed data file' columns may be included when multiple processed data files exist for a Sample (as presented in EXAMPLE 1 worksheet).">Processed_data_file</span></th>
                    <th><span data-tooltip aria-haspopup="true" class="has-tip" title="The name of the files containing the raw data.Additional 'raw data file' columns may be included if more than 1 raw data file exist for a Sample">Raw_file</span></th>
                    <th id="colRef">Actions</th>
                </tr>
                </thead>

                <tbody>
                <tr id="Data_clone" >
                    <td class="md5sum"><input id="md5sum" type="text" name="Samples_information[md5sum][]" readonly/></td>
                    <td class="Sample_name"><input id="Sample_name" type="text" name="Samples_information[Sample_name][]" readonly/></td>
                    <td class="Data_type"><input id="Data_type" type="text" name="Samples_information[Data_type][]" pattern="<?php echo $dataTypesSupportedPatternTrimmed ?>" placeholder="<?php echo $dataTypesSupportedPlaceholder ?>"/></td>
                    <td class="Title"><input id="Title" type="text" name="Samples_information[Title][]" /></td>
                    <td class="Source"><input id="Source" type="text" name="Samples_information[Source][]" /></td>
                    <td class="Organism"><input id="Organism" type="text" name="Samples_information[Organism][]" /></td>
                    <td class="Molecule"><input id="Molecule" type="text" name="Samples_information[Molecule][]" /></td>
                    <td class="Description"><input id="Description" type="text" name="Samples_information[Description][]" /></td>
                    <td class="Processed_data_file"><input id="Processed_data_file" type="text" name="Samples_information[Processed_data_file][]" /></td>
                    <td class="Raw_file"><input id="Raw_file" type="text" name="Samples_information[Raw_file][]" /></td>
                    <!--                    <td id="action_function"><a href="#!" id="action_deleteLine">Delete sample</a>-->
                    <td id="action_function">
                        <a href="#!" class="deleteFiles">Delete sample</a>

                        {* 10/08/2016 <button form="form-descriptions" id="addColButton" type="button">Add Column</button>*}
                        {* 10/08/2016 <button form="form-descriptions" id="delColButton" type="button">Delete Column</button>*}

                        <a href="#" class="button tiny" id="addColButton">Add Column</a><br>
                        <a href="#" class="button tiny" id="delColButton">Delete Column</a>

                    </td>
                </tr>
                <tr id="Data1" >
                    <td class="md5sum"><input id="md5sum1" type="text" name="Samples_information[md5sum][]" readonly/></td>
                    <td class="Sample_name" id="toto"><input id="Sample_name1" type="text" name="Samples_information[Sample_name][]" readonly/></td>
                    <td class="Data_type"><input id="Data_type1" type="text" name="Samples_information[Data_type][]" pattern="<?php echo $dataTypesSupportedPatternTrimmed ?>" placeholder="<?php echo $dataTypesSupportedPlaceholder ?>" /></td>
                    <td class="Title"><input id="Title1" type="text" name="Samples_information[Title][]" /></td>
                    <td class="Source"><input id="Source1" type="text" name="Samples_information[Source][]" /></td>
                    <td class="Organism"><input id="Organism1" type="text" name="Samples_information[Organism][]" /></td>
                    <td class="Molecule"><input id="Molecule1" type="text" name="Samples_information[Molecule][]" /></td>
                    <td class="Description"><input id="Description1" type="text" name="Samples_information[Description][]" /></td>
                    <td class="Processed_data_file"><input id="Processed_data_file1" type="text" name="Samples_information[Processed_data_file][]" /></td>
                    <td class="Raw_file"><input id="Raw_file1" type="text" name="Samples_information[Raw_file][]" /></td>
                    <!--                        <td id="action_function"><a href="#!" id="action_deleteLine">Delete sample</a>-->
                    <td id="action_function">
                        <a href="#!" class="deleteFiles">Delete sample</a><br>
                        <a href="#" class="button tiny" id="addColButton">Add Column</a>
                        <a href="#" class="button tiny" id="delColButton">Delete Column</a>
                        {* 10/08/2016<button form="form-descriptions" id="addColButton" type="button">Add Column</button>*}
                        {* 10/08/2016<button form="form-descriptions" id="delColButton" type="button">Delete Column</button>*}
                    </td>
                </tr>
                </tbody>

            </table>

        </fieldset>

        <fieldset>
            <legend>Protocol</legend>
            <p> Any of the protocols below which are applicable to only a subset of Samples should be included as additional columns of the SAMPLES section instead.</p>

            <div class="row left">
                <div class="medium-2 columns">
                    <label for= "Growth_protocol"><span data-tooltip aria-haspopup="true" class="has-tip" title="[Optional]  Describe the conditions that were used to grow or maintain organisms or cells prior to extract preparation.">Growth_protocol</span></label>
                </div>
                <div class="small-10 columns">
                    <input type='text' name="Protocols_information[Growth_protocol]" id="Growth_protocol" value="" >
                </div>
            </div>

            <div class="row left">
                <div class="medium-2 columns">
                    <label for= "Treatment_protocol"><span data-tooltip aria-haspopup="true" class="has-tip" title="[Optional] Describe the treatments applied to the biological material prior to extract preparation.">Treatment_protocol</span></label>
                </div>
                <div class="small-10 columns">
                    <input size= '150' type='text' name="Protocols_information[Treatment_protocol]" id="Treatment_protocol" value="" >
                </div>
            </div>

            <div class="row left">
                <div class="medium-2 columns">
                    <label for= "Extract_protocol"><span data-tooltip aria-haspopup="true" class="has-tip" title="Describe the protocols used to extract and prepare the material to be sequenced. ">Extract_protocol</span></label>
                </div>
                <div class="small-10 columns">
                    <input size= '150' type='text' name="Protocols_information[Extract_protocol]" id="Extract_protocol" value="" >
                </div>
            </div>

            <div class="row left">
                <div class="medium-4 columns">
                    <label for= "Library_construction_protocol"><span data-tooltip aria-haspopup="true" class="has-tip" title="Describe the library construction protocol.">Library_construction_protocol</span></label>
                </div>
                <div class="small-10 columns">
                    <input size= '150' type='text' name="Protocols_information[Library_construction_protocol]" id="Library_construction_protocol" value="" >
                </div>
            </div>

            <div class="row left">
                <div class="medium-2 columns">
            <label for= "Library_strategy"><span data-tooltip aria-haspopup="true" class="has-tip" title="A Short Read Archive-specific field that describes the sequencing technique for this library. Please select one of the following terms: RNA-Seq miRNA-Seq ncRNA-Seq RNA-Seq (CAGE) RNA-Seq (RACE) ChIP-Seq MNase-Seq MBD-Seq MRE-Seq Bisulfite-Seq Bisulfite-Seq (reduced representation) MeDIP-Seq DNase-Hypersensitivity Tn-Seq FAIRE-seq SELEX RIP-Seq ChIA-PET OTHER">Library_strategy</span></label>
                </div>
                <div class="small-10 columns">
                    <input size= '150' type='text' name="Protocols_information[Library_strategy]" id="Library_strategy" value="" >
                </div>
            </div>
        </fieldset>

</div>

<script>
{*javascript part*}
{literal}

$indexContributor = 1;
    $("#Contributor_table").on("click","#addContributor",function () {
        $indexContributor++;
        //var $newEle = $("#Contributor_table tr:eq(0)").clone().attr("id", "tr_Contributor"+ $indexContributor);
        var $newEle = $("#Contributor_clone_td").clone().attr("id", "tr_Contributor"+ $indexContributor);
        $newEle.find("input").each(function() {
            $(this).val('').attr('id',"Contributor" + $indexContributor);
        }).end().appendTo("#Contributor_table");
    });

    $("#Contributor_table").on("click","#deleteContributor",function () {
        $(this).parents().eq(1).remove();
    });


	$("#sample_table ").on("click", "#addColButton" ,function () {

        var $this = $(this), $table = $this.closest('table');
		var $columnName = window.prompt("Enter Column name", "");

         if ($columnName == null){
            return;
        }
        if (! /^[a-zA-Z0-9_-]+$/.test($columnName)) { // check if the string write by user is available
            return;
        }

        $('<th>' + $columnName + '</th>').insertBefore($table.find('tr').first().find('th:last'));

        var $lastTd = $table.find('tr:gt(0)').find('td:last');

        var $compteur = 0;
        $lastTd.each(function(){
            if ($compteur == 0){
                $('<td class= ' + $columnName +'><input id="'+ $columnName +'" class= "' + $columnName + '"type="text" name="Samples_information['+ $columnName + '][]" value="" ></td>').insertBefore($(this));
                $compteur++;
            }
            else {
                $('<td class= ' + $columnName +'><input id="'+ $columnName+$compteur +'" class= "' + $columnName + '"type="text" name="Samples_information['+ $columnName + '][]" value="" ></td>').insertBefore($(this));
                $compteur++;
            }

        });

    });

    $("#sample_table ").on("click", "#delColButton" ,function () {

        var $columnName = window.prompt("Enter Column name", "");

        if (! /^[a-zA-Z0-9]+$/.test($columnName)){ // check if the string write by user is available
            return;
        }
        $("th").filter(function() {
            return $(this).text() === $columnName;
        }).remove(); //delete the title
        $("td").find('input[name="' + $columnName + '[]"]').remove(); // delete the input element
        $("." + $columnName +"").remove(); //delete the td element

    });


{/literal}
</script>