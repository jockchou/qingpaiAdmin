<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends JY_Controller {
	
	function __construct() {
		parent::__construct ();
	}

	function uploadIcon() {
		$config ['upload_path'] = TV_UPLOAD_IMG_PATH;
		$config ['allowed_types'] = 'gif|jpg|png';
		$config ['max_size'] = '1024';
		$config ['encrypt_name'] = TRUE;
		
		$this->load->library ('upload', $config);
		
		if (! $this->upload->do_upload("iconfile")) {
			$data['status'] = 0;
			$data['msg'] = $this->upload->display_errors('', '');
			echo json_encode($data);
		} else {
			$fileInfo = $this->upload->data();
			
			$data['status'] = 1;
			$data['msg'] = 'upload success';
			$data['filePath'] = substr($fileInfo['file_md5'], 0, 2) . '/' . $fileInfo['file_name'];
			echo json_encode($data);
		}
	}
}


/* End of file upload.php */
/* Location: ./application/controllers/upload.php */