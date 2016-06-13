<?php

/**
* NQ_Object_DB
*
* @package Framework
* @filesource
*/

if (DB_CLASS == 'ezSQL') {
	require_once('DB/ezSQLcore.php');

	if (!defined('DB_DRIVER'))
		die("DB_DRIVER is not defined");

	$db_driver_file = "ezSQL_".DB_DRIVER.".php";
	if ( !is_file(SYSTEM_DIRECTORY_ROOT."/includes/DB/{$db_driver_file}") || !is_readable(SYSTEM_DIRECTORY_ROOT."/includes/DB/{$db_driver_file}") )
		die("The ezSQL driver file '{$db_driver_file}' is not available in includes/DB");

	require_once("DB/{$db_driver_file}");

} else {
	die ('NQ_Object_DB has no MySQL driver defined');
}

/**
* NQ_Object_DB
*
* Extends the base NQ_Object class to include a database connection.
*
* @package Framework
*/
abstract class NQ_Object_DB extends NQ_Object
{

	public function __construct()
	{
		parent::__construct();
		global $_DB;
//die(print_r($_DB));
		foreach ($_DB['db'] as $db => $params) {
			/**
			* dbconn
			* provides a hook to multiple database connections set in array $_DB
			*
			* Connections are accessed using the $_DB[$key] key value:
			* 	eg $this->{$key}
			*
			* The first connection provided in $_DB ($_DB[0]) can be accessed with $this->db
			* This provides backwards compatability with previous framework versions
			*
			*
			* @package Framework
			*/

			$connection = $this->dbConnect($params);
			if ( !is_object($this->db) ) {
				$this->db = new stdClass;
			}
			$this->db->$db = $connection;

		}
	}

	private function dbConnect($arr) {
		if ( !isset($connection) || $connection === null) {

			if (DB_CLASS == 'ezSQL') {
				$driver = "ezSQL_".DB_DRIVER;

				if ( DB_DRIVER == 'sqlite' ) {
					$connection = new ezSQL_sqlite(SYSTEM_DATA_ROOT."/sqlite/", $arr['DB_NAME']);
				} elseif ( DB_DRIVER == 'sqlite3' ) {
					$connection = new ezSQL_sqlite3(SYSTEM_DATA_ROOT."/sqlite/", $arr['DB_NAME']);
				} else {
					$connection = new $driver($arr['DB_USER'],$arr['DB_PASS'],$arr['DB_NAME'],$arr['DB_HOST']);
				}

				if (DB_USECACHE == true)
				{
					$connection->cache_dir = DB_CACHEDIR;
					$connection->cache_timeout = DB_CACHETIMEOUT;
					$connection->use_disk_cache = true;
					$connection->cache_queries = true;

				}else{
					$connection->use_disk_cache = false;
					$connection->use_cache_queries = false;
					$connection->cache_inserts = false;
				}

				$connection->hide_errors();
			}
		}
		return $connection;
	}

	function __destruct()
	{
		parent::__destruct();

	}
}

?>
