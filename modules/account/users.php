<?php

class users extends NQ_Auth_User
{
	public function __construct()
	{
		parent::__construct();
		$this->class_title = "";
	}

	public function __default()
	{

	}

	public function view()
	{
		$id = (int)$_GET['id'];

		$this->set('user_details', $this->get_user_details($id));

	}

	public function __destruct()
	{
		parent::__destruct();
	}

}

?>