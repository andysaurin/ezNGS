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
	    }

		$this->set('data_types', $this->all_data_types() );

    }

    public function __destruct()
    {
        parent::__destruct();
    }

}

?>