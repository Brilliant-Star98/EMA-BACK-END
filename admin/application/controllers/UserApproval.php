<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class UserApproval extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('UserApproval_model');
        $this->isLoggedIn();
    }

    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        $this->global['pageTitle'] = 'Dashboard';
        $id = $this->session->userdata('userId');
        $data['UserApprovalData'] = $this->UserApproval_model->getUserApprovalData($id);
        $data['PendingUserData'] = $this->UserApproval_model->getPendingUserData($id);
        $data['BlockedUserData'] = $this->UserApproval_model->getblockedUserData($id);
        $this->loadViews("approval/approved_user", $this->global, $data,NULL , NULL);
    }


    public function pending()
    {
        $this->global['pageTitle'] = 'Dashboard';
        $id = $this->session->userdata('userId');
        $data['PendingUserData'] = $this->UserApproval_model->getPendingUserData($id);
        $this->loadViews("approval/pending_user", $this->global, $data,NULL , NULL);
    }

    public function blocked()
    {
        $this->global['pageTitle'] = 'Dashboard';
        $id = $this->session->userdata('userId');
        $data['PendingUserData'] = $this->UserApproval_model->getblockedUserData($id);
        $this->loadViews("approval/blocked_user", $this->global, $data,NULL , NULL);
    }


    public function approveNow()
    {
        $this->global['pageTitle'] = 'Dashboard';
        $result = $this->UserApproval_model->approveNow($this->input->get('id'));

        if($result == true)
        {
            $this->session->set_flashdata('success', 'New User Approved successfully');
            if ($this->session->userdata('role') == '1') {
              redirect('list-agent');
            }else{redirect('approve-users');}
        }
        else
        {
            $this->session->set_flashdata('error', 'User Approval failed');
        }
    }

    public function BlockUserNow()
    {
        $this->global['pageTitle'] = 'Dashboard';
        $result = $this->UserApproval_model->BlockUserNow($this->input->get('id'));

        if($result == true)
        {
            $this->session->set_flashdata('error', 'User Blocked successfully');
            if ($this->session->userdata('role') == '1') {
              redirect('list-agent');
            }else{redirect('approve-users');}
        }
        else
        {
            $this->session->set_flashdata('error', 'User Approval failed');
        }


    }




    public function Delete(){

         $result = $this->UserApproval_model->deleteUser($this->input->get('id'));
           if( $result){
            echo(json_encode(array('status'=>TRUE)));
           }else{
            echo(json_encode(array('status'=>FALSE)));
           }
         }





}

?>
