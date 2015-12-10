<?php
class Version_model extends CI_Model {
	private $db;

	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}
	
	public function removeFlash($id) {
		return $this->db->delete('client_flash', array('id' => $id)); 
	}
	
	public function saveFlash($data) {
		return $this->db->insert('client_flash', $data);
	}
	
	public function getFlashList($os, $pageNo=1, $pageSize=10) {
		$sql = "select * from client_flash";
		
		$where = ' WHERE 1 = 1';
		if ($os == 'android' OR $os == 'ios') {
			$where .= " AND os = '" .$os. "'";
		}
		$start = ($pageNo - 1) * $pageSize;
		$orderBY = " ORDER BY id DESC";
		$limit = " LIMIT $start, $pageSize";
		
		$sql .= ($where . $orderBY . $limit);
		
		$sql2 = "SELECT count(*) AS totalNum FROM client_flash " . $where;
		
		$query2 = $this->db->query($sql2);
		$totalTmp = $query2->result_array();
		$totalNum = $totalTmp[0]['totalNum'];
		
		$data['totalPages'] = ceil($totalNum / $pageSize);
		$data['flashList'] = array();
		
		if ($totalNum > 0) {
			$query1 = $this->db->query($sql);
			$data['flashList'] = $query1->result_array();
		}
		return $data;
	}
	
	public function getVersionList($os="android", $pageNo=1, $pageSize=10) {
		$sql = "select * from client_version";
		
		$where = ' WHERE 1 = 1';
		if ($os == 'android' OR $os == 'ios') {
			$where .= " AND os = '" .$os. "'";
		}
		$start = ($pageNo - 1) * $pageSize;
		$orderBY = " ORDER BY versionCode DESC";
		$limit = " LIMIT $start, $pageSize";
		
		$sql .= ($where . $orderBY . $limit);
		
		$sql2 = "SELECT count(*) AS totalNum FROM client_version " . $where;
		
		$query2 = $this->db->query($sql2);
		$totalTmp = $query2->result_array();
		$totalNum = $totalTmp[0]['totalNum'];
		
		$data['totalPages'] = ceil($totalNum / $pageSize);
		$data['versionList'] = array();
		
		if ($totalNum > 0) {
			$query1 = $this->db->query($sql);
			$data['versionList'] = $query1->result_object();
		}
		return $data;
	}
	
	public function getVersionById($id) {
		$query = $this->db->get_where('client_version', array('id' => $id));
		return $query->row_object();
	}
	
	public function saveVersion($data) {
		return $this->db->insert('client_version', $data);
	}
	
	public function updateVersion($id, $data) {
		$this->db->where('id', $id);
		return $this->db->update('client_version', $data);
	}
	
	public function delVersion($id) {
		return $this->db->delete('client_version', array('id' => $id)); 
	}
	
}