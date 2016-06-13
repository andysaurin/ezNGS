<?php

class projects extends NQ_Auth_Admin
{
	public function __construct()
	{
		parent::__construct();
		$this->class_title = "Projects - Admin Panel";
		$this->all_projects = $this->all_projects();

		//we are in admin control panel, thus project manager for all
		$this->set("is_project_manager", true);

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


	public function edit()
	{

//perhaps todo

	}

	public function create()
	{


		if ( isset($_POST['create_user']) ) {
			//form submitted


			$retvar = $this->new_project($arg1, $arg2, $arg3);

			if ( $retvar === true ) {
echo 'all ok';
exit;


			} else {

				$message['text'] = "An error occurred creating the project.<br /> The error returned was: <br /><code>".$retvar."</code></i>";
				$message['type'] = 'alert';
				$message['delay'] = '4000';
				$this->session->message = $message;


			}
//print_r($_POST);

		}


	}


	public function __destruct()
	{
		parent::__destruct();
	}

}

?>