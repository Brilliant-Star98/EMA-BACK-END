<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class User extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('collection_model');
        // $this->isLoggedIn();
    }

    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        $this->global['pageTitle'] = 'Dashboard';
        $data['collectionList'] = $this->collection_model->GetCollection($this->session->userdata('userId'));
        $data['paymentsList']   = $this->user_model->getAllPayments($this->session->userdata('userId'));
        $data['myLocation']     = $this->user_model->getUserLocation($this->session->userdata('userId'));
	
        $this->loadViews("dashboard", $this->global, $data, NULL , NULL);
    }

    /**
     * This function is used to load the user list
     */


  function appUser()
  {
      $data['appUsers'] = $this->user_model->appUsers();


  }






    function userListing()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;

            $this->load->library('pagination');

            $count = $this->user_model->userListingCount($searchText);

			      $returns = $this->paginationCompress ( "userListing/", $count, 5 );

            $data['userRecords'] = $this->user_model->userListing($searchText, $returns["page"], $returns["segment"]);

            $this->global['pageTitle'] = 'CodeInsect : User Listing';

            $this->loadViews("users/users", $this->global, $data, NULL);
        }
    }

    /**
     * This function is used to load the add new form
     */
    function addNew()
    {
            $this->load->model('user_model');
            $this->global['pageTitle'] = 'CodeInsect : Add New Client';
            $this->loadViews("users/addNew", $this->global, NULL);
    }

    /**
     * This function is used to check whether email already exist or not
     */
    function checkEmailExists()
    {
        $userId = $this->input->post("userId");
        $email = $this->input->post("email");

        if(empty($userId)){
            $result = $this->user_model->checkEmailExists($email);
        } else {
            $result = $this->user_model->checkEmailExists($email, $userId);
        }

        if(empty($result)){ echo("true"); }
        else { echo("false"); }
    }

    /**
     * This function is used to add new user to the system
     */
    function addNewUser()
    {

            $this->load->library('form_validation');
            $imageName = "";
            $this->form_validation->set_rules('fname','First Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('lname','Last Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('password','Password','required|max_length[20]');
            $this->form_validation->set_rules('cpassword','Confirm Password','trim|required|matches[password]|max_length[20]');


            if($this->form_validation->run() == FALSE)
            {
                $this->addNew();
            }
            else
            {
                $fname = ucwords(strtolower($this->security->xss_clean($this->input->post('fname'))));
                $lname = ucwords(strtolower($this->security->xss_clean($this->input->post('lname'))));
                $email = $this->security->xss_clean($this->input->post('email'));
                $password = $this->input->post('password');

                $userInfo = array(
                  'email'=>$email,
                  'password'=>getHashedPassword($password),
                  'roleId'=>'2',
                  'fname'=> $fname,
                  'lname'=> $lname
                );


                $this->load->model('user_model');
                $result = $this->user_model->addNewUser($userInfo);

                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New User created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'User creation failed');
                }

                redirect('addNew');
            }

    }

    public function uploadImage()
    {
      if(isset($_FILES['image'])){
         $errors= array();
         $file_name = $_FILES['image']['name'];
         $file_size =$_FILES['image']['size'];
         $file_tmp =$_FILES['image']['tmp_name'];
         $file_type=$_FILES['image']['type'];
         $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));

         $expensions= array("jpeg","jpg","png");

         if(in_array($file_ext,$expensions)=== false){
            $errors[]="extension not allowed, please choose a JPEG or PNG file.";
         }

         if($file_size > 2097152){
            $errors[]='File size must be excately 2 MB';
         }

         $file_name = time().$file_name;

         if(empty($errors)==true){
            move_uploaded_file($file_tmp,"assets/uploads/".$file_name);
            return $file_name;
         }else{
            print_r($errors);
         }
      }
    }


    /**
     * This function is used load user edit information
     * @param number $userId : Optional : This is user id
     */
    function editOld($userId = NULL)
    {
        if($this->isAdmin() == TRUE || $userId == 1)
        {
            $this->loadThis();
        }
        else
        {
            if($userId == null)
            {
                redirect('userListing');
            }

            $data['roles'] = $this->user_model->getUserRoles();
            $data['userInfo'] = $this->user_model->getUserInfo($userId);

            $this->global['pageTitle'] = 'CodeInsect : Edit User';

            $this->loadViews("users/editOld", $this->global, $data, NULL);
        }
    }


    /**
     * This function is used to edit the user information
     */
    function editUser()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');

            $userId = $this->input->post('userId');

            $imageName = "";
            $this->form_validation->set_rules('fname','First Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('lname','Last Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('contact_email','Contact Email','trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('password','Password','matches[cpassword]|max_length[20]');
            $this->form_validation->set_rules('cpassword','Confirm Password','matches[password]|max_length[20]');
            $this->form_validation->set_rules('role','Role','trim|required|numeric');
            $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[10]');
            $this->form_validation->set_rules('address','Address','required');

            if($this->form_validation->run() == FALSE)
            {
                $this->editOld($userId);
            }
            else
            {
                if ($_FILES['image']['name']) {
                  $imageName = $this->uploadImage();
                }
                $fname = ucwords(strtolower($this->security->xss_clean($this->input->post('fname'))));
                $lname = ucwords(strtolower($this->security->xss_clean($this->input->post('lname'))));
                $email = $this->security->xss_clean($this->input->post('email'));
                $password = $this->input->post('password');
                $roleId = $this->input->post('role');
                $mobile = $this->security->xss_clean($this->input->post('mobile'));
                $cemail = $this->security->xss_clean($this->input->post('contact_email'));
                $website= $this->security->xss_clean($this->input->post('website'));
                $address= $this->security->xss_clean($this->input->post('address'));
                $facebook_url  = $this->security->xss_clean($this->input->post('facebook_url'));
                $twitter_url   = $this->security->xss_clean($this->input->post('twitter_url'));
                $linkedin_url  = $this->security->xss_clean($this->input->post('linkedin_url'));
                $dribble_url   = $this->security->xss_clean($this->input->post('dribble_url'));
                $instagram_url = $this->security->xss_clean($this->input->post('instagram_url'));

                $userInfo = array(
                  'email'=>$email,
                  'roleId'=>$roleId,
                  'fname'=> $fname,
                  'lname'=> $lname,
                  'mobile'=>$mobile,
                  'contact_email'=>$cemail,
                  'website'=>$website,
                  'address'=>$address,
                  'facebook_url'=>$facebook_url,
                  'twitter_url'=>$twitter_url,
                  'linkedin_url'=>$linkedin_url,
                  'dribble_url'=>$dribble_url,
                  'instagram_url'=>$instagram_url,
                  'updatedBy'=>$this->vendorId,
                  'updatedDtm'=>date('Y-m-d H:i:s')
                );

                if ($imageName != "") {
                  $userInfo['profile_image'] = $imageName;
                }

                if(!empty($password))
                {
                    $userInfo['password'] = getHashedPassword($password);
                }

                $result = $this->user_model->editUser($userInfo, $userId);

                if($result == true)
                {
                    $this->session->set_flashdata('success', 'User updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'User updation failed');
                }

                redirect('userListing');
            }
        }
    }


    /**
     * This function is used to delete the user using userId
     * @return boolean $result : TRUE / FALSE
     */
    function deleteUser()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $userId = $this->input->post('userId');
            $userInfo = array('isDeleted'=>1,'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));

            $result = $this->user_model->deleteUser($userId, $userInfo);

            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }

    /**
     * This function is used to load the change password screen
     */
    function loadChangePass()
    {
        $this->global['pageTitle'] = 'CodeInsect : Change Password';

        $this->loadViews("admin/changePassword", $this->global, NULL, NULL);
    }


    /**
     * This function is used to change the password of the user
     */
    function changePassword()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('oldPassword','Old password','required|max_length[20]');
        $this->form_validation->set_rules('newPassword','New password','required|max_length[20]');
        $this->form_validation->set_rules('cNewPassword','Confirm new password','required|matches[newPassword]|max_length[20]');

        if($this->form_validation->run() == FALSE)
        {
            $this->loadChangePass();
        }
        else
        {
            $oldPassword = $this->input->post('oldPassword');
            $newPassword = $this->input->post('newPassword');

            $resultPas = $this->user_model->matchOldPassword($this->vendorId, $oldPassword);

            if(empty($resultPas))
            {
                $this->session->set_flashdata('nomatch', 'Your old password not correct');
                redirect('loadChangePass');
            }
            else
            {
                $usersData = array('password'=>getHashedPassword($newPassword), 'updatedBy'=>$this->vendorId,
                                'updatedDtm'=>date('Y-m-d H:i:s'));

                $result = $this->user_model->changePassword($this->vendorId, $usersData);

                if($result > 0) { $this->session->set_flashdata('success', 'Password updation successful'); }
                else { $this->session->set_flashdata('error', 'Password updation failed'); }

                redirect('loadChangePass');
            }
        }
    }

    /**
     * Page not found : error 404
     */
    function pageNotFound()
    {
        $this->global['pageTitle'] = 'CodeInsect : 404 - Page Not Found';

        $this->loadViews("404", $this->global, NULL, NULL);
    }

    /**
     * This function used to show login history
     * @param number $userId : This is user id
     */
    function loginHistoy($userId = NULL)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $userId = ($userId == NULL ? $this->session->userdata("userId") : $userId);

            $searchText = $this->input->post('searchText');
            $fromDate = $this->input->post('fromDate');
            $toDate = $this->input->post('toDate');

            $data["userInfo"] = $this->user_model->getUserInfoById($userId);

            $data['searchText'] = $searchText;
            $data['fromDate'] = $fromDate;
            $data['toDate'] = $toDate;

            $this->load->library('pagination');

            $count = $this->user_model->loginHistoryCount($userId, $searchText, $fromDate, $toDate);

            $returns = $this->paginationCompress ( "login-history/".$userId."/", $count, 5, 3);

            $data['userRecords'] = $this->user_model->loginHistory($userId, $searchText, $fromDate, $toDate, $returns["page"], $returns["segment"]);

            $this->global['pageTitle'] = 'CodeInsect : User Login History';

            $this->loadViews("admin/loginHistory", $this->global, $data, NULL);
        }
    }
}

?>
