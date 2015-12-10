<?php
class Imglibs_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database('default');
	}
	
	function getRobotImageList($robotID, $isPushed, $pageSize, $pageNo) {
		$pageNo = $pageNo <= 0 ? 1 : $pageNo;
		
		$select = "SELECT * FROM image_robot";
		
		$where = " WHERE 1 = 1 ";
		
		if ($isPushed === "0" OR $isPushed === "1") {
			$where .= " AND isPushed = " . $isPushed;
		}
		
		if ($robotID > 0) {
			$where .= " AND userID = " . $robotID;
		}
		
		$orderBy = " ORDER BY id DESC LIMIT ?, ?";
		
		$sql1 = $select . $where . $orderBy;
		
		$sql2 = "SELECT COUNT(*) AS totalNum FROM image_robot " . $where;
		
		$query2 = $this->db->query($sql2);
		$totalTmp = $query2->result_array();
		$totalNum = $totalTmp[0]['totalNum'];
		
		$data['totalPages'] = ceil($totalNum / $pageSize);
		$data['imageList'] = array();
		
		if ($totalNum > 0) {
			$query1 = $this->db->query($sql1, array(($pageNo - 1) * $pageSize, $pageSize));
			$data['imageList'] = $query1->result_array();
		}
		
		return $data;
	}
	
	function getImageList($keyword, $pageSize, $pageNo) {
		$pageNo = $pageNo <= 0 ? 1 : $pageNo;
		
		$select = "SELECT * FROM image_libs";
		
		$where = " WHERE postCnt = 0 ";
		
		if (!empty($keyword)) {
			$where .= " AND tagName like '%{$keyword}%' OR picDesc like '%{$keyword}%'";
		}
		
		$orderBy = " ORDER BY id DESC LIMIT ?, ?";
		
		$sql1 = $select . $where . $orderBy;
		
		$sql2 = "SELECT COUNT(*) AS totalNum FROM image_libs " . $where;
		
		$query2 = $this->db->query($sql2);
		$totalTmp = $query2->result_array();
		$totalNum = $totalTmp[0]['totalNum'];
		
		$data['totalPages'] = ceil($totalNum / $pageSize);
		$data['imageList'] = array();
		
		if ($totalNum > 0) {
			$query1 = $this->db->query($sql1, array(($pageNo - 1) * $pageSize, $pageSize));
			$data['imageList'] = $query1->result_array();
		}
		
		return $data;
	}
	
	function getBlackImageList($pageSize, $pageNo) {
		$pageNo = $pageNo <= 0 ? 1 : $pageNo;
		
		$select = "SELECT * FROM image_black";
		
		$where = " WHERE 1 = 1 ";
		
		$orderBy = " ORDER BY id DESC LIMIT ?, ?";
		
		$sql1 = $select . $where . $orderBy;
		
		$sql2 = "SELECT COUNT(*) AS totalNum FROM image_black " . $where;
		
		$query2 = $this->db->query($sql2);
		$totalTmp = $query2->result_array();
		$totalNum = $totalTmp[0]['totalNum'];
		
		$data['totalPages'] = ceil($totalNum / $pageSize);
		$data['imageList'] = array();
		
		if ($totalNum > 0) {
			$query1 = $this->db->query($sql1, array(($pageNo - 1) * $pageSize, $pageSize));
			$data['imageList'] = $query1->result_array();
		}
		
		return $data;
	}
	
	
	public function getImageById($id) {
		$sql = "select * from image_libs where id = ? limit 1";
		$query = $this->db->query($sql, array($id));
		return $query->row_array();
	}
	
	public function removeById($id) {
		$sql = "delete from image_robot where id = ?";
		return $this->db->query($sql, array($id));
	}
	
	public function removeImageByID($id) {
		$sql = "delete from image_libs where id = ?";
		return $this->db->query($sql, array($id));
	}
	
	public function saveRobotTask($data) {
		return $this->db->insert('image_robot', $data);		
	}
	
	public function updateImageState($imgID) {
		$sql = "UPDATE image_libs SET postCnt = 1 WHERE id = " . $imgID;
		return $this->db->query($sql);
	}
}

/* End of file imglibs_model.php */
/* Location: ./application/models/imglibs_model.php */