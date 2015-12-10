<?php
class Banner_Model extends CI_Model {
	private $db;
	
	function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}
	
	public function getBannerList($pageType, $type, $pageSize=10, $pageNo=1) {
		$sql = 'SELECT * FROM banner';
		
		$where = ' WHERE 1 = 1';
		
		if ($pageType) {
			$where .= " AND pageType = $pageType";
		} 
		
		if ($type) {
			$where .= " AND type = $type";
		}
		
		$start = ($pageNo - 1) * $pageSize;
		$orderBY = " ORDER BY id DESC";
		$limit = " LIMIT $start, $pageSize";
		
		$sql .= ($where . $orderBY . $limit);
		
		$sql2 = "SELECT count(*) AS totalNum FROM banner " . $where;
		
		$query2 = $this->db->query($sql2);
		$totalTmp = $query2->result_array();
		$totalNum = $totalTmp[0]['totalNum'];
		
		$data['totalPages'] = ceil($totalNum / $pageSize);
		$data['bannerList'] = array();
		
		if ($totalNum > 0) {
			$query1 = $this->db->query($sql);
			$data['bannerList'] = $query1->result_array();
		}
		
		return $data;
		
	}
	
	public function saveBanner($data) {
		return $this->db->insert('banner', $data);
	}
	
	public function deleteBanner($id) {
		return $this->db->delete('banner', array('id' => $id));
	}
	
	public function offlineBanner($id) {
		$this->db->where('id', $id);
		return $this->db->update('banner', array('state' => 1));
	}
	
}