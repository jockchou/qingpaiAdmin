<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class JY_Controller extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->helper("url");
		$this->load->library('session');
	}
	
	//获取自建话题
	protected function getCustomSubject() {
		if (ENVIRONMENT == 'production') {
			$subjectID = 36;
		} else if (ENVIRONMENT == 'testing') {
			$subjectID = 10;
		} else {
			$subjectID = 10;
		}
		return array('subjectID' => $subjectID, 'title' => '我在随遇的日常', 'isOfficial' => 1);
	}
	
	public function checkJumpID($type, $id) {
		$result = TRUE;
		if ($type == 3) {
			$this->load->model('jjuser_model', 'jjuser');
			$user = $this->jjuser->get_user_by_id((int)$id);
			
			$result = empty($user) ? '用户ID不存在' : TRUE;
		} else if ($type == 4) {
			$this->load->model('topic_model', 'topic');
			$topic = $this->topic->getTopicById((int)$id);
			
			$result = empty($topic) ? '帖子ID不存在' : TRUE;
			
		} else if ($type == 6) {
			$this->load->model('subjectactivity_model', 'subject');
			$subject = $this->subject->getSubjectById((int)$id);
			
			$result = empty($subject) ? '话题ID不存在' : TRUE;
		}
		return $result;
	}

	public function getJumpStrByType($type, $jump) {
		switch($type){
			case 1: return $jump;
			case 2: return 'homepage://';
			case 3: return 'profile://' . $jump;
			case 4: return 'topic://' . $jump;
			case 5: return 'subjectlist://';
			case 6: return 'subject://' . $jump;
			case 7: return 'map://';
			case 8: return 'square://';
			case 9: return 'hotuser://';
			default: return $jump;
		}
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
	
	public function setRedisCache($key, $val, $time=3600) {
		$redis = $this->createRedis('cache');
		$rtn = false;
		if ($redis) {
			$rtn = $redis->setex($key, $time, $val);
			$redis->close();
		}
		return $rtn;
	}
	
	public function getRedisCache($key) {
		$redis = $this->createRedis('cache');
		$rtn = false;
		if ($redis) {
			$rtn = $redis->get($key);
			$redis->close();
		}
		return $rtn;
	}
	
	public function setRedisSetCache($value, $m = "xiaomi", $key = "xiaomi_chat"){
		$redis = $this->createRedis($m);
		$rtn = false;
		if ($redis) {
			$rtn = $redis->zAdd($key, JY_getMsTime(), $value);
			$redis->close();
		}
		return $rtn;
	}
	
	public function getRedisSetCache($m = "xiaomi", $key = "xiaomi_chat") {
		$redis = $this->createRedis($m);
		$rtn = false;
		if ($redis) {
			$rtn = $redis->zRevRangeByScore($key, JY_getMsTime(), JY_getMsTime() - 24*60*60*1000, array('limit' => array(0, -1),'withscores' => TRUE));
			$redis->close();
		}
		return $rtn;
	}
	
	//发送推送请求
	public function sendPushCommand($pushData, $targetUserID=null) {
		$redis = $this->createRedis('push');
		$qName = "queue.topic.1";
		
		if ($redis) {
			$pushBody = array(
				'targetUserID' => $targetUserID,
				'msgInfo' => $pushData
			);
			$pushBody = json_encode($pushBody);
			$result = $redis->lPush($qName, $pushBody);
			return TRUE;
		}
		return FALSE;
	}
	
	/*
	 * 用随遇小秘与指定用户聊天
	 * 仅支持纯文本 type=0和图片type=1两种方式
	 * type=0,$res填纯文本
	 * type=1,$res填图片地址
	 * */
	public function xiaoMiChat($toUserID, $type, $res) {
		$content = "";
		$resUrl = "";
		$serKey = JY_key($toUserID, JY_SECRET_KEY);
		if ($type == 0) {
			$content = $res;
		} else if ($type == 1) {
			$resUrl = $res;
		}
		
		$postData = array(
			"type" => $type,
			"content" => $content,
			"resUrl" => $resUrl,
			"replyUserID" => $toUserID,
			"key" => $serKey
		);
		
		$this->load->library('HttpsClient');
		$api = JY_PINGO_API_URL . "topic/XiaMiChat";
		
		$wbRtnText = $this->httpsclient->post($api, json_encode($postData));
		log_message('debug', $wbRtnText);
		if ($wbRtnText) {
			$wbRtnText = json_decode($wbRtnText, TRUE);
			if ($wbRtnText && isset($wbRtnText['rtn']) && $wbRtnText['rtn'] == "0") {
				return $wbRtnText;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	public function cleanSession($userID) {
		$redis = $this->createRedis('session');
		if ($redis) {
			$redis->delete($userID);
			$redis->close();
		}
		return true;
	}
	
	//输出自定义JSON
	public function renderMessage($rtn, $message, $data=null) {
		$tmp = array(
			"rtn" => $rtn,
			"msg" => $message
		);
		
		if ($data !== null) {
			$tmp['data'] = $data;
		}
		
		$this->output->set_content_type("application/json;charset=utf-8");
		$this->output->set_output(json_encode($data));
	}
	
	/*
	* 输出JSON数据
	*/
	protected function renderJSON($json_str, $callback=NULL) {

		return  $this->renderView('json', $json_str, $callback);
	}

	/*
	* 输出HTML数据
	*/
	protected function renderHTML($html_str) {

		return  $this->renderView('html', $html_str);
	}

	/*
	* 输出XML数据
	*/
	protected function renderXML($xml_str) {

		return $this->renderView('xml', $xml_str);
	}

	/**
	 * @desc  生成面包屑导航
	 * @param arr $address
	 */
	protected function createCrumbs($address){
		$html  = '<div id="content-header">';
		$html .= '<div id="breadcrumb">';
		$html .= '<a href="' . base_url() . '" data-original-title="返回首页" class="tip-bottom"><i class="icon-home"></i>首页</a>'; 
		if(!empty($address)){
			foreach($address as $k=>$v){
				$html .= '<a href="' . base_url($k) . '" class="tip-bottom" >'. $v .'</a>';
			}
		}
	
		$html .= '</div>';
		$html .= '</div>';
		return $html;
	}
	/*
	* 输出指定格式数据数据
	*/
	protected function renderView($format, $str, $callback=NULL) {
		$mime = "text/html";

		switch ($format) {
			case 'json':
				$mime = "application/json;charset=utf-8";
				break;
			case 'html':
				$mime = "text/html;charset=utf-8";
				break;
			case 'xml':
				$mime = "text/xml;charset=utf-8";
				break;
			default:
				$mime = "text/html;charset=utf-8";
				break;
		}
		$this->output->set_content_type($mime);

		//压缩JSON字符串
		if ($format == 'json') {
			$str = json_encode(json_decode($str));
			if ($callback) {
				$str = $callback . "(" . $str . ");";
			}
		}

		$this->output->set_output($str);
		return $str;
	}
	
	public function cURL_post($url, $post_data) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		$data = curl_exec($ch);
		
		if($data){
			curl_close($ch);
			return $data;
		}
		else { 
			$error = curl_errno($ch);
//			$err = curl_error($ch);
			curl_close($ch);
			return false;
		}
	}
	
	public function clearRedisCache($m, $key) {
		$rtn = false;
		
		if (!empty($key)) {
			$redis = $this->createRedis($m);
			
			if ($redis) {
				
				$keyArr = $redis->keys($key);
				if (!empty($keyArr)) {
					$rtn = $redis->delete($keyArr);
					$redis->close();
				} else {
					$rtn = true;
				}
			}
		}
		return $rtn;
	}
}
/* End of file JY_Controller.php */
/* Location: ./application/core/JY_Controller.php */