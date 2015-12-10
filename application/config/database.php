<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['autoinit'] Whether or not to automatically initialize the database.
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

$active_group = 'default';
$active_record = TRUE;


$db['default']['hostname'] = '192.168.100.4';
$db['default']['username'] = 'root';
$db['default']['password'] = 'joyo2014';
$db['default']['database'] = 'pingo';
$db['default']['dbdriver'] = 'mysql';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = false;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8mb4';
$db['default']['dbcollat'] = 'utf8mb4_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;

$db['joyo_admin']['hostname'] = '192.168.100.4';
$db['joyo_admin']['username'] = 'root';
$db['joyo_admin']['password'] = 'joyo2014';
$db['joyo_admin']['database'] = 'joyo_admin';
$db['joyo_admin']['dbdriver'] = 'mysql';
$db['joyo_admin']['dbprefix'] = '';
$db['joyo_admin']['pconnect'] = FALSE;
$db['joyo_admin']['db_debug'] = TRUE;
$db['joyo_admin']['cache_on'] = FALSE;
$db['joyo_admin']['cachedir'] = '';
$db['joyo_admin']['char_set'] = 'utf8';
$db['joyo_admin']['dbcollat'] = 'utf8_general_ci';
$db['joyo_admin']['swap_pre'] = '';
$db['joyo_admin']['autoinit'] = TRUE;
$db['joyo_admin']['stricton'] = FALSE;

$db['pingo_analysis']['hostname'] = '192.168.100.4';
$db['pingo_analysis']['username'] = 'root';
$db['pingo_analysis']['password'] = 'joyo2014';
$db['pingo_analysis']['database'] = 'pingo_analysis';
$db['pingo_analysis']['dbdriver'] = 'mysql';
$db['pingo_analysis']['dbprefix'] = '';
$db['pingo_analysis']['pconnect'] = FALSE;
$db['pingo_analysis']['db_debug'] = TRUE;
$db['pingo_analysis']['cache_on'] = FALSE;
$db['pingo_analysis']['cachedir'] = '';
$db['pingo_analysis']['char_set'] = 'utf8mb4';
$db['pingo_analysis']['dbcollat'] = 'utf8mb4_general_ci';
$db['pingo_analysis']['swap_pre'] = '';
$db['pingo_analysis']['autoinit'] = TRUE;
$db['pingo_analysis']['stricton'] = FALSE;


$db['pingo_ms']['hostname'] = '192.168.100.9';
$db['pingo_ms']['username'] = 'atlas';
$db['pingo_ms']['password'] = 'joyo2014';
$db['pingo_ms']['database'] = 'pingo_ms';
$db['pingo_ms']['dbdriver'] = 'mysql';
$db['pingo_ms']['dbprefix'] = '';
$db['pingo_ms']['pconnect'] = TRUE;
$db['pingo_ms']['db_debug'] = FALSE;
$db['pingo_ms']['cache_on'] = TRUE;
$db['pingo_ms']['cachedir'] = '';
$db['pingo_ms']['char_set'] = 'utf8mb4';
$db['pingo_ms']['dbcollat'] = 'utf8mb4_general_ci';
$db['pingo_ms']['swap_pre'] = '';
$db['pingo_ms']['autoinit'] = TRUE;
$db['pingo_ms']['stricton'] = TRUE;
$db['pingo_ms']['port'] 	= 1234;



/* End of file database.php */
/* Location: ./application/config/database.php */