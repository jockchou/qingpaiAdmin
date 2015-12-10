<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jjuser extends JY_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('jjuser_model', 'jjuser');
		$this->load->model('album_model', 'album');
		$this->load->model('topic_model', 'topic');
		$this->load->model('sensitive_action_model', 'sensitive_action');
	}
	
	public function jjuserList($onlyRobots=false) {
		
		$userID = (int)$this->input->get('userID', TRUE);
		$nickname = $this->input->get('nickname', TRUE);
		$mobileNum = $this->input->get('mobileNum', TRUE);
		$openType = $this->input->get('openType', TRUE);
		$state = $this->input->get('state', TRUE);
		$order = $this->input->get('order', TRUE);
		$isDubious = $this->input->get('isDubious', TRUE);
		$isFamous = (int)$this->input->get('isFamous', TRUE);
		
		$keyword = $this->input->get('keyword', TRUE);
		
		$pageSize = (int)$this->input->get('pageSize', TRUE);
		$pageNo =  (int)$this->input->get('pageNo', TRUE);
		
		$pageSize = $pageSize <= 0 ? 10 : $pageSize;
		$pageNo = $pageNo <= 0 ? 1: $pageNo;
		
		if ($userID <= 0 AND JY_integer($nickname)) {
			$userID = (int)$nickname;
		}
		
		$queryData = $this->jjuser->getUserList($userID, $nickname, $mobileNum, $openType, $state,$isDubious, $pageNo, $pageSize, $onlyRobots, $order, $isFamous);
		
		$userList = $queryData['userList'];
		$totalPages = $queryData['totalPages'];
		
		$data['crumbs'] = $this->createCrumbs(array('jjuser/jjuserList' => '用户列表'));
		
		$data['pageSize'] = $pageSize;
		$data['pageNo'] = $pageNo;
		$data['nickname'] = $nickname;
		$data['mobileNum'] = $mobileNum;
		$data['openType'] = $openType;
		$data['state'] = $state;
		$data['isDubious'] = $isDubious;
		$data['totalPages'] = $totalPages;
		$data['userList'] = $userList;
		$data['order'] = $order;
		
		$query_config = array(
			'nickname' => $nickname === false ? '' : $nickname,
			'mobileNum' => $mobileNum === false ? '' : $mobileNum,
			'state' => $state === false ? '' : $state,
			'isDubious' => $isDubious === false ? '' : $isDubious,
			'order' => $order === false ? '' : $order,
			'openType' => $openType === false ? '' : $openType
		);
		
		$pathURL = "/jjuser/jjuserList";
		
		if ($onlyRobots) {
			$pathURL = "/jjuser/robotsList";
		}
		$data['pageUrl'] = $pathURL . "?" . http_build_query($query_config);
		$data['pathURL'] = $pathURL;
		
		$this->load->view('jjuserList.php', $data);
	}
	
	public function reportUserList() {
		$userID = (int)$this->input->get('userID', TRUE);
		$nickname = (string)$this->input->get('nickname', TRUE);
		$nickname = trim($nickname);

		$state = $this->input->get('state', TRUE);
		$isDubious = $this->input->get('isDubious', TRUE);

		$pageSize = (int)$this->input->get('pageSize', TRUE);
		$pageNo =  (int)$this->input->get('pageNo', TRUE);
		
		$pageSize = $pageSize <= 0 ? 20 : $pageSize;
		$pageNo = $pageNo <= 0 ? 1: $pageNo;

		$queryData = $this->jjuser->getUserComplainList($userID, $nickname, $state, $isDubious, $pageNo, $pageSize);
		
		$userList = $queryData['userList'];
		$totalPages = $queryData['totalPages'];
		
		$data['crumbs'] = $this->createCrumbs(array('jjuser/reportUserList' => '被举报用户'));
		
		$data['pageSize'] = $pageSize;
		$data['pageNo'] = $pageNo;
		$data['totalPages'] = $totalPages;
		$data['userList'] = $userList;
		$data['userID'] = $userID;
		$data['nickname'] = $nickname;
		$data['state'] = $state;
		$data['isDubious'] = $isDubious;

		$query_config = array(
			'userID' => $userID,
			'nickname' => $nickname,
			'state' => $state,
			'isDubious' => $isDubious,
		);

		$pathURL = "/jjuser/reportUserList";
		
		$data['pageUrl'] = $pathURL . "?" . http_build_query($query_config);
		$data['pathURL'] = $pathURL;
		
		$this->load->view('reportUserList.php', $data);
	}

	public function sensitiveActionList() {
		$userID = (int)$this->input->get('userID', TRUE);
		$state = $this->input->get('state', TRUE);
		$type = $this->input->get('type', TRUE);

		$pageSize = (int)$this->input->get('pageSize', TRUE);
		$pageNo =  (int)$this->input->get('pageNo', TRUE);
		
		$pageSize = $pageSize <= 0 ? 20 : $pageSize;
		$pageNo = $pageNo <= 0 ? 1: $pageNo;

		$queryData = $this->sensitive_action->getSensitiveActionList($userID, $type, $state, $pageNo, $pageSize);
		
		$userList = $queryData['userList'];
		$totalPages = $queryData['totalPages'];
		
		$data['crumbs'] = $this->createCrumbs(array('jjuser/sensitiveActionList' => '可疑行为用户'));
		
		$data['pageSize'] = $pageSize;
		$data['pageNo'] = $pageNo;
		$data['totalPages'] = $totalPages;
		$data['userList'] = $userList;
		$data['userID'] = $userID;
		$data['state'] = $state;
		$data['type'] = $type;

		$query_config = array(
			'userID' => $userID,
		);

		if ($state !== FALSE && $state !== '') {
			$query_config['state'] = $state;
		}

		if ($type !== FALSE && $type !== '') {
			$query_config['type'] = $type;
		}

		$pathURL = "/jjuser/sensitiveActionList";
		
		$data['pageUrl'] = $pathURL . "?" . http_build_query($query_config);
		$data['pathURL'] = $pathURL;
		
		$this->load->view('sensitiveActionList.php', $data);
	}

	public function updateSensitiveActionState() {
		$actionFrom = $this->input->get('actionFrom', TRUE);
		$userID = (int)$this->input->get('userID', TRUE);
		$type = (int)$this->input->get('type', TRUE);

		$result = $this->sensitive_action->updateSensitiveActionState($userID, $type, $actionFrom);
		echo $result ? "1" : "0";
	}
	
	public function setDubious() {
		
		$userID = (int)$this->input->get('userID', TRUE);

		$userInfo = $this->jjuser->get_user_by_id($userID);
		
		if (empty($userInfo)) {
			echo "-1";
		} else {

			$result = $this->jjuser->setDubious($userID);
			if ($result) {
				//所有帖子设为可疑
				$this->load->model('topic_model', 'topic');
				$this->topic->setDubiousByUserID($userID);
			}
			echo $result ? "1" : "0";
		}
	}
	
	public function removeDubious() {
		$userID = (int)$this->input->get('userID', TRUE);
		$result = $this->jjuser->removeDubious($userID);
		echo $result ? "1" : "0";
	}
	
	private function deleteRes($topic) {
		
		if(!empty($topic)) {
			$resUrl = $topic['resUrl'];
			if (!empty($resUrl)) {
				
				$qn = getQNFromUrl($resUrl);
				require_once(dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'third_party'. DIRECTORY_SEPARATOR . 'qiniu' . DIRECTORY_SEPARATOR . 'rs.php');
				Qiniu_SetKeys(JY_QN_accessKey, JY_QN_secretKey);
				$client = new Qiniu_MacHttpClient(null);
				$err = Qiniu_RS_Move($client, $qn['bucket'], $qn['key'], JY_QN_bucket_recycle, $qn['key']);
				if ($err !== null && $err->Code != 612) {
				   $this->topic->insertBadTopic($topic['id'],$resUrl,$err->Code);
				   return false;
				} else {
				   return true;
				}
			}
		}
		return false;
	}
	
	public function blockUserSave() {
		
		$userID = (int)$this->input->get('userID', TRUE);
		$userInfo = $this->jjuser->get_user_by_id($userID);
		if (empty($userInfo)) {
			echo "-1";
		} else {
			$result = $this->jjuser->blockUser($userID);
			if ($result) {
				$this->cleanSession($userID);
				//删除此人所有未审核的贴子
				$this->topic->removeUncheckTopicByUserID($userID);
			}
			echo $result ? "1" : "0";
		}
	}
	
	public function unblockUser() {
		$userID =  $this->input->get('userID', TRUE);
		$result = $this->jjuser->unblockUser($userID);
		echo $result ? "1" : "0";
	}
	
	public function addV() {
		$userID =  $this->input->get('userID', TRUE);
		$isFamous =  $this->input->get('isFamous', TRUE);
		$isFamous = $isFamous == 0 ? 0: 1;
		
		$result = $this->jjuser->updateFamous($userID, $isFamous);
		
		echo $result ? "1" : "0";
	}
	
	public function album() {
		
		$userID = $this->input->get('userID', TRUE);
		
		$albumList = $this->album->getAlbumListByUserID($userID);
		
		$data['albumList'] = $albumList;
		
		$data['crumbs'] = $this->createCrumbs(array('user/album?userID=' . $userID => '用户相册'));
		
		$this->load->view('albumList.php', $data);
	}
	
	
	public function jjuserLocation() {
		
		$data['crumbs'] = $this->createCrumbs(array('user/jjuserLocation' => '用户地图'));
		$this->load->view('jjuserLocation', $data);
	}
	
	public function getUserLocationList() {
		$pageSize = (int)$this->input->get('pageSize', TRUE);
		$pageNo =  (int)$this->input->get('pageNo', TRUE);
		
		$pageSize = $pageSize <= 0 ? 500 : $pageSize;
		$pageNo = $pageNo <= 0 ? 1: $pageNo;
		
		$cacheKey = "user:location:" . $pageSize . ":" . $pageNo;
		
		//从缓存中取数据
		$jsonText = $this->getRedisCache($cacheKey);
		$jsonText = NULL;
		
		if ($jsonText) {
			$this->renderJSON($jsonText);
		} else {
		
			$locationData = $this->jjuser->getUserLocation($pageNo, $pageSize);
			
			$locationList = $locationData['locationList'];
			$totalPages = $locationData['totalPages'];
			
			$data['pageSize'] = $pageSize;
			$data['pageNo'] = $pageNo;
			$data['totalPages'] = $totalPages;
			$userLocationArray = array();
			
			foreach($locationList as $idx => $item) {
				$locTmp['userID'] = $item['userID'];
				$locTmp['nickname'] = $item['nickname'];
				$locTmp['headUrl'] = $item['headUrl'];
				$locTmp['sex'] = $item['sex'];
				$locTmp['lastLoginTime'] = $item['lastLoginTime'];
				$locTmp['peerID'] = $item['peerID'];
				$locTmp['lng'] = $item['longitude'];
				$locTmp['lat'] = $item['latitude'];
				$locTmp['updateTime'] = $item['updateTime'];
				array_push($userLocationArray, $locTmp);
			}
			
			$viewData = array(
				"totalPages" => $totalPages,
				"pageNo" => $pageNo,
				"pageSize" => $pageSize,
				"userLocationArray" => $userLocationArray
			);
			
			$jsonText = json_encode($viewData);
			$this->setRedisCache($cacheKey, $jsonText, 10 * 60);
			$this->renderJSON($jsonText);
		}
	}
	
	public function listChatContent() {
		$userID = $this->input->get("userID", TRUE);//举报人的UserID
		$rpUserID = $this->input->get("rpUserID", TRUE);//被举报的UserID
		
		$data['crumbs'] = $this->createCrumbs(array('jjuser/listChatContent' => '被举报人私聊列表'));
		if ($userID && $rpUserID) {
			$this->load->model('message_model','message');
			$charContentList = $this->message->getChatContentList($userID, $rpUserID);
			$data['charContentList'] = $charContentList;
		}
		$data['rpUserID'] = $rpUserID;
		$data['stateInfo'] = $this->jjuser->getUserState($rpUserID);
		$this->load->view('charList', $data);
	}
	
}
/* End of file jjuser.php */
/* Location: ./application/controllers/jjuser.php */