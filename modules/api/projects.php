<?php

class projects extends NQ_Auth_User
{
	public function __construct()
	{
		parent::__construct();
		$this->class_title = "";

		if ( !$this->is_project_manager( $this->user->id, (int)$_REQUEST['project_id'] )  ) {
			exit();
		}

	}

	public function __default()
	{



	}

	public function add_user()
	{
		$user_id = (int)$_POST['user_id'];
		$project_id = (int)$_POST['project_id'];

		//check to make sure this project ID exists
		if ( !$this->db->master->get_var( "SELECT `id` FROM `projects` WHERE `id`={$project_id} LIMIT 1" ) ) {

			echo "not ok";

		} else {

			$this->db->master->query( "INSERT INTO `users_projects` (`user_id`, `project_id`) VALUES ({$user_id}, {$project_id})" );
			$rowsAffected = $this->db->master->rows_affected;

			if ($rowsAffected > 0){ //we inserted the user
				echo 'ok';
			} else {
				echo "not ok";
			}

		}

	}

	public function remove_user()
	{

		$user_id = (int)$_POST['user_id'];
		$project_id = (int)$_POST['project_id'];

		//$this->db->master->query(" DELETE FROM `users_projects` WHERE project_id={$project_id} AND `user_id`={$user_id} ");
		$this->db->master->query( "DELETE FROM `users_projects` WHERE `project_id`={$project_id} AND `user_id`={$user_id}" );
		$rowsAffected = $this->db->master->rows_affected;

		if ($rowsAffected > 0){
			echo 'ok';
		} else {
			echo "not ok";
		}
	}

	public function __destruct()
	{
		parent::__destruct();
	}

}

?>