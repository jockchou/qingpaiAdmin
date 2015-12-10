<?php
class Subjectactivity_model extends CI_Model {
	public $db;

	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	public function saveActivity($data) {
		$data['md5Title'] = md5($data['title']);
		return $this->db->insert('subject', $data);
	}
	
	public function getSubjectTitle($subjectID){
		
		$sql = "select title from subject where id = ?";
		$query = $this->db->query($sql,array($subjectID));
		$result = $query->row_array();
		return $result['title'];
	}
	public function updateActivity($data,$id) {
		$data['md5Title'] = md5($data['title']);
		$this->db->where('id', $id);
		return $this->db->update('subject', $data); 
	}

	public function getAllSubjectList(){
		
		$sql = "select * from subject";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getOrder($id){
		
		$sql = "select * from subject where id=".$id;
		$query = $this->db->query($sql);
		$result = $query->row_array();
		return $result['orderVal'];
	}
	
	public function getActivityList($pageNo = 1, $pageSize = 10, $subjectTitle = "") {
		
		$$subjectTitle = str_replace(" ","",$subjectTitle);
		
		$sql = "SELECT * FROM subject";
		
		$where = " WHERE 1=1";
		
		if($subjectTitle != ""){
			$where .= " AND title = '$subjectTitle'";
		}
		$start = ($pageNo - 1) * $pageSize;
		$orderBY = " ORDER BY orderVal DESC,id ASC";
		$limit = " LIMIT $start, $pageSize";
		
		$sql .= ($where . $orderBY . $limit);
		
		$sql2 = "SELECT count(*) AS totalNum FROM subject" . $where;
		
		$query2 = $this->db->query($sql2);
		$totalTmp = $query2->row_array();
		$totalNum = $totalTmp['totalNum'];
		
		$data['totalPages'] = ceil($totalNum / $pageSize);
		$data['activityList'] = array();
		
		if ($totalNum > 0) {
			$query1 = $this->db->query($sql);
			$data['activityList'] = $query1->result_object();
		}
		return $data;
	}

	public function updateTopicCount($count,$subjectID){
		
		$sql = "update subject set topicCnt = ? where id = ?";
		return $this->db->query($sql,array($count,$subjectID));
	}
	
	public function deleteActivity($id) {
		return $this->db->delete('oper_activity', array('id' => $id)); 
	}

	public function offActivity($id, $state) {
		$this->db->where('id', $id);
		return $this->db->update('subject', array('state' => $state)); 
	}
	
	public function getSubjectById($id){
		$sql = "select * from subject where id = ?";
		$query = $this->db->query($sql,array($id));
		return $query->row_array();
	}
	
	
	public function geSubjectHotsearchList($pageNo = 1, $pageSize = 10) {
		$select = "SELECT a.title, a.content, a.state, b.* FROM subject a, subject_hotsearch b";
		
		$where = " WHERE a.id = b.subjectID";
		
		$start = ($pageNo - 1) * $pageSize;
		$orderBY = " ORDER BY b.orderVal DESC, b.id ASC";
		$limit = " LIMIT $start, $pageSize";
		
		$sql = $select . $where . $orderBY . $limit;
		
		$sql2 = "SELECT count(*) AS totalNum FROM subject_hotsearch";
		
		$query2 = $this->db->query($sql2);
		$totalTmp = $query2->row_array();
		$totalNum = $totalTmp['totalNum'];
		
		$data['totalPages'] = ceil($totalNum / $pageSize);
		$data['subjectList'] = array();
		
		if ($totalNum > 0) {
			$query1 = $this->db->query($sql);
			$data['subjectList'] = $query1->result_array();
		}
		return $data;
	}
	
	public function deSearchHostByID($id) {
		return $this->db->delete('subject_hotsearch', array('id' => $id)); 
	}
	
	public function saveHotSearch($subjectID) {
		$data = array(
			"subjectID" => $subjectID,
			"addTime" => date('Y-m-d H:i:s')
		);
		return $this->db->insert('subject_hotsearch', $data, true);
	}
	
	public function delHotSearchBySubject($subjectID){
		return $this->db->delete('subject_hotsearch', array('subjectID' => $subjectID)); 
	}
	
	public function getHotSearchBySubject($subjectID){
		$sql = "SELECT subjectID FROM subject_hotsearch WHERE subjectID = ?";
		$query = $this->db->query($sql, array($subjectID));
		return $query->row_array();
	}
}