<?php
class Sticker_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database('default');
	}

	public function getStickerClassList($pageNo=1, $pageSize=10){
		
		$sql1 = "SELECT * FROM sticker_category";

		$orderBY = " ORDER BY orderVal DESC, id ASC";
		
		$start = ($pageNo - 1) * $pageSize;
		
		$limit = " LIMIT $start, $pageSize";
		
		$sql1 .= ($orderBY . $limit);

		$sql2 = "SELECT count(id) AS totalNum FROM sticker_category ";

		$query2 = $this->db->query($sql2);
		$totalTmp = $query2->result_array();
		$totalNum = $totalTmp[0]['totalNum'];

		$data['totalPages'] = ceil($totalNum / $pageSize);
		$data['stickerClassList'] = array();

		if ($totalNum > 0) {
			$query1 = $this->db->query($sql1);
			$data['stickerClassList'] = $query1->result_array();
		}

		return $data;
	}
	
	public function getStickerList($pageNo=1, $pageSize=10,$categoryID=0) {
		$sql1 = "SELECT * FROM sticker ";
		
		
		$orderBY = " ORDER BY orderVal DESC, id ASC";
		
		$start = ($pageNo - 1) * $pageSize;
		
		$limit = " LIMIT $start, $pageSize";
		
		$sql2 = "SELECT count(id) AS totalNum FROM sticker ";
		
		if($categoryID > 0){
			$sql1 .= "where categoryID = ".$categoryID;
			$sql2 .= "where categoryID = ".$categoryID;
		}
		
		$sql1 .= ($orderBY . $limit);

		$query2 = $this->db->query($sql2);
		$totalTmp = $query2->result_array();
		$totalNum = $totalTmp[0]['totalNum'];

		$data['totalPages'] = ceil($totalNum / $pageSize);
		$data['tagsList'] = array();

		if ($totalNum > 0) {
			$query1 = $this->db->query($sql1);
			$data['tagsList'] = $query1->result_array();
		}

		return $data;
	}

	public function updateOnlineState($id, $state) {
		
		$data['updateTime'] = date("Y-m-d H:i:s");
		$this->db->where('id', $id);
		return $this->db->update('sticker', array("state" => $state));
	}
	
	public function getStickerById($id) {
		$sql = "select * from sticker where id = ? limit 1;";
		$query = $this->db->query($sql, $id);
		return $query->row_array();
	}
	
	public function removeCrond($id) {
		$sql = "delete from sticker_crond where id = ?";
		return $this->db->query($sql, array($id));
	}
	
	public function getCrondList($stickerID, $pageNo=1, $pageSize=10) {
		$sql1 = "SELECT * FROM sticker_crond WHERE stickerID = ? ";

		$orderBY = " ORDER BY id ASC";
		
		$start = ($pageNo - 1) * $pageSize;
		
		$limit = " LIMIT $start, $pageSize";
		
		$sql1 .= ($orderBY . $limit);

		$sql2 = "SELECT count(id) AS totalNum FROM sticker_crond WHERE stickerID = ? ";

		$query2 = $this->db->query($sql2, array($stickerID));
		$totalTmp = $query2->result_array();
		$totalNum = $totalTmp[0]['totalNum'];

		$data['totalPages'] = ceil($totalNum / $pageSize);
		$data['crondList'] = array();

		if ($totalNum > 0) {
			$query1 = $this->db->query($sql1, array($stickerID));
			$data['crondList'] = $query1->result_array();
		}

		return $data;
	}
	
	public function saveCrond($data) {
		$data['addTime'] = date("Y-m-d H:i:s");
		return $this->db->insert('sticker_crond', $data);
	}
	
	public function getStickerClassById($id){
		
		$sql = "select * from sticker_category where id = ? limit 1;";
		$query = $this->db->query($sql, $id);
		return $query->row_array();
	}
	public function saveSticker($data) {
		return $this->db->insert('sticker', $data);
	}
	
	public function updateSticker($id, $data) {
		$data['updateTime'] = date("Y-m-d H:i:s");
		$this->db->where('id', $id);
		return $this->db->update('sticker', $data);
	}
	
	public function saveStickerClass($data) {
		return $this->db->insert('sticker_category', $data);
	}
	
	public function updateStickerClass($id, $data) {
		//$data['updateTime'] = date("Y-m-d H:i:s");
		$this->db->where('id', $id);
		return $this->db->update('sticker_category', $data);
	}
	
	public function saveStickerActivity($data) {
		return $this->db->insert('sticker_activity', $data, true);
	}
	
	public function updateStickerActivity($id, $data) {
		$this->db->where('id', $id);
		return $this->db->update('sticker_activity', $data); 
	}
	
	public function getActivityByStickerID($stickerID) {
		$sql = "SELECT * FROM sticker_activity WHERE stickerID = ? LIMIT 1";
		$query = $this->db->query($sql, array($stickerID));
		return $query->row_array();
	}
	
	public function removeClass($id){
		$sql = "delete from sticker_category where id = ?";
		$result = $this->db->query($sql,array($id));
		if(!$result){
			return false;
		}else{
			$sql = "update sticker set categoryID = 0 where categoryID = ?";
			return $this->db->query($sql,array($id));
		}
	}
	
	public function getAllCategoryID(){
		$sql = "select id,title from sticker_category";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function getSubjectIdByTitle($md5SubjectTitle){
		$sql = "SELECT id FROM subject WHERE md5Title = ?";
		$query = $this->db->query($sql, array($md5SubjectTitle));
		return $query->row_array();
	}
	
	public function saveSubjectTitle($subjectTitle){
		$sql = "INSERT INTO subject(title, md5Title) VALUES(?, ?)";
		return $this->db->query($sql, array($subjectTitle, md5($subjectTitle)));
	}
}

/* End of file sticker_model.php */
/* Location: ./application/models/sticker_model.php */