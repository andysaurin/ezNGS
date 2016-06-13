<?php

	session_start();


	echo "name before=".$_SESSION['name']."<br>";
	$_SESSION['name'] = 'lucie';
	echo "name after=".$_SESSION['name']."<br>";
