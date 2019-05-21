<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class BillGenerated extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library('M_pdf');
        $this->load->model('user_model');
        $this->load->model('BillGenerated_model');
        $this->load->library('email');
       // $this->isLoggedIn();
    }

    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        $this->global['pageTitle'] = 'Dashboard';
        $data['BillGeneratedData'] = $this->BillGenerated_model->getBillGeneratedData();
        $this->loadViews("billgenerated/list", $this->global, $data,NULL , NULL);
    }


    /**
     * This function is used to add new user to the system
     */

    function getBillValue()
    {
      $id = $this->input->post('id');
      $data = $this->BillGenerated_model->MyBillType($id);
      $data2 = array();
      if (count($data) >0) {
        $mytye = explode(',',$data[0]->billtype);
        $data2 = $this->BillGenerated_model->TheBillType($mytye);
      }

      echo '<select class="form-control" name="bill_type" required>';
      echo '<option selected>Select Bill Type</option>';
       foreach ($data2 as $bill) {
      echo '<option value="'.$bill->id.'">'.$bill->bill_title.'</option>';
       }
      echo '</select>';

    }




    public function MonthFilter()
    {
        $mont = $this->input->post('month');
        $data = $this->BillGenerated_model->BillMonthData($mont);
        foreach ($data as $BillType) {
        echo '<tr>';
        echo '<td>'.$BillType->id.'</td>';
        echo '<td>'.$BillType->fname.''.$BillType->lname.'';
        echo '<td>'.$BillType->bill_month.'</td>';
        echo '<td>'.$BillType->bill_amount.'</td>';
        echo '<td>'.$BillType->bill_generated_date.'</td>';
        echo '<td>'.$BillType->due_date.'</td>';
        echo '<td>'.$BillType->rate.'</td>';
        echo '<td>'.$BillType->unit.'</td>';
        echo '<td>';
        echo '<a class=" btn btn-sm btn-dark" style="float: none; padding:5px; margin: 0px;" href="'.base_url().'edit-billgenerated?id='.$BillType->id.'"><span class="ti-pencil"></span></a>';
        echo '<a class="btn btn-danger btn-animation"  onclick="deleteRow('.$BillType->id.')"  style="float: none; padding:5px; margin: 0px;"><span class="fa fa-trash"></span> </a>';
        echo '</td>';
        echo '</tr>';
        }
   }


   public function MonthPendingFilter()
   {
       $mont = $this->input->post('month');
       $data = $this->BillGenerated_model->MonthPendingFilter($mont);
       foreach ($data as $BillType) {
       echo '<tr>';
       echo '<td>'.$BillType->id.'</td>';
       echo '<td>'.$BillType->fname.''.$BillType->lname.'';
       echo '<td>'.$BillType->bill_month.'</td>';
       echo '<td>'.$BillType->bill_amount.'</td>';
       echo '<td>'.$BillType->bill_generated_date.'</td>';
       echo '<td>'.$BillType->due_date.'</td>';
       echo '<td>'.$BillType->rate.'</td>';
       echo '<td>'.$BillType->unit.'</td>';
       echo '<td>';
       echo '<a class=" btn btn-sm btn-dark" style="float: none; padding:5px; margin: 0px;" href="'.base_url().'edit-billgenerated?id='.$BillType->id.'"><span class="ti-pencil"></span></a>';
       echo '<a class="btn btn-danger btn-animation"  onclick="deleteRow('.$BillType->id.')"  style="float: none; padding:5px; margin: 0px;"><span class="fa fa-trash"></span> </a>';
       echo '</td>';
       echo '</tr>';
       }
  }

   public function MonthPaidFilter()
   {
       $mont = $this->input->post('month');
       $data = $this->BillGenerated_model->MonthPaidFilter($mont);
       foreach ($data as $BillType) {
       echo '<tr>';
       echo '<td>'.$BillType->id.'</td>';
       echo '<td>'.$BillType->fname.''.$BillType->lname.'';
       echo '<td>'.$BillType->bill_month.'</td>';
       echo '<td>'.$BillType->bill_amount.'</td>';
       echo '<td>'.$BillType->bill_generated_date.'</td>';
       echo '<td>'.$BillType->due_date.'</td>';
       echo '<td>'.$BillType->rate.'</td>';
       echo '<td>'.$BillType->unit.'</td>';
       echo '<td>';
       echo '<a class=" btn btn-sm btn-dark" style="float: none; padding:5px; margin: 0px;" href="'.base_url().'edit-billgenerated?id='.$BillType->id.'"><span class="ti-pencil"></span></a>';
       echo '<a class="btn btn-danger btn-animation"  onclick="deleteRow('.$BillType->id.')"  style="float: none; padding:5px; margin: 0px;"><span class="fa fa-trash"></span> </a>';
       echo '</td>';
       echo '</tr>';
       }
  }







    function Add()
    {
      $data['BillType'] = $this->BillGenerated_model->getBillType();
      $data['User'] = $this->BillGenerated_model->getUser();
      $this->load->library('form_validation');

      $this->form_validation->set_rules('bill_type','bill type','required');
      $this->form_validation->set_rules('bill_month','bill month','required');
      $this->form_validation->set_rules('bill_amount','bill amount','required');
      $this->form_validation->set_rules('bill_generated_date','bill date','required');
      $this->form_validation->set_rules('due_date','due date','required');
      $this->form_validation->set_rules('unit','unit','required');
      $this->form_validation->set_rules('late_fee','late fee','required');
      $this->form_validation->set_rules('total_amount','total amount','required');

      if($this->form_validation->run() == FALSE)
      {
          $this->loadViews("billgenerated/add", $this->global, $data, NULL , NULL);
      }
      else
      {
        $bill_month  = $this->input->post('bill_month');
        $bill_amount = $this->input->post('bill_amount');
        $client_id   = $this->input->post('client_id');
        $from        = $this->session->userdata('userId');

          $userInfo = array(
            'bill_type'=>$this->security->xss_clean($this->input->post('bill_type')),
            'bill_month'=>$this->security->xss_clean($this->input->post('bill_month')),
            'bill_amount'=>$this->security->xss_clean($this->input->post('bill_amount')),
            'bill_generated_date'=>$this->security->xss_clean($this->input->post('bill_generated_date')),
            'due_date'=>$this->security->xss_clean($this->input->post('due_date')),
            'unit'=>$this->security->xss_clean($this->input->post('unit')),
            'late_fee'=>$this->security->xss_clean($this->input->post('late_fee')),
            'total_amount'=>$this->security->xss_clean($this->input->post('total_amount')),
            'client_id'=>$this->security->xss_clean($this->input->post('client_id')),
            'status'=>'0',
            'agent_id'=>$from
            );

          $result = $this->BillGenerated_model->addBillGenerated($userInfo);

          if($result > 0)
          {
              $title = "Bill Generated";
              $body  = "A new bill is generated by your estate agent.\nBill Month : $bill_month\nBill Amount : $$bill_amount";
              $this->sendNotification($title, $body, 'BILL', $client_id, $from, "");
              $rscode = array('agent_code'=>'EMA'.$result);
              $data['billDetails'] =   $this->BillGenerated_model->billDetails($result);
              $userData = $this->BillGenerated_model->getUserData($client_id);
              $data['userData'] =  $userData;

              $mesg     = $this->load->view('mail/bill_email_template',$data,true);
              $subject  = "Bill Generated : $bill_month";
              $to_email = $userData->email;
              // $this->sendEmail($to_email, $subject, $mesg);
              $this->sendinvoice($to_email, $subject, $mesg);
              $this->session->set_flashdata('success', 'New Bill Generated successfully');
          }
          else
          {
              $this->session->set_flashdata('error', 'BillGenerated creation failed');
          }

          redirect('add-billgenerated');
      }
    }

	function callinvoice()
	{
		$mess = "<h1>amineshchedwal</h1>";
		$this->sendinvoice("amineshchedwal@gmail.com","ema invoice",$mess);
	}

	function sendinvoice($to, $subject, $message1){

    $html=$message1;
    $mpdf= $this->m_pdf->load();
		$pdfFilePath = "output_pdf_name.pdf";
		$mpdf->WriteHTML($html);
		$fileData = $mpdf->Output($pdfFilePath, "S");


		$from        = "info@ema.com';";
		$mainMessage = "EMA INVOICE SYSTEM.";
		$fileatt     = "./invoice.pdf";
		$fileatttype = "application/pdf";
		$fileattname = "invoice.pdf";
		$headers = "From: $from";

		// This attaches the file
		$semi_rand     = md5(time());
		$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
		$headers      .= "\nMIME-Version: 1.0\n" .
		"Content-Type: multipart/mixed;\n" .
		" boundary=\"{$mime_boundary}\"";
		$message = $message1.".\n\n" .
		"-{$mime_boundary}\n" .
		"Content-Type: text/plain; charset=\"iso-8859-1\n" .
		"Content-Transfer-Encoding: 7bit\n\n" .
		$mainMessage  . "\n\n";

		$data = chunk_split(base64_encode($fileData));
		$message .= "--{$mime_boundary}\n" .
		"Content-Type: {$fileatttype};\n" .
		" name=\"{$fileattname}\"\n" .
		"Content-Disposition: attachment;\n" .
		" filename=\"{$fileattname}\"\n" .
		"Content-Transfer-Encoding: base64\n\n" .
		$data . "\n\n" .
		"-{$mime_boundary}-\n";

		// Send the email
		if(mail($to, $subject, $message, $headers)) {

			return true;

		}else {

			return false;

		}

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


    function Edit()
    {

        $data['BillGenerated'] = $this->BillGenerated_model->getBillGeneratedSingle($this->input->get('id'));
        if($this->isAgent() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
              $this->form_validation->set_rules('bill_amount','bill amount','required');
              $this->form_validation->set_rules('unit','unit','required');
              $this->form_validation->set_rules('late_fee','late fee','required');
              $this->form_validation->set_rules('total_amount','total amount','required');

            if($this->form_validation->run() == FALSE)
            {
                $this->loadViews("billgenerated/edit", $this->global, $data,NULL , NULL);
            }
            else
            {
              $userInfo = array(
                'bill_amount'=>$this->security->xss_clean($this->input->post('bill_amount')),
                'unit'=>$this->security->xss_clean($this->input->post('unit')),
                'late_fee'=>$this->security->xss_clean($this->input->post('late_fee')),
                'total_amount'=>$this->security->xss_clean($this->input->post('total_amount')),
                'status'=>'0',
                );



                $result = $this->BillGenerated_model->UpdateUser($userInfo,$this->input->get('id'));

                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New BillGenerated update successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'BillGenerated updation failed');
                }

                redirect('list-billgenerated');
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

	 $result = $this->BillGenerated_model->deleteUser($this->input->get('id'));
	   if( $result){
		echo(json_encode(array('status'=>TRUE)));
	   }else{
		echo(json_encode(array('status'=>FALSE)));
	   }

	}

	public function sendNotification($title = '', $body = '', $type= '', $to = '', $from = '1', $data = "")
	{
	   $token = $this->BillGenerated_model->getUserToken($to);
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
		   'to'      => $token,
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


public function billSettings()
{
  $data['BillType'] = $this->BillGenerated_model->getFixedBillType();
  $this->load->library('form_validation');
  $this->form_validation->set_rules('billtype[]','Bill type','trim|numeric');
  $this->form_validation->set_rules('bill_amount[]','Bill amount','trim|numeric');
  $this->form_validation->set_rules('late_fee[]','Bate fee','trim|numeric');
  if($this->form_validation->run() == FALSE)
  {
      $this->loadViews("billgenerated/settings", $this->global, $data, NULL , NULL);
  }
  else
  {
    //[billtype] => Array ( [0] => 6 [1] => 7 [2] => 8 ) [bill_amount] => Array ( [0] => 12 [1] => 45 [2] => 53 ) [late_fee] => Array ( [0] => 33 [1] => 63 [2] => 23 ) )
    //`agent_id`, `bill_type_id`, `amount`, `late_fee`,
    $billTypeArr = $this->input->post('billtype');
    $billAmountArr = $this->input->post('bill_amount');
    $billLateArr = $this->input->post('late_fee');
    $agent_id = $this->session->userdata('userId');

    $dataInfo = array();
    for($i=0; $i<count($billTypeArr); $i++) {
      $tempArr = array(
        'agent_id' => $agent_id,
        'bill_type_id' => $billTypeArr[$i],
        'amount' => $billAmountArr[$i],
        'late_fee' => $billLateArr[$i],
       );
       $dataInfo[] = $tempArr;
    }

    if (count($dataInfo) > 0) {
      $this->BillGenerated_model->deletePreviousBillSetting($agent_id);
      $result = $this->BillGenerated_model->setBillSettingsAmount($dataInfo);
      if($result){
        $this->session->set_flashdata('success', 'Bills Amount Updated Successfully');
      }else{
        $this->session->set_flashdata('error', 'Bills Amount Updation Failed');
      }
    }else {
      $this->session->set_flashdata('error', 'No Bill Available');
    }

      redirect('bill-settings');
  }
}


}

?>
