<?php

class projects_users extends NQ_Auth_User
{
    public function __construct()
    {
        parent::__construct();

        $this->class_title = "Projects - Users Panel";
        $this->all_projects = $this->all_projects();

        foreach($this->all_projects as $k => $project) {

            $users = $this->project_users($project->id);

            $this->all_projects[$k]->users = $users;
            $this->all_projects[$k]->available_users = $this->all_users($users);

        }

        $this->set("all_users", $this->all_users($users) );

        //We need to know if current user are manager of some projects or not
        //Strategy create an array where you find name's project manage by current user
        //if this one is never manager create an empty array
        $manager = array();

        foreach($this->all_projects as $k => $project) {
            if($this->is_project_manager( $this->user->id,$project->id)){
                $manager[] = $project->name;
                }
            }

        $this->set("manager",  $manager );
        $this->set('projects',  $this->all_projects );
    }

    public function __default()
    {
        if (!empty($_POST)) {//check if this array is empty.
            echo $_POST['group_id'];
            if (!$this->delete_rna_group_already_define($_POST['group_id'],$_POST['project_id'] )){
                die("Error De la muerta");
            }
        }
        //$this->set('projects',  $this->all_projects );

    }

    public function define_groups()
    {
        if (!empty($_POST)){//check if the array are empty
            //we need the project_id so we save it and delete it in the array
            $project_id=$_POST['project_id'];
            array_shift($_POST);
            //in the html table foreach sub array the first line is empty and is used like a "template"
            //so we delete these lines before to save all information in the DB
            array_shift($_POST["Group_name"]);
            array_shift($_POST["Group_description"]);
            if (!$this->rna_groups_in_db($_POST, $project_id)){
                die("Error saving RNA group");
            }
        }
    }

    public function save_design()
    {
        if (!empty($_POST)) {//check if this array is empty.
            //in the html table foreach sub array the first line is empty and is used like a "template"
            //so we delete these lines before to save all information in the DB
            $project_id=$_POST['project_id'];
            unset($_POST['project_id']);
            array_shift($_POST["Group_name_available"]);
            array_shift($_POST["Group_reference"]);
            array_shift($_POST["Group_test"]);

/*            print_r($_POST);*/
            if (!$this->write_rna_design($_POST, $project_id)){
                die("Error saving RNA design.tab");
            }

        }
    }

    /* 11/10/2016 public function delete_rna_group_already_define()
    {
        if (!empty($_POST)) {//check if this array is empty.
            echo $_POST['group_id'];
            if (!$this->delete_rna_group_already_define($_POST['group_id'],$_POST['project_id'] )){
                die("Error De la muerta");
            }
        }
    }*/

    public function write_sample_rna()
    {
        if (!empty($_POST)) {//check if this array is empty.
            $project_id=$_POST['project_id'];
            unset($_POST['project_id']);
            array_shift($_POST);
            //print_r($_POST);

            if (!$this->Write_tab_file($_POST,$project_id)){
                die("Error saving RNA samples.tab");
            }

        }
    }

    public function save_assignation()
    {
        //print_r($_POST);
        /* 18/09/2016 for($sample = 1; $sample < count($_POST["rna_groups_assignation"]["md5sum"]); $sample++) {
            $md5 = $_POST["rna_groups_assignation"]["md5sum"][$sample];
            $Sample_name = $_POST["rna_groups_assignation"]["Sample_name"][$sample];
            $groups = "";
            foreach ($_POST["rna_groups_assignation"][$md5] as $group => $groupName) {
                $groups = $groups . $groupName . ", ";
            }
            echo "MD5sum: ". $md5 . "Sample_name: " . $Sample_name . "Group: " . $groups;
        }*/

        if (!empty($_POST)) {//check if this array is empty.
            $project_id = $_POST['project_id'];
            array_shift($_POST);
            if (!$this->add_rna_assignation_in_db($_POST, $project_id)){
                die("Error saving RNA assignation");
            }

        }


    }

    public function save_annotations()
    {
        if (!empty($_POST)){//check if this array is empty.
            //We store the location of the YAML file
            $filename = SYSTEM_PROJECTS_ROOT . "/" . $_POST['project_id'] . "/metadata/" . "/description.yml";
            //array_shift($_POST);

            /*First step fill the metadata table, so need to obtain all column name*/
            $all_col_name_array = array_keys($_POST["Samples_information"]);
            if (!$this->metadata_in_db($all_col_name_array, $_POST['project_id'])){
                die("Error saving metadata header");
            }
            if (!$this->metadata_value_in_db($_POST["Samples_information"])){
                die("Error saving metadata value");
            }

            array_shift($_POST);
            $res = yaml_emit_file($filename, $_POST, $encoding = YAML_UTF8_ENCODING );
        }
    }

    public function save_rna_config()
    {
        if (!empty($_POST)) {//check if this array is empty.
            $pathToProject = SYSTEM_PROJECTS_ROOT . "/" . $_POST['project_id'];
            $filenameYaml = SYSTEM_PROJECTS_ROOT . "/" . $_POST['project_id'] . "/metadata" . "/config.yml";
            #$filenameJson = SYSTEM_PROJECTS_ROOT . "/" . $_POST['project_id'] . "/metadata" . "/config.json";
            $temp = SYSTEM_PROJECTS_ROOT . "/" . $_POST['project_id'] . "/metadata" . "/configtemp.yml";
            $configinit = yaml_parse_file($filenameYaml);
            //print_r($configinit);

            /*Part about some parameters set by the server*/
            $_POST["author"] = $this->user->username;
            $_POST["qsub"]="-q biotools -V -m a -d . ";
            $_POST["metadata"]["samples"] = $pathToProject . "/metadata/samples.tab";
            $_POST["metadata"]["design"] = $pathToProject . "/metadata/design.tab";
            $_POST["metadata"]["configfile"] = $pathToProject . "/metadata/config.yml";

            $_POST["dir"]["base"] = $pathToProject;
            $_POST["dir"]["reads_source"] = $pathToProject . "/samples";
            $_POST["dir"]["fastq"] = $pathToProject . "/samples";
            $_POST["dir"]["genome"] = SYSTEM_DATA_ROOT .  "/genomes/Ecoli_K12"; //WARNING HARD CODE to chage after test !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
            $_POST["dir"]["results"] = $pathToProject . "/results";
            $_POST["dir"]["gene_regulation"] = $pathToProject . "/gene-regulation";

            $_POST["dir"]["samples"] = $pathToProject . "/results/samples";
            $_POST["dir"]["diffexpr"] = $pathToProject . "/results/diffexpr";
            $_POST["dir"]["reports"] = $pathToProject . "/results/reports";

            //echo implode(" ",$_POST["Mapping"]);

            /*if (isset($_POST["Mapping"])){
                $configinit["tools"]["mapping"]=implode(" ",$_POST["Mapping"]);
                unset($_POST["Mapping"]);
            }*/

            $filenameToolsAvailable = SYSTEM_CONFIG_TOOLS_DIR . "tools_available.yml";
            $configToolsAvailable = yaml_parse_file($filenameToolsAvailable);
            $stepsOfAnalysis = array_keys($configToolsAvailable["RNA-seq"]);

            foreach ($_POST as $key => $value){
                if (is_array($value)){
                    //echo $value;
                    foreach ($value as $key2 => $item) {
//                        if (isset($_POST["Mapping"])){
                        //if ($key == "Mapping"){
                        if (in_array($key,$stepsOfAnalysis)){
                            $stepName = strtolower($key);
                            //echo $value;
                            //echo $_POST[$key];
                            //echo $key;
                            $configinit["tools"]["$stepName"]=implode(" ",$_POST[$key]);
                            //unset($key);
                        }else{
                            $configinit[$key][$key2]=trim($item);
                        }
                    }
                }else{
                    $configinit[$key]=trim($value);
                }
            }

            //Write the config file
            $res = yaml_emit_file($temp, $configinit, $encoding = YAML_UTF8_ENCODING );

            `iconv -f utf-16be -t utf8 "{$temp}" > "{$filenameYaml}"`;

            //file_put_contents($filenameJson, json_encode($configinit));


            /* 27/10/2016 $yaml = Yaml::dump($configinit);

            file_put_contents($filename, $yaml);*/

            //we need to touch all the data files before to run the analysis
            $pathToSamples =$pathToProject . "/samples";
            `find "{$pathToSamples}" -exec touch {} \;`;

        }
    }

    public function go()
    {
	    if ( is_numeric($_GET['id']) && $_GET['id'] > 0 ) {
	   	 //get information on project from DB
            //print_r($this->project_info( (int)$_GET['id'] ));
	   	 	$this->set('project', $this->project_info( (int)$_GET['id'] ) );
            $this->all_files = $this->get_all_files_in_project($_GET['id']);
            $this->set('filetable', $this->all_files);
            $this->all_rna_groups = $this->get_all_rna_groups_in_project($_GET['id']);
            $this->set('rna_groups', $this->all_rna_groups);
            //Before to load this YAML file we need to check if it exist
            $filename = SYSTEM_PROJECTS_ROOT . "/" . $_GET['id'] . "/metadata/" . "/description.yml";
            if (file_exists($filename)){
                $this->all_annotations = json_encode(yaml_parse_file($filename));
            }else{
                $this->all_annotations = array();
            }
            $this->set('all_annotations', $this->all_annotations);

            $this->rna_group_already_assignated = $this->rna_group_already_assigned_in_db($_GET['id']);
            $this->set('rna_group_already_assignated', $this->rna_group_already_assignated);

            //print_r($this->rna_group_already_assignated);

            /*If in this project a design.tab file exist load it*/
            $filenameDesign = SYSTEM_PROJECTS_ROOT . "/" . $_GET['id'] . "/metadata/" . "/design.tab";
            $design_rna = array();
            if (file_exists($filenameDesign)) {//check if file exist
                $handle = fopen($filenameDesign, "r");//open a flux
                while (($data = fgetcsv($handle,  0, "\t")) !== FALSE) {//read line by line
                    array_push($design_rna,$data);//store every lines in a table
                }
                array_shift($design_rna);
                //print_r($design_rna);
                $this->set("design_rna",$design_rna);
            }

            /*Part about load all tools's name available to make analysis*/
            $filenameToolsAvailable = SYSTEM_CONFIG_TOOLS_DIR . "tools_available.yml";
            //$configToolsAvailable = json_encode(yaml_parse_file($filenameToolsAvailable));
            $configToolsAvailable = yaml_parse_file($filenameToolsAvailable);
            //print_r($configToolsAvailable);
            $this->set("tools_available",$configToolsAvailable);


            //we need a global variable path_project NOT SURE 19/10/2016
            //$this->set('path_project', SYSTEM_PROJECTS_ROOT . "/" . $_GET['id']);

            }

		$this->set('data_types', $this->all_data_types() );

    }

    public function __destruct()
    {
        parent::__destruct();
    }

}

?>