<?php
class Comment_model extends CI_Model {
	public $db;	

	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}
	
	public function get_comment_list($topicID, $filter = TRUE, $lastCommentID = 0, $order = "asc", $requestCnt = 10) {
		
		$order = $order == "desc" ? "DESC" : "ASC";
		
		$where = "WHERE topicID = ? ";
		
		if ($order == "DESC") {
			$where .= "AND id < ?";
		} else {
			$where .= "AND id > ?";
		}
		
		if ($filter) {
			$where .= " AND status >= 0";
		}
		
		$sql = "SELECT * FROM comment $where ORDER BY id $order LIMIT ?";
		
		$query = $this->db->query($sql, array($topicID, $lastCommentID, ($requestCnt + 1)));
		return $query->result_array();
	}
	
	public function update_comment_status($userId, $status) { 
		$data = array('status' => $status);
		$this->db->where('userID', $userId);
		return $this->db->update('comment', $data); 
	}
	
	public function update_comment_status_by_id($id, $status) {
		$data = array('status' => $status);
		$this->db->where('id', $id);
		return $this->db->update('comment', $data); 
	}
	
	//根据评论id查询评论
	public function get_comment_by_id($id) {
		$sql = "select * from comment where id = ?";
		$query = $this->db->query($sql, array($id));
		return $query->row_array();
	}
	
	public function get_comment_list_by_ids($cids) {
		$sql = "select * from comment where id in(" . $cids . ")";
		$query = $this->db->query($sql, null);
		return $query->result_array();
	}
	//评论点赞
	public function update_praiseCnt($id, $set = "1") {
		if ($set == "1") { // 注意这里的$set, 需要用字符串判断
			$sql = "update comment set praiseCnt = praiseCnt + 1 where id = ?";
		} else {
			$sql = "update comment set praiseCnt = praiseCnt - 1 where id = ? AND praiseCnt > 0";
		}
		return $this->db->query($sql, array($id));
	}
	
	//根据文章ID和用户ID查询某个用户针对某个文章的所有评论，按时间排序
	public function get_all_comment_user($topicID, $userID) {
		$sql = "select * from comment where topicID = ? and userID = ? and status >= 0 order by id desc";
		$query = $this->db->query($sql, array($topicID, $userID));
		return $query->result_array();
	}
	
	//保存评论
	public function save($comment) {
		return $this->db->insert('comment', $comment);
	}
	
	/*
	 *  查询所有参与过评论的用户
	 *  $exceptUserId 不包括的用户，排除$exceptUserId
	 */
	public function get_all_comment_users($topicID, $exceptUserId = null) {
		$sql = "select distinct userID from comment where topicID = ? AND status >= 0 ";
		if ($exceptUserId != null) {
			$sql .= "AND userID != " . $exceptUserId;
		}
		$query = $this->db->query($sql, array($topicID));
		return $query->result_array();
	}
	
	public function save_comment_report($commentID, $userID, $reason) {
		$data = array(
			"userID" => $userID,
			"commentID" => $commentID,
			"reason" => $reason
		);
		return $this->db->insert('comment_report', $data, TRUE);
	}
	
	public function removeUserComment($userID) {
		$sql = "UPDATE comment SET status = -2 WHERE userID = ? AND status = 0";
		return $this->db->query($sql, array($userID));
	}
	
	public function getCommentList($keyword=null, $dateScope=null, $isCheck=null, $pageNo=1, $pageSize=10) {
		$sql1 = "SELECT * FROM comment";
		
		$where = ' WHERE 1 = 1';
		

		if (!empty($keyword)) {
			$where .= " AND (content LIKE '%$keyword%') ";
		}

		//最近6小时、最近12小时、最近24小时、最近2天、最近3天、最近1星期
		if ($dateScope) {
			$timeago = JY_timeago($dateScope);
			$where .= " AND pubTime >= '$timeago'";
		}
		
		if ($isCheck == "Y") {//核审过的
			$where .= " AND (status = 1 OR status = -1)";
		} else if ($isCheck == "N") { //未审核的
			$where .= " AND status = 0";
		}
		
		$orderBY = " ORDER BY id DESC";
		
		$start = ($pageNo - 1) * $pageSize;
		
		$limit = " LIMIT $start, $pageSize";
		
		$sql1 .= ($where . $orderBY . $limit);
		
		$sql2 = "SELECT count(id) AS totalNum FROM comment " . $where;
		
		$query2 = $this->db->query($sql2);
		$totalTmp = $query2->result_array();
		$totalNum = $totalTmp[0]['totalNum'];
		
		$data['totalPages'] = ceil($totalNum / $pageSize);
		$data['commentList'] = array();
		
		if ($totalNum > 0) {
			$query1 = $this->db->query($sql1);
			$data['commentList'] = $query1->result_array();
		}
		
		return $data;
	}
	
	public function update_comment_status_batch($data) {
		return $this->db->update_batch('comment', $data, 'id'); 
	}
}