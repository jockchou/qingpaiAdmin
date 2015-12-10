<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| REDIS 配置项
| -------------------------------------------------------------------
*/

$config['session']['host'] 	= '192.168.100.6';
$config['session']['auth'] 	= 'joyo2014';
$config['session']['port'] 	= '6379';
$config['session']['db'] 	= '5';


$config['push']['host'] 	= '192.168.100.6';
$config['push']['auth'] 	= 'joyo2014';
$config['push']['port'] 	= '6379';
$config['push']['db'] 		= '6';

//缓存
$config['cache']['host'] 	= '192.168.100.6';
$config['cache']['auth'] 	= 'joyo2014';
$config['cache']['port'] 	= '6379';
$config['cache']['db'] 		= '9';

//操作行为摘要
$config['action']['host'] 	= '192.168.100.6';
$config['action']['auth'] 	= 'joyo2014';
$config['action']['port'] 	= '6379';
$config['action']['db'] 	= '8';

