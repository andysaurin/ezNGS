<?php

class import extends NQ_Auth_User
{
	public function __construct()
	{
		parent::__construct();

	}

	public function __default()
	{

		if ( !$_POST['path'] )
			die("not_ok 1");

		if ( !$_POST['project_id'] || !is_numeric($_POST['project_id']) || $_POST['project_id'] < 0)
			die("not_ok 2");


		$from_path = SYSTEM_UPLOAD_ROOT . "/{$this->user->username}/" . base64_decode( $_POST['path'] );

		if ( !is_file($from_path) )
			die("not_ok 3");



//echo $from_path;

		$md5 = `md5sum "{$from_path}"`;
		$md5 = substr($md5, 0, 32);

		if ( !preg_match("/^[a-z0-9]{32}$/", $md5) )
			die("not_ok 4");

		$path_parts = pathinfo($from_path);
		$file_ext = $path_parts['extension'];

//echo "md5sum = '{$md5}'";

		$to_dir = SYSTEM_PROJECTS_ROOT . "/" . $_POST['project_id'] . "/samples/" . $md5;

		`mkdir "{$to_dir}"`;

		if ( !is_dir($to_dir) || !is_writeable($to_dir) )
			die("not_ok 5");


		$to_filename = "{$md5}.{$file_ext}";
		$to_filepath = "{$to_dir}/{$to_filename}";

		`cp "{$from_path}" "{$to_filepath}"`;

		if ( is_file($to_filepath) ) {

			die("ok"); //file copied successfully

		}

		die("not_ok 6");



	}



	public function __destruct()
	{
		parent::__destruct();
	}

}

?>