<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Api_Model');
    }

    public function verifyAgentCode($agentCode = '')
    {
      $result = $this->Api_Model->verifyAgentCode($agentCode);
      if ($result != false) {
        $this->response(true, "Success", $result);
      }else {
        $this->response(false, "Please enter a valide agent code.");
      }
    }

    public function verify($lang='', $country='', $mobile='')
     {
       $result = $this->Api_Model->verifyUser($country, $mobile);
       if ($result) {
         $this->response(true, "Mobile number not existing.");
       }else {
         $this->response(false, "Mobile number alredy existing.");
       }
     }

     public function registerUser()
     {
       $country      = $this->input->post('country');
       $country_code = $this->input->post('country_code');
       $short_code   = $this->input->post('short_code');
       $phone        = $this->input->post('phone');
       $fname        = $this->input->post('fname');
       $lname        = $this->input->post('lname');
       $email        = $this->input->post('email');
       $password     = $this->input->post('password');
       $agent_code   = $this->input->post('agent_code');
       $latitude     = $this->input->post('latitude');
       $longitude    = $this->input->post('longitude');

         if ($this->Api_Model->verifyUser($country_code, $phone)) {
           $data = array(
             'country'      => $country,
             'country_code' => $country_code,
             'short_code'   => $short_code,
             'mobile'       => $phone,
             'fname'        => $fname,
             'lname'        => $lname,
             'email'        => $email,
             'password'     => getHashedPassword($password),
             'agent_id'     => $agent_code,
             'latitude'     => $latitude,
             'longitude'     => $longitude,
             'roleId'       => 3,
             'status'       => 0,
            );
           $result = $this->Api_Model->registerUser($data);
           if ($result != false) {
             $this->response(true, "Registration successfull\nOnce agent will approve your account then you can login");
           }else {
             $this->response(false, "Registration failed");
           }
         }else {
           $this->response(false, "Mobile number already existing.");
         }
     }
     //2019.3.18 coded by Feng
     public function updateUserInfo()
     {
         $user_id       = $this->input->post('user_id');
         $country       = $this->input->post('country_name');
         $country_code  = $this->input->post('ph_code');
         $fname         = $this->input->post('fname');
         $lname         = $this->input->post('lname');
         $email         = $this->input->post('email');
         $phone         = $this->input->post('phone');
         $street        = $this->input->post('street');
         $court         = $this->input->post('court');
         $plate_info    = $this->input->post('plate_info');

         $data = array(
             'country'      => $country,
             'country_code' => $country_code,
             'mobile'       => $phone,
             'fname'        => $fname,
             'lname'        => $lname,
             'email'        => $email,
             'street'       => $street,
             'court'        => $court,
             'plate_info'   => $plate_info,
         );

         if(strlen($plate_info) == 0)
             $this->response(true, "Updating Profile Successful");
         else{
             if ($this->Api_Model->carVisible($plate_info, $user_id) == 1){
                 $this->response(false, "Existing Car");
             }
             else{
                 $uid = intval($user_id);
                 $this->registerUserCar($uid, $plate_info);
                 $this->response(true, "Updating Profile Successful");
             }
         }
     }
     //2019.3.15 coded by Feng
     public function registerUserCar($userId, $plate_number)
     {
         $data = array(
             'car_plate' => $plate_number,
             'userId'      => $userId,
             'car_status'   => 0,
         );

         $this->Api_Model->registerCarForUser($data);

     }
     //coded by Feng
     public function updateCarStatus()
     {
        $plate_number = $this->input->post('plate_number');
        $status = $this->input->post('car_status');
        $ctime = strtotime($this->input->post('time'));
        $result = $this->Api_Model->getCarStatus($plate_number);

        if ($result == null) {
            $this->response(false, "This car can't be recognized");
        }
        else{
            $userData = $this->Api_Model->getUserDetail($result[0]->userId);
            $data = array(
                'vehicle_number' => $plate_number,
                'vehicle_status' => $status,
            );
            $not_array = $this->Api_Model->getVehicleNotificationStatus($result[0]->userId);
            $time_from = strtotime($not_array[0]->car_notification_from);
            $time_to = strtotime($not_array[0]->car_notification_to);
            if ($status == 1){  //car is going to exit now
                $this->Api_Model->updateCarStatus($plate_number, 2);
                if ($not_array != null && $not_array[0]->status == 1 && $ctime >= $time_from && $ctime <= $time_to)
                    $this->sendVehicleNotificationToUser($userData, $data);
                $this->response(true, "This car is recognized");
            }
            else if ($status == 2){  //car is going to enter now
                $this->Api_Model->updateCarStatus($plate_number, 1);
                if ($not_array != null && $not_array[0]->status == 1 && $ctime >= $time_from && $ctime <= $time_to)
                    $this->sendVehicleNotificationToUser($userData, $data);
                $this->response(true, "This car is recognized");
            }
        }
     }
     //coded by Feng
     public function getCarListForUser($userId = '')
     {
         $data = $this->Api_Model->getCarListForUser(intval($userId));
         $this->response(true, "Success", $data);
     }
     //coded by Feng
     public function getCarHistory()
     {
         $car_plate = $this->input->post('car_plate');
         $date_from = $this->input->post('date_from');
         $date_to   = $this->input->post('date_to');
         $data = $this->Api_Model->getCarHistory($car_plate, $date_from, $date_to);
         $this->response(true, "Success", $data);
     }
     //coded by Feng
    public function reserveVisitor()
    {
        $data = array(
            'visitor_name' => $this->input->post('visitor_name'),
            'userId' => $this->input->post('user_id'),
            'mobile'     => $this->input->post('mobile'),
            'gender'     => $this->input->post('gender'),
            'date_in'    => $this->input->post('date_in'),
            'time_in'    => $this->input->post('time_in'),
            'date_out'   => $this->input->post('date_out'),
            'time_out'   => $this->input->post('time_out'),
            'vical_no' => $this->input->post('vical_no'),
            'num_person' => $this->input->post('person'),
            'status'     => '0',
            'ext_times'  => '0',
            'guard_id'   => $this->input->post('guard_id'),
        );
        $result = $this->Api_Model->reserveVisitor($data);
        if ($result != -1)
            $this->response(true, "Visitor reserved successfully", $result);
        else
            $this->response(false, "Visitor Reservation failed");
    }
    //coded by Feng
    public function updateReserveVisitor()
    {
        $userId = $this->input->post('user_id');
        $visitorId = $this->input->post('visitor_id');
        $status = $this->input->post('status');
        //$userData = $this->Api_Model->getUserDetail($userId);
        $data = array(
            'visitor_name'=> $this->input->post('visitor_name'),
            'userId'     => $this->input->post('user_id'),
            'date_in'     => $this->input->post('date_in'),
            'time_in'     => $this->input->post('time_in'),
            'date_out'    => $this->input->post('date_out'),
            'time_out'    => $this->input->post('time_out'),
            'gender'      => $this->input->post('gender'),
            'mobile'      => $this->input->post('mobile'),
            'vical_no'    => $this->input->post('vical_no'),
            'num_person'  => $this->input->post('person'),
            'status'      => $status,
            'ext_times'   => $this->input->post('ext_times'),
            'guard_id'    => $this->input->post('guard_id'),
        );

        $result = $this->Api_Model->updateReserveVisitor($visitorId, $data);
        if ($result) {
            //$res = $this->Api_Model->getVisiterDetail($visitorId);
            $this->response(true, "Visitor Updated Successfully");
        }else {
            $this->response(false, "Visitor Updating Failed");
        }
    }
    //coded by Feng
    public function cancelReservation($visitorId = '')
    {
        $result = $this->Api_Model->cancelReservation($visitorId);
        if ($result) {
            $this->response(true, "Reservation Cancelled Successfully");
        }else{
            $this->response(false, "Reservation Cancelling Failed");
        }
    }
    //coded by Feng
    public function contactGuardForReservation()
    {
        $userId         = $this->input->post('user_id');
        $agent_id       = $this->input->post('agent_id');
        $guard_id       = $this->input->post('guard_id');
        $visitor_name   = $this->input->post('visitor_name');
        $visitor_id     = $this->input->post('visitor_id');
        $reason         = $this->input->post('reason');

        $userData       = $this->Api_Model->getUserDetail($guard_id);
        $data = array(
            'user_id'      => $userId,
            'visitor_name' => $visitor_name,
            'visitor_id'   => $visitor_id,
            'reason'       => $reason,
        );
        $this->sendNotificationToGuard($userData, $data);
        $this->response(true, "Extension Request Sent Successfully");

    }
    //coded by Feng
    public function getAllReservedVisitors($userId = '', $date = '')
    {
        $data = $this->Api_Model->getAllReservedVisitors($userId, $date);
        if (count($data) > 0)
            $this->response(true, "List Reserved Visitors", $data);
        else
            $this->response(false, "No Reserved Visitors found");
    }
    //coded by Feng
    public function isReservedVisitorLive($visitorId)
    {
        $result = $this->Api_Model->isReservedVisitor($visitorId);
        if ($result)
            $this->response(true, "This visitor is reserved");
        else
            $this->response(false, "This visitor isn't reserved");
    }
    //coded by Feng
    public function updateNotificationStatus()
    {
        $userId = $this->input->post('userId');
        $data = array(
            'userid' => $userId,
            'car_notification_from' => $this->input->post('car_notification_from'),
            'car_notification_to' => $this->input->post('car_notification_to'),
            'status' => $this->input->post('status'),
        );

        $result = $this->Api_Model->updateVehicleNotificationStatus($userId, $data);
        if ($result)
            $this->response(true, "Vehicle Notification is upgraded");
        else
            $this->response(false, "Updating Vehicle Notification is failed");
    }
    //coded by Feng
    public function getNotificationStatus($userId){
        $data = $this->Api_Model->getVehicleNotificationStatus($userId);
        if (count($data) > 0)
            $this->response(true, "Notification Status loaded successfully", $data);
        else
            $this->response(false, "Notification Status couldn't load");
    }

     public function loginUser()
     {
       $country      = $this->input->post('country');
       $country_code = $this->input->post('country_code');
       $mobile        = $this->input->post('phone');
       $password     = $this->input->post('password');
       $fb_token     = $this->input->post('fb_token');

       $result = $this->Api_Model->userLogin($mobile, $password, $country_code);
       if ($result != false) {
		   if($result[0]->status == '1'){
				$userId = $result[0]->userId;
				$this->Api_Model->updateProfile($userId, array('fb_token' => $fb_token));
				$this->response(true, "Login successfull", $result);
		   }else if($result[0]->status == '2'){
			   $this->response(false, "Your account is suspended by Agent\nContact to your agent.");
		   }else{
			   $this->response(false, "Your account is not approved by Agent\nOnce agent will approve your account then you can login.");
		   }
       }else {
         $this->response(false, "Incorrect mobile number or password.");
       }
     }


     public function loginAgent()
     {
       $email        = $this->input->post('email');
       $password     = $this->input->post('password');
       $fb_token     = $this->input->post('fb_token');

       $result = $this->Api_Model->userAgentLogin($email, $password);
       if ($result != false) {
		   if($result[0]->status == '1'){
				$userId = $result[0]->userId;
				$this->Api_Model->updateProfile($userId, array('fb_token' => $fb_token));
				$this->response(true, "Login successfull", $result);
		   }else if($result[0]->status == '2'){
			   $this->response(false, "Your account is suspended by Admin\nContact to your Admin.");
		   }else{
			   $this->response(false, "Your account is not approved by Admin\nOnce Admin will approve your account then you can login.");
		   }
       }else {
         $this->response(false, "Incorrect email or password.");
       }
     }


     public function loginGuard()
     {
       $email        = $this->input->post('email');
       $password     = $this->input->post('password');
       $fb_token     = $this->input->post('fb_token');

       $result = $this->Api_Model->userGuardLogin($email, $password);
       if ($result != false) {
		   if($result[0]->status == '1'){
				$userId = $result[0]->userId;
				$this->Api_Model->updateProfile($userId, array('fb_token' => $fb_token));
				$this->response(true, "Login successfull", $result);
		   }else if($result[0]->status == '2'){
			   $this->response(false, "Your account is suspended by Admin\nContact to your Admin.");
		   }else{
			   $this->response(false, "Your account is not approved by Admin\nOnce Admin will approve your account then you can login.");
		   }
       }else {
         $this->response(false, "Incorrect email or password.");
       }
     }



     public function getUserData($mobile='', $password = '')
     {
       $data = $this->Api_Model->getUserData($mobile, $password);
       $this->response(true, "Success", $data);
     }


     public function updateProfile()
     {
        $imageName = "";
        $userId = $this->input->post('user_id');
        $plate_info = $this->input->post('plate_info');
        $imageName = $this->uploadImage();

        $data = array(
          'fname'     => $this->input->post('fname'),
          'lname'     => $this->input->post('lname'),
          'email'     => $this->input->post('email'),
          'full_address'   => $this->input->post('full_address'),
          'court'  => $this->input->post('court'),
          'street'  => $this->input->post('street'),
          'residents'  => $this->input->post('residents')
        );

        if ($imageName != '') {
           $data['profile_picture'] = $imageName;
        }

        if(strlen($plate_info) != 0) {
            if ($this->Api_Model->carVisible($plate_info, $userId) == 1){
                $this->response(false, "Existing Car");
            }
            else{
                $uid = intval($userId);
                $this->registerUserCar($uid, $plate_info);
                //$this->response(true, "Updating Profile Successful");
                $result = $this->Api_Model->updateProfile($userId, $data);
                if ($result) {
                    $userdata = $this->Api_Model->getUserDataById($userId);
                    $this->response(true, "Profile update successfully", $userdata);
                }else {
                    $this->response(false, "Profile not updated failed");
                }

            }
        }
        else {
            $result = $this->Api_Model->updateProfile($userId, $data);
            if ($result) {
                $userdata = $this->Api_Model->getUserDataById($userId);
                $this->response(true, "Profile update successfully", $userdata);
            }else {
                $this->response(false, "Profile not updated failed");
            }
        }
     }

     public function SingleProfile($id='')
     {
       $result =  $this->Api_Model->SingleProfile($id);
       if ($result) {
         $this->response(true, "Profile details.",$result);
       }else {
         $this->response(false, "There are no Profile.");
       }
     }


     public function response($status=false, $message = 'Failed',  $data = array())
       {
         if ($status) {
           echo json_encode( array('status' => 1, 'message' => $message, 'data' => $data) );
         }else {
           echo json_encode( array('status' => 0, 'message' => $message, 'data' => $data) );
         }
         die();
       }


       public function uploadImage()
         {
           if(isset($_FILES['image'])){
              $errors= array();
              $file_name = $_FILES['image']['name'];
              $file_size =$_FILES['image']['size'];
              $file_tmp =$_FILES['image']['tmp_name'];
              $file_type=$_FILES['image']['type'];
              $tempVar = explode('.',$file_name);
              $file_ext=strtolower(end($tempVar));

              $expensions= array("jpeg","jpg","png");

              if(in_array($file_ext,$expensions)=== false){
                 $errors[]="extension not allowed, please choose a JPEG or PNG file.";
              }

              if($file_size > 9097152){
                 $errors[]='File size must be excately 2 MB';
              }

              $file_name = time().$file_name;

              if(empty($errors)==true){
                 move_uploaded_file($file_tmp,"assets/uploads/".$file_name);
                 return $file_name;
              }else{
                return "";
              }
           }else{
             return '';
           }

         }

       public function uploadProductsImage()
      {
           if(isset($_FILES['product_image'])){
              $errors= array();
              $file_name = $_FILES['product_image']['name'];
              $file_size =$_FILES['product_image']['size'];
              $file_tmp =$_FILES['product_image']['tmp_name'];
              $file_type=$_FILES['product_image']['type'];
              $tempVar = explode('.',$file_name);
              $file_ext=strtolower(end($tempVar));

              $expensions= array("jpeg","jpg","png");

              if(in_array($file_ext,$expensions)=== false){
                 $errors[]="extension not allowed, please choose a JPEG or PNG file.";
              }

              if($file_size > 2097152){
                 $errors[]='File size must be exactly 2 MB';
              }

              $file_name = time().$file_name;

              if(empty($errors)==true){
                 move_uploaded_file($file_tmp,"assets/uploads/".$file_name);
                 return $file_name;
              }else{
                return "";
              }
           }else{
             return '';
           }

         }


         public function uploadSimpleImage($pram)
        {
                $errors= array();
                $file_name = $pram['name'];
                $file_size =$pram['size'];
                $file_tmp =$pram['tmp_name'];
                $file_type=$pram['type'];
                $tempVar = explode('.',$file_name);
                $file_ext=strtolower(end($tempVar));

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
                  return "";
                }

           }


// ==========================HRK======================================

function currentBills($pram = '')
{

  $result =  $this->Api_Model->currentBills($pram);
  if ($result) {
     $this->response(true, "Bill details.",$result);
  }else {
    $this->response(false, "Data not found");
  }

}

function SingleBill($pram = '')
{

  $result =  $this->Api_Model->SingleBill($pram);
  if ($result) {
     $this->response(true, "Bill details.",$result);
  }else {
    $this->response(false, "Data not found");
  }

}

function previousBills($pram = '')
{

  $result =  $this->Api_Model->previousBills($pram);
  if ($result) {
     $this->response(true, "Bill details.",$result);
  }else {
    $this->response(false, "Data not found");
  }

}



function notificationList($pram = '')
{

  $result =  $this->Api_Model->notificationList($pram);
  if ($result) {
     $this->response(true, "Bill details.",$result);
  }else {
    $this->response(false, "Data not found");
  }

}



function paymentHistory($pram = '')
{
  $result =  $this->Api_Model->paymentHistory($pram);
  if ($result) {
     $this->response(true, "Payment History.",$result);
  }else {
    $this->response(false, "Data not found");
  }
}


function paymentDetails($pram = '')
{

  $result =  $this->Api_Model->paymentDetails($pram);
  if ($result) {
     $this->response(true, "Payment details.",$result);
  }else {
    $this->response(false, "Data not found");
  }

}


public function addTransaction()
{
	$user_id = $this->input->post('user_id');
	$bill_id = $this->input->post('bill_id');
	$amount  = $this->input->post('amount');
	$merchant_id = $this->input->post('merchant_id');
	$transaction_id = $this->input->post('transaction_id');
      $paymentData = array(
        'user_id'      => $user_id,
        'bill_id'      => $bill_id,
        'amount'       => $amount,
        'merchant_id'  => $merchant_id,
        'transaction_id'   => $transaction_id,
        'paytment_method' => 'MPESA',
        'status' => 1,
        'transaction_date' => date('Y-m-d'),
       );
      $result = $this->Api_Model->addTransaction($paymentData);
      if ($result != false) {
		  $paymentData['id'] = $result;
        $UPDATE = $this->Api_Model->updateBillStatus($bill_id, $result);
		$token  = $this->Api_Model->getUserToken($user_id);
		$to     = $user_id;
		$title  = "Transaction Successfull";
		$body   = "You have successfully paid your bill of amount: $amount\nTransaction Id: $transaction_id";
		$type   = "SYSTEM";
		$from   = "ADMIN";
		$this->sendNotification($token, $title, $body, $type, $to, $from , "");

		$this->sendTransactionEmail($result, $bill_id, $user_id);

        $this->response(true, "Transaction Success");
      }else {
        $this->response(false, "Transaction failed");
      }

}

	function sendTransactionEmail($txnId , $billId, $userId){
		$data['billDetails'] =  $this->Api_Model->billDetails($billId);
		$userData            =  $this->Api_Model->getSingleUserData($userId);
		$data['userData']    =  $userData;
		$data['paymentData'] =  $this->Api_Model->paymentData($txnId);
    $data['logo_url']    =  base_url()."uploads/logo.png";

		$mesg     = $this->load->view('mail/invoice_email_template',$data,true);
		$subject  = "EMA Invoice : $".$data['paymentData']->amount;
		$to_email = $userData->email;
		$to_email = 'aashutoshyadav19@gmail.com';

		$this->sendEmail($to_email, $subject, $mesg);
	}


	function downloadInvoice($txnId , $billId, $userId){
		$data['billDetails'] =  $this->Api_Model->billDetails($billId);
		$userData            =  $this->Api_Model->getSingleUserData($userId);
		$data['userData']    =  $userData;
		$data['paymentData'] =  $this->Api_Model->paymentData($txnId);
		$data['logo_url']    =  base_url()."uploads/logo.png";

		//$this->load->view('mail/invoice_email_template',$data);

		$html     = $this->load->view('mail/invoice_email_template',$data,true);
		$subject  = "EMA Invoice : $".$data['paymentData']->amount;
		$this->load->library('m_pdf');
		//this the the PDF filename that user will get to download
		$pdfFilePath ="ema-bill-".time()."-download.pdf";
		//actually, you can pass mPDF parameter on this load() function
		$pdf = $this->m_pdf->load();
		//generate the PDF!
		$pdf->WriteHTML($html,2);
		//offer it to user via browser download! (The PDF won't be saved on your server HDD)
		$pdf->Output($pdfFilePath, "D");

	}


	function downloadBill($billId, $userId){
		$data['billDetails'] =  $this->Api_Model->billDetails($billId);
		$userData            =  $this->Api_Model->getSingleUserData($userId);
		$data['userData']    =  $userData;

		//$this->load->view('mail/bill_email_template',$data);

		 $html     = $this->load->view('mail/bill_email_template',$data,true);
		$subject  = "EMA Invoice : $".$data['paymentData']->amount;

		$this->load->library('m_pdf');
		//this the the PDF filename that user will get to download
		$pdfFilePath ="ema-bill-".time()."-download.pdf";
		//actually, you can pass mPDF parameter on this load() function
		$pdf = $this->m_pdf->load();
		//generate the PDF!
		$pdf->WriteHTML($html,2);
		//offer it to user via browser download! (The PDF won't be saved on your server HDD)
		$pdf->Output($pdfFilePath, "D");
	}


	function sendEmail($to, $subject, $message){

		$from = 'info@ema.com';
		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		// Create email headers
		$headers .= 'From: '.$from."\r\n".
			'Reply-To: '.$from."\r\n" .
			'X-Mailer: PHP/' . phpversion();

		// Sending email
		if(mail($to, $subject, $message, $headers)){
			return true;
		} else{
			return false;
		}
	}


public function contactUsData()
{
	$user_id  = $this->input->post('user_id');
	$agent_id = $this->input->post('agent_id');
	$subject  = $this->input->post('subject');
	$message  = $this->input->post('message');
	$data = array(
		'user_id'  => $user_id,
		'agent_id' => $agent_id,
		'subject'  => $subject,
		'message'  => $message,
		'type'     => 'CONTACT',
		'status'   => '0',
	);
	$result = $this->Api_Model->contactUsData($data);
	if ($result) {
		$this->response(true, "Your message submitted successfully.\nyour agent will contact you soon");
	}else {
		$this->response(false, "Message failed");
	}

}


public function sendDistressMessage()
{
	$user_id  = $this->input->post('user_id');
	$agent_id = $this->input->post('agent_id');
	$subject  = $this->input->post('subject');
	$message  = $this->input->post('message');
	$latitude  = $this->input->post('lat');
	$longitude = $this->input->post('lng');
	$data = array(
		'user_id'  => $user_id,
		'agent_id' => $agent_id,
		'subject'  => $subject,
		'message'  => $message,
		'latitude' => $latitude,
		'longitude'=> $longitude,
		'type'     => 'DISTRESS',
		'status'   => '0'
	);
	$result = $this->Api_Model->insertDistressRequest($data);
	if ($result > 0) {
		$userDetail = $this->Api_Model->getSingleUserData($user_id);
		$agentDetail = $this->Api_Model->getSingleUserData($agent_id);
		$data['id'] = $result;
		$data['fname'] = $userDetail->fname;
		$data['lname'] = $userDetail->lname;
		$token = $agentDetail->fb_token;
		$msgData = json_encode($data);
		$this->sendNotification($token, $subject, $message,'DISTRESS', $agent_id, $user_id, $msgData);

		$this->response(true, "Your message submitted successfully.\nyour agent will contact you soon");
	}else {
		$this->response(false, "Message failed");
	}

}

public function sendDistressMessageAll()
{
	$user_id  = $this->input->post('user_id');
	$agent_id = $this->input->post('agent_id');

	$notificationId = $this->input->post('message_id');
     $notificationData = $this->Api_Model->getDestressbyId($notificationId, $agent_id);

     if ($notificationData == FALSE) {
       $this->response(false, "Distress notification not found");
     }

     $tokensArr = $this->Api_Model->getUserTokens($agent_id);
     $tokens = array();
     foreach ($tokensArr as $value) {
       $tokens[] = $value->fb_token;
     }
     if (count($tokens) == 0) {
       $this->response(false, "No users found");
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

     $result = $this->Api_Model->updateDestressbyId($notificationId);
	if ($result) {
		$this->response(true, "Distress notification sent to your all users");
	}else {
		$this->response(false, "Message failed");
	}

}




// public function passwordReset($lang='', $country_code = '', $mobile='', $password = '')
// {
//   $result = $this->Api_Model->passwordReset($mobile, getHashedPassword($password), $country_code);
//   if ($result) {
//     $this->response(true, "Password changed successfully");
//   }else {
//     $this->response(false, "Unable to change your password");
//   }
// }


public function passwordReset()
{
  $user_id     = $this->input->post('user_id');
  $old_password     = $this->input->post('old_password');
  $new_password     = getHashedPassword($this->input->post('new_password'));

  $isUser = $this->Api_Model->checkUser($user_id, $old_password);
  if($isUser != false) {
    //$email = $isUser->email;

    $result =  $this->Api_Model->updatePassword($user_id, array('password' => $new_password));

    if ($result) {
      $this->response(true, "Password changed successfully");
    }else {
      $this->response(false, "Unable to change password");
    }

  }else {
    $this->response(false, "Invalid old Password");
  }
}



function forgotPassword()
{

        $email = $this->security->xss_clean($this->input->post('login_email'));

        if($this->Api_Model->checkEmailExist($email))
        {
            $encoded_email = urlencode($email);

            $this->load->helper('string');
            $data['email'] = $email;
            $data['activation_id'] = random_string('alnum',15);
            $data['createdDtm'] = date('Y-m-d H:i:s');
            $data['agent'] = getBrowserAgent();
            $data['client_ip'] = $this->input->ip_address();


            $save = $this->Api_Model->resetPasswordUser($data);

            if($save)
            {
                $data1['reset_link'] = base_url() . "resetPasswordConfirmUser/" . $data['activation_id'] . "/" . $encoded_email;
                $userInfo = $this->Api_Model->getCustomerInfoByEmail($email);

                if(!empty($userInfo)){
                    $data1["name"] = $userInfo[0]->fname;
                    $data1["email"] = $userInfo[0]->email;
                    $data1["message"] = "Reset Your Password";
                }

                $sendStatus = resetPasswordEmail($data1);

                if($sendStatus){
                    $this->response(true, "Reset password link sent successfully, please check mails.");
                } else {
                    $this->response(false, "Email has been failed, try again.");
                }
            }
            else
            {
              $this->response(false, "It seems an error while sending your details, try again.");
            }
        }
        else
        {
            $this->response(false, "This email is not registered with us.");
        }

}



function graphData($pram = '')
{
	$data = array();
    $data['graph'] = $this->Api_Model->graphData($pram);
    $data['current'] = $this->Api_Model->getCurrentMonthBillCount($pram);
    $data['previous']= $this->Api_Model->getPreviousMonthBillCount($pram);
    $data['notification'] = $this->Api_Model->getNotificationsCount($pram);
    $data['payment'] = $this->Api_Model->getPaymentsCount($pram);
	$this->response(true, "Graph details.",$data);
}

function getContactList($pram = '')
{
    $data = $this->Api_Model->getContactList($pram);
	$this->response(true, "Contact requests",$data);
}

function agentData($pram = '')
{
	$data = array();
    $data['total']    = $this->Api_Model->getTotalBillCount($pram);
    $data['payed']    = $this->Api_Model->getPayedBillCount($pram);
    $data['unpayed']  = $this->Api_Model->getUnpayedBillCount($pram);
    $data['distress'] = $this->Api_Model->getDistressCount($pram);
    $data['contact']  = $this->Api_Model->getContactCount($pram);
	$this->response(true, "Agent Dashboard Details.",$data);
}

function getDistressMessage($userId = ''){
    $data = $this->Api_Model->getDistressMessage($userId);
	$this->response(true, "Agent Distress Message List.",$data);
}



	public function sendNotification($token = '', $title = '', $body = '', $type= '', $to = '', $from = '1', $data = "")
	{
	   if($token == ''){
		return false;
	   }


	   $ApiKey = "AIzaSyDW2akTjJJUw2hTIX4rjjHrcXtv2rba8pQ";

	   $data = array(
						'message'  => $body,
						'title' => $title,
						'type' => $type,
						'data' => $data,
						'user' => $to,
					);
	   $fields = array(
		   'to'      => $token,
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

	function replyVisiter(){
		$user_id    = $this->input->post('user_id');
		$visiter_id = $this->input->post('visiter_id');
		$visit_to   = $this->input->post('visit_to');
		$visitor_name  = $this->input->post('visitor_name');
		$status  = $this->input->post('status');

		$result = $this->Api_Model->updateVisiter($visiter_id, $status);
		if ($result) {
			if($status == '1'){
        $userData    = $this->Api_Model->getUserDetail($user_id);
        $visiterData = $this->Api_Model->getVisiterDetail($visiter_id);
        $guardData   = $this->Api_Model->getUserDetail($visiterData->guard_id);
        $title = "Visiter Allowed";
        $body = $userData->fname." ".$userData->lname." accepted the visiting request of ".$visiterData->visitor_name;
        $token = $guardData->fb_token;
        $type = "1";
        $to   = $visiterData->guard_id;
        $from   = $user_id;
        $data   = "";
        $this->sendNotification($token, $title, $body, $type, $to, $from, $data);
				$this->response(true, "You have successfully accepted request");
			}else{
        $userData    = $this->Api_Model->getUserDetail($user_id);
        $visiterData = $this->Api_Model->getVisiterDetail($visiter_id);
        $guardData   = $this->Api_Model->getUserDetail($visiterData->guard_id);
        $title = "Visiter Request Rejected";
        $body = $userData->fname." ".$userData->lname." Rejected the visiting request of ".$visiterData->visitor_name;
        $token = $guardData->fb_token;
        $type = "1";
        $to   = $visiterData->guard_id;
        $from   = $user_id;
        $data   = "";
        $this->sendNotification($token, $title, $body, $type, $to, $from, $data);
				$this->response(true, "You have successfully rejected request");
			}

		}else {
			$this->response(false, "Message failed");
		}
	}

    public function setExtension() {
        $visitor_id = $this->input->post('visitor_id');
        $reason = $this->input->post('reason');
        $visitor_name = $this->input->post('visitor_name');
        $user_id = $this->input->post('user_id');
        $result = $this->Api_Model->resetExtensionForReservation($visitor_id);
        if ($result){
            $userData = $this->Api_Model->getUserDetail($user_id);
            $data = array(
                'visitor_name' => $visitor_name,
                'visitor_id'   => $visitor_id,
            );
            $this->sendExtensionNotificationToUser($userData, $data);
            $this->response(true, "Extension reset");
        }
        else
            $this->response(false, "Extension failed");
    }

	function checkBillStatus(){
		$users = $this->Api_Model->checkBillStatus();
		$result = array();
		foreach($users as $user){
			$subject = "Remainder Notification";
		    $message = "You have a pending bill.\nPlease pay your bill before due date. After due date you have to pay fine on each bill payments.";
			$token   = $user->fb_token;
			$type    = 'REMINDER';
			$to      = $user->userId;
			$from    = "ADMIN";
			$data    = json_encode($user);
			$result[] = $this->sendNotification($token, $subject, $message, $type, $to, $from, $data);
		}

		print_r($result);
	}


public function getAllUsersByAgentId($agentId='')
{
  $data = $this->Api_Model->getAllUsersByAgentId($agentId);
  if(count($data) > 0){
    $this->response(true, "Users List", $data);
  }else{
    $this->response(false, "No Users Added by Your Agent");
  }
}


public function setVisitorEntry()
{
   $imageName = "";
   $imageName = $this->uploadImage();
   $userId = $this->input->post('user_id');
   $userData = $this->Api_Model->getUserDetail($userId);
   $data = array(
     'guard_id'    => $this->input->post('guard_id'),
     'visitor_name'=> $this->input->post('visitor_name'),
     'visit_to'    => $this->input->post('user_name'),
     'user_id'     => $this->input->post('user_id'),
     'date_in'     => $this->input->post('date_in'),
     'time_in'     => $this->input->post('time_in'),
     'date_out'    => $this->input->post('date_out'),
     'time_out'    => $this->input->post('time_out'),
     'gender'      => $this->input->post('gender'),
     'mobile'      => $this->input->post('mobile'),
     'vical_no'    => $this->input->post('vehical_num'),
     'num_person'  => $this->input->post('person'),
     'status'      => '0',
   );

   if ($imageName != '') {
      $data['image'] = $imageName;
   }
   $result = $this->Api_Model->setVisitorEntry($data);
   if ($result  > 0) {
     $data['id'] = "$result";
     $this->sendVisiterNotificationToUser($userData, $data);

     $this->response(true, "Visitor Added Successfully");
   }else {
     $this->response(false, "Visitor Not Added Failed");
   }
}

public function setVisitorUpdate()
{
   $imageName = "";
   $imageName = $this->uploadImage();
   $userId = $this->input->post('user_id');
   $visitorId = $this->input->post('visitor_id');
   $status = $this->input->post('status');
   $exit = $this->input->post('exit');
   $userData = $this->Api_Model->getUserDetail($userId);
   $data = array(
     'guard_id'    => $this->input->post('guard_id'),
     'visitor_name'=> $this->input->post('visitor_name'),
     'visit_to'    => $this->input->post('user_name'),
     'user_id'     => $this->input->post('user_id'),
     'date_in'     => $this->input->post('date_in'),
     'time_in'     => $this->input->post('time_in'),
     'date_out'    => $this->input->post('date_out'),
     'time_out'    => $this->input->post('time_out'),
     'gender'      => $this->input->post('gender'),
     'mobile'      => $this->input->post('mobile'),
     'vical_no'    => $this->input->post('vehical_num'),
     'num_person'  => $this->input->post('person'),
     'status'      => $status
   );

   if ($imageName != '') {
      $data['image'] = $imageName;
   }
   $result = $this->Api_Model->updateVisitorEntry($visitorId, $data);
   if ($result) {
     if ($status == '0') {
         $data['id'] = $visitorId;
         $this->sendVisiterNotificationToUser($userData, $data);
     }
     else if($exit == 'exiting') {
         $data['id'] = $visitorId;
         $this->sendVisiterExitNotificationToUser($userData, $data);
     }

     $res = $this->Api_Model->getVisiterDetail($visitorId);
     $this->response(true, "Visitor Added Successfully", $res);
   }else {
     $this->response(false, "Visitor Not Added Failed");
   }
}

public function getAllVisitors($guard_id='', $date = '')
{
  $data = $this->Api_Model->getAllVisitors($guard_id, $date);
  if(count($data) > 0){
    $this->response(true, "Visitor List", $data);
  }else{
    $this->response(false, "No Visitors Added by Your Agent");
  }
}

public function getGuardData($guard_id='', $date = '')
{
  $data = $this->Api_Model->getVisitorsCount($guard_id, $date);
  $result['total_visitor'] = count($data);
  if(count($data) > 0){
    $this->response(true, "Visitors Count", $result);
  }else{
    $this->response(false, "No Visitors Today");
  }
}
//coded by Feng
public function sendNotificationToGuard($userData, $userInfo)
{
    $tokens = array();
    $tokens[] = $userData->fb_token;

    $ApiKey = "AIzaSyDW2akTjJJUw2hTIX4rjjHrcXtv2rba8pQ";

    $subject = "Visitor Extension Request Arrival";
    $message = "Hello ".$userData->fname."\nReservation extension request arrived\nVisitor Name : ";
    $message .= $userInfo['visitor_name']."\nReason : ".$userInfo['reason'];

    $data = array(
        'message'  => $message,
        'title' => $subject,
        'type' => 'EXTENSION',
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
//coded by Feng
public function sendVisiterExitNotificationToUser($userData, $userInfo)
{
    $tokens = array();
    $tokens[] = $userData->fb_token;

    $ApiKey = "AIzaSyDW2akTjJJUw2hTIX4rjjHrcXtv2rba8pQ";

    $subject = "Visitor Exiting";
    $message = "Hello ".$userData->fname."\nA visitor is exiting on the gate\nName : ";
    $message .= $userInfo['visitor_name']."\nMobile No. : ".$userInfo['mobile'];

    $data = array(
        'message'  => $message,
        'title' => $subject,
        'type' => 'VISITER_EXITING',
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
//coded by Feng
public function sendVehicleNotificationToUser($userData, $carInfo)
{
    $tokens = array();
    $tokens[] = $userData->fb_token;

    $ApiKey = "AIzaSyDW2akTjJJUw2hTIX4rjjHrcXtv2rba8pQ";

    $subject_template = "Your Vehicle Entry";

    if ($carInfo['vehicle_status'] == 1){
        $subject_template = "Your Vehicle Exit";
        $message = "Hello ".$userData->fname."\nYour Vehicle is Exiting now.\nVehicle REG No : ";
        $message .= $carInfo['vehicle_number']."\n";
    }
    else if($carInfo['vehicle_status'] == 2){
        $message = "Hello ".$userData->fname."\nYour Vehicle is Arriving now.\nVehicle REG No : ";
        $message .= $carInfo['vehicle_number']."\n";
    }

    $subject = $subject_template;

    $data = array(
        'message'  => $message,
        'title' => $subject,
        'type' => 'VEHICLES',
        'payloadData' => json_encode($carInfo),
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
//coded by Feng
public function sendExtensionNotificationToUser($userData, $userInfo)
{
    $tokens = array();
    $tokens[] = $userData->fb_token;

    $ApiKey = "AIzaSyDW2akTjJJUw2hTIX4rjjHrcXtv2rba8pQ";

    $subject = "Extension Response";
    $message = "Hello ".$userData->fname."\nYour Visitor :".$userInfo['visitor_name']." 's extension request is allowed for another 5 times.\n";

    $data = array(
        'message'  => $message,
        'title' => $subject,
        'type' => 'EXTENSION_AGREE',
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

public function generateFixedBill()
{
    $this->load->model(array('BillGenerated_model'));
    $bill_generated_date  = date("Y-m-d");
    $bill_month  = date("Y-m")."-01";
    $due_date    = date("Y-m")."-25";
    $unit        = "1";

    $agentArr = $this->Api_Model->getAllAgents();
    if (count($agentArr) == 0) {
      echo "No Agents Available";
      die();
    }

    foreach ($agentArr as $valueAgent) {
      $billDataArr = $this->Api_Model->getFixedBillByAgent($valueAgent);
      $userDataArr = $this->Api_Model->getUsersByAgent($valueAgent);

      if (count($userDataArr) == 0 || count($billDataArr) == 0) {
        continue;
      }

      foreach ($userDataArr as $valueUser) {
        $billtypeArr = explode(',', $valueUser->billtype);
        if (count($billtypeArr) == 0) {
          continue;
        }

        $from        = $valueAgent;
        $client_id   = $valueUser->userId;
        $token       = $valueUser->fb_token;

        /************************* CHECK FOR DUE BILLS START *********************************/
              $this->checkForPreviousBill($client_id);
        /************************* CHECK FOR DUE BILLS END *********************************/


        foreach ($billDataArr as $valueBill) {
          if (!in_array($valueBill->bill_type_id, $billtypeArr)){
            continue;
          }

          $bill_type    = $valueBill->bill_type_id;
          $bill_amount  = $valueBill->amount;
          $late_fee     = $valueBill->late_fee;
          $total_amount = $bill_amount + $late_fee;

          $userInfo = array(
            'bill_type'           => $bill_type,
            'bill_month'          => $bill_month,
            'bill_amount'         => $bill_amount,
            'bill_generated_date' => $bill_generated_date,
            'due_date'            => $due_date,
            'unit'                => $unit,
            'late_fee'            => $late_fee,
            'total_amount'        => $total_amount,
            'client_id'           => $client_id,
            'status'              => '0',
            'agent_id'            => $from
            );

            $result = $this->BillGenerated_model->addBillGenerated($userInfo);
            if($result > 0)
            {
                $title = "Bill Generated";
                $body  = "A new bill is generated by your estate agent.\nBill Month : $bill_month\nBill Amount : $$bill_amount";
                $this->sendNotification($token, $title, $body, 'BILL', $client_id, $from, "");
                $rscode = array('agent_code'=>'EMA'.$from);
                $data['billDetails'] =   $this->BillGenerated_model->billDetails($result);
                $userData = $this->BillGenerated_model->getUserData($client_id);
                $data['userData'] =  $userData;
                $mesg     = $this->load->view('mail/bill_email_template',$data,true);
                $subject  = "Bill Generated : $bill_month";
                $to_email = $userData->email;
                $this->sendEmail($to_email, $subject, $mesg);
                echo "New Bill Generated successfully\n";
            }else{
                echo "BillGenerated creation failed\n";
            }

        }

      }
    }
  }


  public function checkForPreviousBill($client_id='')
  {
    $this->load->model(array('BillGenerated_model'));
    $dueBillsAmount = $this->Api_Model->getDueBillsOfUser($client_id);
    if ($dueBillsAmount != '') {
      $title = "Pay Due Bills";
      $body  = "You have some due bills.\nTotal amount $$dueBillsAmount.\n(Including Late Fee)";
      $userData = $this->BillGenerated_model->getUserData($client_id);
      $token = $userData->fb_token;
      $this->sendNotification($token, $title, $body, 'BILL', $client_id, $userData->agent_id, "");

      $data['agentData'] = $this->BillGenerated_model->getUserData($userData->agent_id);
      $data['userData']  = $userData;
      $data['total']     = $dueBillsAmount;

      $mesg     = $this->load->view('mail/due_email_template',$data,true);
      $subject  = "EMA Bill Due : $$dueBillsAmount";
      $to_email = $userData->email;
      $this->sendEmail($to_email, $subject, $mesg);
      echo "Due Bill Email Sent successfully\n";
    }
  }

}

?>
