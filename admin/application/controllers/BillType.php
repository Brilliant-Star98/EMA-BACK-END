<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class BillType extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('BillType_model');
        $this->isLoggedIn();
    }

    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        $this->global['pageTitle'] = 'Dashboard';
        $data['BillTypeData'] = $this->BillType_model->getBillTypeData();
        $this->loadViews("billtype/list", $this->global, $data,NULL , NULL);
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
            $imageName = "";
            $this->form_validation->set_rules('bill_title','bill title','required');
            $this->form_validation->set_rules('ismanual','Check bill type','required');
            $this->form_validation->set_rules('bill_description','Last Name','required');


            if($this->form_validation->run() == FALSE)
            {
                $this->loadViews("billtype/add", $this->global, NULL , NULL);
            }
            else
            {

                if ($_FILES['image']['name']) {
                  $imageName = $this->uploadImage();
                }

                $userInfo = array(
                  'bill_title'=>$this->security->xss_clean($this->input->post('bill_title')),
                  'ismanual'=>$this->input->post('ismanual'),
                  'bill_description'=>$this->security->xss_clean($this->input->post('bill_description')),
                  'created_by'=>$this->session->userdata('userId'),
                  );

                if ($imageName != "") {
                  $userInfo['bill_logo'] = $imageName;
                }

                $result = $this->BillType_model->addBillType($userInfo);

                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New BillType created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'BillType creation failed');
                }

                redirect('add-billtype');
            }
        }
    }





    function Edit()
    {

        $data['BillType'] = $this->BillType_model->getBillTypeSingle($this->input->get('id'));

        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            $imageName = "";
            $this->form_validation->set_rules('bill_title','bill title','required');
            $this->form_validation->set_rules('ismanual','Check bill type','required');
            $this->form_validation->set_rules('bill_description','Last Name','required');

            if($this->form_validation->run() == FALSE)
            {
                $this->loadViews("billtype/edit", $this->global, $data,NULL , NULL);
            }
            else
            {


                if ($_FILES['image']['name']) {
                  $imageName = $this->uploadImage();
                }

                $userInfo = array(
                  'bill_title'=>$this->security->xss_clean($this->input->post('bill_title')),
                  'ismanual'=>$this->input->post('ismanual'),
                  'bill_description'=>$this->security->xss_clean($this->input->post('bill_description')),
                  'created_by'=>$this->session->userdata('userId'),
                  );

                if ($imageName != "") {
                  $userInfo['bill_logo'] = $imageName;
                }
                $result = $this->BillType_model->UpdateUser($userInfo,$this->input->get('id'));

                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New BillType update successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'BillType updation failed');
                }

                redirect('list-billtype');
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

         $result = $this->BillType_model->deleteUser($this->input->get('id'));
           if( $result){
            echo(json_encode(array('status'=>TRUE)));
           }else{
            echo(json_encode(array('status'=>FALSE)));
           }

         }





}

?>
