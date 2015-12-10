<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| REDIS 配置项
| -------------------------------------------------------------------
*/

$config['session']['host'] 	= '192.168.200.2';
$config['session']['auth'] 	= 'joyo2014';
$config['session']['port'] 	= '6379';
$config['session']['db'] 	= '5';


$config['push']['host'] 	= '192.168.200.2';
$config['push']['auth'] 	= 'joyo2014';
$config['push']['port'] 	= '6379';
$config['push']['db'] 		= '6';

//缓存
$config['cache']['host'] 	= '192.168.200.2';
$config['cache']['auth'] 	= 'joyo2014';
$config['cache']['port'] 	= '6379';
$config['cache']['db'] 		= '9';

//小秘私聊用户缓存
$config['xiaomi']['host'] 	= '192.168.200.2';
$config['xiaomi']['auth'] 	= 'joyo2014';
$config['xiaomi']['port'] 	= '6379';
$config['xiaomi']['db'] 	= '7';

//操作行为摘要
$config['action']['host'] 	= '192.168.200.2';
$config['action']['auth'] 	= 'joyo2014';
$config['action']['port'] 	= '6379';
$config['action']['db'] 	= '8';