<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Payment extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('Payment_model');
        $this->isLoggedIn();
    }

    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        $this->global['pageTitle'] = 'Dashboard';
          $id = $this->session->userdata('userId');
        $data['PaymentData'] = $this->Payment_model->getPaymentData($id);
        $this->loadViews("payment/list", $this->global, $data,NULL , NULL);
    }

    /**
     * This function is used to add new user to the system
     */

     public function emailtemplate()
     {
         $this->global['pageTitle'] = 'Dashboard';
         $data['PaymentData'] = $this->Payment_model->getPaymentData();
         $this->loadViews("mail/agent_email_template", $this->global, $data,NULL , NULL);
     }


    public function Delete(){

         $result = $this->Payment_model->deleteUser($this->input->get('id'));
           if( $result){
            echo(json_encode(array('status'=>TRUE)));
           }else{
            echo(json_encode(array('status'=>FALSE)));
           }

         }





}

?>
