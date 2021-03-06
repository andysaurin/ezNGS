<?php

class projects extends NQ_Auth_Admin
{
	public function __construct()
	{
		parent::__construct();
		$this->class_title = "Projects - Admin Panel";
		$this->all_projects = $this->all_projects();

		//we are in admin control panel, thus project manager for all
		$this->set("is_admin", true);

		//$all_users = $this->all_users();


		foreach($this->all_projects as $k => $project) {

			$users = $this->project_users($project->id);

			$this->all_projects[$k]->users = $users;
			$this->all_projects[$k]->available_users = $this->all_users($users);
		}

		//$this->set("all_users", $this->all_users($users) );

	}

	public function __default()
	{

		$this->set('projects',  $this->all_projects );

//die(print_r($this->all_projects));
	}


	public function edit()
	{

//perhaps todo

	}

	public function go()
	{

//perhaps todo

	}

	public function create()
	{


		if ( isset($_POST['create_project']) ) {
			//form submitted

			$retvar = $this->new_project($_POST['project_name']);

			if ( $retvar === true ) {
				$message['text'] = "New project is created: <br /><code>".$_POST['project_name']."</code></i>";
				$message['type'] = 'success';
				$message['delay'] = '4000';
				$this->session->message = $message;

			} else {

				$message['text'] = "An error occurred creating the project.<br /> The error returned was: <br /><code>".$retvar."</code></i>";
				$message['type'] = 'alert';
				$message['delay'] = '4000';
				$this->session->message = $message;


			}

		}


	}


	public function __destruct()
	{
		parent::__destruct();
	}

}

?>