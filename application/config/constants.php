<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/


$__url = 'http://'.$_SERVER['SERVER_NAME'];
if ($_SERVER['SERVER_PORT'] != "80") {
	$__url = $__url . ":" . $_SERVER['SERVER_PORT'];
}
define('JY_BASE_URL', $__url);
define('JY_SECRET_KEY', 'joyodream_123456');
define('JY_SESSION_TIME', 3600 * 24 * 15);

define('JY_QN_accessKey', 'pU2VbLy6emWXs5x8Kxy2ZIKFtCHID-ghDimXM9tl');
define('JY_QN_secretKey', '3N2Ngow0rsEFiJzK6EoHPljza3iP55GtTwsv2WyF');

define('JY_QN_bucket_image', 'qpimage');
define('JY_QN_bucket_video', 'qpvideo');
define('JY_QN_bucket_voice', 'qpvoice');
define('JY_QN_bucket_head',  'qphead');
define('JY_QN_bucket_album', 'qpalbum');
define('JY_QN_bucket_recycle', 'qprecycle');
define('JY_QN_bucket_piclibs', 'piclibs');

define('JY_QN_FILE_SIZE_LIMIT', 3 * 1024 * 1024);

define('JY_UPLOAD_IMG_PATH', '/data/resource/image/');
define('JY_PINGO_DATA_URL', 'http://pingodata.qiniudn.com/');
define('JY_PINGO_STICKER_URL', 'http://qpsticker.qiniudn.com/');


if (ENVIRONMENT == "production") {
	define('JY_PINGO_API_URL', 'http://api.impingo.me/');
	define('JY_PINGO_API_HOST', 'api.impingo.me/');
} else {
	define('JY_PINGO_API_URL', 'http://test.api.impingo.me/');
	define('JY_PINGO_API_HOST', 'test.api.impingo.me/');
}

define('JY_QN_piclibs_url', 'http://piclibs.qiniudn.com/');

define('JY_MIME_JSON', 'application/json;charset=utf-8');

define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);


	
/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/* End of file constants.php */
/* Location: ./application/config/constants.php */