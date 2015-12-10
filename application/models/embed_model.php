<?php
class Embed_model extends CI_Model {
	public $db;

	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}
	
	public function getEmbedList($page=null, $pageNo=1, $pageSize=10) {
		
		$sql = "select a.id, a.topicID, a.pushStatus, a.pushTime, a.pubTime, a.page, a.relationship, b.content, b.praiseCnt, b.praiseCnt, b.commentCnt, b.shareCnt, b.userID, b.locCity, b.status, b.uploadBkgImageUrl, b.bkgImageMode, b.selectBkgImageIdx from oper_topic a left join topicinfo b ON a.topicID = b.id ";
		
		$where = ' WHERE 1 = 1';
		if ($page) {
			$where .= " AND a.page = '" .$page. "'";
		}

		$start = ($pageNo - 1) * $pageSize;
		$orderBY = " ORDER BY a.id DESC";
		$limit = " LIMIT $start, $pageSize";
		
		$sql .= ($where . $orderBY . $limit);
		
		$sql2 = "SELECT count(*) AS totalNum FROM oper_topic a " . $where;
		
		$query2 = $this->db->query($sql2);
		$totalTmp = $query2->result_array();
		$totalNum = $totalTmp[0]['totalNum'];
		
		$data['totalPages'] = ceil($totalNum / $pageSize);
		$data['embedList'] = array();
		
		if ($totalNum > 0) {
			$query1 = $this->db->query($sql);
			$data['embedList'] = $query1->result_object();
		}
		
		return $data;
	}
	
	public function saveEmbed($topicID, $page, $locCity, $relationship, $pubTime) {
		$sql = "INSERT IGNORE INTO `oper_topic` (`topicID`, `page`, `locCity`, `relationship`, `pubTime`) VALUES (?, ?, ?, ?, ?)";
		return $this->db->query($sql, array($topicID, $page, $locCity, $relationship, $pubTime));
	}

	// insert时候，存在就update
	public function saveEmbedInsert4Update ($topicID, $page, $locCity, $relationship, $pubTime) {
		
		$sql = "INSERT INTO `oper_topic` (`topicID`, `page`, `locCity`, `relationship`, `pubTime`) VALUES (?, ?, ?, ?, ?) on duplicate key update locCity=?, relationship=?, pubTime=?";

		return $this->db->query($sql, array($topicID, $page, $locCity, $relationship, $pubTime, $locCity, $relationship, $pubTime));
	}
	
	public function deleteEmbed($id) {
		return $this->db->delete('oper_topic', array('id' => $id)); 
	}

	public function update_oper_topic_4_push($id, $data) {
		$this->db->where('id', $id);
		return $this->db->update('oper_topic', $data); 
	}
	
}