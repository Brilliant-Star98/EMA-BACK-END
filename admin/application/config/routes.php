<?php  if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}
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

$route['default_controller'] = "login";
$route['404_override'] = 'error';


/*********** USER DEFINED ROUTES *******************/

$route['loginMe'] = 'Login/loginMe';
$route['dashboard'] = 'User';
$route['logout'] = 'User/logout';


$route['userListing'] = 'User/userListing';
$route['userListing/(:num)'] = "User/userListing/$1";
$route['addNew'] = "User/addNew";
$route['addNewUser'] = "User/addNewUser";
$route['editOld'] = "User/editOld";
$route['editOld/(:num)'] = "User/editOld/$1";
$route['editUser'] = "User/editUser";
$route['deleteUser'] = "User/deleteUser";

$route['loadChangePass'] = "User/loadChangePass";
$route['changePassword'] = "User/changePassword";
$route['pageNotFound'] = "User/pageNotFound";
$route['checkEmailExists'] = "User/checkEmailExists";
$route['login-history'] = "User/loginHistoy";
$route['login-history/(:num)'] = "User/loginHistoy/$1";
$route['login-history/(:num)/(:num)'] = "User/loginHistoy/$1/$2";

$route['forgotPassword'] = "Login/forgotPassword";
$route['resetPasswordUser'] = "Login/resetPasswordUser";
$route['resetPasswordConfirmUser'] = "Login/resetPasswordConfirmUser";
$route['resetPasswordConfirmUser/(:any)'] = "Login/resetPasswordConfirmUser/$1";
$route['resetPasswordConfirmUser/(:any)/(:any)'] = "Login/resetPasswordConfirmUser/$1/$2";
$route['createPasswordUser'] = "Login/createPasswordUser";


// ===================HRK=============================

$route['list-agent'] = "Agent/index";
$route['add-agent'] = "Agent/Add";
$route['edit-agent'] = "Agent/Edit";
$route['delete-agent'] = "Agent/Delete";

$route['list-user']    = "AddUser/index";
$route['add-user']     = "AddUser/Add";
$route['edit-user']    = "AddUser/Edit";
$route['delete-user']  = "AddUser/Delete";


$route['list-billtype'] = "BillType/index";
$route['add-billtype'] = "BillType/Add";
$route['edit-billtype'] = "BillType/Edit";
$route['delete-billtype'] = "BillType/Delete";

$route['list-billgenerated']   = "BillGenerated/index";
$route['add-billgenerated']    = "BillGenerated/Add";
$route['edit-billgenerated']   = "BillGenerated/Edit";
$route['delete-billgenerated'] = "BillGenerated/Delete";

$route['bill-settings']        = "BillGenerated/billSettings";

$route['list-notification'] = "Notification/index";
$route['add-notification'] = "Notification/Add";
$route['edit-notification'] = "Notification/Edit";
$route['delete-notification'] = "Notification/Delete";

$route['list-notification-set']   = "SetNotification/index";
$route['add-notification-set']    = "SetNotification/Add";
$route['edit-notification-set']   = "SetNotification/Edit";
$route['delete-notification-set'] = "SetNotification/Delete";

$route['distress-requests'] = "SetNotification/distressRequest";
$route['distress-send-all'] = "SetNotification/distressSendAll";
$route['delete-distress']   = "SetNotification/deleteDistress";

$route['report'] = "Report/index";

$route['get-category-list'] = "Collection/GetCatList";

$route['approve-users'] = "UserApproval/index";
$route['pending-users'] = "UserApproval/pending";
$route['blocked-users'] = "UserApproval/blocked";
$route['block-now'] = "UserApproval/BlockUserNow";
$route['approve-user-now'] = "UserApproval/approveNow";


$route['list-payment'] = "Payment/index";
$route['delete-payment'] = "Payment/Delete";



$route['list-guard'] = "AddGuard/index";
$route['add-guard'] = "AddGuard/Add";
$route['edit-guard'] = "AddGuard/Edit";
$route['delete-guard'] = "AddGuard/Delete";

$route['list-visitors'] = "AddVisitor/index";
$route['add-visitors'] = "AddVisitor/Add";
$route['edit-visitors'] = "AddVisitor/Edit";
$route['delete-visitors'] = "AddVisitor/Delete";




/* End of file routes.php */
/* Location: ./application/config/routes.php */
