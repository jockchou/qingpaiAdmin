<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Beauty extends JY_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('beauty_model');
	}

	public function stickerList() {
		
		$gradeID = (int)$this->input->get('gradeID', TRUE);
		$pageNo = (int)$this->input->get('pageNo', TRUE);
		
		
		$pageSize = 10;
		$pageNo = $pageNo <= 0 ? 1: $pageNo;
		$queryData = null;

		$queryData = $this->beauty_model->getStickerList($pageNo, $pageSize, $gradeID);

		$stickerList = $queryData['stickerList'];
		$totalPages = $queryData['totalPages'];

		//设置数据
		$data['pageSize'] = $pageSize;
		$data['pageNo'] = $pageNo;
		$data['stickerList'] = $stickerList;
		$data['totalPages'] = $totalPages;
		
		$pathURL = "/beauty/stickerList";
		$data['crumbs'] = $this->createCrumbs(array($pathURL => '颜值贴纸列表'));
		if($gradeID > 0){
			$data['pageUrl'] = $pathURL . "?gradeID=".$gradeID;
		}else{
			$data['pageUrl'] = $pathURL."?";
		}
		$data['pathURL'] = $pathURL;

		$this->load->view('beauty/stickerList', $data);

	}

	public function stickerGrade(){
		
		$pageNo = (int)$this->input->get('pageNo', TRUE);

		$pageSize = 10;
		$pageNo = $pageNo <= 0 ? 1: $pageNo;
		$queryData = null;

		$queryData = $this->beauty_model->getStickerGradeList($pageNo, $pageSize);

		$stickerGradeList = $queryData['stickerGradeList'];
		$totalPages = $queryData['totalPages'];

		//设置数据
		$data['pageSize'] = $pageSize;
		$data['pageNo'] = $pageNo;
		$data['stickerGradeList'] = $stickerGradeList;
		$data['totalPages'] = $totalPages;
		
		$pathURL = "/beauty/stickerGrade";
		$data['crumbs'] = $this->createCrumbs(array($pathURL => '贴纸分类'));

		$data['pageUrl'] = $pathURL . "?";
		$data['pathURL'] = $pathURL;
		
		$this->load->view('beauty/stickerGradeList', $data);
	}
	public function stickerAdd() {
		$gradeList = $this->beauty_model->getAllGrade();
		$data['gradeList'] = $gradeList;
		$data['crumbs'] = $this->createCrumbs(array('beauty/stickerList' => '颜值贴纸列表', 'beauty/stickerAdd' => '添加颜值贴纸'));
		$this->load->view('beauty/stickerAdd', $data);
	}
	public function stickerGradeAdd(){
		
		$data['crumbs'] = $this->createCrumbs(array('beauty/stickerGrade' => '颜值贴纸分类', 'beauty/stickerAdd' => '添加颜值贴纸级别'));
		$this->load->view('beauty/stickerGradeAdd', $data);
	}
	
	public function stickerGradeSave(){
		$id = (int)$this->input->post("id", TRUE);
		$gradeName = $this->input->post("gradeName", TRUE);
		$minScore = (int)$this->input->post("minScore", TRUE);
		$maxScore = (int)$this->input->post("maxScore", TRUE);
		
		$errorMessage = array();
		if ($minScore > 100 || $minScore < 0 || $maxScore > 100 || $maxScore < 0 || $minScore >= $maxScore) {
			array_push($errorMessage, array('messageText' => "分数范围设置不正确！"));
			$data['message'] = array('error' => $errorMessage);
			$this->load->view('message', $data);
			return;
		}
		
		$errorMessage = array();
		
		$nowTime = date('Y-m-d H:i:s');
		
		if ($id > 0) {
			$updateData = array(
				'minScore' => $minScore,
				'maxScore' => $maxScore,
				'updateTime' => $nowTime
			);
			
			$result = $this->beauty_model->updateStickerGrade($id, $updateData);
		} else {
			$saveData = array(
				'gradeName' => $gradeName,
				'minScore' => $minScore,
				'maxScore' => $maxScore,
				'addTime' => $nowTime,
				'updateTime' => $nowTime
			);
			
			$result = $this->beauty_model->saveStickerGrade($saveData);
		}
		
		if ($result) {
			array_push($errorMessage, array('messageText' => '保存成功!'));
			$data['message'] = array('success' => $errorMessage);
		} else {
			array_push($errorMessage, array('messageText' => '提交失败!'));
			$data['message'] = array('error' => $errorMessage);
		}
		$this->load->view('message', $data);
	}
	
	public function stickerSave() {
		$name = (string)$this->input->post("name", TRUE);
		$gradeID = (int)$this->input->post("gradeID", TRUE);
		$sex = (int)$this->input->post("sex", TRUE);
		$tag = (int) $this->input->post("tag", TRUE);
		$tagStartTime = (string)$this->input->post("tagStartTime");
		$tagEndTime = (string)$this->input->post("tagEndTime");
		$onlineTime = (string)$this->input->post("onlineTime");
		$subjectTitle = (string) $this->input->post("subjectTitle", TRUE);
		$textPosX = (int)$this->input->post("textPosX", TRUE);
		$textPosY = (int)$this->input->post("textPosY", TRUE);
		$isFullScreen = (int)$this->input->post("isFullScreen", TRUE);
				
		$resUrl = "";
		
		$iconConfig ['upload_path'] = JY_UPLOAD_IMG_PATH;
		$iconConfig ['allowed_types'] = 'png|jpg';
		$iconConfig ['max_size'] = 1024;
		$iconConfig ['encrypt_name'] = TRUE;
		$iconConfig ['bucket']  = 'qpsticker';
		
		$iconPath = '';
		$iconError = NULL;
		$errorMessage = array();
		
		if (isset($_FILES['imageFile']) AND $_FILES['imageFile']['error'] !== 4) {
			$this->load->library ('upload', $iconConfig, 'imageFile');
			//处理上传的图标
			if (! $this->imageFile->do_upload("imageFile", TRUE)) {
				$iconError = '背景图上传失败: ' . $this->imageFile->display_errors('', '');
			} else {
				$iconFileInfo = $this->imageFile->data();
				$iconPath = $iconFileInfo['qiniu_ret']['key'];
			}
		}
		
		if ($iconError) {
			array_push($errorMessage, array('messageText' => $iconError));
		}
		
		if (empty($iconPath)) {
			array_push($errorMessage, array('messageText' => "未选择贴纸图片"));
		}
		
		if ($gradeID <= 0) {
			array_push($errorMessage, array('messageText' => "未创建贴纸级别"));
		}
		
		if ($tag != "0" && (empty($tagStartTime) || empty($tagEndTime))) {
			array_push($errorMessage, array('messageText' => "未选择标签有效日期"));
		}
			
		if (!empty($errorMessage)) {
			$data['message'] = array('error' => $errorMessage);
			$this->load->view('message', $data);
		} else {
			
			$timeNow = date("Y-m-d H:i:s");
			$msgTmp = array(
				'gradeID' => $gradeID,
				'name' => $name,
				'sex' => $sex,
				'addTime' => $timeNow,
				'updateTime' => $timeNow,
				'textPosX' => $textPosX,
				'textPosY' => $textPosY,
				'tag' => $tag,
				'tagStartTime' => $tagStartTime,
				'tagEndTime' => $tagEndTime,
				'onlineTime' => empty($onlineTime) ? $timeNow : $onlineTime,
				'isFullScreen' => $isFullScreen,
				
			);
			
			if ("" != trim($subjectTitle)) {
				$result = $this->beauty_model->getSubjectIdByTitle(md5($subjectTitle));
				if(!$result){
					//不存在，创建话题
					$result = $this->beauty_model->saveSubjectTitle($subjectTitle);
					if($result){
						$subjectID = $this->db->insert_id();
						$msgTmp['subjectID'] = $subjectID;
					}
				}else{
					$msgTmp['subjectID'] = (int)$result['id'];
				}
				$msgTmp['subjectTitle'] = $subjectTitle;
			}
			
			if (!empty($iconPath)) {
				$resUrl = JY_PINGO_STICKER_URL . $iconPath;
				$msgTmp['imageUrl'] = $resUrl;
			}
			
			$result = $this->beauty_model->saveSticker($msgTmp);
			
			if ($result) {
				array_push($errorMessage, array('messageText' => '保存成功!'));
				$data['message'] = array('success' => $errorMessage);
			} else {
				array_push($errorMessage, array('messageText' => '提交失败!'));
				$data['message'] = array('error' => $errorMessage);
			}
			
			$this->load->view('message', $data);
		}
	}
	
	public function stickerDelete() {
		$id = (int)$this->input->get('id', true);
		$result = $this->beauty_model->deleteSticker($id);
		if ($result) {
			echo "1";
		} else {
			echo "0";
		}
	}
	
	public function stickerState() {
		$id = (int)$this->input->get('id', TRUE);
		$state = (int)$this->input->get('state', TRUE);
		$result = $this->beauty_model->updateOnlineState($id, $state);
		if ($result) {
			echo "1";
		} else {
			echo "0";
		}
	}
	
	public function stickerEdit() {
		$stickerID = $this->input->get('stickerID', true);
		$sticker = $this->beauty_model->getStickerById($stickerID);
		$data['sticker'] = $sticker;
		$categoryIDList = $this->beauty_model->getAllCategoryID();
		$data['categoryIDList'] = $categoryIDList;
		$data['crumbs'] = $this->createCrumbs(array('sticker/stickerList' => '贴纸列表', 'sticker/stickerAdd' => '添加贴纸'));
		$this->load->view('stickerAdd', $data);
	}
	
	public function stickerGradeEdit(){
		$id = $this->input->get('id', true);
		$stickerGrade = $this->beauty_model->getStickerGradeById($id);
		$data['stickerGrade'] = $stickerGrade;
		$data['crumbs'] = $this->createCrumbs(array('sticker/stickerList' => '贴纸列表', 'sticker/stickerGradeEdit' => '更改分类贴纸'));
		$this->load->view('beauty/stickerGradeAdd', $data);
	}
	
	public function stickerGradeDelete(){
		$id = (int)$this->input->get('id', true);
		echo $this->beauty_model->removeGrade($id);
	}
	
	public function stickerActivity() {
		$stickerID = $this->input->get("stickerID", true);
		$data['crumbs'] = $this->createCrumbs(array('beauty/stickerActivity' => '编辑活动'));
		$data['stickerID'] = $stickerID;
		
		$activityInfo = $this->beauty_model->getActivityByStickerID($stickerID);
		
		$data['actiInfo'] = $activityInfo;
		$this->load->view('beauty/stickerActivity', $data);
	}
	
	public function stickerActivitySave() {
		$activityID = $this->input->post("activityID", true);
		$title = $this->input->post("title", true);
		$content = $this->input->post("content", true);
		$stickerID = $this->input->post('stickerID', true);
		
		$iconConfig ['upload_path'] = JY_UPLOAD_IMG_PATH;
		$iconConfig ['allowed_types'] = 'png|jpg';
		$iconConfig ['max_size'] = 256;
		$iconConfig ['encrypt_name'] = TRUE;
		$iconConfig ['bucket']  = 'pingodata';
		
		$iconPath = '';
		$iconError = NULL;
		$errorMessage = array();
		
		if (isset($_FILES['imageFile']) AND $_FILES['imageFile']['error'] !== 4) {
			$this->load->library ('upload', $iconConfig, 'imageFile');
			//处理上传的图标
			if (! $this->imageFile->do_upload("imageFile", TRUE)) {
				$iconError = '图上传失败: ' . $this->imageFile->display_errors('', '');
			} else {
				$iconFileInfo = $this->imageFile->data();
				$iconPath = $iconFileInfo['qiniu_ret']['key'];
			}
		}
		
		if ($iconError) {
			array_push($errorMessage, array('messageText' => $iconError));
		}
		
		if (empty($activityID) && empty($iconPath)) {
			array_push($errorMessage, array('messageText' => "未选择上传图片"));
		}
		
		if (!empty($errorMessage)) {
			$data['message'] = array('error' => $errorMessage);
			$this->load->view('message', $data);
		} else {
			$now = date("Y-m-d H:i:s");
			
			$tmpObj = array(
				"stickerID" => $stickerID,
				"title" => $title,
				"content" => $content,
				"updateTime" => $now
			);
			if (!empty($iconPath)) {
				$tmpObj['posterUrl'] = JY_PINGO_DATA_URL . $iconPath;
			}
			if (!empty($activityID)) {
				$result = $this->beauty_model->updateStickerActivity($activityID, $tmpObj);
			} else {
				$tmpObj['addTime'] = $now;
				$result = $this->beauty_model->saveStickerActivity($tmpObj);
			}
			
			if ($result) {
				array_push($errorMessage, array('messageText' => '保存成功!'));
				$data['message'] = array('success' => $errorMessage);
			} else {
				array_push($errorMessage, array('messageText' => '提交失败!'));
				$data['message'] = array('error' => $errorMessage);
			}
			
			$this->load->view('message', $data);
		}
	}
	
}

/* End of file sticker.php */
/* Location: ./application/controllers/sticker.php */