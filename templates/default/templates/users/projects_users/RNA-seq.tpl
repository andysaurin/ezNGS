<h2>Sample grouping</h2>

<script>
    {*javascript part*}
    {literal}

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

        var tableId = {/literal}{$rna_groups|json_encode}{literal};
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

    {/literal}
</script>


<form id="form-define-groups" action="/{$module}/{$class}/define_groups" method="POST">

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

{if $rna_groups|@count > 0}
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

            <script type="text/javascript">loadGroupAvailable()</script>

        </div>
    </fieldset>
{/if}

{debug}