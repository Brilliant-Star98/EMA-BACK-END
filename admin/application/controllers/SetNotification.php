<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class SetNotification extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('SetNotification_model');
        $this->isLoggedIn();
    }

    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        $this->global['pageTitle'] = 'Dashboard';
        $data['SetNotificationData'] = $this->SetNotification_model->getSetNotificationData();
        $this->loadViews("setnotification/list", $this->global, $data,NULL , NULL);
    }


    function Add()
    {
        if($this->isAgent() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $data['getUserData'] = $this->SetNotification_model->getUserData($this->session->userdata('userId'));
            $data['BillType'] = $this->SetNotification_model->getBillType();
            $data['NotificationType'] = $this->SetNotification_model->NotificationType();

            $this->load->library('form_validation');

            $this->form_validation->set_rules('to','Notification to','required');
            $this->form_validation->set_rules('type','Notification type','required');
            $this->form_validation->set_rules('title','title','required');
            $this->form_validation->set_rules('message','message','required');

            if($this->form_validation->run() == FALSE)
            {
                $this->loadViews("setnotification/add", $this->global, $data, NULL , NULL);
            }
            else
            {

				$to = $this->security->xss_clean($this->input->post('to'));
				$title = $this->security->xss_clean($this->input->post('title'));
				$message = $this->security->xss_clean($this->input->post('message'));
				$type = $this->security->xss_clean($this->input->post('type'));
				$userId = $this->session->userdata('userId');

        $tokens = array();
        if ($to == 'ALL') {
          $tokensArr = $this->SetNotification_model->getUserTokens();
          foreach ($tokensArr as $value) {
            $tokens[] = $value->fb_token;
          }
          if (count($tokens) == 0) {
            $this->session->set_flashdata('error', 'No users found');
            redirect('add-notification-set');
          }
        }else {
          $tokens[] = $this->SetNotification_model->getUserToken($to);
        }



        $notificationResult = $this->sendNotification($tokens, $title, $message, $type, $to, 'ADMIN', "test");
        $userInfo = array(
          'to'      => $to,
          'title'   => $title,
          'message' => $message,
          'type'    => $type,
          'status'  => '0',
          'from'    => $userId
          );

        $result = $this->SetNotification_model->addSetNotification($userInfo);

          if($result > 0)
          {
              $this->session->set_flashdata('success', 'New SetNotification created successfully');
          }
          else
          {
              $this->session->set_flashdata('error', 'SetNotification creation failed');
          }

          redirect('list-notification-set');
        }
      }
    }


	public function sendNotification($token = array(), $title = '', $body = '', $type= '', $to = '', $from = '1', $data = "")
	{
	   if(count($token) == 0){
		     return false;
	   }


	   $ApiKey = "AIzaSyDW2akTjJJUw2hTIX4rjjHrcXtv2rba8pQ";

	   $notification = array(
								'title'  		=> $title,
								'text'   		=> $body,
								'click_action' 	=> 'OPEN_NOTIFICATION_ACTIVITY',
								"sound" => "default",
								"priority" => "high",
								"show_in_foreground" => true
							);
	   $data = array(
						'message'  => $body,
						'title' => $title,
						'type' => $type,
						'data' => $data,
						'user' => $to,
					);
	   $fields = array(
		   'registration_ids' => $token,
		   'notification' => $notification,
		   "priority"=> 10,
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

	   return $result;
	}



    function Edit()
    {

      $data['getUserData'] = $this->SetNotification_model->getUserData($this->session->userdata('userId'));
      $data['BillType'] = $this->SetNotification_model->getBillType();
      $data['NotificationType'] = $this->SetNotification_model->NotificationType();
      $data['SetNotification'] = $this->SetNotification_model->SetNotification($this->input->get('id'));

        if($this->isAgent() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('to','Notification to','required');
            $this->form_validation->set_rules('type','Notification type','required');
            $this->form_validation->set_rules('title','title','required');
            $this->form_validation->set_rules('message','message','required');

            if($this->form_validation->run() == FALSE)
            {
                $this->loadViews("setnotification/edit", $this->global, $data,NULL , NULL);
            }
            else
            {

              $userInfo = array(
                'to'=>$this->security->xss_clean($this->input->post('to')),
                'title'=>$this->security->xss_clean($this->input->post('title')),
                'message'=>$this->security->xss_clean($this->input->post('message')),
                'type'=>$this->security->xss_clean($this->input->post('type')),
                'status'=>'0',
                'from'=>$this->session->userdata('userId')
                );


                $result = $this->SetNotification_model->UpdateUser($userInfo,$this->input->get('id'));

                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New SetNotification update successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'SetNotification updation failed');
                }

                redirect('list-notification-set');
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



    public function Delete()
    {
        $result = $this->SetNotification_model->deleteUser($this->input->get('id'));
       if( $result){
        echo(json_encode(array('status'=>TRUE)));
       }else{
        echo(json_encode(array('status'=>FALSE)));
       }
    }

    public function deleteDistress()
    {
        $result = $this->SetNotification_model->deleteDistress($this->input->get('id'));
       if( $result){
        echo(json_encode(array('status'=>TRUE)));
       }else{
        echo(json_encode(array('status'=>FALSE)));
       }
    }


   public function distressRequest()
   {
     $this->global['pageTitle'] = 'Dashboard';
     $data['SetNotificationData'] = $this->SetNotification_model->getDestressAlertRequests();
     $this->loadViews("distressnotification/list", $this->global, $data,NULL , NULL);
   }

   public function distressSendAll()
   {
     $notificationId = $this->input->get('id');
     $notificationData = $this->SetNotification_model->getDestressbyId($notificationId);

     if ($notificationData == FALSE) {
       $this->session->set_flashdata('error', 'Distress notification not found');
       redirect('distress-requests');
     }

     $tokensArr = $this->SetNotification_model->getUserTokens();
     $tokens = array();
     foreach ($tokensArr as $value) {
       $tokens[] = $value->fb_token;
     }
     if (count($tokens) == 0) {
       $this->session->set_flashdata('error', 'No users found');
       redirect('distress-requests');
     }
	   $ApiKey = "AIzaSyDW2akTjJJUw2hTIX4rjjHrcXtv2rba8pQ";
	   $notification = array(
      								'title'  		=> $notificationData->subject,
      								'text'   		=> $notificationData->message,
      								'click_action' 	=> 'OPEN_NOTIFICATION_ACTIVITY',
      								"sound" => "default",
      								"priority" => "high",
      								"show_in_foreground" => true
      							);
	   $data = array(
  						'message'  => $notificationData->message,
  						'title' => $notificationData->subject,
  						'type' => 'DISTRESS',
  						'payloadData' => json_encode($notificationData),
  						'user' => "ALL",
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

     $result = $this->SetNotification_model->updateDestressbyId($notificationId);
     $this->session->set_flashdata('success', 'Distress notification sent to your all users');
     redirect('distress-requests');
   }


}

?>
