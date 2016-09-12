<?php
/* Smarty version 3.1.29, created on 2016-09-12 10:59:53
  from "/home/lucie/amidex/templates/default/templates/users/projects_users/RNA-seq.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_57d66e897a7090_73306974',
  'file_dependency' => 
  array (
    'c11ebdacf7df01dc792394224975c26e487e8793' => 
    array (
      0 => '/home/lucie/amidex/templates/default/templates/users/projects_users/RNA-seq.tpl',
      1 => 1473426226,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_57d66e897a7090_73306974 ($_smarty_tpl) {
?>
<h2>Sample grouping</h2>

<?php echo '<script'; ?>
>
    
    

    /*Javascript function for the Add group possibility in the group definition table*/
    $indexGroup = 1;
    $("#group_definition").on("click","#add_group",function () {
        $indexGroup++;
        var $newTr = $("#group_definition_clone").clone().attr("id", "group_definition"+ $indexGroup);
        $newTr.find("input").each(function() {
            $(this).val('').attr("id",function(_, id) { return id + $indexGroup });
        }).end().appendTo("#group_definition");
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

    /*function loadFileIdUploaded(){

        var tableId2 = ;
        var $indexSample2 = 1;
        //first create lines
        var $numberOfLineToAdd = tableId2.length -1 ;
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
            $(this).val(tableId2[indexFile]["name"]);
            $(this).attr("value",tableId2[indexFile]["name"]);
            $(this).attr("placeholder",tableId2[indexFile]["name"]);
            indexFile++;
        });
    };*/

    
<?php echo '</script'; ?>
>


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
                <td class="Group_name"><input id="Group_name" class="input_without_space" type="text" name="Group_name[]" /></td>
                <td class="large-9 Group_description"><input id="Group_description" class="input_with_space" type="text" name="Group_description[]" /></td>
            </tr>
            <tr id="group_definition1">
                <td class="Group_name"><input id="Group_name1" class="input_without_space" type="text" name="Group_name[]" /></td>
                <td class="large-9 Group_description"><input id="Group_description1" class="input_with_space" type="text" name="Group_description[]" /></td>
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
                    <th>Group_name</th>
                    <th>Group_description</th>
                </tr>
                <tr id="group_available_clone">
                    <td class="large-2 Group_name_available"><input id="Group_name_availble" class="input_without_space" type="text" name="Group_name_available[]" readonly/></td>
                    <td class="large-12 Group_description_available"><input id="Group_description_available" class="input_with_space" type="text" name="Group_description_available[]" readonly/></td>
                </tr>
                <tr id="group_definition_available1">
                    <td class="large-2 Group_name_available"><input id="Group_name_available1" class="input_without_space" type="text" name="Group_name_available[]" readonly/></td>
                    <td class="large-12 Group_description_available"><input id="Group_description_available1" class="input_with_space" type="text" name="Group_description_available[]" readonly/></td>
                </tr>
            </table>

            <?php echo '<script'; ?>
 type="text/javascript">loadGroupAvailable()<?php echo '</script'; ?>
>

        </div>
    </fieldset>
<?php }
if (count($_smarty_tpl->tpl_vars['filetable']->value) > 0) {?>
<form id="form-assignation-groups" action="rna_groups_assignation" method="post">
    <fieldset>
        <legend>Sample-Group assignation</legend>

        <table id="group_assignation">
            <tr>
                <th>md5sum</th>
                <th>Sample_name</th>
                <th>Groups_available</th>
            </tr>
            <tr id="group_assignation_clone">
                <td class="md5sum"><input id="md5sum" type="text" name="rna_groups_assignation[md5sum][]" readonly/></td>
                <td class="Sample_name"><input id="Sample_name" type="text" name="rna_groups_assignation[Sample_name][]" readonly/></td>
                <td class="Groups_available2"></td>
            </tr>
            <tr id="group_assignation1">
                <td class="md5sum"><input id="md5sum1" type="text" name="rna_groups_assignation[md5sum][]" readonly/></td>
                <td class="Sample_name"><input id="Sample_name1" type="text" name="rna_groups_assignation[Sample_name][]" readonly/></td>
                <td class="Groups_available2"></td>
            </tr>

        </table>



    </fieldset>
    <input type="submit" value="Valider">
</form>
<?php }
}
}
