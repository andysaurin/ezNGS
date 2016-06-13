<?php
/**
* db.php
*
* @package Framework
* @filesource
*/

/**
* DB connection class
* Which mysql DB class to use
* @global string DB_CLASS database class to use
* @link ezSQL: https://github.com/ezSQL/ezSQL
*/
define ('DB_CLASS', 'ezSQL');

/**
* DB driver
* Which DB driver to use - the corresponding ezSQL file must be available in includes/DB
* e.g. for DB_DRIVER 'mysql', the file ezSQL_mysql.php will be used
* @global string DB_DRIVER database driver to use
* @link ezSQL: https://github.com/ezSQL/ezSQL
*/
//define ('DB_DRIVER', 'mysql');
define ('DB_DRIVER', 'sqlite3');

define ('DB_DIR', SYSTEM_DATA_ROOT . '/sqlite');

/**
* DB connection params
* These are the params required for the mysql driver
*
* @global mixed $_DB array where keys become the connection hook (see NQ_Obect_DB)
*/

$files = scandir(DB_DIR);

$databases = array();

$_DB = array ( 'db' => array() );

if ( is_array($files) ) {

	foreach ($files as $file ) {
		if (preg_match("/\.db$/", $file) ) {
			$dbname = str_replace(".db", "", $file);
			$_DB['db'][$dbname]['DB_NAME'] = $file;
		}
	}
}



//$_DB = array ( 'db' => $databases );
//print_r($_DB);

//exit;
/*

	'db' => array (
		'DB_USER' => 'dbuser',
		'DB_PASS' => 'dbpass',
		'DB_HOST' => 'localhost',
		'DB_NAME' => 'amidex'
	),

);
*/

/**
* ezSQL cache params
* Turn on/off caching of ezSQL queries
*
* @global strings DB_ for ezSQL cache
* @link http://www.jvmultimedia.com/portal/node/14
*/
define ('DB_USECACHE', false); //will we use an internal mysql cache or not?
define ('DB_CACHEDIR', SYSTEM_DATA_ROOT.'/db_c'); //cache path
define ('DB_CACHETIMEOUT', 1); //life of cache in hours

?>
