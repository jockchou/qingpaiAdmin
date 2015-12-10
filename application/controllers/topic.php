<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Topic extends JY_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('topic_model');
		$this->load->model('subjectactivity_model');
	}

	public function topicList($isReport=false) {
		
		$userID = (int)$this->input->get('userID', TRUE);
		$topicId = (int)$this->input->get('topicID', TRUE);
		$stickerID = (int)$this->input->get('stickerID', TRUE);
		$keyword = $this->input->get('keyword', TRUE);
		$state = $this->input->get('state', TRUE);
		$type = $this->input->get('type', TRUE);
		$highQuality = $this->input->get('highQuality', TRUE);
		$heatOrder = $this->input->get('heatOrder', TRUE);
		$beginTime = $this->input->get('beginTime', TRUE);
		$endTime = $this->input->get('endTime', TRUE);
		$pageNo = (int)$this->input->get('pageNo', TRUE);
		$subjectID = (int)$this->input->get('subjectID',TRUE);
		
		$pageSize = 48;
		$pageNo = $pageNo <= 0 ? 1: $pageNo;
		$queryData = null;
		
		if ($isReport == "1") {
			$queryData = $this->topic_model->getReportList($topicId, $userID, $type, $keyword, $state, $pageNo, $pageSize);
		} else {
			$queryData = $this->topic_model->getTopicList($topicId, $userID, $stickerID, $subjectID, $type, $keyword, $state, $highQuality, $heatOrder, $beginTime, $endTime, $pageNo, $pageSize);
		}
		
		$topicList = $queryData['topicList'];
		$totalPages = $queryData['totalPages'];
		
		$topicList = JY_sliceArray($topicList, 4);
		
		//设置数据
		$data['pageSize'] = $pageSize;
		$data['pageNo'] = $pageNo;
		
		$data['totalPages'] = $totalPages;
		$data['topicList'] = $topicList;
		
		$userID = $userID > 0 ? $userID : '';
		$stickerID = $stickerID > 0 ? $stickerID : '';
		$subjectID = $subjectID > 0 ? $subjectID : '';
		
		$data['userID'] = $userID ;
		$data['keyword'] = $keyword;
		$data['state'] = $state;
		$data['type'] = $type;
		$data['highQuality'] = $highQuality;
		$data['heatOrder'] = $heatOrder;
		$data['stickerID'] = $stickerID;
		
		$query_config = array(
			'userID' => $userID,
			'stickerID' => $stickerID,
			'subjectID' => $subjectID,
			'keyword' => $keyword ? $keyword : '',
			'state' => (!empty($state) OR $state === "0") ? $state : "",
			'type' => (!empty($type) OR $type === "0") ? $type : "",
			'highQuality' => (!empty($highQuality) OR $highQuality === "0") ? $highQuality : "",
			'heatOrder' => (!empty($heatOrder) OR $heatOrder === "0") ? $heatOrder : "",
		);

		if ($beginTime !== FALSE && $endTime !== FALSE && $beginTime <= $endTime) {
			$query_config['beginTime'] = $beginTime;
			$query_config['endTime'] = $endTime;
		}
		
		$pathURL = "/topic/topicList";
		$data['crumbs'] = $this->createCrumbs(array($pathURL => '帖子列表'));
		
		if ($isReport == "1") {
			$pathURL = "/topic/reportList";
			$data['crumbs'] = $this->createCrumbs(array($pathURL => '举报列表'));
		}
		
		$data['pageUrl'] = $pathURL . "?" . http_build_query($query_config);
		$data['pathURL'] = $pathURL;
		
		$this->load->view('topicList', $data);
	}
	
	private function deleteResByTopicIDArray($badTopicList) {
		if(empty($badTopicList)) return true;
		
		require_once(dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'third_party'. DIRECTORY_SEPARATOR . 'qiniu' . DIRECTORY_SEPARATOR . 'rs.php');
		
		if(!empty($badTopicList)) {
			foreach ($badTopicList as $key => $topic) {
				$resUrl = $topic['resUrl'];
				if (!empty($resUrl)) {
					$qn = getQNFromUrl($resUrl);
					Qiniu_SetKeys(JY_QN_accessKey, JY_QN_secretKey);
					$client = new Qiniu_MacHttpClient(null);
					$err = Qiniu_RS_Move($client, $qn['bucket'], $qn['key'], JY_QN_bucket_recycle, $qn['key']);
					if ($err !== null && $err->Code != 612) {
					   $this->topic->insertBadTopic($topic['id'], $resUrl, $err->Code);
					   return false;
					} else {
					   return true;
					}
				}
			}
		}
		return true;
	}
	
	private function pushDubious($topicIdList){
		
		if(empty($topicIdList)) return true;
		
		$topicInfoList = $this->topic_model->getTopicByIdList($topicIdList);
		
		foreach ($topicInfoList as $idx => $topicInfo) {
			$user = $this->topic_model->getUserInfoById($topicInfo['userID']);
			$userInfo = array(
				"userID" => (int)$user['id'],
				"nickname" => (string)$user['nickname'],
				"headUrl" => (string)$user['headUrl'],
				"sex" => (string)$user['sex'],
				"birthday" => (string)$user['birthday'],
				"heatCnt" => (int)$user['heatCnt'],
				"praiseCnt" => (int)$user['praiseCnt']
			);
			$baseTopic =  array(
				"topicID" => (string)$topicInfo['id'],
				"type" => (int)$topicInfo['type'],
				"content" => $topicInfo['content'],
				"resUrl" => $topicInfo['resUrl'],
				"replyTopicID" => (string)$topicInfo['replyTopicID'],
				"replyUserID" => (string)$topicInfo['replyTopicID'],
				"stickerID" => (string)$topicInfo['stickerID'],
				"subjectID" => (string)$topicInfo['subjectID'],
				"subjectTitle" => (string)$topicInfo['subjectTitle'],
				"location" => (string)$topicInfo['city'],
				"userInfo" => $userInfo,
				"heat" => (int)$topicInfo['heat'],
				"praiseCnt" => (int)$topicInfo['praise'],
				"duration" => (int)$topicInfo['duration'],
				"pubTime" => $topicInfo['pubTime'],
				"recvTime" => $topicInfo['pubTime'],
				"isDiscard" => 0
			);
			$result = $this->sendPushCommand($baseTopic);
		}
	}
	
	//处理通过
	private function handlePass($topicIdList) {
		if(empty($topicIdList)) return true;
		return $this->topic_model->updateTopicPass($topicIdList);
	}
	
	//设置优质
	private function handleHigh($topicIdList){
		if(empty($topicIdList)) return true;
		return $this->topic_model->updateTopicHighBatch($topicIdList);
	}
	
	//处理低质
	private function handleLow($topicIdList){
		if(empty($topicIdList)) return true;
		return $this->topic_model->updateTopicLowBatch($topicIdList);
	}
	
	//处理劣质
	private function handleBad($topicIdList) {
		if(empty($topicIdList)) return true;
		return $this->topic_model->updateTopicBadBatch($topicIdList);
	}
	
	//移出专题
	private function handleOutSubject($topicIdList) {
		if(empty($topicIdList)) return true;
		return $this->topic_model->removeFromSubject($topicIdList);
	}
	
	//单个审核
	public function checkTopicSingle() {
		$topicID = (int)$this->input->get('topicID', true);
		$checkType = (int)$this->input->get('checkType', true);
		$removeSubject = (int)$this->input->get('removeSubject', true);
		
		$topicIdList = array($topicID);
		$result = false;
		$needSendMsg = false;
		$topic = $this->topic_model->getTopicByIdArray($topicID);
		
		if (!empty($topic)) {
		
			if ($checkType == 1) { //优质
				$result = $this->handleHigh($topicIdList);
			} else if ($checkType == 2) { //通过
				$result = $this->handlePass($topicIdList);
			} else if ($checkType == 3) { //低质
				$result = $this->handleLow($topicIdList);
				//$needSendMsg = $result;
			} else if ($checkType == 4) { //劣质
				$result = $this->handleBad($topicIdList);
			}
			
			if ($checkType != 3 && $removeSubject == 1) {
				$result = $this->handleOutSubject($topicIdList);
				$needSendMsg = $result;
			}
			
			if ($needSendMsg) {
				$this->xiaoMiChatMsg($topic['userID'], $topic['subjectTitle'], $topic['pubTime']);
			}
			echo "1";
		} else {
			echo "-1";
		}
	}
	
	//批量审核帖子
	public function checkTopicBatch(){
		$highTopicArr = $this->input->post('highTopicArr', true);
		$passTopicArr = $this->input->post('passTopicArr', true);
		$lowTopicArr = $this->input->post('lowTopicArr', true);
		$badTopicArr = $this->input->post('badTopicArr', true);
		$selectTopicArr = $this->input->post('selectTopicArr', true);
		$reserveTopicArr = $this->input->post('reserveTopicArr', true);
		if (is_array($selectTopicArr) && is_array($reserveTopicArr)) {
			$reserveTopicArr = array_diff($reserveTopicArr, $selectTopicArr);
		}
		//$outSubjectArr = $this->input->post('outSubjectArr', true);
		$subjectID = (int)$this->input->post('subjectID', true);
		
		$pageState = $this->input->post('pageState', true);
		$topicSubjectList = $this->input->post('topicSubjectList', true);
		$topicSubjectArr = array();
		
		if (!empty($topicSubjectList) && is_array($topicSubjectList)) {
			foreach ($topicSubjectList as $topicSubject) {
				
				if (empty($topicSubjectArr[$topicSubject['topicID']])) {
					$topicSubjectArr[$topicSubject['topicID']] = array();
				}
				$subject = array(
					'subjectID' => $topicSubject['subjectID'],
					'title' => $topicSubject['subjectTitle'],
					'isOfficial' => $topicSubject['isOfficial']
				);
				array_push($topicSubjectArr[$topicSubject['topicID']], $subject);
			}
			
		}
		
		$highResult = -1;
		$passResult = -1;
		$lowResult = -1;
		$badResult = -1;
		$outSubjectResult = -1;
		$selectResult = -1;
		$reserveResult = -1;
		
		//优质处理
		if (!empty($highTopicArr)) {
			$highResult = $this->handleHigh($highTopicArr);
		}
		
		//通过处理
		if (!empty($passTopicArr)) {
			$passResult = $this->handlePass($passTopicArr);
		}
		
		//低质处理
		if (!empty($lowTopicArr)) {
			//$topicList = $this->topic_model->getTopicListIsSubject($lowTopicArr);
			$lowResult = $this->handleLow($lowTopicArr);
			/*if ($lowResult) { //移出专题后，要发小秘通知给用户
				foreach ($topicList as $key => $topic) {
					if ($topic['state'] != -2 && $topic['state'] != -1) {
						$this->xiaoMiChatMsg($topic['userID'], $topic['subjectTitle'], $topic['pubTime']);
					}
				}
			}*/
		}
		
		//劣质处理
		if (!empty($badTopicArr)) {
			
			$badTopicList = $this->topic_model->getTopicByIdList($badTopicArr);
			$result = $this->deleteResByTopicIDArray($badTopicList);
			if($result){
				foreach ($badTopicList as $key => $badTopic){
					if($badTopic['state'] == -1)continue;
					$content = "您于 ".date('Y-m-d H:i',ceil($badTopic['pubTime']/1000));
					$content .= "发的随遇：".mb_substr($badTopic['content'], 0 , 9)."...";
					$content .= " 因违反随遇社区规范，已被删除，请注意社交礼仪！";
					$this->xiaoMiChat($badTopic['userID'], 0, $content);
				}
				$this->handleBad($badTopicArr);//如果资源删除成功，再更新state状态，防止已劣质贴处理时再被推送。
			}
		}
		
		//精选处理
		if (!empty($selectTopicArr)) {
			$nowTime = date('Y-m-d H:i:s');
			$saveData = array();
			
			$existSelectTopicIDArr = $this->topic_model->getSelectionTopicIDArr($selectTopicArr);
			
			$selectTopicList = $this->topic_model->getTopicByIdList($selectTopicArr);
			
			foreach ($selectTopicList as $topic) {
				if (!in_array($topic['id'], $existSelectTopicIDArr)) {
					$selectTopic = array(
						'topicID' => $topic['id'],
						'state' => 0,
						'addTime' => $nowTime
					);
					array_push($saveData, $selectTopic);
					
					$content = "您于 ".date('Y-m-d H:i',ceil($topic['pubTime']/1000));
					$content .= "发的随遇";
					if (!empty($topic['content'])) {
						$content .= "：" . mb_substr($topic['content'], 0 , 9) . "... ";
					} else {
						$content .= "，";
					}
					$content .= "被随遇官方列入首页精选啦！期待你带来更多的优质内容！";
					$this->xiaoMiChat($topic['userID'], 0, $content);
				}
			}
			if (!empty($saveData)) {
				$selectResult = $this->topic_model->saveSelectionTopicBatch($saveData);
			} else {
				$selectResult = true;
			}
			
		}
		
		//处理预约精选
		if (!empty($reserveTopicArr)) {
			$nowTime = date('Y-m-d H:i:s');
			$saveData = array();
			
			$existSelectTopicIDArr = $this->topic_model->getSelectionTopicIDArr($reserveTopicArr);
			
			if (!empty($existSelectTopicIDArr)) {
				$reserveTopicArr = array_diff($reserveTopicArr, $existSelectTopicIDArr);
			}
			
			foreach ($reserveTopicArr as $topicID) {
				$reserveTopic = array(
					'topicID' => $topicID,
					'isSend' => 0,
					'addTime' => $nowTime
				);
				array_push($saveData, $reserveTopic);
			}
			
			if (!empty($saveData)) {
				$reserveResult = $this->topic_model->saveReserveTopicBatch($saveData);
			} else {
				$reserveResult = true;
			}
			
		}
		
		//移出专题
		/*if (!empty($outSubjectArr)) {
			$topicList = $this->topic_model->getTopicListIsSubject($outSubjectArr);
			$outSubjectResult = $this->handleOutSubject($outSubjectArr);
			if ($outSubjectResult) {
				foreach ($topicList as $key => $topic) {
					if ($topic['state'] != -2 && $topic['state'] != -1) {
						$this->xiaoMiChatMsg($topic['userID'], $topic['subjectTitle'], $topic['pubTime']);
					}
				}
			}
		}*/
		if (!empty($topicSubjectArr)) {
			$topicList = $this->topic_model->getTopicInfoList(array_keys($topicSubjectArr));
			$outSubjectResult = $this->topic_model->updateTopicSubjectBantch($topicSubjectArr);
			if ($outSubjectResult) {
				foreach ($topicList as $topic) {
					if (!empty($topicSubjectArr[$topic['id']])) {
						foreach ($topicSubjectArr[$topic['id']] as $subject) {
							if (!$this->isCustomSubjectID($subject['subjectID'])) {
								$this->xiaoMiChatMsg($topic['userID'], $subject['title'], $topic['pubTime']);
							}				
						}
					}
				}
			}
		}
		
		//可疑的审核通过后，要再推送一次
		if ($pageState == -3) {
			$topicArrTmp = array();
			if ($highResult) {
				$topicArrTmp = array_merge($topicArrTmp, $highTopicArr);
			}
			if ($passResult) {
				$topicArrTmp = array_merge($topicArrTmp, $passTopicArr);
			}
			
			$this->pushDubious($topicArrTmp);
		}
		
		$viewData = array(
			"r1" => $highResult,
			"r2" => $passResult,
			"r3" => $lowResult,
			"r4" => $badResult,
			"r5" => $outSubjectResult,
			"r6" => $selectResult,
			"r7" => $reserveResult
		);
		$this->renderJSON(json_encode($viewData));
	}
	
	private function isCustomSubjectID($subjectID) {
		if (ENVIRONMENT == 'production' && 36 == $subjectID) {
			return true;
		} else if ((ENVIRONMENT == 'testing' || ENVIRONMENT == 'development') && 10 == $subjectID) {
			return true;
		} else {
			return false;
		}
	}
	
	private function xiaoMiChatMsg($userID, $subjectTitle, $pubTime){
		$content = "亲爱的用户，你于 ".date('Y年m月d日',ceil($pubTime/1000))." 发表的随遇与 【".$subjectTitle."】 话题无关，已被移出话题，感谢参与！";
		$text = $this->xiaoMiChat($userID, 0, $content);
		return $text['rtn'] == "0" ? true : false;
	}
}
