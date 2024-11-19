<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
// routes for log out
$route['logout-a']			= 'Login/logoutAdmin';

//routes for change pass
$route['change-pass']		= 'Admin/Change_pass';

//routes for login
$route['login-a']			= 'Login/logAdmin';

//routes for profile
$route['profile'] 				= 'Admin';
$route['line_chart']			= 'Admin/getDataCountByMonth';
$route['adduser_content']		= 'Admin/adduser_content';
$route['adduser_content_cebu']	= 'Admin/adduser_content_cebu';
$route['edituser_content'] 		= 'Admin/edituser_content';

$route['crudcreate'] 			= 'Admin/crudcreate';
$route['crudupdate'] 			= 'Admin/crudupdate';
$route['buupdate'] 				= 'Admin/buupdate';

$route['bucreate'] 				= 'Admin/bucreate';
$route['compcreate'] 			= 'Admin/compcreate';

$route['addbu_content'] 		= 'Admin/addbu_content';
$route['addgroup_content'] 		= 'Admin/addgroup_content';

$route['edituser_content2'] 	= 'Admin/edituser_content2';
$route['userTasks_content'] 	= 'Admin/userTasks_content';
$route['editbu_content'] 		= 'Admin/editbu_content';
$route['editbu_content2'] 		= 'Admin/editbu_content2';

$route['editrfs_content'] 		= 'Request/editrfs_content';
$route['edittor_content'] 		= 'Request/edittor_content';
$route['editisr_content'] 		= 'Request/editisr_content';
$route['editconcern_content'] 	= 'Request/editconcern_content';

$route['concern_content'] 		= 'Request/concern_content';
$route['concern_create'] 		= 'Request/concern_create';

$route['rfs_content'] 			= 'Request/rfs_content';
$route['rfs_create'] 			= 'Request/rfs_create';

$route['tor_content'] 			= 'Request/tor_content';
$route['tor_create'] 			= 'Request/tor_create';

$route['isr_content'] 			= 'Request/isr_content';
$route['isr_create'] 			= 'Request/isr_create';

$route['addremarks_content'] 	= 'Request/addremarks_content';
$route['editremarks_content'] 	= 'Request/editremarks_content';
$route['viewremarks_content'] 	= 'Request/viewremarks_content';
// $route['userdetails_content'] 	= 'Request/userdetails_content';
$route['save_remarks'] 			= 'Request/save_remarks';
$route['remarksupdate'] 		= 'Request/remarksupdate';

$route['groupsupdate'] 			= 'Request/reqgroupupdate';

$route['approveconcern_content']= 'Request/approveconcern_content';

$route['approverfs_content'] 	= 'Request/approverfs_content';
$route['approverfs_content_e'] 	= 'Request/approverfs_content_e';

$route['approvetor_content'] 	= 'Request/approvetor_content';
$route['approvetor_content_e'] 	= 'Request/approvetor_content_e';

$route['approveisr_content'] 	= 'Request/approveisr_content';
$route['approveisr_content_e'] 	= 'Request/approveisr_content_e';

$route['bu_contents'] 			= 'Admin/bu_contents';

$route['rfsupdate'] 			= 'Request/rfsupdate';
$route['torupdate'] 			= 'Request/torupdate';
$route['isrupdate'] 			= 'Request/isrupdate';
$route['concernupdate'] 		= 'Request/concernupdate';

$route['status_deactivate']		= 'Admin/DeactivateUserStatus';
$route['status_activate']		= 'Admin/ActivateUserStatus';

$route['status_deactivate_group']	= 'Admin/DeactivateGroupStatus';
$route['status_activate_group']		= 'Admin/ActivateGroupStatus';

$route['reset_password'] 			= 'Admin/resetPassword';

$route['check_code'] 			= 'Admin/check_code';
$route['check_emp'] 			= 'Admin/CheckEmp';


$route['status_update']			= 'Admin/UpdateStatus';
$route['status_update_rfs']		= 'Admin/UpdateStatusRfs';
$route['status_update_tor']		= 'Admin/UpdateStatusTor';
$route['status_update_isr']		= 'Admin/UpdateStatusIsr';
$route['status_update_groups']	= 'Admin/UpdateStatusGroup';
$route['status_update_bu']		= 'Admin/UpdateStatusBu';
$route['status_update_burole']	= 'Admin/UpdateStatusBuRoles';
$route['status_update_burole1']	= 'Admin/UpdateStatusBuRoles1';
$route['status_update_burole2']	= 'Admin/UpdateStatusBuRoles2';

$route['status_update_files']	= 'Request/UpdateStatusFiles';
$route['status_update_request']	= 'Request/UpdateStatusRequest';
$route['status_update_approve']	= 'Approve/ApproveStatusRequest';
$route['status_update_execute']	= 'Execute/ExecuteStatusRequest';
$route['status_update_review']	= 'Review/ReviewStatusRequest';
$route['status_update_verify']	= 'Verify/VerifyStatusRequest';
$route['status_update_concern']	= 'Execute/ExecuteStatusConcern';
$route['status_ack_concern']	= 'Request/AcknowledgeStatusConcern';

$route['status_update_recall']	= 'Request/RecallStatusRequest';
$route['status_update_recall_a']= 'Approve/RecallStatusRequestA';
$route['status_update_recall_e']= 'Execute/RecallStatusRequestE';
$route['status_update_recall_r']= 'Review/RecallStatusRequestR';
$route['status_update_recall_v']= 'Verify/RecallStatusRequestV';

$route['status_update_a']		= 'Approve/CompleteStatusRequestA';
$route['status_update_e']		= 'Execute/CompleteStatusRequestE';
$route['status_update_r']		= 'Review/CompleteStatusRequestR';
$route['status_update_v']		= 'Verify/CompleteStatusRequestV';

$route['view-contact'] 			= 'Admin/ViewContact';
$route['view-users'] 			= 'Admin/ViewUsers';
$route['view-users-cebu'] 		= 'Admin/ViewUsersCebu';
$route['view-bu'] 			    = 'Admin/ViewBu';
$route['view-usergroup'] 		= 'Admin/ViewUsergroup';
$route['view-approvers'] 		= 'Admin/ViewApprovers';
$route['view-logs'] 			= 'Admin/ViewLogs';
$route['view-logs-r'] 			= 'Admin/ViewReqLogs';
$route['view-req'] 				= 'Admin/ViewReq';
$route['view-pending'] 			= 'Admin/ViewPending';
$route['view-deduct'] 			= 'Admin/ViewDeduction';
// for request
$route['view-concern'] 				= 'Request/ViewConcernPending';
$route['view-concern-completed'] 	= 'Request/ViewConcernCompleted';
$route['view-concern-cancelled'] 	= 'Request/ViewConcernCancelled';

$route['view-rfs'] 			    = 'Request/ViewRfsPending';
$route['view-rfs-completed'] 	= 'Request/ViewRfsCompleted';
$route['view-rfs-cancelled'] 	= 'Request/ViewRfsCancelled';

$route['view-tor'] 			    = 'Request/ViewTorPending';
$route['view-tor-completed'] 	= 'Request/ViewTorCompleted';
$route['view-tor-cancelled'] 	= 'Request/ViewTorCancelled';

$route['view-isr'] 			    = 'Request/ViewIsrPending';
$route['view-isr-completed'] 	= 'Request/ViewIsrCompleted';
$route['view-isr-cancelled'] 	= 'Request/ViewIsrCancelled';

//for approve
$route['pending-rfs-status'] 	= 'Approve/PendingStatusRfs';
$route['approve-rfs-status'] 	= 'Approve/ApproveStatusRfs';
$route['cancel-rfs-status'] 	= 'Approve/CancelStatusRfs';

$route['pending-tor-status'] 	= 'Approve/PendingStatusTor';
$route['approve-tor-status'] 	= 'Approve/ApproveStatusTor';
$route['cancel-tor-status'] 	= 'Approve/CancelStatusTor';

$route['pending-isr-status'] 	= 'Approve/PendingStatusIsr';
$route['approve-isr-status'] 	= 'Approve/ApproveStatusIsr';
$route['cancel-isr-status'] 	= 'Approve/CancelStatusIsr';

//for execute
$route['pending-concern-status']= 'Execute/PendingStatusConcernExecute';
$route['pending-rfs-status-e'] 	= 'Execute/PendingStatusRfsExecute';
$route['pending-tor-status-e'] 	= 'Execute/PendingStatusTorExecute';
$route['pending-isr-status-e'] 	= 'Execute/PendingStatusIsrExecute';

$route['approve-concern-status']= 'Execute/ApproveStatusConcernExecute';
$route['approve-rfs-status-e'] 	= 'Execute/ApproveStatusRfsExecute';
$route['approve-tor-status-e'] 	= 'Execute/ApproveStatusTorExecute';
$route['approve-isr-status-e'] 	= 'Execute/ApproveStatusIsrExecute';

$route['cancel-concern-status'] = 'Execute/CancelStatusConcernExecute';
$route['cancel-rfs-status-e'] 	= 'Execute/CancelStatusRfsExecute';
$route['cancel-tor-status-e'] 	= 'Execute/CancelStatusTorExecute';
$route['cancel-isr-status-e'] 	= 'Execute/CancelStatusIsrExecute';

//for review
$route['pending-rfs-status-r'] 	= 'Review/PendingStatusRfsReview';
$route['pending-tor-status-r'] 	= 'Review/PendingStatusTorReview';
$route['pending-isr-status-r'] 	= 'Review/PendingStatusIsrReview';

$route['approve-rfs-status-r'] 	= 'Review/ApproveStatusRfsReview';
$route['approve-tor-status-r'] 	= 'Review/ApproveStatusTorReview';
$route['approve-isr-status-r'] 	= 'Review/ApproveStatusIsrReview';

$route['cancel-rfs-status-r'] 	= 'Review/CancelStatusRfsReview';
$route['cancel-tor-status-r'] 	= 'Review/CancelStatusTorReview';
$route['cancel-isr-status-r'] 	= 'Review/CancelStatusIsrReview';

//for verify
$route['pending-rfs-status-v'] 	= 'Verify/PendingStatusRfsVerify';
$route['pending-tor-status-v'] 	= 'Verify/PendingStatusTorVerify';
$route['pending-isr-status-v'] 	= 'Verify/PendingStatusIsrVerify';

$route['approve-rfs-status-v'] 	= 'Verify/ApproveStatusRfsVerify';
$route['approve-tor-status-v'] 	= 'Verify/ApproveStatusTorVerify';
$route['approve-isr-status-v'] 	= 'Verify/ApproveStatusIsrVerify';

$route['cancel-rfs-status-v'] 	= 'Verify/CancelStatusRfsVerify';
$route['cancel-tor-status-v'] 	= 'Verify/CancelStatusTorVerify';
$route['cancel-isr-status-v'] 	= 'Verify/CancelStatusIsrVerify';


$route['printisr/(:any)'] 		= 'Request/printisr/$1';
$route['printrfs/(:any)'] 		= 'Request/printrfs/$1';
$route['printtor/(:any)'] 		= 'Request/printtor/$1';
// $route['view-tor-approve'] 		= 'Admin/ApproveTor';
// $route['view-isr-approve'] 		= 'Admin/ApproveIsr';


// for searching employee
$route['employee/search'] 		= 'Employee/search';
$route['store_user'] 		    = 'Employee/store';
$route['store_user_cebu'] 		= 'Employee/store_cebu';
$route['employee/user_list'] 	= 'Employee/user_list';

$route['employee/deac'] 		= 'Employee/autoDeactivateResigned';
$route['employee/autoUpdateName'] 		= 'Employee/autoUpdateName';

$route['employee/view'] 		= 'Employee/view';

$route['requests/list'] 		= 'Request/request_list';
$route['execute/list'] 			= 'Execute/request_list';
$route['approve/list'] 			= 'Approve/request_list';
$route['review/list'] 			= 'Review/request_list';
$route['verify/list'] 			= 'Verify/request_list';

$route['admin/reqlogs_list'] 	= 'Admin/reqlogs_list';
$route['admin/logs_list'] 		= 'Admin/logs_list';

$route['upload_files'] 			= 'Admin/upload_files';

//routes for change profile
$route['update-profile']		= 'Admin/ProfileUpdate';
$route['update-profile/(\d+)'] 	= 'Admin/ProfileUpdateView/$1';

//routes for change profile pic
$route['update-profile-pic']			= 'Admin/ProfilePicUpdate';
$route['update-profile-pic/(\d+)'] 		= 'Admin/ProfilePicUpdateView/$1';

$route['showApprovedRfs'] 			    = 'Request/showApprovedRfs';
$route['showApprovedTor'] 			    = 'Request/showApprovedTor';
$route['showApprovedIsr'] 			    = 'Request/showApprovedIsr';

$route['multipleImageStore'] 			= 'Admin/multipleImageStore';

$route['fetch-bu'] 						= 'Admin/fetch_bu';
$route['execute/update_status_to_approve'] 	= 'Execute/update_status_to_approve';