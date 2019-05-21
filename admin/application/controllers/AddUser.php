<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class AddUser extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('AddUser_model');
        $this->load->library('email');
        $this->isLoggedIn();
    }

    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        $this->global['pageTitle'] = 'Dashboard';
        $id = $this->session->userdata('userId');
        $data['AddUserData'] = $this->AddUser_model->getAddUserData($id);
        $this->loadViews("user/list", $this->global, $data,NULL , NULL);
    }

    public function test()
    {
        $this->global['pageTitle'] = 'Dashboard';
        $data['AddUserData'] = $this->AddUser_model->getAddUserData();
        $this->loadViews("user/listajax", $this->global, $data,NULL , NULL);
    }

    /**
     * This function is used to add new user to the system
     */
    function Add()
    {

        if($this->isAgent() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            $imageName = "";
            $this->form_validation->set_rules('fname','First Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('lname','Last Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]|is_unique[tbl_users.email]');
           // $this->form_validation->set_rules('contact_email','Contact Email','trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('password','Password','required|max_length[20]');
            $this->form_validation->set_rules('confirm_password','Confirm Password','trim|required|matches[password]|max_length[20]');
            $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[5]|is_unique[tbl_users.mobile]');
            $this->form_validation->set_rules('address','Address','required');

            if($this->form_validation->run() == FALSE)
            {
              $data['BillType'] = $this->AddUser_model->BillType();
                $this->loadViews("user/add", $this->global, $data,NULL , NULL);
            }
            else
            {



              $biltyp =  implode(',',$this->input->post('billtype'));
              $count = count($this->input->post('name'));
              $t_name     = $this->input->post('name');
              $t_pcontact = $this->input->post('pcontact');
              $t_scontact = $this->input->post('scontact');
              $t_gender   = $this->input->post('gender');

              $f_array = array();

              for ($i=0; $i < $count; $i++) {
                $temparray = array('name'=>$t_name[$i], 'gender'=>$t_gender[$i], 'pcontact'=>$t_pcontact[$i], 'scontact'=>$t_scontact[$i]);
                $f_array[] = $temparray;
              }

              $residents =  json_encode($f_array);


                if ($_FILES['image']['name']) {
                  $imageName = $this->uploadImage();
                }

                $fname = ucwords(strtolower($this->security->xss_clean($this->input->post('fname'))));
                $lname = ucwords(strtolower($this->security->xss_clean($this->input->post('lname'))));
                $email = $this->security->xss_clean($this->input->post('email'));
                $password = $this->input->post('password');
                $mobile = $this->security->xss_clean($this->input->post('mobile'));
                $website= $this->security->xss_clean($this->input->post('website'));
                $address= $this->security->xss_clean($this->input->post('address'));

                $userInfo = array(
                  'email'=>$email,
                  'password'=>getHashedPassword($password),
                  'roleId'=>'3',
                  'fname'=> $fname,
                  'lname'=> $lname,
                  'mobile'=>$mobile,
                  'country_code'=>$this->input->post('country_code'),
                  'short_code'=>$this->input->post('short_code'),
                  'country'=>$this->security->xss_clean($this->input->post('country')),
                  'house_number'=>$this->security->xss_clean($this->input->post('house_number')),
                  'street'=>$this->security->xss_clean($this->input->post('street')),
                  'court'=>$this->security->xss_clean($this->input->post('court')),
                  'contact_email'=>$this->security->xss_clean($this->input->post('contact_email')),
                  'latitude'=>$this->security->xss_clean($this->input->post('latitude')),
                  'longitude'=>$this->security->xss_clean($this->input->post('longitude')),
                  'content'=>$this->security->xss_clean($this->input->post('content')),
                  'full_address'=>$address,
                  'residents'=>$residents,
                  'billtype'=>$biltyp,
                  'agent_id'=>$this->session->userdata('userId'),
                  'status'=>'1'
                     );

                if ($imageName != "") {
                  $userInfo['profile_picture'] = $imageName;
                }

                $result = $this->AddUser_model->addNewUser($userInfo);

                if($result > 0)
                {
                  $data['userDetails'] = array('username'=>$this->input->post('email'),'password'=>$this->input->post('password'),'insertedid'=>'00');
                  $mesg = $this->load->view('mail/agent_email_template',$data,true);

                  $configs = array(
                  'charset'=>'utf-8',
                  'wordwrap'=> TRUE,
                  'mailtype' => 'html'
                  );

                   $from_email = "info@ema.com";
                   $to_email = $this->input->post('email');
                   $this->email->initialize($configs);
                   $this->email->from($from_email, 'EMA User');
                   $this->email->to($to_email);
                   $this->email->subject('EMA Registration');
                   $this->email->message($mesg);

                   if($this->email->send()) {
                    $this->session->set_flashdata('success', 'New User created successfully');
                  }
                }
                else
                {
                    $this->session->set_flashdata('error', 'AddUser creation failed');
                }

                redirect('add-user');
            }
        }
    }





    function Edit()
    {

        $data['AddUser'] = $this->AddUser_model->getAddUserSingle($this->input->get('id'));
        $data['BillType'] = $this->AddUser_model->BillType();

        $data['getBillType'] = $this->AddUser_model->getBillType($this->input->get('id'));

        if($this->isAgent() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            $imageName = "";
            $this->form_validation->set_rules('fname','First Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('lname','Last Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]');
           // $this->form_validation->set_rules('contact_email','Contact Email','trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[5]');
            $this->form_validation->set_rules('address','Address','required');

            if($this->form_validation->run() == FALSE)
            {
                $this->loadViews("user/edit", $this->global, $data,NULL , NULL);
            }
            else
            {



                $biltyp =  implode(',',$this->input->post('billtype'));
                $count = count($this->input->post('name'));
                $t_name = $this->input->post('name');
                $t_pcontact = $this->input->post('pcontact');
                $t_scontact = $this->input->post('scontact');
                $t_gender = $this->input->post('gender');

                $f_array = array();

                for ($i=0; $i < $count; $i++) {
                $temparray = array('name'=>$t_name[$i], 'gender'=>$t_gender[$i], 'pcontact'=>$t_pcontact[$i], 'scontact'=>$t_scontact[$i]);
                  $f_array[] = $temparray;
                }

                $residents =  json_encode($f_array);


                if ($_FILES['image']['name']) {
                  $imageName = $this->uploadImage();
                }

                $fname = ucwords(strtolower($this->security->xss_clean($this->input->post('fname'))));
                $lname = ucwords(strtolower($this->security->xss_clean($this->input->post('lname'))));
                $email = $this->security->xss_clean($this->input->post('email'));
                $password = $this->input->post('password');
                $mobile = $this->security->xss_clean($this->input->post('mobile'));
                $website= $this->security->xss_clean($this->input->post('website'));
                $address= $this->security->xss_clean($this->input->post('address'));

                $userInfo = array(
                  'email'=>$email,
                  'roleId'=>'3',
                  'fname'=> $fname,
                  'lname'=> $lname,
                  'mobile'=>$mobile,
                  'country_code'=>$this->input->post('country_code'),
                  'short_code'=>$this->input->post('short_code'),
                  'country'=>$this->security->xss_clean($this->input->post('country')),
                  'house_number'=>$this->security->xss_clean($this->input->post('house_number')),
                  'street'=>$this->security->xss_clean($this->input->post('street')),
                  'court'=>$this->security->xss_clean($this->input->post('court')),
                  'contact_email'=>$this->security->xss_clean($this->input->post('contact_email')),
                  'latitude'=>$this->security->xss_clean($this->input->post('latitude')),
                  'longitude'=>$this->security->xss_clean($this->input->post('longitude')),
                  'full_address'=>$address,
                  'residents'=>$residents,
                  'billtype'=>$biltyp,
                  'agent_id'=>$this->session->userdata('userId'),
                  'status'=>'1'
                     );

                if ($password != "") {
                  $userInfo['password'] = getHashedPassword($password);
                }
                if ($imageName != "") {
                  $userInfo['profile_picture'] = $imageName;
                }

                $result = $this->AddUser_model->UpdateUser($userInfo,$this->input->get('id'));

                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New AddUser update successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'AddUser updation failed');
                }

                redirect('edit-user?id='.$this->input->get('id'));
            }
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
         $imgfile = explode('.',$file_name);
         $file_ext=strtolower(end($imgfile));

         $expensions= array("jpeg","jpg","png","JPG","JPEG","PNG");

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
          return '';
         }
      }
      return '';
    }



    public function Delete(){

         $result = $this->AddUser_model->deleteUser($this->input->get('id'));
           if( $result){
            echo(json_encode(array('status'=>TRUE)));
           }else{
            echo(json_encode(array('status'=>FALSE)));
           }

         }





}

?>
