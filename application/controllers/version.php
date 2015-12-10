<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Version extends JY_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('version_model');
	}
	
	public function flashAdd() {
		$data['crumbs'] = $this->createCrumbs(array("version/flashAdd"=>"新增闪屏"));
		$this->load->view('flashAdd', $data);
	}
	
	public function flashRemove() {
		$id = $this->input->get('id', true);
		echo (int)$this->version_model->removeFlash($id);
	}
	
	public function flashSave() {
		$startTime = $this->input->post('startTime', TRUE);
		$endTime = $this->input->post('endTime', TRUE);
		$os = $this->input->post('os', TRUE);
		
		$errorMessage = array();
		$imageUrl = '';
		$iconPath = '';
		$iconError = NULL;
		
		$iconConfig ['upload_path'] = JY_UPLOAD_IMG_PATH;
		$iconConfig ['allowed_types'] = 'gif|jpg|png';
		$iconConfig ['max_size'] = 512;
		$config['max_width']  = '960';
		$config['max_height']  = '1024';
		$iconConfig ['encrypt_name'] = TRUE;
		
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
			
			$flashData['imageUrl'] = $imageUrl;
			$flashData['os'] = $os;
			$flashData['startTime'] = $startTime;
			$flashData['endTime'] = $endTime;
			$flashData['addTime'] = date('Y-m-d H:i:s');
			
			$result= $this->version_model->saveFlash($flashData);
			
			if ($result) {
				array_push($errorMessage, array('messageText' => '保存成功!'));
				$data['message'] = array('success' => $errorMessage);
			} else {
				array_push($errorMessage, array('messageText' => '提交失败!'));
				$data['message'] = array('error' => $errorMessage);
			}
		}
				
		$this->load->view('message', $data);
	}
	
	public function flashList() {
		$pageSize = (int)$this->input->get('pageSize', TRUE);
		$pageNo =  (int)$this->input->get('pageNo', TRUE);
		
		$pageNo = $pageNo <= 0 ? 1 : $pageNo;
		$pageSize = ($pageSize > 0 && $pageSize <= 50) ? $pageSize : 10;
		
		$queryData = $this->version_model->getFlashList(null, $pageNo, $pageSize);
		
		$flashList = $queryData['flashList'];
		$totalPages = $queryData['totalPages'];

		//设置数据
		$data['pageSize'] = $pageSize;
		$data['pageNo'] = $pageNo;
		$data['totalPages'] = $totalPages;
		$data['flashList'] = $flashList;
		
		$data['crumbs'] = $this->createCrumbs(array('version/flashList' => '闪屏管理'));
		$query_config = array(
			'pageSize' => $pageSize
		);
		
		$data['pageUrl'] = "/version/flashList?" . http_build_query($query_config);
		
		$this->load->view('flashList', $data);
	}
	
	public function versionList($os='android') {
		
		$pageSize = (int)$this->input->get('pageSize', TRUE);
		$pageNo =  (int)$this->input->get('pageNo', TRUE);
		
		$pageNo = $pageNo <= 0 ? 1 : $pageNo;
		$pageSize = ($pageSize > 0 && $pageSize <= 50) ? $pageSize : 10;
		
		$queryData = $this->version_model->getVersionList($os, $pageNo, $pageSize);
		
		$versionList = $queryData['versionList'];
		$totalPages = $queryData['totalPages'];

		//设置数据
		$data['os'] = $os;
		$data['pageSize'] = $pageSize;
		$data['pageNo'] = $pageNo;
		$data['totalPages'] = $totalPages;
		$data['versionList'] = $versionList;
		
		if ($os == 'android') {
			$data['crumbs'] = $this->createCrumbs(array('version/androidList' => 'Android版本管理'));
		} else {
			$data['crumbs'] = $this->createCrumbs(array('version/iosList' => 'IOS版本管理'));
		}
		$query_config = array(
			'pageSize' => $pageSize,
			'os' => $os ? $os : '',
		);
		
		$data['pageUrl'] = "/version/versionlist?" . http_build_query($query_config);
		
		$this->load->view('versionList', $data);
	}
	
	/**
	 * @desc 新增版本信息
	 */
	public function versionAdd(){
		$data['crumbs'] = $this->createCrumbs(array("version/versionAdd"=>"新增版本"));
		$this->load->view('versionEdit', $data);
	}
	
	public function versionSave() {
		$versionId = $this->input->post('versionId', TRUE);
		
		$versionCode = $this->input->post('versionCode', TRUE);
		$version = $this->input->post('version', TRUE);
		$fileSize = $this->input->post('fileSize', TRUE);
		$os = $this->input->post('os', TRUE);
		$downURL = $this->input->post('downURL', TRUE);
		$isForbidden = (int)$this->input->post('isForbidden', TRUE);
		$updateMsg = $this->input->post('updateMsg', TRUE);
		
		$data['versionCode'] = $versionCode;
		$data['version'] = $version;
		$data['fileSize'] = $fileSize;
		$data['os']	= $os;
		$data['downURL'] = $downURL;
		$data['updateMsg'] = $updateMsg;
		$data['isForbidden'] = $isForbidden;
		$data['opTime']	= date('Y-m-d H:i:s');
		
		if ($versionId) {
			$this->version_model->updateVersion($versionId, $data);
		} else {
			$this->version_model->saveVersion($data);
		}
	
		if ($os == "android") {
			redirect(base_url('/version/androidList'), 'location', 301);
		} else {
			redirect(base_url('/version/iosList'), 'location', 301);
		}
		
	}

	public function versionEdit() {
		$id = $this->input->get('id', TRUE);
		$os = $this->input->get('os', TRUE);
		
		$version = $this->version_model->getVersionById($id);
		
		if ($os == "android") {
			$data['crumbs'] = $this->createCrumbs(array(
				"version/androidList" => 'Android版本',
				"version/versionEdit?id=$id&os=$os" => '编辑版本'
			));
		} else {
			$data['crumbs'] = $this->createCrumbs(array(
				'version/iosList' => 'IOS版本',
				"version/versionEdit?id=$id&os=$os" => '编辑版本'
			));
		}
		$data['version'] = $version;
		$this->load->view('versionEdit', $data);
	}
	
	
	public function versionDelete() {
		$id = $this->input->get('id', TRUE);
		$os = $this->input->get('os', TRUE);
		
		$this->version_model->delVersion($id);
		
		if ($os == "android") {
			redirect(base_url('/version/androidList'), 'location', 301);
		} else {
			redirect(base_url('/version/iosList'), 'location', 301);
		}
	}	
}

/* End of file manager.php */
/* Location: ./application/controllers/manager.php */