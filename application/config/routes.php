<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

//标签管理 
$route['tags/tagsSave']						= "tags/tagsSave";
$route['tags/tagsList']						= "tags/tagsList";
$route['tags/tagsAdd']						= "tags/tagsAdd";

//账号管理 
$route['user/userList']						= "user/userList";
$route['user/userAdd']						= "user/userAdd";
$route['user/userDelete']					= "user/userDelete";
$route['user/userAuth']						= "user/userAuth";

//修改密码
$route['admin/changePass']					= "user/changePass";
$route['admin/savePass']					= "user/savePass";

$route['upload/uploadIcon'] 				= "upload/uploadIcon";

$route['login/index'] 						= "login/index";
$route['login/login'] 						= "login/doLogin";
$route['login/logout'] 						= "login/logout";

//客户端版本管理
$route['version/androidList'] 				= "version/versionList/android";
$route['version/iosList'] 					= "version/versionList/ios";
$route['version/versionEdit'] 				= "version/versionEdit";
$route['version/versionSave'] 				= "version/versionSave";
$route['version/versionDelete'] 			= "version/versionDelete";

// 文章审核
$route['topic/topicList'] 					= "topic/topicList/0";
$route['topic/checkTopic'] 					= "topic/checkTopic";
$route['topic/checkTopicBatch'] 			= "topic/checkTopicBatch";
$route['topic/checkTopicSingle'] 			= "topic/checkTopicSingle";
$route['topic/reportList'] 					= "topic/topicList/1";


//用户管理
$route['jjuser/jjuserList'] 				= "jjuser/jjuserList";
$route['jjuser/robotsList'] 				= "jjuser/jjuserList/true";
$route['jjuser/blockUserSave'] 				= "jjuser/blockUserSave";
$route['jjuser/unblockUser'] 				= "jjuser/unblockUser";
$route['jjuser/album']						= "jjuser/album";
$route['jjuser/jjuserLocation']				= "jjuser/jjuserLocation";
$route['jjuser/getUserLocationList']		= "jjuser/getUserLocationList";
$route['jjuser/reportUserList']				= "jjuser/reportUserList";
$route['jjuser/addV']						= "jjuser/addV";

//消息相关
$route['message/msgEdit'] 						= "message/msgEdit";
$route['message/msgSave'] 						= "message/msgSave";
$route['message/msgList'] 						= "message/msgList";
$route['message/msgDel'] 						= "message/msgDel";

$route['message/chatHome'] 						= "message/chatHome";
$route['message/chatPost'] 						= "message/chatPost";

//贴纸管理
$route['sticker/stickerList'] 					= "sticker/stickerList";
$route['sticker/stickerDelete'] 				= "sticker/stickerDelete";
$route['sticker/stickerAdd'] 					= "sticker/stickerAdd";
$route['sticker/stickerActivity'] 				= "sticker/stickerActivity";
$route['sticker/stickerActivitySave'] 			= "sticker/stickerActivitySave";

$route['sticker/addCrond'] 						= "sticker/addCrond";
$route['sticker/saveCrond'] 					= "sticker/saveCrond";
$route['sticker/removeCrond'] 					= "sticker/removeCrond";
$route['sticker/listCrond'] 					= "sticker/listCrond";

//颜值贴纸管理
$route['beauty/stickerList'] 					= "beauty/stickerList";
$route['beauty/stickerDelete'] 					= "beauty/stickerDelete";
$route['beauty/stickerAdd'] 					= "beauty/stickerAdd";
$route['beauty/stickerGrade'] 					= "beauty/stickerGrade";

//相册库
$route['imglibs/imageList'] 					= "imglibs/imageList";
$route['imglibs/blackList'] 					= "imglibs/blackList";
$route['imglibs/addRobotTask'] 					= "imglibs/addRobotTask";
$route['imglibs/saveRobotTask'] 				= "imglibs/saveRobotTask";
$route['imglibs/robotTaskList'] 				= "imglibs/robotTaskList";
$route['imglibs/delRobotTask'] 					= "imglibs/delRobotTask";
$route['imglibs/deleteImage'] 					= "imglibs/deleteImage";

//数据统计
$route['analytics/topic'] 					= "analytics/topic";
$route['analytics/user'] 					= "analytics/user";
$route['analytics/exportTopicExcel'] 		= "analytics/exportTopicExcel";
$route['analytics/exportUserExcel'] 		= "analytics/exportUserExcel";


//评论审核
$route['comport/comportList'] 				= "commentreport/commentReportList";
$route['comport/comportCheck'] 				= "commentreport/commentReportCheck";
$route['comport/getComment'] 				= "commentreport/getAssignTopicComment";
$route['comport/delComment'] 				= "commentreport/delComment";
$route['comport/delCommentArr'] 			= "commentreport/delCommentArr";
$route['comport/getDubiousComment']			= "commentreport/getDubiousComment";
$route['comport/passDubiousComment']		= "commentreport/passDubiousComment";
$route['comport/delDubiousComment']			= "commentreport/delDubiousComment";

//消息管理
$route['sysnotice/sysNoticList'] 			= "sysnotice/sysNoticList";
$route['sysnotice/saveSysNotice'] 			= "sysnotice/saveSysNotice";
$route['sysnotice/deleteSysNotice'] 		= "sysnotice/deleteSysNotice";
$route['sysnotice/editSystNotice'] 			= "sysnotice/editSystNotice";

//banner管理
$route['banner/bannerList'] 				= "banner/bannerList";
$route['banner/saveBanner'] 				= "banner/saveBanner";
$route['banner/deleteBanner'] 				= "banner/deleteBanner";
$route['banner/editBanner'] 				= "banner/editBanner";

//精选贴管理
$route['selectionTopic/selectionTopicList'] 	= "selectionTopic/selectionTopicList";
$route['selectionTopic/saveSelectionTopic'] 	= "selectionTopic/saveSelectionTopic";
$route['selectionTopic/deleteSelectionTopic'] 	= "selectionTopic/deleteSelectionTopic";
$route['selectionTopic/editSelectionTopic'] 	= "selectionTopic/editSelectionTopic";

//话题管理
$route['subjectactivity/searchHotList'] 	= "subjectactivity/searchHotList";
$route['subjectactivity/deSearchHost'] 		= "subjectactivity/deSearchHost";

$route['default_controller'] 				= "home";
$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */