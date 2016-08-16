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

    public function go()
    {
	    if ( is_numeric($_GET['id']) && $_GET['id'] > 0 ) {
	   	 //get information on project from DB
            print_r($this->project_info( (int)$_GET['id'] ));
	   	 	$this->set('project', $this->project_info( (int)$_GET['id'] ) );
	    }

    }

    public function __destruct()
    {
        parent::__destruct();
    }

}

?>