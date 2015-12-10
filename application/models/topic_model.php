<?php
class Topic_model extends CI_Model {
	public $db;
	
	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	//所有帖子设为可疑
	public function setDubiousByUserID($userID){
		$sql = "UPDATE topic SET state = -3 WHERE state = 0 AND userID = ?";
		return $this->db->query($sql, array($userID));
	}

	
	public function insertBadTopic($topicID,$resUrl,$errCode){
		$sql = "insert into badtopic_recycle (topicID,resUrl,errCode) values ('$topicID','$resUrl','$errCode')";
		return $this->db->query($sql);
	}

	public function removeDubiousByUserID($userID){
		$sql = "UPDATE topic SET state = 0 WHERE state = -3 AND userID = ?";
		return $this->db->query($sql, array($userID));
	}
	
	public function removeUncheckTopicByUserID($userID) {
		$checkTime = date("Y-m-d H:i:s");
		$sql = "UPDATE topic SET checkTime = ?, state = -1 WHERE userID = ? AND (state = 0 OR state = -3)";
		return $this->db->query($sql, array($checkTime, $userID));
	}
	
	//通过
	public function updateTopicPass($idArray) {
		$topicIDListStr = implode(",", $idArray);
		$checkTime = date("Y-m-d H:i:s");

		$sql = "UPDATE topic SET checkTime = ?, highQuality = 0, state = 1 WHERE id in({$topicIDListStr});";
		return $this->db->query($sql, array($checkTime));

	}
	
	//优质
	public function updateTopicHighBatch($idArray) {
		$topicIDListStr = implode(",", $idArray);
		$checkTime = date("Y-m-d H:i:s");
		$sql = "UPDATE topic SET checkTime = ?, highQuality = 1, state = 1 WHERE id IN({$topicIDListStr});";
		return $this->db->query($sql, array($checkTime));
	}
	
	//低质，移出专题
	public function updateTopicLowBatch($idArray){
		$topicIDListStr = implode(",", $idArray);
		$checkTime = date("Y-m-d H:i:s");

		$sql = "UPDATE topic SET checkTime= ?, highQuality = -1, state = 1, subjectID = 0, subjectTitle = '' WHERE id IN({$topicIDListStr});";

		$result = $this->db->query($sql, array($checkTime));
		return $result;
	}
	
	//劣质
	public function updateTopicBadBatch($idArray) {
		$topicIDListStr = implode(",", $idArray);
		$checkTime = date("Y-m-d H:i:s");
		$sql = "UPDATE topic SET checkTime= ?, highQuality = 0, state = -1 WHERE id IN({$topicIDListStr});";
		return $this->db->query($sql, array($checkTime));
	}
	
	//移出专题
	public function removeFromSubject($idArray) {
		$topicIDListStr = implode(",", $idArray);
		$sql = "UPDATE topic SET subjectID = 0, subjectTitle = '' WHERE id IN({$topicIDListStr});";
		return $this->db->query($sql);
	}
	
	public function saveUserInbox($fromUserID, $toUserID, $topicID) {
		$data = array(
			"userID" => $toUserID,
			"fromUserID" => $fromUserID,
			"topicID" => $topicID,
			"isPingo" => 0,
			"recvTime" => JY_getMsTime()
		);
		
		return $this->db->insert('user_inbox', $data, true);
	}
	
	
	public function saveTopic($topic) {
		return $this->db->insert('topic', $topic);
	}
	
	public function getTopicById($id) {
		$query = $this->db->get_where('topic', array('id' => $id));
		return $query->row_object();
	}
	
	public function getTopicByIdArray($id) {
		$sql = "SELECT * FROM topic WHERE id = ? LIMIT 1";
		$query = $this->db->query($sql, array($id));
		return $query->row_array();
	}
	
	public function getUserInfoById($id){
		$sql = "SELECT * FROM user WHERE id = ?";
		$query = $this->db->query($sql, array($id));
		return $query->row_array();
	}
	
	public function getTopicByIdList($idArray){
		$topicIDListStr = implode(",", $idArray);
		$limit = count($idArray);
		$sql = "SELECT * FROM topic WHERE id IN({$topicIDListStr}) LIMIT ?";
		$result = $this->db->query($sql, array($limit));
		return $result->result_array();
	}
	
	public function getTopicListIsSubject($idArray) {
		$topicIDListStr = implode(",", $idArray);
		$limit = count($idArray);
		$sql = "SELECT * FROM topic WHERE subjectID > 0 AND id IN({$topicIDListStr}) LIMIT ?";
		$result = $this->db->query($sql, array($limit));
		return $result->result_array();
	}
	
	public function getChatList($userID, $fromUserID) {
		$sql = "SELECT COUNT(*) AS total FROM user_inbox WHERE (fromUserID=? OR fromUserID=?) AND (userID=? OR userID=?)";
		
		$query = $this->db->query($sql, array($fromUserID, $userID, $userID, $fromUserID));
		$rowTmp = $query->row_array();
		$total = $rowTmp['total'];
		$size = 10;
		
		if ($total > $size) {
			$start = $total - $size;
		} else {
			$start = 0;
		}
		
		//设置成已经读
		$sql2 = "UPDATE user_inbox SET isRead = 1, readTime = NOW() WHERE isRead = 0 AND userID = ? AND fromUserID = ?";
		$this->db->query($sql2, array($userID, $fromUserID));
		
		$sql1 = "select a.*, b.*, c.* from user_inbox a, topic b, user c where a.topicID = b.id and b.userID = c.id and (a.fromUserID=? OR a.fromUserID=?) AND (a.userID=? OR a.userID=?) order by a.id ASC Limit ?, ?";
		$query1 = $this->db->query($sql1, array($fromUserID, $userID, $userID, $fromUserID, $start, $size));
		return $query1->result_array();
	}
	
	public function updateTopicSubjectID($moveList){
		
		$moveList = implode(",", $moveList);
		$sql = "update topic set subjectID=0,subjectTitle=null where id in ({$moveList})";
		return $this->db->query($sql);
	}
	
	
	public function getTopicList($topicId=false, $userID=false, $stickerID=0, $subjectID=0, $type=false, $keyword=false, $state=false, $highQuality=false, $heatOrder=false, $beginTime=false, $endTime=false, $pageNo=1, $pageSize=10) {
		
		$sql1 = "SELECT b.* FROM topic b";
		
		if ($subjectID != 0) {
			$where = ", subject_to_topic a WHERE a.subjectID = $subjectID AND a.topicID = b.id AND b.state != -2 AND b.replyUserID = 0";
		} else {
			$where = ' WHERE b.state != -2 AND b.replyUserID = 0';
		}
		
		if (!empty($topicId)) {
			$where .= " AND b.id = $topicId";
		} else {
			if (!empty($type) OR $type === "0") {
				$where .= " AND b.type = $type";
			}
			
			if (!empty($userID)) {
				$where .= " AND b.userID = $userID";
			}
			
			if (!empty($stickerID) && $stickerID != 0) {
				$where .= " AND b.stickerID = $stickerID";
			}
			
			//if (!empty($subjectID) && $subjectID != 0) {
			//	$where .= " AND subjectID = $subjectID";
			//}
			
			if (!empty($state) OR $state === '0') {
				$where .= " AND b.state = $state";
			}

			if (!empty($highQuality) OR $highQuality === '0') {
				$where .= " AND b.highQuality = $highQuality";
			}

			if ($beginTime !== FALSE && $endTime !== FALSE && strtotime($beginTime) <= strtotime($endTime) ) {
				$where .= " AND b.pubTime >= '" . strtotime($beginTime) * 1000 . "'";
				$where .= " AND b.pubTime < '" . (strtotime($endTime) * 1000 + 24 * 60 * 60 * 1000 ). "'";
			}
			
			if (!empty($keyword)) {
				$where .= " AND b.content LIKE '%$keyword%'";
			}
		}
		
		if ($heatOrder !== FALSE && $heatOrder !== "") {
			if ($heatOrder == '1') {
				$orderBY = " ORDER BY b.heat DESC, b.id DESC";
			} else {
				$orderBY = " ORDER BY b.heat ASC, b.id DESC";
			}
		} else {
			$orderBY = " ORDER BY b.id DESC";
		}
		
		
		$start = ($pageNo - 1) * $pageSize;
		
		$limit = " LIMIT $start, $pageSize";
		
		$sql1 .= ($where . $orderBY . $limit);
		
		$sql2 = "SELECT count(*) AS totalNum FROM topic b" . $where;
		
		$query2 = $this->db->query($sql2);
		$totalTmp = $query2->result_array();
		$totalNum = $totalTmp[0]['totalNum'];
		
		$data['totalPages'] = ceil($totalNum / $pageSize);
		//
		$topicList = array();
		
		if ($totalNum > 0) {
			$query1 = $this->db->query($sql1);
			$topicList = $query1->result_array();
		}
		
		$topicIDArr = array();
		
		foreach ($topicList as $item) {
			array_push($topicIDArr, $item['id']);
		} 
		
		$selectTopicList = array();
		if (!empty($topicIDArr)) {
			$sql3 = "SELECT topicID from topic_select WHERE topicID IN (" . implode(',', $topicIDArr) .") LIMIT " . count($topicList);
			$query = $this->db->query($sql3);
			$selectTopicList = $query->result_array();
		}
		
		$selectTopicIDArr = array();
		foreach ($selectTopicList as $item) {
			array_push($selectTopicIDArr, $item['topicID']);
		}
		
		$reserveTopicList = array();
		if (!empty($topicIDArr)) {
			$sql4 = "SELECT topicID from topic_reserve WHERE topicID IN (" . implode(',', $topicIDArr) .") LIMIT " . count($topicList);
			$query = $this->db->query($sql4);
			$reserveTopicList = $query->result_array();
		}
		
		$reserveTopicIDArr = array();
		foreach ($reserveTopicList as $item) {
			array_push($reserveTopicIDArr, $item['topicID']);
		}
		
		foreach ($topicList as $key => $item) {
			if (in_array($item['id'], $selectTopicIDArr)) {
				$topicList[$key]['isSelect'] = true;
			} else {
				$topicList[$key]['isSelect'] = false;
			}
			if (in_array($item['id'], $reserveTopicIDArr)) {
				$topicList[$key]['isReserve'] = true;
			} else {
				$topicList[$key]['isReserve'] = false;
			}
		}
		
		$data['topicList'] = $topicList;
		
		return $data;
	}
	
	public function getReportList($topicId=false, $userID=false, $type=false, $keyword=false, $state=false, $pageNo=1, $pageSize=10) {
		$sql1 = "SELECT a.* FROM topic a, topic_complain b";
		
		$where = ' WHERE a.replyUserID = 0 AND a.id = b.topicID';
		
		if (!empty($topicId)) {
			$where .= " AND a.id = $topicId";
		} else {
			if (!empty($type) OR $type === "0") {
				$where .= " AND a.type = $type";
			}
			
			if (!empty($userID)) {
				$where .= " AND a.userID = $userID";
			}
			
			if (!empty($state) OR $state === '0') {
				$where .= " AND a.state = $state";
			}
			
			if (!empty($keyword)) {
				$where .= " AND a.content LIKE '%$keyword%'";
			}
		}
		
		$orderBY = " ORDER BY b.id DESC";
		
		$start = ($pageNo - 1) * $pageSize;
		
		$limit = " LIMIT $start, $pageSize";
		
		$sql1 .= ($where . $orderBY . $limit);
		
		$sql2 = "SELECT count(a.id) AS totalNum FROM topic a, topic_complain b" . $where;
		
		$query2 = $this->db->query($sql2);
		$totalTmp = $query2->result_array();
		$totalNum = $totalTmp[0]['totalNum'];
		
		$data['totalPages'] = ceil($totalNum / $pageSize);
		$data['topicList'] = array();

		if ($totalNum > 0) {
			$query1 = $this->db->query($sql1);
			$data['topicList'] = $query1->result_array();
		}
		
		return $data;
	}
	
	public function getSelectionTopicList($pageSize=10, $pageNo=1, $topicState){
		$sql = "SELECT a.*, b.resUrl, b.userID FROM topic_select a, topic b";
		
		$where = " WHERE a.topicID = b.id AND b.state >= 0";
		
		if ($topicState == 1 || $topicState == 2) {
			$topicState--;
			$where .= " AND a.state = $topicState";
		}
		
		$start = ($pageNo - 1) * $pageSize;
		$orderBY = " ORDER BY a.id DESC";
		$limit = " LIMIT $start, $pageSize";
		
		$sql .= ($where . $orderBY . $limit);
		
		$sql2 = "SELECT count(*) AS totalNum FROM topic_select a, topic b" . $where;
		
		$query2 = $this->db->query($sql2);
		$totalTmp = $query2->row_array();
		$totalNum = $totalTmp['totalNum'];
		
		$data['totalPages'] = ceil($totalNum / $pageSize);
		$data['selectionTopicList'] = array();
		
		if ($totalNum > 0) {
			$query1 = $this->db->query($sql);
			$data['selectionTopicList'] = $query1->result_array();
		}
		
		return $data;
	}
	
	public function saveSelectionTopic($data) {
		return $this->db->insert('topic_select', $data);
	}
	
	public function saveSelectionTopicBatch($data) {
		return $this->db->insert_batch('topic_select', $data, TRUE);
	}
	
	public function deleteSelectionTopic($id) {
		$this->db->where('id', $id);
		return $this->db->delete('topic_select');
	}
	
	public function setTopicSelectState($id, $state) {
		$this->db->where('id', $id);
		$this->db->set('state', $state);
		return $this->db->update('topic_select');
	}
	
	public function getSelectionTopicIDArr($topicIDArr) {
		$selectTopicIDArr = array();
		
		$sql = "SELECT topicID FROM topic_select WHERE topicID IN(" . implode(',', $topicIDArr) . ") LIMIT ?";
		$query = $this->db->query($sql, array(count($topicIDArr)));
		$result = $query->result_array();
		
		if (!empty($result)) {
			foreach ($result as $item) {
				array_push($selectTopicIDArr, $item['topicID']);
			}
		}
		return $selectTopicIDArr;
	}
	
	public function isExistSelectionTopicID($topicID) {
		$sql = "SELECT id FROM topic_nice WHERE topicID = ? LIMIT 1";
		$query = $this->db->query($sql, array($topicID));
		$result = $query->row_array();
		return isset($result['id']) ? true : false;
	}
	
	public function updateCommentCnt($topicID){
		$sql = "update topic set commentCnt = commentCnt - 1 where id = ? and commentCnt > 0";
		return $this->db->query($sql, array($topicID));
	}
	
	public function updateTopicSubjectBantch($topicSubjectArr) {
		$topicIDArr = array_keys($topicSubjectArr);
		$deleteIDArr = array();
		$insertTopicIDArr = array();
		$newTopicSubjectArr = array();
		$subjectIDArr = array();
		$result1 = true;
		$result2 = true;
		$result3 = true;
		
		$sql = "SELECT a.id, a.topicID, b.id AS subjectID, b.title, b.isOfficial FROM subject_to_topic a, subject b WHERE a.subjectID = b.id AND a.topicID IN (" . implode(',', $topicIDArr) . ") LIMIT ?";
		$query = $this->db->query($sql, array(3*count($topicIDArr)));
		$topicSubjectList = $query->result_array();
		
		foreach ($topicSubjectList as $key => $item) {
			$subject = array(
				'subjectID' => $item['subjectID'],
				'title' => $item['title'],
				'isOfficial' => $item['isOfficial']
			);
			if (in_array($subject, $topicSubjectArr[$item['topicID']])) {
				unset($topicSubjectList[$key]);
				array_push($deleteIDArr, $item['id']);
				if (empty($subjectIDArr[$item['subjectID']])) {
					$subjectIDArr[$item['subjectID']] = 1;
				} else {
					$subjectIDArr[$item['subjectID']]++;
				}
			}
		}
		
		foreach ($topicIDArr as $topicID) {
			$newTopicSubjectArr[$topicID] = array();
		}
		
		foreach ($topicSubjectList as $item) {
			
			$subject = array(
				'subjectID' => $item['subjectID'],
				'title' => $item['title'],
				'isOfficial' => $item['isOfficial']
			);
			
			array_push($newTopicSubjectArr[$item['topicID']], $subject);
		}
		
		if (!empty($deleteIDArr)) {
			$result1 = $this->deleteSubjectToTopicBantch($deleteIDArr);
			if ($result1) {
				$this->setSubjectTopicCntBatch($subjectIDArr);
			}
		}
		
		if ($result1) {
			foreach ($newTopicSubjectArr as $key => $item) {
				if (empty($item)) {
					$item = array($this->getCustomSubject());
					array_push($insertTopicIDArr, $key);
				}
				$subjectID = 0;
				$subjectTitle = '';
				foreach ($item as $subject) {
					if ($subject['isOfficial'] == 1) {
						$subjectID = $subject['subjectID'];
						$subjectTitle = $subject['title'];
						break;
					}
				}
				$updateData = array(
					'subjectID' => $subjectID,
					'subjectTitle' => $subjectTitle,
					'simpleSubjectJson' => json_encode($item)
				);
				
				$result2 = $this->updateTopicSubject($key, $updateData);
			}
		}
		
		if (!empty($insertTopicIDArr) && $result1 && $result2) {
			$result3 = $this->saveCustomSubjectToTopic($insertTopicIDArr);
		}
		
		return $result1 && $result2 && $result3;
	}
	
	private function getCustomSubject() {
		if (ENVIRONMENT == 'production') {
			$subjectID = 36;
		} else if (ENVIRONMENT == 'testing') {
			$subjectID = 10;
		} else {
			$subjectID = 10;
		}
		return array('subjectID' => $subjectID, 'title' => '我在随遇的日常', 'isOfficial' => 1);
	}
	
	public function updateTopicSubject($id, $data) {
		$this->db->where('id', $id);
		return $this->db->update('topic', $data);
	}
	
	public function deleteSubjectToTopicBantch($deleteIDArr) {
		$sql = "DELETE FROM subject_to_topic WHERE id IN (" . implode(',', $deleteIDArr) . ")";
		return $this->db->query($sql);
	}
	
	public function setSubjectTopicCntBatch($subjectIDArr) {
		foreach($subjectIDArr as $id => $value) {
			$sql = "UPDATE subject SET topicCnt = topicCnt - $value WHERE id = $id";
			$query = $this->db->query($sql);
		}
	}
	
	public function saveCustomSubjectToTopic($topicIDArr) {
		$data = array();
		$addTime = date('Y-m-d H:i:s');
		if (ENVIRONMENT == 'production') {
			$subjectID = 36;
		} else if (ENVIRONMENT == 'testing') {
			$subjectID = 10;
		} else {
			$subjectID = 10;
		}
		
		foreach ($topicIDArr as $topicID) {
			$item = array(
				'subjectID' => $subjectID,
				'topicID' => $topicID,
				'addTime' => $addTime
			);
			array_push($data, $item);
		}
		
		$sql = "UPDATE subject SET topicCnt = topicCnt + " . count($topicIDArr) . " WHERE id = $subjectID";
		
		$this->db->query($sql);
		
		return $this->db->insert_batch('subject_to_topic', $data, TRUE);
		
	}
	
	public function getTopicSubject($subjectID, $topicIDArr) {
		$sql = "SELECT a.topicID, b.id AS subjectID, b.title AS subjectTitle, b.isOfficial FROM subject_to_topic a, subject b WHERE a.subjectID = ? AND a.topicID IN (" . implode(',', $topicIDArr) . ") AND a.subjectID = b.id LIMIT ?";
		$query = $this->db->query($sql, array($subjectID, 3*count($topicIDArr)));
		return $query->result_array();
	}
	
	public function getTopicInfoList($topicIDArr) {
		$sql = "SELECT * FROM topic WHERE id IN (" . implode(',', $topicIDArr) . ") LIMIT ?";
		$query = $this->db->query($sql, count($topicIDArr));
		return $query->result_array();
	}
	
	public function getReserveTopicList($pageSize, $pageNo, $isSend = 0) {
		$sql = "SELECT a.*, b.resUrl, b.userID FROM topic_reserve a, topic b";
		
		$where = " WHERE a.topicID = b.id AND a.isSend = ? AND b.state >= 0";
		
		$start = ($pageNo - 1) * $pageSize;
		$orderBY = " ORDER BY a.id DESC";
		$limit = " LIMIT $start, $pageSize";
		
		$sql .= ($where . $orderBY . $limit);
		
		$sql2 = "SELECT count(*) AS totalNum FROM topic_reserve a, topic b" . $where;
		
		$query2 = $this->db->query($sql2, array($isSend));
		$totalTmp = $query2->row_array();
		$totalNum = $totalTmp['totalNum'];
		
		$data['totalPages'] = ceil($totalNum / $pageSize);
		$data['reserveTopicList'] = array();
		
		if ($totalNum > 0) {
			$query1 = $this->db->query($sql, array($isSend));
			$data['reserveTopicList'] = $query1->result_array();
		}
		
		return $data;
	}
	
	public function deleteReserveTopic($id) {
		$this->db->where('id', $id);
		return $this->db->delete('topic_reserve');
	}
	
	public function saveReserveTopicBatch($saveData) {
		return $this->db->insert_batch('topic_reserve', $saveData, TRUE);
	}
	
}