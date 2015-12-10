<?php if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );

if (! function_exists ( 'aapt' )) {
	function aapt($apkFile) {
		
		if (is_file($apkFile)) {
			
			$cmd = "/usr/local/sandai/apktool/aapt d badging $apkFile";
	
			$apkInfo = shell_exec($cmd);
			
			if ($apkInfo) { //命令执行成功
				
				preg_match("/package: name='(.*)' versionCode='(.*)' versionName='(.*)'/", $apkInfo , $matches);
				
				if (is_array($matches) AND count($matches) === 4) {
					$packageName = $matches [1];
					$versionCode = $matches [2];
					$versionName = $matches [3];
					
					error_log($apkInfo, 3, "/usr/local/sandai/apktool/$packageName-" . date('YmdHis') . ".txt");
					
					return array (
						'packageName' => $packageName,
						'versionCode' => $versionCode,
						'versionName' => $versionName
					);
				} else {
					return FALSE;
				}
			} else {
				return FALSE;
			}
		}
		return FALSE;
	}
}

/* End of file apk_helper.php */
/* Location: ./system/helpers/apk_helper.php */