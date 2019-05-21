<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('./vendor/autoload.php');

class PaymentApi extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
    $this->load->model('user_model');
    $this->load->model('Booking_model');
    $this->load->model('Api_Model');
  }

  function index()
  {

// 	  mail("amineshchedwal@gmail.com","DATA : ",json_encode($_REQUEST['PaymentApi']));

    $token = $_REQUEST['token'];
    \Stripe\Stripe::setApiKey('sk_test_0VvhXqARhCIIMKnrxtGiAX1E');
    $charge = \Stripe\Charge::create(array('amount' => 100, 'currency' => 'usd', 'source' => $token ));

    if ($charge != null) {


      $post = array();
      $img1 = '';
      $img2 = '';
      $img3 = '';

      if(isset($_FILES['offer_img']['name']) && !empty($_FILES['offer_img']['name'])){
          $img1 = $this->uploadSimpleImage($_FILES['offer_img']);
     }
     if(isset($_FILES['x_ray']['name']) && !empty($_FILES['x_ray']['name'])){
          $img2 = $this->uploadSimpleImage($_FILES['x_ray']);
     }
     if(isset($_FILES['document']['name']) && !empty($_FILES['document']['name'])){
          $img3 = $this->uploadSimpleImage($_FILES['document']);
     }

       $data = array(
            'user_id'=>$this->input->post('user_id'),
            'name'=>$this->input->post('name'),
            'email'=>$this->input->post('email'),
            'dob'=>$this->input->post('dob'),
            'phone'=>$this->input->post('phone'),
            'offer_from_1_dentist'=>$this->input->post('offer'),
            'doc1'=>$img1,
            'doc2'=>$img2,
            'doc3'=>$img3,
            'comments'=>$this->input->post('comment'),
            'payment_status'=>'1',
            'transaction_id'=>'ch_1Bn0MMGIJMYUxiU9gKi9OuxI',
            'assign_doctor_id'=>'',
          );

		      //   $data = array(
          //   'user_id'=> 34,
          //   'name'=>"ABC",
          //   'email'=>"abc@abc.com",
          //   'dob'=>"12/12/2015",
          //   'phone'=>'123456789',
          //   'offer_from_1_dentist'=>"test",
          //   'doc1'=>$img1,
          //   'doc2'=>$img2,
          //   'doc3'=>$img3,
          //   'comments'=>"comment",
          //   'payment_status'=>'1',
          //   'transaction_id'=>'ch_1Bn0MMGIJMYUxiU9gKi9OuxI',
          //   'assign_doctor_id'=>'',
          // );




          $result = $this->Api_Model->addNewData($data);
          if($result > 0)
          {
              echo json_encode(array('status'=>1, 'message'=>'Your Request has been sent','data' =>$data));
          }
          else
          {
            echo json_encode(array('status'=>0, 'message'=>'Your Request Faild', 'data' =>$data));
            die();
          }


      echo json_encode(array('status' => 1, 'message'=> "Your request submitted successfully.", 'data' => array(), 'response' => $charge));
      //echo json_encode(array('status' => 1, 'message'=> "Your request submitted successfully.", 'data' => array(), 'response' => 12));
     }else {
      echo json_encode(array('status' => 0, 'message'=> "Request Failed", 'data' => array()));
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

}

/*
On SUccess Response:

Stripe\Charge JSON: { "id": "ch_1Bn0MMGIJMYUxiU9gKi9OuxI", "object": "charge", "amount": 100, "amount_refunded": 0, "application": null, "application_fee": null, "balance_transaction": "txn_1Bn0MMGIJMYUxiU9imuaEFfe", "captured": true, "created": 1516608534, "currency": "usd", "customer": null, "description": null, "destination": null, "dispute": null, "failure_code": null, "failure_message": null, "fraud_details": [], "invoice": null, "livemode": false, "metadata": [], "on_behalf_of": null, "order": null, "outcome": { "network_status": "approved_by_network", "reason": null, "risk_level": "normal", "seller_message": "Payment complete.", "type": "authorized" }, "paid": true, "receipt_email": null, "receipt_number": null, "refunded": false, "refunds": { "object": "list", "data": [], "has_more": false, "total_count": 0, "url": "\/v1\/charges\/ch_1Bn0MMGIJMYUxiU9gKi9OuxI\/refunds" }, "review": null, "shipping": null, "source": { "id": "card_1Bn0LoGIJMYUxiU9gtS9ftF7", "object": "card", "address_city": null, "address_country": null, "address_line1": null, "address_line1_check": null, "address_line2": null, "address_state": null, "address_zip": null, "address_zip_check": null, "brand": "Visa", "country": "US", "customer": null, "cvc_check": "pass", "dynamic_last4": null, "exp_month": 11, "exp_year": 2022, "fingerprint": "topVwGREv4cYx1n2", "funding": "unknown", "last4": "1111", "metadata": [], "name": null, "tokenization_method": null }, "source_transfer": null, "statement_descriptor": null, "status": "succeeded", "transfer_group": null }

On Fail Response


*/
