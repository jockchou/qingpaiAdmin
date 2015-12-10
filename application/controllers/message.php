<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Message extends JY_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('jjuser_model', 'jjuser');
		$this->load->model('topic_model', 'topic');
		$this->load->model('message_model', 'message');
		$this->load->model('subject_model', 'subject');
	}
	
	public function msgDel() {
		$id = $this->input->get('id', TRUE);
		
		$result = $this->message->delMessage($id);
		
		echo $result ? "1" : "0";
	}
	
	public function msgEdit() {
		$data['crumbs'] = $this->createCrumbs(array('message/msgEdit' => '编辑消息'));
		$this->load->view('msgEdit', $data);		
	}
	
	public function msgSave() {
		$os = (string)$this->input->post("os", TRUE);
		$title = (string)$this->input->post("title", TRUE);
		$content = (string)$this->input->post("content", TRUE);
		$pushTime = $this->input->post("pushTime", TRUE);
		$logindays = $this->input->post("logindays", TRUE);
		$version =  (string)$this->input->post("version", TRUE);
		$subjectIdList = (string)$this->input->post("subjectIdList", TRUE);
		
		$resUrl = "";
		
		$type = 0; //默认文字
		
		$iconConfig ['upload_path'] = JY_UPLOAD_IMG_PATH;
		$iconConfig ['allowed_types'] = 'gif|jpg|png';
		$iconConfig ['max_size'] = 256;
		$config['max_width']  = '800';
 		$config['max_height']  = '600';
		$iconConfig ['encrypt_name'] = TRUE;
		
		$iconPath = '';
		$iconError = NULL;
		$errorMessage = array();
		
		if (isset($_FILES['imageFile']) AND $_FILES['imageFile']['error'] !== 4) {
			$this->load->library ('upload', $iconConfig, 'imageFile');
					
			//处理上传的图标
			if (! $this->imageFile->do_upload("imageFile", TRUE)) {
				$iconError = '背景图上传失败: ' . $this->imageFile->display_errors('', '');
			} else {
				$iconFileInfo = $this->imageFile->data();
				$iconPath = $iconFileInfo['qiniu_ret']['key'];
			}
		}
		
		if ($iconError) {
			array_push($errorMessage, array('messageText' => $iconError));
		}
		
		if (!empty($errorMessage)) {
			$data['message'] = array('error' => $errorMessage);
			$this->load->view('message', $data);
		} else {
			if (!empty($iconPath)) { //没有传图片
				$type = 1;
				$resUrl = JY_PINGO_DATA_URL . $iconPath;
			}
			
			$msgTmp = array(
				"os" => $os,
				"type" => $type,
				"title" => $title,
				"content" => $content,
				"addTime" => date("Y-m-d H:i:s"),
				"pushTime" => $pushTime,
				"resUrl" => $resUrl,
				"logindays" => $logindays,
				"version" => $version,
				"subjectID" => "",
				"subjectTitle" => "",
				"simpleSubjectJson" => ""
			);
			
			$subjectIdList = str_replace("，",",",$subjectIdList);
			$subjectIdList = str_replace(" ","",$subjectIdList);
			
			$subjectList = $this->subject->getSubjectListById($subjectIdList);
			
			if (!empty($subjectList)) {
				$msgTmp['subjectID'] = 0;
				$msgTmp['subjectTitle'] = "";
				//subjectID, subjectTitle 存第一个官方话题
				foreach ($subjectList as $subject) {
					if ($subject['isOfficial'] == '1') {
						$msgTmp['subjectID'] = $subject['subjectID'];
						$msgTmp['subjectTitle'] = $subject['title'];
						break;
					}
				}
				$msgTmp["simpleSubjectJson"] = json_encode($subjectList);
			} else {
				$subject = $this->getCustomSubject();
				$simpleSubject = array($subject);
				$msgTmp['subjectID'] = $subject['subjectID'];
				$msgTmp['subjectTitle'] = $subject['title'];
				$msgTmp['simpleSubjectJson'] = json_encode($simpleSubject);
			}
			
			$result = $this->message->saveMessage($msgTmp);
			
			if ($result) {
				array_push($errorMessage, array('messageText' => '保存成功!'));
				$data['message'] = array('success' => $errorMessage);
			} else {
				array_push($errorMessage, array('messageText' => '提交失败!'));
				$data['message'] = array('error' => $errorMessage);
			}
			
			$this->load->view('message', $data);
		}
	}
	
	public function msgList() {
		$data['crumbs'] = $this->createCrumbs(array('message/msgEdit' => '消息列表'));
		
		$pageSize = (int)$this->input->get('pageSize', TRUE);
		$pageNo =  (int)$this->input->get('pageNo', TRUE);
		$isSend =  (string)$this->input->get('isSend', TRUE);
		
		//默认值
		$pageNo = $pageNo <= 0 ? 1 : $pageNo;
		$pageSize = ($pageSize > 0 && $pageSize <= 50) ? $pageSize : 10;
		
		$pageInfo = $this->message->getMessageList($isSend, $pageSize, $pageNo);
		
		$messageList = $pageInfo['messageList'];
		$totalPages = $pageInfo['totalPages'];
		
		$data['pageNo'] = $pageNo;
		$data['pageSize'] = $pageSize;
		$data['messageList'] = $messageList;
		$data['totalPages'] = $totalPages;
		$data['isSend'] = $isSend;
		
		$query_config = array(
			'isSend' => $isSend
		);
		
		$pathURL = "/message/msgList";
		
		$data['pageUrl'] = $pathURL . "?" . http_build_query($query_config);
		$data['pathURL'] = $pathURL;
		
		$this->load->view('msgList', $data);
	}
	
	public function chatHome() {
		$data['crumbs'] = $this->createCrumbs(array('message/chatHome' => '聊天首页'));
		
		$userID = "10086";
		
		$toUserID = (int)$this->input->get("toUserID", TRUE);
		
		$toUser = $this->jjuser->get_user_by_id($toUserID);
		
		//查询我的好友列表
		$followList = $this->jjuser->getFollowList($userID);
		
		$messageList = array();
		
		$data['followList'] = $followList;
		$data['toUserID'] = $toUserID;
		$data['toUser'] = $toUser;
		$data['messageList'] = $messageList;
		
		$this->load->view('chatHome', $data);
	}
	
	public function chatPost() {
		$content = (string)$this->input->post('txtContent', TRUE);
		$toUserID = $this->input->post('toUserID', TRUE);
		$type = (int)$this->input->post('type', TRUE);
		$userID = "10086";
		
		$startTime = JY_getMsTime();
		$wbRtnText = $this->xiaoMiChat($toUserID, $type, $content);
		$endTime = JY_getMsTime();
		
		log_message('debug', "xiaoMiChat:" . isset($wbRtnText['rtn']) ? $wbRtnText['rtn'] : "timeout");
		log_message('debug', "xiaoMiChat:" . $endTime - $startTime);
		
		if ($wbRtnText) {
			$user = $this->jjuser->get_user_by_id($userID);
			$rtnData = $wbRtnText['data'];
			$data['topicID'] = $rtnData['topicID'];
			$data['pubTime'] = $rtnData['pubTime'];
			$data['user'] = $user;
			$data['content'] = $content;
			if($type == 1){
				$data['resUrl'] = $content;
			}
			$this->load->view('chatMsgTmpl', $data);
		}
	}
	
	public function feedBack(){
		
		$userID = "10086";
		$userList = array();
		$chatUserList = array();
		$toUserID = (int)$this->input->get("toUserID", TRUE);
		$state = (int)$this->input->get("state", TRUE);//0表示未读，1表示已读
		$fromJJUser = (int)$this->input->get("fromJJUser", TRUE);//小秘对某个用户的私聊
		
		if($fromJJUser == 1){
			$result = $this->setRedisSetCache($toUserID);
		}
		
		if($state == 1){
			$chatUserList = $this->getRedisSetCache();
			$chatUserList = array_keys($chatUserList);
			$chatUserList = $this->jjuser->getUserByIdList($chatUserList);
		}
		
		$userList = $this->message->getNoticeList($state);
		
		if(!empty($chatUserList)){
			$userList = array_merge($chatUserList, $userList);
		}
		
		$userXiaomi = $this->jjuser->get_user_by_id(10086);
		
		$toUser = $this->jjuser->get_user_by_id($toUserID);
		
		$messageInfoList = $this->message->getMessage($state, $toUserID);
		
		$messageList = array();
		$mIdList = array();
		$key = 0;
		foreach ($messageInfoList as $messageInfo){
			array_push($mIdList, $messageInfo['mId']);
			$pubTime = $messageInfo['mTime'];
			$messageList[$key]['pubTime'] = $pubTime;
			$mBody = json_decode($messageInfo['mBody']);
			$messageList[$key]['content'] = $mBody->content;
			if($messageInfo['fromUserID'] == 10086){
				$messageList[$key]['user'] = $userXiaomi;
				$messageList[$key]['topicID'] = "chat_"."10086_".$toUserID."_"."$pubTime";
			}else{
				$messageList[$key]['user'] = $toUser;
				$messageList[$key]['topicID'] = "chat_".$toUserID."_"."10086_"."$pubTime";
			}
			if($mBody->resUrl != ""){
				
				$resUrl = explode('/', $mBody->resUrl);
				if(count($resUrl) >2){
					$resUrl = $resUrl[2];
					$resUrl = explode('.', $resUrl);
					if(is_array($resUrl) && !empty($resUrl)){
						$resUrl = $resUrl[0];
					}else{
						$resUrl = "";
					}
					
				}else{
					$resUrl = "";
				}
				if($resUrl != ""){
					$messageList[$key]['type'] = "1";
					$messageList[$key]['resUrl'] = $mBody->resUrl;
				}else{
					$messageList[$key]['type'] = "0";
				}
			}else{
				$messageList[$key]['type'] = "0";
			}
			
			$key++;
		}
		
		$this->message->updateMsg($mIdList, $toUserID);
		
		$data['messageList'] = $messageList;
		$data['userList'] = $userList;
		$data['toUserID'] = $toUserID;//跟某个用户聊天
		$data['toUser'] = $toUser;//联系中的用户的信息
		$data['state'] = $state;
		$data['crumbs'] = $this->createCrumbs(array('message/feedBack' => '反馈首页'));
		
		$this->load->view('feedBack', $data);
	}
}

/* End of file message.php */
/* Location: ./application/controllers/message.php */