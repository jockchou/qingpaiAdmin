<?php
class Tags_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database('default');
	}

	function get_tags_by_tagsName($tagName) {
		$sql = "SELECT id, tagName, sexAdapt, updateTime FROM tags WHERE tagName = ? LIMIT 1";
		
		$query = $this->db->query($sql, array($tagName));
		
		$data =  $query->row();
		
		if (empty($data)) {
			return NULL;
		} else {
			return $data;
		}
	}

	public function get_tags_list($pageNo=1, $pageSize=10) {
		$sql1 = "SELECT id, tagName, sexAdapt, updateTime FROM tags";

		$orderBY = " ORDER BY id DESC";
		
		$start = ($pageNo - 1) * $pageSize;
		
		$limit = " LIMIT $start, $pageSize";
		
		$sql1 .= ($orderBY . $limit);

		$sql2 = "SELECT count(id) AS totalNum FROM tags ";

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

	public function delete_tags($tagName) {
		$this->db->where('tagName', $tagName);
		return $this->db->delete('tags');
	}

	public function save_tags($data) {
		return $this->db->insert('tags', $data);
	}

}

/* End of file tags_model.php */
/* Location: ./application/models/tags_model.php */