<?php
class Beauty_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database('default');
	}

	public function getStickerGradeList($pageNo=1, $pageSize=10){
		
		$sql1 = "SELECT * FROM beauty_grade";

		$orderBY = " ORDER BY id DESC";
		
		$start = ($pageNo - 1) * $pageSize;
		
		$limit = " LIMIT $start, $pageSize";
		
		$sql1 .= ($orderBY . $limit);

		$sql2 = "SELECT count(id) AS totalNum FROM beauty_grade";

		$query2 = $this->db->query($sql2);
		$totalTmp = $query2->row_array();
		$totalNum = $totalTmp['totalNum'];

		$data['totalPages'] = ceil($totalNum / $pageSize);
		$data['stickerGradeList'] = array();

		if ($totalNum > 0) {
			$query1 = $this->db->query($sql1);
			$data['stickerGradeList'] = $query1->result_array();
		}

		return $data;
	}
	
	public function getStickerList($pageNo=1, $pageSize=10,$gradeID=0) {
		$sql1 = "SELECT * FROM beauty_sticker";
		
		
		$orderBY = " ORDER BY id DESC";
		
		$start = ($pageNo - 1) * $pageSize;
		
		$limit = " LIMIT $start, $pageSize";
		
		$sql2 = "SELECT count(id) AS totalNum FROM beauty_sticker ";
		
		if($gradeID > 0){
			$sql1 .= "where gradeID = ".$gradeID;
			$sql2 .= "where gradeID = ".$gradeID;
		}
		
		$sql1 .= ($orderBY . $limit);

		$query2 = $this->db->query($sql2);
		$totalTmp = $query2->result_array();
		$totalNum = $totalTmp[0]['totalNum'];

		$data['totalPages'] = ceil($totalNum / $pageSize);
		$data['stickerList'] = array();

		if ($totalNum > 0) {
			$query1 = $this->db->query($sql1);
			$data['stickerList'] = $query1->result_array();
		}

		return $data;
	}
	
	public function deleteSticker($id) {
		$this->db->where('id', $id);
		return $this->db->delete('beauty_sticker');
	}

	public function updateOnlineState($id, $state) {
		
		$data['updateTime'] = date("Y-m-d H:i:s");
		$data['state'] = $state;
		$this->db->where('id', $id);
		return $this->db->update('beauty_sticker', $data);
	}
	
	public function getStickerById($id) {
		$sql = "select * from beauty_sticker where id = ? limit 1;";
		$query = $this->db->query($sql, $id);
		return $query->row_array();
	}
	
	public function getStickerGradeById($id){
		
		$sql = "select * from beauty_grade where id = ? limit 1";
		$query = $this->db->query($sql, array($id));
		return $query->row_array();
	}
	public function saveSticker($data) {
		return $this->db->insert('beauty_sticker', $data);
	}
	
	public function updateSticker($id, $data) {
		$data['updateTime'] = date("Y-m-d H:i:s");
		$this->db->where('id', $id);
		return $this->db->update('beauty_sticker', $data);
	}
	
	public function saveStickerGrade($data) {
		return $this->db->insert('beauty_grade', $data);
	}
	
	public function removeGrade($id){
		$sql = "delete from beauty_grade where id = ?";
		$result = $this->db->query($sql,array($id));
		if(!$result){
			return false;
		}else{
			$sql = "update beauty_sticker set gradeID = 0 where gradeID = ?";
			return $this->db->query($sql,array($id));
		}
	}
	
	public function getAllGrade(){
		$sql = "select id,gradeName from beauty_grade";
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
	
	public function updateStickerGrade($id, $updateData) {
		$this->db->where('id', $id);
		return $this->db->update('beauty_grade', $updateData);
	}
	
}

/* End of file sticker_model.php */
/* Location: ./application/models/sticker_model.php */