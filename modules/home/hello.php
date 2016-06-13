<?php

class hello extends NQ_Auth_User
{
	public function __construct()
	{
		parent::__construct();
		$this->class_title = "Hello World";

		$this->hello = "world";
	}

	public function __default()
	{


	}

	public function world()
	{

$toto = array();
$toto['key1'] = 'val1';

$andy = (object)$toto;

//print_r( $this->db );

/*
print_r($andy);
exit;
*/
$this->set('toto', $toto);
$this->set('andy', $andy);

	}


	public function __destruct()
	{
		parent::__destruct();
	}

}

?>