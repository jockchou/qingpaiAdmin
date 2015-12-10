<?php
class Operation_model extends CI_Model {
	private $db;

	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}
	
	public function getOperationList($page=null, $action=null, $pageNo=1, $pageSize=10) {
		
		$sql = "select * from operation";
		
		$where = ' WHERE 1 = 1';
		if ($page) {
			$where .= " AND page = '" .$page. "'";
		}
		if ($action) {
			$where .= " AND action = '" .$action. "'";
		}
		
		$start = ($pageNo - 1) * $pageSize;
		$orderBY = " ORDER BY id DESC";
		$limit = " LIMIT $start, $pageSize";
		
		$sql .= ($where . $orderBY . $limit);
		
		$sql2 = "SELECT count(*) AS totalNum FROM operation " . $where;
		
		$query2 = $this->db->query($sql2);
		$totalTmp = $query2->result_array();
		$totalNum = $totalTmp[0]['totalNum'];
		
		$data['totalPages'] = ceil($totalNum / $pageSize);
		$data['operationList'] = array();
		
		if ($totalNum > 0) {
			$query1 = $this->db->query($sql);
			$data['operationList'] = $query1->result_object();
		}
		
		return $data;
	}
	
	public function saveOperstion($data) {
		return $this->db->insert('operation', $data);
	}
	
	public function getOperationById($id) {
		$query = $this->db->get_where('operation', array('id' => $id));
		return $query->row_object();
	}
	
	public function updateOperation($id, $data) {
		$this->db->where('id', $id);
		return $this->db->update('operation', $data);
	}
	
	public function deleteOperaion($id) {
		return $this->db->delete('operation', array('id' => $id)); 
	}
	
}