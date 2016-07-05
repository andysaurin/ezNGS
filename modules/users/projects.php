<?php

class projects extends NQ_Auth_User
{
    public function __construct()
    {
        parent::__construct();
        $this->class_title = "Projects - Users Panel";
        $this->all_projects = $this->all_projects();

        foreach($this->all_projects as $k => $project) {

            $users = $this->project_users($project->id);

            $this->all_projects[$k]->users = $users;
        }

        $this->set("all_users", $this->all_users( $users ) );
    }

    public function __default()
    {

        $this->set('projects',  $this->all_projects );

    }

    public function __destruct()
    {
        parent::__destruct();
    }

}

?>