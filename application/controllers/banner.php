<?php
class Banner extends JY_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('banner_model', 'banner');
	}
	
	public function bannerList() {
		$data['crumbs'] = $this->createCrumbs(array('banner/bannerList' => 'banner列表'));
		
		$pageType = (int)$this->input->get('pageType', TRUE);
		$type =  (string)$this->input->get('type', TRUE);
		$pageSize = (int)$this->input->get('pageSize', TRUE);
		$pageNo =  (int)$this->input->get('pageNo', TRUE);
		
		//默认值
		$pageNo = $pageNo <= 0 ? 1 : $pageNo;
		$pageSize = ($pageSize > 0 && $pageSize <= 50) ? $pageSize : 10;
		
		$pageInfo = $this->banner->getbannerList($pageType, $type, $pageSize, $pageNo);
		
		if ($pageInfo) {
			$data['pageNo'] = $pageNo;
			$data['pageSize'] = $pageSize;
			$data['bannerList'] = $pageInfo['bannerList'];
			$data['totalPages'] = $pageInfo['totalPages'];
			$data['type'] = $type;
			$data['pageType']= $pageType;
		}
		
		$query_config = array(
			'pageType' => $pageType,
			'type' => $type
		);
		
		$pathURL = "/banner/bannerList";
		
		$data['pageUrl'] = $pathURL . "?" . http_build_query($query_config);
		$data['pathURL'] = $pathURL;
		
		$this->load->view('bannerList', $data);
	}
	
	public function saveBanner() {
		
		$pageType = (int)$this->input->post('pageType', TRUE);
		$type = (int)$this->input->post('type', TRUE);
		$jumpUrl = $this->input->post('jumpUrl', TRUE);
		$onlineTime = $this->input->post('onlineTime', TRUE);
		
		$errorMessage = array();
		
		if ($type == 2) {
			$this->load->model('subjectactivity_model', 'subject');
			$subject = $this->subject->getSubjectById((int)$jumpUrl);
			
			if (empty($subject)) {
				array_push($errorMessage, array('messageText' => '话题ID不存在'));
				$data['message'] = array('error' => $errorMessage);
			}
		} 
		
		if (empty($data['message'])) {
			$iconConfig ['upload_path'] = JY_UPLOAD_IMG_PATH;
			$iconConfig ['allowed_types'] = 'gif|jpg|png';
			$iconConfig ['max_size'] = 256;
			$config['max_width']  = '800';
			$config['max_height']  = '600';
			$iconConfig ['encrypt_name'] = TRUE;
			
			$imageUrl = '';
			$iconPath = '';
			$iconError = NULL;
			
			
			if (isset($_FILES['imageFile']) AND $_FILES['imageFile']['error'] !== 4) {
				$this->load->library ('upload', $iconConfig, 'imageFile');
						
				//处理上传的图标
				if (! $this->imageFile->do_upload("imageFile", TRUE)) {
					$iconError = '图片上传失败: ' . $this->imageFile->display_errors('', '');
				} else {
					$iconFileInfo = $this->imageFile->data();
					$iconPath = $iconFileInfo['qiniu_ret']['key'];
				}
			}
			
			if ($iconError) {
				array_push($errorMessage, array('messageText' => $iconError));
				$data['message'] = array('warning' => $errorMessage);
				
			} else {
				if (!empty($iconPath)) { 
					$imageUrl = JY_PINGO_DATA_URL . $iconPath;
				}
				
				$jumpUrl = ($type == 2) ? 'subject://' . $jumpUrl : $jumpUrl;
				
				$bannerData['imageUrl'] = $imageUrl;
				$bannerData['type'] = $type;
				$bannerData['pageType'] = $pageType;
				$bannerData['jumpUrl'] = $jumpUrl;
				$bannerData['onlineTime'] = $onlineTime;
				$bannerData['addTime'] = date('Y-m-d H:i:s');
				
				$result= $this->banner->saveBanner($bannerData);
				
				if ($result) {
					array_push($errorMessage, array('messageText' => '保存成功!'));
					$data['message'] = array('success' => $errorMessage);
				} else {
					array_push($errorMessage, array('messageText' => '提交失败!'));
					$data['message'] = array('error' => $errorMessage);
				}
			}
		}
				
		$this->load->view('message', $data);
	}
	
	public function offlineBanner() {
		$id = (int)$this->input->get('id', TRUE);
		$result = $this->banner->offlineBanner($id);
		if ($result) {
			echo "0";
		} else {
			echo "999";
		}
	}
	
	public function deleteBanner() {
		
		$id = (int)$this->input->get('id', TRUE);
		$result = $this->banner->deleteBanner($id);
		if ($result) {
			echo "0";
		} else {
			echo "999";
		}
		
	}
	
	public function editBanner() {
		$data['crumbs'] = $this->createCrumbs(array('message/msgEdit' => '编辑Banner'));
		$this->load->view('bannerEdit', $data);
	}
}