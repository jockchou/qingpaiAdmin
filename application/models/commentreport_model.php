<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Commentreport_model extends JY_Model {
	
	private $mongo;
	public function __construct() {
		parent::__construct();
		$this->load->database('default');
		$this->mongo = $this->createMongoDB("pingo");
	}
	
	//举报的评论列表
	public function getCommentReportList($hasCheck = NULL, $pageNo = 1, $pageSize = 10, $status = 0) {
		
		$sql = "SELECT a.* FROM comment_report a";
		
		$where = ' WHERE 1 = 1 ';
		if($status == 4){
			
		}else if($status == 1){
				$where .= " AND a.status = -1";
		}else if($status == 2){
				$where .= " AND a.status = 0";
		}else if($status == 3){
				$where .= " AND a.status = 1";
		}else if($status == 0){
				$where .= " AND a.status = -1";
		}
		$start = ($pageNo - 1) * $pageSize;
		$orderBY = " ORDER BY id DESC";
		$limit = " LIMIT $start, $pageSize";
		
		$sql .= ($where . $orderBY . $limit);
		
		$sql2 = "SELECT count(*) AS totalNum from comment_report a" . $where;
		
		$query2 = $this->db->query($sql2);
		$totalTmp = $query2->row_array();
		$totalNum = $totalTmp['totalNum'];
		
		$data['totalPages'] = ceil($totalNum / $pageSize);
		$data['commentReportList'] = array();
		
		if ($totalNum > 0) {
			$query1 = $this->db->query($sql);
			$data['commentReportList'] = $query1->result_array();
		}
		return $data;
	}
	
	public function update_comment_report($id, $data, $commentID) {
		
		//更新mongo部分
		if($commentID != null && $data['status'] == 0){
			
			$collection = $this->mongo->comment;
			$newdata = array('$set' => array("state" => -1));
			
			try{
				$collection->update(array('_id' => new MongoId($commentID)), $newdata);
			}catch (MongoException $e){
				return false;
			}
			//更新数据库部分
			}
		$this->db->where('id', $id);
		return $this->db->update('comment_report', $data);
	}
	
	public function delComment($commentID){
		$collection = $this->mongo->comment;
		$newdata = array('$set' => array("state" => -2));
		try{
			$collection->update(array('_id' => new MongoId($commentID)), $newdata);
		}catch (MongoException $e){
			return false;
		}
		return true;
	}
	
	public function delDubiousComment($commentID){
		$collection = $this->mongo->comment;
		$newdata = array('$set' => array("state" => -1, "isDubious" => 0));
		try{
			$collection->update(array('_id' => new MongoId($commentID)), $newdata);
		}catch (MongoException $e){
			return false;
		}
		return true;
	}
	
	public function getCommentByID($commentID){
		$collection = $this->mongo->comment;
		$comment = $collection->findOne(array('_id' => new MongoId($commentID)));
		return $comment;
	}
	public function getAssignTopicComment($id, $isCommentID, $pageNo = 1, $pageSize = 10, $all = false){
		//$isCommentID:是不是评论ID，$all：拉取指定时间内的所有评论
		$collection = $this->mongo->comment;
		$commentList = array();
		$data = array();
		$data['commentList'] = array();
		
		if($isCommentID){
			
			$comment = $collection->findOne(array('_id' => new MongoId($id)));
			array_push($commentList, $comment);
			$data['totalPages'] = 1;
				
			if(!empty($comment)){
				$data['commentList'] = $commentList;
			}
		}else{
			
			if($all){
				$lastThreeDays = JY_getMsTime() - 3600 * 48 * 1000;
				$cursor = $collection->find(array("state" => 0, "pubTime" => array('$gt' => $lastThreeDays)));
				$totalNum = $collection->count(array("state" => 0, "pubTime" => array('$gt' => $lastThreeDays)));
			}else{
				$cursor = $collection->find(array("state" => 0, "topicID" => $id));
				$totalNum = $collection->count(array("state" => 0, "topicID" => $id));
			}
				
			try{
				$cursor = $cursor->skip(($pageNo - 1) * $pageSize);
				$topicCommentObj = $cursor->limit($pageSize + 1);
			}catch(MongoCursorException $e){
				return array();
			}
				 
			$commentList = array();
				
			foreach($topicCommentObj as $comment){
					
				$comment['pubTime'] = JY_ms2Date($comment['pubTime']);
				array_push($commentList, $comment);
			}
				
			$data['totalPages'] = ceil($totalNum / $pageSize);
				
			if($totalNum > 0){
				$data['commentList'] = $commentList;
			}
		}
		return $data;
	}
	
	public function getUserComment($userID, $content, $pageNo, $pageSize){
		
		$collection = $this->mongo->comment;
		$commentList = array();
		$data = array();
		$data['commentList'] = array();
		
		$query = array();
		
		$query['state'] = 0;
		
		if($userID != 0){
			$query["userID"] = $userID;
		}
		
		if($content != ""){
			$query["content"] = array('$regex' => "$content");
		}
		
		if(empty($query)){
			$data['totalPages'] = 1;
			return $data;
		}
		
		$cursor = $collection->find($query);
		$totalNum = $collection->count($query);
		
		try{
			$cursor = $cursor->skip(($pageNo - 1) * $pageSize);
			$userCommentObj = $cursor->limit($pageSize + 1);
		}catch(MongoCursorException $e){
			return array();
		}
				 
		$commentList = array();
				
		foreach($userCommentObj as $comment){
					
			$comment['pubTime'] = JY_ms2Date($comment['pubTime']);
			array_push($commentList, $comment);
		}
				
		$data['totalPages'] = ceil($totalNum / $pageSize);
				
		if($totalNum > 0){
			$data['commentList'] = $commentList;
		}
		
		return $data;
	}
	
	public function getDubiousComment($pageNo, $pageSize){
		
		$collection = $this->mongo->comment;
		$commentList = array();
		$data = array();
		$data['commentList'] = array();
		
		$cursor = $collection->find(array('isDubious' => 1, 'state' => 0));
		$totalNum = $collection->count(array('isDubious' => 1, 'state' => 0));
		
		try{
			$cursor = $cursor->sort(array('pubTime' => -1));
			$cursor = $cursor->skip(($pageNo - 1) * $pageSize);
			$topicCommentObj = $cursor->limit($pageSize + 1);
		}catch(MongoCursorException $e){
			return array();
		}
				 
		$commentList = array();
		$userIDList = array();
		foreach($topicCommentObj as $comment){
			array_push($userIDList, $comment['userID']);
			$comment['pubTime'] = JY_ms2Date($comment['pubTime']);
			array_push($commentList, $comment);
		}
				
		$data['totalPages'] = ceil($totalNum / $pageSize);

		if($totalNum > 0){
			$data['userIDList'] = $userIDList;
			$data['commentList'] = $commentList;
		}
		return $data;
	}
	
	public function passDubiousComment($commentID){
		
		$collection = $this->mongo->comment;
		$newdata = array('$set' => array("isDubious" => 0));
		try{
			$collection->update(array('_id' => new MongoId($commentID)), $newdata);
		}catch (MongoException $e){
			return false;
		}
		return true;
	}
}