<?php
class SelectionTopic extends JY_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('topic_model', 'topic');
	}
	
	public function selectionTopicList() {
		$data['crumbs'] = $this->createCrumbs(array('selectiontopic/selectionTopicList' => '精选帖列表'));
		
		$pageSize = (int)$this->input->get('pageSize', TRUE);
		$pageNo =  (int)$this->input->get('pageNo', TRUE);
		$topicState =  (int)$this->input->get('topicState', TRUE);
		
		//默认值
		$pageNo = $pageNo <= 0 ? 1 : $pageNo;
		$pageSize = ($pageSize > 0 && $pageSize <= 50) ? $pageSize : 10;
		
		$pageInfo = $this->topic->getSelectionTopicList($pageSize, $pageNo, $topicState);
		
		if ($pageInfo) {
			$data['pageNo'] = $pageNo;
			$data['pageSize'] = $pageSize;
			$data['topicState'] = $topicState;
			$data['selectionTopicList'] = $pageInfo['selectionTopicList'];
			$data['totalPages'] = $pageInfo['totalPages'];
		}
		
		$data['pageUrl'] = "/selectionTopic/selectionTopicList?";
		if (isset($topicState)) $data['pageUrl'] .= 'topicState=' . $topicState;
		$this->load->view('selectionTopicList', $data);
	}
	
	public function reserveTopicList() {
		$data['crumbs'] = $this->createCrumbs(array('selectiontopic/reserveTopicList' => '预约精选列表'));
		
		$pageSize = (int)$this->input->get('pageSize', TRUE);
		$pageNo =  (int)$this->input->get('pageNo', TRUE);
		$isSend = (int)$this->input->get('isSend', TRUE);
		
		$redis = $this->createRedis('action');
		$isOpen = (int)$redis->get('selectionTopic:reserve:open');
		$redis->close();
		
		//默认值
		$pageNo = $pageNo <= 0 ? 1 : $pageNo;
		$pageSize = ($pageSize > 0 && $pageSize <= 50) ? $pageSize : 10;
		
		$pageInfo = $this->topic->getReserveTopicList($pageSize, $pageNo, $isSend);
		
		if ($pageInfo) {
			$data['pageNo'] = $pageNo;
			$data['pageSize'] = $pageSize;
			$data['isOpen'] = $isOpen;
			$data['isSend'] = $isSend;
			$data['reserveTopicList'] = $pageInfo['reserveTopicList'];
			$data['totalPages'] = $pageInfo['totalPages'];
		}
		
		$data['pageUrl'] = "/selectionTopic/reserveTopicList?";
		$data['pageUrl'] .= "isSend=$isSend";
		$this->load->view('reserve/reserveTopicList', $data);
	}
	
	public function doSendAction() {
		$setOpen = (int)$this->input->get('setOpen', TRUE);
		
		$redis = $this->createRedis('action');
		$result = $redis->set('selectionTopic:reserve:open', $setOpen);
		if ($result) {
			echo "0";
		} else {
			echo "999";
		}
	}
	
	/*public function saveSelectionTopic() {
		
		$topicID = (int)$this->input->post('topicID', TRUE);
		$locIdx = (int)$this->input->post('locIdx', TRUE);
		$offlineTime = $this->input->post('offlineTime', TRUE);
		$onlineTime = $this->input->post('onlineTime', TRUE);
		
		$errorMessage = array();
		
		$check = $this->checkJumpID(4, $topicID);
		$isExistTopicID = $this->topic->isExistSelectionTopicID($topicID);
		if ($check !== TRUE) {
			array_push($errorMessage, array('messageText' => $check));
			$data['message'] = array('error' => $errorMessage);
		} else if ($isExistTopicID) {
			array_push($errorMessage, array('messageText' => '不能插入已经存在的帖子ID'));
			$data['message'] = array('error' => $errorMessage);
		} else if ($locIdx <= 0 || $locIdx >= 51) {
			array_push($errorMessage, array('messageText' => '插入的位置不正确'));
			$data['message'] = array('error' => $errorMessage);
			
		} else if (strtotime($offlineTime) < time() || strtotime($offlineTime) < strtotime($onlineTime)) {
			array_push($errorMessage, array('messageText' => '失效时间设置错误'));
			$data['message'] = array('error' => $errorMessage);
		} else {
			
			$data['topicID'] = $topicID;
			$data['onlineTime'] = $onlineTime;
			$data['offlineTime'] = $offlineTime;
			$data['addTime'] = date('Y-m-d H:i:s');
			$data['locIdx'] = $locIdx;
			
			$result= $this->topic->saveSelectionTopic($data);
			
			if ($result) {
				array_push($errorMessage, array('messageText' => '保存成功!'));
				$data['message'] = array('success' => $errorMessage);
			} else {
				array_push($errorMessage, array('messageText' => '提交失败!'));
				$data['message'] = array('error' => $errorMessage);
			}
				
		}
		$this->load->view('message', $data);
	}*/
	
	public function deleteSelectionTopic() {
		
		$id = (int)$this->input->get('id', TRUE);
		$result = $this->topic->deleteSelectionTopic($id);
		if ($result) {
			echo "0";
		} else {
			echo "999";
		}
		
	}
	
	public function deleteReserveTopic() {
		$id = (int)$this->input->get('id', TRUE);
		$result = $this->topic->deleteReserveTopic($id);
		if ($result) {
			echo "0";
		} else {
			echo "999";
		}
	}
	
	/*public function editSelectionTopic() {
		$data['crumbs'] = $this->createCrumbs(array('message/msgEdit' => '编辑精选贴'));
		$this->load->view('selectionTopicEdit', $data);
	}*/
	
	public function setSelectionTopicState() {
		$state = (int)$this->input->get('state', TRUE);
		$id = (int)$this->input->get('id', TRUE);
		if ($id > 0) {
			$result = $this->topic->setTopicSelectState($id, $state);
			if ($result) {
				echo "0";
			} else {
				echo "999";
			}
		} else {
			echo "777";
		}
	}
	
}