<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Notification extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('Notification_model');
        $this->isLoggedIn();
    }

    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        $this->global['pageTitle'] = 'Dashboard';
        $data['NotificationData'] = $this->Notification_model->getNotificationData();
        $this->loadViews("notification/list", $this->global, $data,NULL , NULL);
    }

    /**
     * This function is used to add new user to the system
     */
    function Add()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('title','title','required');
            $this->form_validation->set_rules('description','description','required');

            if($this->form_validation->run() == FALSE)
            {
                $this->loadViews("notification/add", $this->global, NULL , NULL);
            }
            else
            {
                $userInfo = array(
                  'title'=>$this->security->xss_clean(strtoupper($this->input->post('title'))),
                  'description'=>$this->security->xss_clean($this->input->post('description')),
                  'created_by'=>$this->session->userdata('userId'),
                  );

                $result = $this->Notification_model->addNotification($userInfo);
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New Notification created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Notification creation failed');
                }
                redirect('add-notification');
            }
        }
    }





    function Edit()
    {

        $data['Notification'] = $this->Notification_model->getNotificationSingle($this->input->get('id'));

        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('title','title','required');
            $this->form_validation->set_rules('description','description','required');

            if($this->form_validation->run() == FALSE)
            {
                $this->loadViews("notification/edit", $this->global, $data,NULL , NULL);
            }
            else
            {
              $userInfo = array(
                'title'=>$this->security->xss_clean(strtoupper($this->input->post('title'))),
                'description'=>$this->security->xss_clean($this->input->post('description')),
                'created_by'=>$this->session->userdata('userId'),
                  );

              $result = $this->Notification_model->UpdateUser($userInfo,$this->input->get('id'));

                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New Notification update successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Notification updation failed');
                }

                redirect('list-notification');
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

         $result = $this->Notification_model->deleteUser($this->input->get('id'));
           if( $result){
            echo(json_encode(array('status'=>TRUE)));
           }else{
            echo(json_encode(array('status'=>FALSE)));
           }

         }





}

?>
