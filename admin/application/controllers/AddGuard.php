<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class AddGuard extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('AddGuard_model');
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
        $data['AddGuardData'] = $this->AddGuard_model->getAddGuardData($id);
        $this->loadViews("guard/list", $this->global, $data, null, null);
    }

    /**
     * This function is used to add new user to the system
     */
    public function Add()
    {
        if ($this->isAgent() == true) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');
            $imageName = "";
            $this->form_validation->set_rules('fname', 'First Name', 'trim|required|max_length[128]');
            $this->form_validation->set_rules('lname', 'Last Name', 'trim|required|max_length[128]');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[128]|is_unique[tbl_users.email]');
            // $this->form_validation->set_rules('contact_email','Contact Email','trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('password', 'Password', 'required|max_length[20]');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]|max_length[20]');
            $this->form_validation->set_rules('mobile', 'Mobile Number', 'required|min_length[10]|is_unique[tbl_users.mobile]');
            $this->form_validation->set_rules('address', 'Address', 'required');

            if ($this->form_validation->run() == false) {
                $this->loadViews("guard/add", $this->global, null, null);
            } else {
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
                  'roleId'=>'4',
                  'fname'=> $fname,
                  'lname'=> $lname,
                  'mobile'=>$mobile,
                  'country_code'=>$this->input->post('country_code'),
                  'short_code'=>$this->input->post('short_code'),
                  'country'=>$this->security->xss_clean($this->input->post('country')),
                  'alt_mobile'=>$this->security->xss_clean($this->input->post('alt_mobile')),
                  'contact_email'=>$this->security->xss_clean($this->input->post('contact_email')),
                  'latitude'=>$this->security->xss_clean($this->input->post('latitude')),
                  'longitude'=>$this->security->xss_clean($this->input->post('longitude')),
                  'content'=>$this->security->xss_clean($this->input->post('content')),
                  'full_address'=>$address,
                  'agent_id'=>$this->session->userdata('userId'),
                  'status'=>'1'
                     );

                if ($imageName != "") {
                    $userInfo['profile_picture'] = $imageName;
                }

                $result = $this->AddGuard_model->addNewUser($userInfo);

                if ($result > 0) {
                    $data['userDetails'] = array('username'=>$this->input->post('email'),'password'=>$this->input->post('password'),'insertedid'=>'00');
                    $mesg = $this->load->view('mail/agent_email_template', $data, true);

                    $configs = array(
                  'charset'=>'utf-8',
                  'wordwrap'=> true,
                  'mailtype' => 'html'
                  );

                    $from_email = "info@ema.com";
                    $to_email = $this->input->post('email');
                    $this->email->initialize($configs);
                    $this->email->from($from_email, 'EMA Guard');
                    $this->email->to($to_email);
                    $this->email->subject('EMA Registration');
                    $this->email->message($mesg);

                    if ($this->email->send()) {
                        $this->session->set_flashdata('success', 'New Guard created successfully');
                    }
                } else {
                    $this->session->set_flashdata('error', 'AddGuard creation failed');
                }

                redirect('add-guard');
            }
        }
    }





    public function Edit()
    {
        $data['AddGuard'] = $this->AddGuard_model->getAddGuardSingle($this->input->get('id'));

        if ($this->isAgent() == true) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');
            $imageName = "";
            $this->form_validation->set_rules('fname', 'First Name', 'trim|required|max_length[128]');
            $this->form_validation->set_rules('lname', 'Last Name', 'trim|required|max_length[128]');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('mobile', 'Mobile Number', 'required|min_length[10]');
            $this->form_validation->set_rules('address', 'Address', 'required');

            if ($this->form_validation->run() == false) {
                $this->loadViews("guard/edit", $this->global, $data, null, null);
            } else {
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
                  'roleId'=>'4',
                  'fname'=> $fname,
                  'lname'=> $lname,
                  'mobile'=>$mobile,
                  'country_code'=>$this->input->post('country_code'),
                  'short_code'=>$this->input->post('short_code'),
                  'country'=>$this->security->xss_clean($this->input->post('country')),
                  'alt_mobile'=>$this->security->xss_clean($this->input->post('alt_mobile')),
                  'contact_email'=>$this->security->xss_clean($this->input->post('contact_email')),
                  'latitude'=>$this->security->xss_clean($this->input->post('latitude')),
                  'longitude'=>$this->security->xss_clean($this->input->post('longitude')),
                  'content'=>$this->security->xss_clean($this->input->post('content')),
                  'full_address'=>$address,
                  'agent_id'=>$this->session->userdata('userId'),
                  'status'=>'1'
                     );

                if ($imageName != "") {
                    $userInfo['profile_picture'] = $imageName;
                }

                $result = $this->AddGuard_model->UpdateUser($userInfo, $this->input->get('id'));

                if ($result > 0) {
                    $this->session->set_flashdata('success', 'New AddGuard update successfully');
                } else {
                    $this->session->set_flashdata('error', 'AddGuard updation failed');
                }

                redirect('edit-guard?id='.$this->input->get('id'));
            }
        }
    }













    public function uploadImage()
    {
        if (isset($_FILES['image'])) {
            $errors= array();
            $file_name = $_FILES['image']['name'];
            $file_size =$_FILES['image']['size'];
            $file_tmp =$_FILES['image']['tmp_name'];
            $file_type=$_FILES['image']['type'];
            $imgfile = explode('.', $file_name);
            $file_ext=strtolower(end($imgfile));

            $expensions= array("jpeg","jpg","png","JPG","JPEG","PNG");

            if (in_array($file_ext, $expensions)=== false) {
                $errors[]="extension not allowed, please choose a JPEG or PNG file.";
            }

            if ($file_size > 2097152) {
                $errors[]='File size must be excately 2 MB';
            }

            $file_name = time().$file_name;

            if (empty($errors)==true) {
                move_uploaded_file($file_tmp, "assets/uploads/".$file_name);
                return $file_name;
            } else {
                return '';
            }
        }
        return '';
    }



    public function Delete()
    {
        $result = $this->AddGuard_model->deleteUser($this->input->get('id'));
        if ($result) {
            echo(json_encode(array('status'=>true)));
        } else {
            echo(json_encode(array('status'=>false)));
        }
    }
}
