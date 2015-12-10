<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report_model extends CI_Model {
	
	private $db = null;
	
	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}
	
	public function getReportList($hasRead=NULL, $pageNo=1, $pageSize=10) {
		
		$sql = "SELECT * FROM report";
		
		$where = ' WHERE 1 = 1';
		if ($hasRead == 'Y' OR $hasRead == 'N') {
			$where .= " AND hasRead = '" .$hasRead. "'";
		}
		$start = ($pageNo - 1) * $pageSize;
		$orderBY = " ORDER BY id DESC";
		$limit = " LIMIT $start, $pageSize";
		
		$sql .= ($where . $orderBY . $limit);
		
		$sql2 = "SELECT count(*) AS totalNum FROM report " . $where;
		
		$query2 = $this->db->query($sql2);
		$totalTmp = $query2->result_array();
		$totalNum = $totalTmp[0]['totalNum'];
		
		$data['totalPages'] = ceil($totalNum / $pageSize);
		$data['reportList'] = array();
		
		if ($totalNum > 0) {
			$query1 = $this->db->query($sql);
			$data['reportList'] = $query1->result_object();
		}
		return $data;
	}
	
	public function getCommentReportList($hasCheck=NULL, $pageNo=1, $pageSize=10) {
		
		$sql = "select a.id, a.commentID, a.reason, a.hasCheck, a.opTime, a.userID as reportUID, b.userID, b.content, b.pubTime from comment_report a left join comment b on a.commentID = b.id";
		
		$where = ' where 1 = 1 ';
		if ($hasCheck == '0' OR $hasCheck == '1') {
			$where .= " AND a.hasCheck = " . $hasCheck;
		}
		$start = ($pageNo - 1) * $pageSize;
		$orderBY = " ORDER BY id DESC";
		$limit = " LIMIT $start, $pageSize";
		
		$sql .= ($where . $orderBY . $limit);
		
		$sql2 = "SELECT count(*) AS totalNum from comment_report a left join comment b on a.commentID = b.id " . $where;
		
		$query2 = $this->db->query($sql2);
		$totalTmp = $query2->result_array();
		$totalNum = $totalTmp[0]['totalNum'];
		
		$data['totalPages'] = ceil($totalNum / $pageSize);
		$data['commentReportList'] = array();
		
		if ($totalNum > 0) {
			$query1 = $this->db->query($sql);
			$data['commentReportList'] = $query1->result_object();
		}
		return $data;
	}
	
	public function update_comment_report($id, $data) {
		$this->db->where('id', $id);
		return $this->db->update('comment_report', $data); 
	}
	
	public function update_report($id, $data) {
		$this->db->where('id', $id);
		return $this->db->update('report', $data); 
	}
	
	public function update_report_by_topicId($topicId, $data) {
		$this->db->where('topicID', $topicId);
		return $this->db->update('report', $data); 
	}
}

/* End of file report_model.php */
/* Location: ./application/models/report_model.php */