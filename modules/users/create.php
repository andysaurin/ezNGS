<?php

class create extends NQ_Auth_Admin
{
	public function __construct()
	{
		parent::__construct();
		$this->class_title = "";
	}

	public function __default()
	{

	}

public function test()
{
	echo "ok";
exit;

}
	public function __destruct()
	{
		parent::__destruct();
	}

}

?>