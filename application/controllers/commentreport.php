<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Commentreport extends JY_Controller {
	
	function __construct() {
		parent::__construct ();
		$this->load->model("commentreport_model", "comment");
		$this->load->model("jjuser_model", "user");
		$this->load->model("topic_model", "topic");
	}
	
	/**
	 * 
	 * 	status=4 所有被举报评论
		status=3 举报已通过评论
		status=2 举报未通过评论
		status=1 举报未审核评论
	 */
	public function commentReportList() {
		
		$pageSize = (int)$this->input->get('pageSize', TRUE);
		$pageNo =  (int)$this->input->get('pageNo', TRUE);
		$status = (int)$this->input->get('status', TRUE);
		$title = (string)$this->input->get('title', TRUE);
		
		if($title == "") $title = "举报未审核评论";
		$pageNo = $pageNo <= 0 ? 1 : $pageNo;
		$pageSize = ($pageSize > 0 && $pageSize <= 50) ? $pageSize : 10;
		
		$queryData = $this->comment->getCommentReportList(null, $pageNo, $pageSize, $status);
		
		$commentReportList = $queryData['commentReportList'];
		$totalPages = $queryData['totalPages'];
		
		$status == 0 ? 1 : $status;
		
		//设置数据
		$data['pageSize'] = $pageSize;
		$data['pageNo'] = $pageNo;
		$data['totalPages'] = $totalPages;
		$data['commentReportList'] = $commentReportList;
		$data['title'] = $title;
		$data['status'] = $status;
		$query_config = array(
			'pageSize' => $pageSize,
			'status' => $status,
			'title' => $title 
		);
		
		$data['pageUrl'] = "/comport/comportList?" . http_build_query($query_config);
		
		$data['crumbs'] = $this->createCrumbs(array('comport/comportList' => '评论举报'));
		
		$this->load->view('commentReportList', $data);
	}
	
	public function commentReportCheck() {
		$op = $this->input->get('op', TRUE);
		$id = $this->input->get('id', TRUE);
		$commentID = $this->input->get('commentID', TRUE);
		
		$commentInfo = $this->comment->getCommentByID($commentID);
		$this->topic->updateCommentCnt($commentInfo['topicID']);
		$status = $op == "yes" ? 1 : 0;
		if($status == 1){
			$commentID = null;
		}
		$feed = array('hasCheck'=> '1', 'checkTime' => Date('Y-m-d H:i:s'), "status" => $status);
		echo $this->comment->update_comment_report($id, $feed, $commentID);
	}
	
	
	public function delComment(){
		
		$op = $this->input->get('op', TRUE);
		$id = (int)$this->input->get('id', TRUE);
		$isDubious = (int)$this->input->get('isDubious', TRUE); 
		$commentID = $this->input->get_post("commentID");
		if($id != 0){
			$status = $op == "yes" ? 1 : 0;
			$feed = array('hasCheck'=> '1', 'checkTime' => Date('Y-m-d H:i:s'), "status" => $status);
			$this->comment->update_comment_report($id, $feed, $commentID);
			if($status == 1){
				echo "1";
				return;
			}
		}
		
		if($isDubious == 1){
			$result = $this->comment->delDubiousComment($commentID);
		}else{
			$result = $this->comment->delComment($commentID);
		}
		
		if($result){
			$result = $this->deleteComment($commentID);
		}
		echo $result == true ? "1" : "0";
	}
	
	public function delCommentArr(){
		$commentIDList = $this->input->post("commentIDList");
		//$commentIDList = json_decode($commentIDList);
		$curUserID = 0;
		foreach ($commentIDList as $commentID){
			$this->comment->delComment($commentID);
			$result = $this->getRedisCache("$curUserID:delCommentArr");
			if(!$result){
				$curUserID = $this->deleteComment($commentID, true);
				$this->setRedisCache("$curUserID:delCommentArr", $curUserID, 180);//为了防止小秘对同一用户过多的推送通知，限定3分钟内最多只能发送2条推送
			}else{
				$this->deleteComment($commentID, false);
			}
		}
		echo "1";
	}
	
	private function deleteComment($commentID, $ms = true){
		
		$commentInfo = $this->comment->getCommentByID($commentID);
			
		$toUserNickname = "";
			
		$masterID = "";
			
		$toUserID = "";
			
		$commentInfo['userInfo'] = array();
			
		if(!empty($commentInfo)){
				
			$user = $this->user->get_user_by_id($commentInfo['userID']);//发评论人的用户信息
			$userInfo = new UserInfo($user);
			$commentInfo['userInfo'] = $userInfo->format();
			if($commentInfo['toUserID'] != ""){
				$toUserID = $commentInfo['toUserID'];
				$row = $this->user->get_user_by_id($commentInfo['toUserID']);//@某人时，获取被@用户的nickname;
				if(!empty($row)){
					$toUserNickname = $row['nickname'];
				}
			}
				
			$topicInfo = $this->topic->getTopicByIdArray($commentInfo['topicID']);
				
			if(!empty($topicInfo)){
				$masterID = $topicInfo['userID'];
			}
				
			$commentInfo['commentID'] = (string)$commentInfo['_id'];
			unset($commentInfo['_id']);
		}
			
		$commentInfo['toUserNickname'] = $toUserNickname;
			
		$curUserID = $commentInfo['userID'];
		unset($commentInfo['userID']);
		
		$result = $this->topic->updateCommentCnt($commentInfo['topicID']);
			
		if($result){
			
			if($ms){
				$content = "您于 ".date('Y-m-d H:i',ceil($commentInfo['pubTime']/1000));
				$content .= "发的评论：".mb_substr($commentInfo['content'], 0 , 9)."...";
				$content .= " 因违反随遇社区规范，已被删除，请注意社交礼仪！";
				$this->xiaoMiChat($curUserID, 0, $content);
			}
				
			$postData = array(
				"passwd" => "joyo2014",
				"msgType" => 7,
				"pushType" => 9,
				"body" => $commentInfo
			);
				
			$msAPI = JY_PINGO_API_URL . "comment/pushMS";
				
			if($masterID != ""){
				$postData['toUid'] = $masterID;
				$wbRtnText = $this->cURL_post($msAPI, json_encode($postData));
				log_message('debug', $wbRtnText);
			}
				
			if($toUserID != ""){
				$postData['toUid'] = $toUserID;
				$wbRtnText = $this->cURL_post($msAPI, json_encode($postData));
				log_message('debug', $wbRtnText);
			}
		}

		usleep(20);
		return $curUserID;
	}
	
	public function getAssignTopicComment(){
		
		$id = $this->input->get_post("id");
		$userID = $this->input->get('userID', TRUE);
		$content = $this->input->get('content', TRUE);
		$type = (int)$this->input->get('type', TRUE);
		$pageSize = (int)$this->input->get('pageSize', TRUE);
		$pageNo =  (int)$this->input->get('pageNo', TRUE);

		$pageNo = $pageNo <= 0 ? 1 : $pageNo;
		$pageSize = ($pageSize > 0 && $pageSize <= 100) ? $pageSize : 100;
		
		if($type == 0){
			
			$isCommentID = false;//判断是否是一个评论ID，为false时说明是帖子的ID
			$all = false;
			if($id == "" || $id == 0){
				$all = true;
			}else if(strlen($id) == 24){//commentID
				$isCommentID = true;
			}
			$queryData = $this->comment->getAssignTopicComment($id, $isCommentID, $pageNo, $pageSize, $all);
		}else if($type == 1){
			$queryData = $this->comment->getUserComment($userID, $content, $pageNo, $pageSize);
		}
		
		$commentReportList = $queryData['commentList'];
		$totalPages = $queryData['totalPages'];

		//设置数据
		$data['pageSize'] = $pageSize;
		$data['pageNo'] = $pageNo;
		$data['totalPages'] = $totalPages;
		$data['commentList'] = $commentReportList;
		$data['userID'] = $userID;
		$data['type'] = $type;
		$query_config = array(
			//'pageSize' => $pageSize,
			"id" => $id,
			"userID" => $userID,
			"content" => $content,
			"type" => $type
		);
		
		
		
		$data['pageUrl'] = "/comport/getComment?" . http_build_query($query_config);
		
		$data['crumbs'] = $this->createCrumbs(array('comport/getComment' => '帖子评论列表'));
		
		$this->load->view('commentList', $data);
	}
	
	public function getDubiousComment(){
		
		$pageSize = (int)$this->input->get('pageSize', TRUE);
		$pageNo =  (int)$this->input->get('pageNo', TRUE);

		$pageNo = $pageNo <= 0 ? 1 : $pageNo;
		$pageSize = ($pageSize > 0 && $pageSize <= 100) ? $pageSize : 100;
		
		$queryData = $this->comment->getDubiousComment($pageNo, $pageSize);
		
		$commentReportList = $queryData['commentList'];
		$totalPages = $queryData['totalPages'];
		$userIDList = $queryData['userIDList'];
		
		$userInfoList = $this->user->getUserByIdList($userIDList);
		
		foreach ($userInfoList as $userInfo){
			foreach ($commentReportList as $key => $commentReport){
				if($userInfo['id'] == $commentReport['userID']){
					$commentReportList[$key]['state'] = $userInfo['state'];
				}
			}
			
		}
		//设置数据
		$data['pageSize'] = $pageSize;
		$data['pageNo'] = $pageNo;
		$data['totalPages'] = $totalPages;
		$data['commentList'] = $commentReportList;
		
		$query_config = array(
			//'pageSize' => $pageSize,
			//"id" => $id
		);
		
		$data['pageUrl'] = "/comport/getDubiousComment?" . http_build_query($query_config);
		
		$data['crumbs'] = $this->createCrumbs(array('comport/getDubiousComment' => '可疑评论列表'));
		
		$this->load->view('dubiousCommentList', $data);
	}
	
	public function delDubiousComment(){
		$commentID = $this->input->get_post("commentID");
		$result = $this->comment->delDubiousComment($commentID);
		if($result){
			echo "1";
		}else{
			echo "0";
		}
	}
	
	public function passDubiousComment(){
		
		$commentID = $this->input->get_post("commentID");
		
		$commentInfo = $this->comment->getCommentByID($commentID);
		
		$toUserNickname = "";
		
		$masterID = "";
		
		$toUserID = "";
		
		$commentInfo['userInfo'] = array();
		
		if(!empty($commentInfo)){
			
			$user = $this->user->get_user_by_id($commentInfo['userID']);//发评论人的用户信息
			$userInfo = new UserInfo($user);
			$commentInfo['userInfo'] = $userInfo->format();
			if($commentInfo['toUserID'] != ""){
				$toUserID = $commentInfo['toUserID'];
				$row = $this->user->get_user_by_id($commentInfo['toUserID']);//@某人时，获取被@用户的nickname;
				if(!empty($row)){
					$toUserNickname = $row['nickname'];
				}
			}
			
			$topicInfo = $this->topic->getTopicByIdArray($commentInfo['topicID']);
			
			if(!empty($topicInfo)){
				$masterID = $topicInfo['userID'];
			}
			
			$commentInfo['commentID'] = (string)$commentInfo['_id'];
			unset($commentInfo['_id']);
		}
		
		$commentInfo['toUserNickname'] = $toUserNickname;
		
		$curUserID = $commentInfo['userID'];
		unset($commentInfo['userID']);
		
		$result = $this->comment->passDubiousComment($commentID);
		
		if($result){
				
			$postData = array(
				"passwd" => "joyo2014",
				"msgType" => 6,
				"pushType" => 8,
				"body" => $commentInfo
			);
				
			$msAPI = JY_PINGO_API_URL . "comment/pushMS";
				
			//评论可疑，从评论人的角度推送
			if($curUserID == $masterID){
					if($toUserID != ""){
						$postData['toUid'] = $toUserID;
						$wbRtnText = $this->cURL_post($msAPI, json_encode($postData));
						log_message('debug', $wbRtnText);//推给被@的人
					}
			}else{
					if($toUserID != "" && $toUserID != $masterID){
						$postData['toUid'] = $toUserID;
						$wbRtnText = $this->cURL_post($msAPI, json_encode($postData));
						log_message('debug', $wbRtnText);//推给被@的人
					}
					$postData['toUid'] = $masterID;
					$wbRtnText = $this->cURL_post($msAPI, json_encode($postData));
					log_message('debug', $wbRtnText);//推给楼主
			}
			
		}
		if($result){
			echo "1";
		}else{
			echo "0";
		}
	}
	
}


/* End of file upload.php */
/* Location: ./application/controllers/upload.php */