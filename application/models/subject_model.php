<?php
class Subject_model extends CI_Model {
	public $db;

	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}
	
	public function get_subject_list($pageNo = 1, $pageSize = 20) {
		$sql = "SELECT * FROM topic_subject ";
		
		$where = ' WHERE 1 = 1';
		
		$start = ($pageNo - 1) * $pageSize;
		
		$orderBY = " ORDER BY isHot DESC, weight DESC, id DESC";
		
		$limit = " LIMIT $start, $pageSize";
		
		$sql .= ($where . $orderBY . $limit);
		
		$sql2 = "SELECT COUNT(*) AS totalNum FROM topic_subject " . $where;
		
		$query2 = $this->db->query($sql2);
		$totalTmp = $query2->result_array();
		$totalNum = $totalTmp[0]['totalNum'];
		
		$data['totalPages'] = ceil($totalNum / $pageSize);
		$data['subjectList'] = array();
		
		if ($totalNum > 0) {
			$query1 = $this->db->query($sql);
			$data['subjectList'] = $query1->result_object();
		}
		
		return $data;
	}

	public function get_subject_topic_info_list($subjectId, $start, $requestCnt, $incrNum) {
		
		$sql = "select * from subject_topic_info where subjectId = ? order by weight desc limit ?, ?";

		$query = $this->db->query($sql, array($subjectId, $start, (int)$requestCnt + (int)$incrNum ));

		return $query->result_array();
	}

	public function get_topic_subject_ids($subjectIdArr) {
		
		$subjectIDListStr = implode(",", $subjectIdArr);

		$len = count($subjectIDListStr);
		
		$sql = "SELECT * FROM topic_subject WHERE id IN ($subjectIDListStr) ORDER BY id ASC LIMIT $len";
		
		$result = $this->db->query($sql);
		
		return $result->result_array();
	}

	public function get_topic_subject_id($subjectId) {
	
		$sql = "SELECT * FROM topic_subject WHERE id = ? LIMIT 1";
		
		$result = $this->db->query($sql, array($subjectId));
		
		return $result->row_array();
	}
	
	public function get_recommend_list($pageNo = 1, $pageSize = 20) {
		$sql = "SELECT * FROM topic_subject_rec ";
		
		$where = ' WHERE 1 = 1';
		
		$start = ($pageNo - 1) * $pageSize;
		
		$orderBY = " ORDER BY orderNum DESC";
		
		$limit = " LIMIT $start, $pageSize";
		
		$sql .= ($where . $orderBY . $limit);
		
		$sql2 = "SELECT COUNT(*) AS totalNum FROM topic_subject_rec " . $where;
		
		$query2 = $this->db->query($sql2);
		$totalTmp = $query2->result_array();
		$totalNum = $totalTmp[0]['totalNum'];
		
		$data['totalPages'] = ceil($totalNum / $pageSize);
		$data['recommendList'] = array();
		
		if ($totalNum > 0) {
			$query1 = $this->db->query($sql);
			$data['recommendList'] = $query1->result_object();
		}
		
		return $data;
	}
	
	public function save($data) {
		return $this->db->insert('topic_subject', $data);		
	}
	
	public function update($subjectId, $data) {
		$this->db->where('id', $subjectId);
		return $this->db->update('topic_subject', $data); 
	}
	
	public function remove($subjectId) {
		return $this->db->delete('topic_subject', array('id' => $subjectId)); 
	}
	
	//分页查询专题下的贴子
	public function get_subject_topicinfo_list($subjectId, $pageNo=1, $pageSize=20) {
		$sql = "SELECT * FROM subject_topic_info ";
		
		$where = ' WHERE subjectId = ?';
		
		$start = ($pageNo - 1) * $pageSize;
		
		$orderBY = " ORDER BY weight DESC, topicID DESC";
		
		$limit = " LIMIT $start, $pageSize";
		
		$sql .= ($where . $orderBY . $limit);
		
		$sql2 = "SELECT COUNT(*) AS totalNum FROM subject_topic_info " . $where;
		
		$query2 = $this->db->query($sql2, array($subjectId));
		$totalTmp = $query2->result_array();
		$totalNum = $totalTmp[0]['totalNum'];
		
		$data['totalPages'] = ceil($totalNum / $pageSize);
		$data['topicList'] = array();
		$data['topicID2subTopicInfoArr'] = array();
		
		if ($totalNum > 0) {
			$query1 = $this->db->query($sql, array($subjectId));
			$topicIDList = $query1->result_object();
			$topicIdsArray = array();
			$topicID2subTopicInfoArr = array();
			foreach ( $topicIDList as $key => $item ) {
				array_push($topicIdsArray, $item->topicID);
				$topicID2subTopicInfoArr[$item->topicID] = $item;
			}
			$data['topicID2subTopicInfoArr'] = $topicID2subTopicInfoArr;
			$data['topicList'] = $this->get_topic_ids($topicIdsArray);
		}
		
		return $data;
	}
	
	// 多个文章ID批量查询文章，按照参数id给的顺序返回
	public function get_topic_ids($topicIDList) {
		
		$topicIDListStr = implode(",", $topicIDList);

		$len = count($topicIDList);
		
		$sql = "SELECT * FROM topicinfo WHERE id IN ($topicIDListStr) ORDER BY FIND_IN_SET(id, '{$topicIDListStr}') LIMIT $len";
		
		$result = $this->db->query($sql);
		
		return $result->result_object();
	}
	
	public function remove_recomment($id) {
		return $this->db->delete('topic_subject_rec', array('id' => $id)); 
	}
	
	public function save_recomment($data) {
		return $this->db->insert('topic_subject_rec', $data);
	}
	
	public function remove_topic($subjectId, $topicID) {
		return $this->db->delete('subject_topic_info', array('topicID' => $topicID, "subjectId" => $subjectId)); 
	}
	
	public function save_topic_to_subject($data) {
		return $this->db->insert('subject_topic_info', $data, TRUE);
	}
	
	public function top_topic($subjectId, $topicID, $weight) {
		
		if ($weight == 0) {
			$sql = "select max(weight) as maxValue from subject_topic_info where subjectId = ?";
			$query = $this->db->query($sql, array($subjectId));
			$subjectTmp = $query->row_array();
			$maxValue = (int)$subjectTmp['maxValue'];
			
			$sql = "update subject_topic_info set weight = ? where subjectId = ? and topicID = ?";
			
			return $this->db->query($sql, array($maxValue + 1, $subjectId, $topicID));
		} else {
			$sql = "update subject_topic_info set weight = 0 where subjectId = ? and topicID = ?";
			return $this->db->query($sql, array($subjectId, $topicID));
		}
		
	}
	
	public function update_recomment_online($id, $op) {
		if ($op == 'on') {
			$onlineStatus = 1;
		} else {
			$onlineStatus = 0;
		}
		$this->db->where('id', $id);
		return $this->db->update('topic_subject_rec', array('onlineStatus' => $onlineStatus)); 
	}

	public function update_subject_topic_weight($subjectId, $topicID, $weight) {
		$sql = "update subject_topic_info set weight = ? where subjectId = ? and topicID = ?";
		return $this->db->query($sql, array($weight, $subjectId, $topicID));
	}

	public function set_hot_topic($subjectId, $topicID, $ishot) {
		$sql = "update subject_topic_info set ishot = ? where subjectId = ? and topicID = ?";
		return $this->db->query($sql, array($ishot, $subjectId, $topicID));
	}
	
	public function getSubjectListById($subjectIdList) {
		if($subjectIdList == "") return array();
		$sql = "/*master*/ SELECT id AS subjectID, title, isOfficial FROM subject WHERE id IN ({$subjectIdList})";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
}