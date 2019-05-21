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
class AddVisitor extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('Visitors_model');
        $this->isLoggedIn();
    }

    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        $this->global['pageTitle'] = 'Dashboard';
        $data['VisitorsData'] = $this->Visitors_model->getVisitorsData();
        $this->loadViews("visitors/list", $this->global, $data, null, null);
    }


    /**
     * This function is used to add new user to the system
     */
    public function Add()
    {
        if ($this->isGuard() == true) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('visitor_name', 'visitor name', 'required');
            $this->form_validation->set_rules('visit_to', 'visit to', 'required');
            $this->form_validation->set_rules('gender', 'gender', 'required');
            $this->form_validation->set_rules('date_in', 'Date Entry', 'required');
            $this->form_validation->set_rules('time_in', 'time in', 'required');
            $this->form_validation->set_rules('time_out', 'time out', 'required');
            $this->form_validation->set_rules('mobile', 'mobile', 'required');
            $this->form_validation->set_rules('vical_no', 'vical no', 'required');


            if ($this->form_validation->run() == false) {
				$data['usersData'] = $this->Visitors_model->getUsersData();
                $this->loadViews("visitors/add", $this->global,$data, null, null);
            } else {

				$userId = $this->input->post('visit_to');
				$userData = $this->Visitors_model->getUserDetail($userId);
                $userInfo = array(
                  'visitor_name'=>$this->security->xss_clean($this->input->post('visitor_name')),
                  'visit_to'=>$userData->fname." ".$userData->lname,
                  'user_id'=>$this->security->xss_clean($this->input->post('visit_to')),
                  'gender'=>$this->security->xss_clean($this->input->post('gender')),
                  'date_in'=>$this->security->xss_clean($this->input->post('date_in')),
                  'date_out'=>$this->security->xss_clean($this->input->post('date_out')),
                  'time_in'=>$this->security->xss_clean($this->input->post('time_in')),
                  'time_out'=>$this->security->xss_clean($this->input->post('time_out')),
                  'mobile'=>$this->security->xss_clean($this->input->post('mobile')),
                  'vical_no'=>$this->security->xss_clean($this->input->post('vical_no')),
                  'guard_id'=>$this->session->userdata('userId'),
                  );

                $result = $this->Visitors_model->addVisitors($userInfo);

                if ($result > 0) {
					$userInfo['id'] = "$result";
					$this->sendVisiterNotificationToUser($userData, $userInfo);
                    $this->session->set_flashdata('success', 'New Visitors created successfully');
                } else {
                    $this->session->set_flashdata('error', 'Visitors creation failed');
                }

                redirect('add-visitors');
            }
        }
    }

   public function sendVisiterNotificationToUser($userData, $userInfo)
   {
		 $tokens = array();
		 $tokens[] = $userData->fb_token;

	   $ApiKey = "AIzaSyDW2akTjJJUw2hTIX4rjjHrcXtv2rba8pQ";

	   $subject = "Visiter Arrival";
	   $message = "Hello ".$userData->fname."\nA visiter arrival on the gate\nName : ";
	   $message .= $userInfo['visitor_name']."\nMobile No. : ".$userInfo['mobile'];

	   $data = array(
  						'message'  => $message,
  						'title' => $subject,
  						'type' => 'VISITER',
  						'payloadData' => json_encode($userInfo),
  						'user' => $userData->userId,
  					);
	   $fields = array(
        		   'registration_ids' => $tokens,
        		   'data'    => $data
        		   );
	   $headers = array(
          		   'Authorization: key=' . $ApiKey,
          		   'Content-Type: application/json'
          		   );
	   $ch = curl_init();
	   curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
	   curl_setopt( $ch,CURLOPT_POST, true );
	   curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
	   curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
	   curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
	   curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
	   $result = curl_exec($ch );
	   curl_close( $ch );
   }



    public function Edit()
    {
        $data['Visitors'] = $this->Visitors_model->getVisitorsSingle($this->input->get('id'));

        if ($this->isGuard() == true) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('visitor_name', 'visitor name', 'required');
            $this->form_validation->set_rules('visit_to', 'visit to', 'required');
            $this->form_validation->set_rules('gender', 'gender', 'required');
            $this->form_validation->set_rules('date_in', 'Date Entry', 'required');
            $this->form_validation->set_rules('time_in', 'time in', 'required');
            $this->form_validation->set_rules('time_out', 'time out', 'required');
            $this->form_validation->set_rules('mobile', 'mobile', 'required');
            $this->form_validation->set_rules('vical_no', 'vical no', 'required');

            if ($this->form_validation->run() == false) {
                $this->loadViews("visitors/edit", $this->global, $data, null, null);
            } else {


                $userInfo = array(
                 'visitor_name'=>$this->security->xss_clean($this->input->post('visitor_name')),
                  'visit_to'=>$this->security->xss_clean($this->input->post('visit_to')),
                  'gender'=>$this->security->xss_clean($this->input->post('gender')),
                  'date_in'=>$this->security->xss_clean($this->input->post('date_in')),
                  'date_out'=>$this->security->xss_clean($this->input->post('date_out')),
                  'time_in'=>$this->security->xss_clean($this->input->post('time_in')),
                  'time_out'=>$this->security->xss_clean($this->input->post('time_out')),
                  'mobile'=>$this->security->xss_clean($this->input->post('mobile')),
                  'vical_no'=>$this->security->xss_clean($this->input->post('vical_no')),
                  'guard_id'=>$this->session->userdata('userId'),
                  );


                $result = $this->Visitors_model->UpdateUser($userInfo, $this->input->get('id'));

                if ($result > 0) {
                    $this->session->set_flashdata('success', 'New Visitors update successfully');
                } else {
                    $this->session->set_flashdata('error', 'Visitors updation failed');
                }

                redirect('list-visitors');
            }
        }
    }






	 public function visitorFilter()
    {

                $userInfo = array(
                  'date'=>$this->security->xss_clean($this->input->post('dateRange')),
                  'time_in'=>$this->security->xss_clean($this->input->post('startTime')),
                  'time_out'=>$this->security->xss_clean($this->input->post('endTime')),
                  'vical_no'=>$this->security->xss_clean($this->input->post('vicalNo')),
                  );

				  print_r($userInfo); die();

                $result = $this->Visitors_model->addVisitors($userInfo);

                if ($result > 0) {
                    $this->session->set_flashdata('success', 'New Visitors created successfully');
                } else {
                    $this->session->set_flashdata('error', 'Visitors creation failed');
                }

                redirect('add-visitors');


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
        $result = $this->Visitors_model->deleteUser($this->input->get('id'));
        if ($result) {
            echo(json_encode(array('status'=>true)));
        } else {
            echo(json_encode(array('status'=>false)));
        }
    }
}
