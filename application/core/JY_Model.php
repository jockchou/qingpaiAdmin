<?php if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );

class JY_Model extends CI_Model {
	
	function __construct() {
		parent::__construct ();
	}
	
	public function createRedis($m) {
		$this->load->config('redis', TRUE);
		$config = $this->config->item('redis');
		$config = $config[$m];
		
		$host = $config['host'];
		$auth = $config['auth'];
		$port = $config['port'];
		$db	  = $config['db'];
		
		try {
			$redis = new Redis();
			$redis->connect($host, $port, 10);
			$redis->auth($auth);
			$redis->select($db);
			return $redis;
		} catch (Exception $e) {
			log_message('error', "Redis init fail. " . $e);
			return FALSE;
		}
	}
	
	public function createMongoDB($m = 'pingo'){
 		
		$this->load->config('mongo', TRUE);
		$config = $this->config->item('mongo');
		$config = $config[$m];
		
		$host = $config['host'];
		$port = $config['port'];
		$db	  = $config['db'];
		$mongoURI= "mongodb://"."$host".":".$port;
		try {
			$mongo = new MongoClient($mongoURI);
			$mongodb = $mongo -> selectDB($db);
			return $mongodb;
		} catch (Exception $e) {
			log_message('error', "MongoDB init fail. " . $e);
			return FALSE;
		}
 	}
}

/* End of file JY_Model.php */
/* Location: ./application/core/JY_Model.php */