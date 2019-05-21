<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Api_Model extends CI_Model
{

  public $userTable = 'tbl_users';

  public function __construct()
    {
      parent::__construct();
      $this->load->database();
    }


  public function verifyAgentCode($agentCode)
  {
    $this->db->select('*');
    $this->db->where('userId', $agentCode);
    $this->db->where('roleId', '2');
    $query = $this->db->get('tbl_users');
    if ($query->num_rows() > 0) {
      return $query->result();
    }else {
      return false;
    }
  }

  public function verifyUser($country_code, $mobile)
  {
    $this->db->select('userId');
    $this->db->where('mobile', $mobile);
    $this->db->where('country_code', $country_code);
    $query = $this->db->get('tbl_users');
    if ($query->num_rows() > 0) {
      return false;
    }else {
      return true;
    }
  }

	function getUserToken($id)
    {
        $this->db->select('fb_token');
        $this->db->from('tbl_users');
        $this->db->where('userId', $id);
        $query = $this->db->get();
		if ($query->num_rows() > 0) {
		  $data = $query->result();
		  return $data[0]->fb_token;
		}else {
		  return "";
		}
    }

    function getChatMessage($id)
    {
      $sql = "SELECT message, attechment FROM booking_chat WHERE booking_id = $id ORDER BY id DESC";
      $query = $this->db->query($sql);
      return $query->result();
    }

    public function registerUser($data)
    {
      return $this->db->insert('tbl_users', $data);
    }

    //2019.3.15 coded by Feng
    public function registerCarForUser($data)
    {
        return $this->db->insert('tbl_user_cars', $data);
    }

    //coded by Feng
    public function getCarStatus($car_plate)
    {
        $this->db->select('userId');
        $this->db->select('car_status');
        $this->db->where('car_plate', $car_plate);
        $query = $this->db->get('tbl_user_cars');
        $data = $query->result();
        //$cstatus = $data[0]->car_status;
        return $data;
    }

    //coded by Feng
    public function carVisible($car_plate, $user_id)
    {
        $this->db->select('car_status');
        $this->db->where('car_plate', $car_plate);
        $this->db->where('userId', $user_id);
        $query = $this->db->get('tbl_user_cars');
        if($query->num_rows() > 0)
            return 1;
        return 0;
    }
    //coded by Feng
    public function updateCarStatus($plate_number, $cstatus)
    {
        $data = array('car_status' => $cstatus);
        $this->db->where('car_plate', $plate_number);
        $this->db->update('tbl_user_cars', $data);

        $data_time = array('car_plate' =>   $plate_number,
                           'car_status' =>  $cstatus,
                           'car_time' =>    date('Y-m-d H:i:s'),
                           'is_resident' => 1,
        );
        return $this->db->insert('tbl_user_cars_time', $data_time);
    }
    //coded by Feng
    public function getCarListForUser($userId = '')
    {
        $this->db->select('car_plate');
        $this->db->select('car_status');
        $this->db->where('userId', $userId);
        $query =  $this->db->get('tbl_user_cars');
        $car_list = $query->result();
        if ($query->num_rows() > 0)
            return $car_list;
        return 0;
    }
    //coded by Feng
    public function getCarHistory($car_plate, $date_from, $date_to)
    {
        //$dFrom = date_create_from_format('Y-m-d H:m:s', $date_from);
        //$dTo = date_create_from_format('Y-m-d H:m:s', $date_to);;
        $multipleWhere = [
            'car_plate'   => $car_plate,
            'is_resident' => 1,
            'car_time >=' => $date_from,
            'car_time <=' => $date_to,
        ];

        $this->db->select('car_status');
        $this->db->select('car_time');
        $this->db->where($multipleWhere);
        $query = $this->db->get('tbl_user_cars_time');
        return $query->result();

    }
    //coded by Feng
    public function reserveVisitor($data)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_reserved_visitors', $data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;

    }
    //coded by Feng
    public function updateVehicleNotificationStatus($userId, $data)
    {
        $this->db->select('status');
        $this->db->where('userId', $userId);
        $query = $this->db->get('tbl_users_notifications');
        $result = $query->result();
        if ($result == null)
            return $this->db->insert('tbl_users_notifications', $data);
        else{
            $this->db->where('userId', $userId);
            return $this->db->update('tbl_users_notifications', $data);
        }
    }
    //coded by Feng
    public function getVehicleNotificationStatus($userId)
    {
        $this->db->select('status');
        $this->db->select('car_notification_from');
        $this->db->select('car_notification_to');
        $this->db->where('userId', $userId);
        $query = $this->db->get('tbl_users_notifications');
        return $query->result();
    }
    //coded by Feng
    public function updateReserveVisitor($visitorId, $data)
    {
        $this->db->where('id', $visitorId);
        return $this->db->update('tbl_reserved_visitors', $data);
    }
    //coded by Feng
    public function cancelReservation($visitorId)
    {
        $this->db->where('id', $visitorId);
        return $this->db->delete('tbl_reserved_visitors');
    }
    //coded by Feng
    public function getAllReservedVisitors($userId='', $date='')
    {
        $this->db->select('*');
        $this->db->from('tbl_reserved_visitors');
        $this->db->where('userId', $userId);
        $this->db->where('date_in', $date);
        $this->db->where('status !=', '4');
        $this->db->order_by("id", 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }else {
            return array();
        }
    }
    //coded by Feng
    public function isReservedVisitor($visitorId)
    {
        $this->db->select('*');
        $this->db->where('id', $visitorId);
        $this->db->from('tbl_reserved_visitors');
        $query = $this->db->get();
        if ($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    //coded by Feng
    public function resetExtensionForReservation($visitor_id)
    {
        $data = array('ext_times' => 0);
        $this->db->where('id', $visitor_id);
        return $this->db->update('tbl_reserved_visitors', $data);

    }
    public function passwordReset($mobile='', $password = '', $country_code = '')
    {
      $data = array('password' => $password);
      $this->db->where('mobile', $mobile);
      $this->db->where('country_code', $country_code);
      return $this->db->update('tbl_users', $data);
    }

    public function updateVisiter($id='', $status = '')
    {
      $data = array('status' => $status);
      $this->db->where('id', $id);
      return $this->db->update('tbl_visitors', $data);
    }

    public function addNewData($data)
    {
      return $this->db->insert('booking_request', $data);
    }

    public function updateToken($country_code = '', $mobile='', $token = '')
    {
      $this->db->where('country_code', $country_code);
      $this->db->where('mobile', $mobile);
      return $this->db->update('tbl_users', array('firebase_token' => $token));
    }



    public function getUserData($mobile='', $password = '')
    {
      $this->db->select('*');
      $this->db->from($this->userTable);
      $this->db->where('mobile', $mobile);
      $query = $this->db->get();
      $user = $query->result();
      if(!empty($user)){
          if(verifyHashedPassword($password, $user[0]->password)){
              return $user;
          } else {
              return array();
          }
      } else {
          return array();
      }
    }

    public function getUserDataById($id='')
    {
      $this->db->select('*');
      $this->db->from($this->userTable);
      $this->db->where('userId', $id);
      $query = $this->db->get();
      return $query->result();
    }

      public function userLogin($mobile, $password, $country_code)
      {
        $this->db->select('*');
        $this->db->from($this->userTable);
        $this->db->where('mobile', $mobile);
        $this->db->where('roleId', '3');
        $this->db->where('country_code', $country_code);
        $query = $this->db->get();

        $user = $query->result();
        if(!empty($user)){
            if(verifyHashedPassword($password, $user[0]->password)){
                return $user;
            } else {
                return false;
            }
        } else {
            return false;
        }
      }

      public function userAgentLogin($email, $password)
      {
        $this->db->select('*');
        $this->db->from($this->userTable);
        $this->db->where('email', $email);
        $this->db->where('roleId', '2');
        $query = $this->db->get();

        $user = $query->result();
        if(!empty($user)){
            if(verifyHashedPassword($password, $user[0]->password)){
                return $user;
            } else {
                return false;
            }
        } else {
            return false;
        }
      }


      public function userGuardLogin($email, $password)
      {
        $this->db->select('*');
        $this->db->from($this->userTable);
        $this->db->where('email', $email);
        $this->db->where('roleId', '4');
        $query = $this->db->get();

        $user = $query->result();
        if(!empty($user)){
            if(verifyHashedPassword($password, $user[0]->password)){
                return $user;
            } else {
                return false;
            }
        } else {
            return false;
        }
      }

      public function getAllUsersByAgentId($agentId)
      {
        $this->db->select('userId, fname, lname, country_code, mobile');
        $this->db->from($this->userTable);
        $this->db->where('agent_id', $agentId);
        $this->db->where('roleId', '3');
        $query = $this->db->get();
        return $query->result();
      }


	  function billDetails($id)
    {
        $this->db->select('tbl_bill_generated.*,tbl_users.fname,tbl_users.lname,tbl_users.email,tbl_users.full_address,tbl_bill_type.bill_title');
        $this->db->from('tbl_bill_generated');
        $this->db->join('tbl_users', 'tbl_users.userId = tbl_bill_generated.client_id');
        $this->db->join('tbl_bill_type', 'tbl_bill_type.id = tbl_bill_generated.bill_type');
        $this->db->where('tbl_bill_generated.id', $id);
        $query = $this->db->get();
        return $query->result();
    }

	function getSingleUserData($id)
    {
        $this->db->select('*');
        $this->db->from('tbl_users');
        $this->db->where('userId', $id);
        $query = $this->db->get();
		if ($query->num_rows() > 0) {
		  $data = $query->result();
		  return $data[0];
		}else {
		  return false;
		}
    }

    public function updateProfile($userId, $data)
      {
        $this->db->where('userId', $userId);
        return $this->db->update('tbl_users', $data);
      }

      function SingleProfile($id='')
      {
          $this->db->select('*');
          $this->db->from('tbl_users');
          $this->db->where('userId', $id);
          $query = $this->db->get();

         return $query->result();
      }

// =================================HRK==================================================

public function currentBills($id='')
{
  $this->db->select('tbl_bill_generated.*,tbl_bill_type.bill_title');
  $this->db->from('tbl_bill_generated');
  $this->db->join('tbl_bill_type', 'tbl_bill_generated.bill_type = tbl_bill_type.id');
  $this->db->where('tbl_bill_generated.client_id', $id);
  $this->db->where('MONTH(bill_generated_date)', date('m'));
  $query = $this->db->get();
  return $query->result();
}

public function previousBills($id='')
{
  $this->db->select('tbl_bill_generated.*,tbl_bill_type.bill_title');
  $this->db->from('tbl_bill_generated');
  $this->db->join('tbl_bill_type', 'tbl_bill_generated.bill_type = tbl_bill_type.id');
  $this->db->where('tbl_bill_generated.client_id', $id);
  $this->db->where('MONTH(bill_generated_date)', date('m')-1);
  $query = $this->db->get();
  return $query->result();
}



public function SingleBill($id='')
{
  $this->db->select('tbl_bill_generated.*,tbl_bill_type.bill_title as bill_type');
  $this->db->from('tbl_bill_generated');
  $this->db->join('tbl_bill_type', 'tbl_bill_generated.bill_type = tbl_bill_type.id');
  $this->db->where('tbl_bill_generated.id', $id);
  $query = $this->db->get();
  return $query->result();
}


public function notificationList($id='')
{
  $this->db->select('notifications.*,tbl_notification_type.title as type');
  $this->db->from('notifications');
  $this->db->join('tbl_notification_type', 'notifications.type = tbl_notification_type.id');
  $this->db->where('notifications.to', $id);
  $query = $this->db->get();
  return $query->result();
}


public function paymentHistory($id='')
{
  $this->db->select('tbl_payment_details.*, tbl_bill_type.bill_title');
  $this->db->from('tbl_payment_details');
  $this->db->join('tbl_bill_type', 'tbl_bill_type.id = tbl_payment_details.bill_type', 'LEFT');
  $this->db->where('tbl_payment_details.user_id', $id);
  $query = $this->db->get();
  return $query->result();
}

public function paymentDetails($id='')
{
  $this->db->select('tbl_payment_details.*,tbl_users.fname,tbl_users.lname');
  $this->db->from('tbl_payment_details');
  $this->db->join('tbl_users', 'tbl_users.userId = tbl_payment_details.user_id');
  $this->db->where('tbl_payment_details.id', $id);
  $query = $this->db->get();
  return $query->result();
}

public function addTransaction($data)
{
	$res = $this->db->insert('tbl_payment_details', $data);
   if($res){
	   return $this->db->insert_id();
   }else{
	   return false;
   }

}
public function paymentData($txnId)
{
	$this->db->select('*');
	$this->db->from('tbl_payment_details');
	$this->db->where('id', $txnId);
	$query = $this->db->get();
	if ($query->num_rows() > 0) {
	$data = $query->result();
	return $data[0];
	}else {
	return false;
	}
}

public function contactUsData($data)
{
  return $this->db->insert('tbl_contact_us', $data);
}

public function insertDistressRequest($data)
{
  $this->db->insert('tbl_distress', $data);
  $insert_id = $this->db->insert_id();
  return  $insert_id;
}

public function updateBillStatus($billId = '', $txnId = '')
{
  $this->db->where('id', $billId);
  return $this->db->update('tbl_bill_generated', array('status' => '1', 'txn_id' => $txnId));
}


public function updatePassword($user_id, $data)
{
  $this->db->where('userId', $user_id);
  return $this->db->update('tbl_users', $data);
}


function checkUser($id,$password)
{
    $this->db->select('*');
    $this->db->from($this->userTable);
    $this->db->where('userId', $id);
    $query = $this->db->get();

    $user = $query->result();
    if(!empty($user)){
        if(verifyHashedPassword($password, $user[0]->password)){
            return $user;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function checkEmailExist($email)
{
    $this->db->select('userId');
    $this->db->where('email', $email);
    $query = $this->db->get('tbl_users');
    if ($query->num_rows() > 0){
        return true;
    } else {
        return false;
    }
}

function resetPasswordUser($data)
{
    $result = $this->db->insert('tbl_reset_password', $data);

    if($result) {
        return TRUE;
    } else {
        return FALSE;
    }
}

function getCustomerInfoByEmail($email)
{
    $this->db->select('userId, email, fname');
    $this->db->from('tbl_users');
    $this->db->where('isDeleted', 0);
    $this->db->where('email', $email);
    $query = $this->db->get();

    return $query->result();
}



public function graphData($id='')
{
  $this->db->select('tbl_bill_generated.id,tbl_bill_generated.bill_month,tbl_bill_generated.bill_amount,tbl_bill_type.bill_title');
  $this->db->from('tbl_bill_generated');
  $this->db->join('tbl_bill_type', 'tbl_bill_generated.bill_type = tbl_bill_type.id');
  $this->db->where('tbl_bill_generated.client_id', $id);
  $this->db->where('MONTH(tbl_bill_generated.bill_generated_date) = MONTH(CURDATE())');
  $query = $this->db->get();
  return $query->result();
}

public function getCurrentMonthBillCount($id='')
{
  $this->db->select('tbl_bill_generated.id');
  $this->db->from('tbl_bill_generated');
  $this->db->join('tbl_bill_type', 'tbl_bill_generated.bill_type = tbl_bill_type.id');
  $this->db->where('tbl_bill_generated.client_id', $id);
  $this->db->where('MONTH(bill_generated_date)', date('m'));
  $query = $this->db->get();
  return $query->num_rows();
}


public function getPreviousMonthBillCount($id='')
{
  $this->db->select('tbl_bill_generated.id');
  $this->db->from('tbl_bill_generated');
  $this->db->join('tbl_bill_type', 'tbl_bill_generated.bill_type = tbl_bill_type.id');
  $this->db->where('tbl_bill_generated.client_id', $id);
  $this->db->where('MONTH(bill_generated_date)', date('m')-1);
  $query = $this->db->get();
  return $query->num_rows();
}

public function getPaymentsCount($id='')
{
  $this->db->select('tbl_payment_details.id');
  $this->db->from('tbl_payment_details');
  $this->db->join('tbl_users', 'tbl_users.userId = tbl_payment_details.user_id');
  $this->db->where('tbl_payment_details.user_id', $id);
  $query = $this->db->get();
  return $query->num_rows();
}

public function getNotificationsCount($id='')
{
  $this->db->select('notifications.id');
  $this->db->from('notifications');
  $this->db->join('tbl_notification_type', 'notifications.type = tbl_notification_type.id');
  $this->db->where('notifications.to', $id);
  $query = $this->db->get();
  return $query->num_rows();
}

public function getTotalBillCount($id='')
{
  $this->db->select('id');
  $this->db->from('tbl_bill_generated');
  $this->db->where('agent_id', $id);
  $this->db->where('MONTH(bill_generated_date)', date('m'));
  $query = $this->db->get();
  return $query->num_rows();
}

public function getPayedBillCount($id='')
{
  $this->db->select('id');
  $this->db->from('tbl_bill_generated');
  $this->db->where('agent_id', $id);
  $this->db->where('status', '1');
  $this->db->where('MONTH(bill_generated_date)', date('m'));
  $query = $this->db->get();
  return $query->num_rows();
}

public function getUnpayedBillCount($id='')
{
  $this->db->select('id');
  $this->db->from('tbl_bill_generated');
  $this->db->where('agent_id', $id);
  $this->db->where('status', '0');
  $this->db->where('MONTH(bill_generated_date)', date('m'));
  $query = $this->db->get();
  return $query->num_rows();
}

public function getDistressCount($id='')
{
  $this->db->select('id');
  $this->db->from('tbl_distress');
  $this->db->where('agent_id', $id);
  $this->db->where('MONTH(created)', date('m'));
  $query = $this->db->get();
  return $query->num_rows();
}

public function getContactCount($id='')
{
  $this->db->select('id');
  $this->db->from('tbl_contact_us');
  $this->db->where('agent_id', $id);
  $this->db->where('status', '0');
  $this->db->where('MONTH(created)', date('m'));
  $query = $this->db->get();
  return $query->num_rows();
}



public function getContactList($id='')
{
  $selectA = "A.id, A.subject as title, A.message, A.status, A.created as created_date, B.fname, B.lname, B.country_code, B.mobile";
  $sql = "SELECT ".$selectA." FROM tbl_contact_us A, tbl_users B WHERE B.userId = A.user_id AND A.agent_id = '$id' AND MONTH(created) = ".date('m')." ORDER BY A.id DESC";
  $query = $this->db->query($sql);
  return $query->result();
}


public function getDistressMessage($id='')
{
  $selectA = "A.*, B.fname, B.lname";
  $sql = "SELECT ".$selectA." FROM tbl_distress A, tbl_users B WHERE B.userId = A.user_id AND A.agent_id = '$id' AND MONTH(created) = ".date('m')." ORDER BY A.id DESC";
  $query = $this->db->query($sql);
  return $query->result();
}


function checkBillStatus(){
	$sql = "SELECT A.userId, A.fname, A.lname, A.fb_token FROM tbl_users A, tbl_bill_generated B WHERE A.userId = B.client_id AND B.status = '0'";
	$query = $this->db->query($sql);
    return $query->result();
}

 function getDestressbyId($notificationId, $agent_id)
{
	$this->db->select('tbl_distress.*,tbl_users.fname,tbl_users.lname');
	$this->db->from('tbl_distress');
	$this->db->join('tbl_users', 'tbl_users.userId = tbl_distress.user_id');
	$this->db->where('tbl_distress.agent_id', $agent_id);
	$this->db->where('tbl_distress.id', $notificationId);
	$query = $this->db->get();
	if ($query->num_rows() > 0) {
		  $data = $query->result();
		  return $data[0];
		}else {
		  return FALSE;
		}
}


function getUserTokens($userId)
  {
	  $this->db->select('fb_token');
      $this->db->select('userId');
      $this->db->from('tbl_users');
      $this->db->where('agent_id', $userId);
      $this->db->where('fb_token !=', '');
	  $this->db->group_by('fb_token');
      $query = $this->db->get();
    	if ($query->num_rows() > 0) {
    	  return $query->result();
    	}else {
    	  return array();
    	}
  }


    public function updateDestressbyId($id)
  {
      $this->db->where('id', $id);
      $res=$this->db->update('tbl_distress', array('status' => 1 ,'isAll'=>1));
      if($res == 1)
      return true;
      else
      return false;
  }


public function setVisitorEntry($data)
{
  $this->db->trans_start();
  $this->db->insert('tbl_visitors', $data);
  $insert_id = $this->db->insert_id();
  $this->db->trans_complete();
  return $insert_id;
}

public function getAllVisitors($guard_id='', $date = '')
{
    $this->db->select('*');
    $this->db->from('tbl_visitors');
    $this->db->where('guard_id', $guard_id);
    $this->db->where('date_in', $date);
    $this->db->where('status !=', '4');
    $this->db->order_by("id", 'desc');
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      return $query->result();
    }else {
      return array();
    }
}

public function getVisitorsCount($guard_id='', $date = '')
{
    $this->db->select('id');
    $this->db->from('tbl_visitors');
    $this->db->where('guard_id', $guard_id);
    $this->db->where('date_in', $date);
    $this->db->where('status !=', '4');
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      return $query->result();
    }else {
      return array();
    }
}

public function getVisiterDetail($id='')
{
    $this->db->select('*');
    $this->db->from('tbl_visitors');
    $this->db->where('id', $id);
    $this->db->order_by("id","desc");
    $query = $this->db->get();
    $data = $query->result();
    return $data[0];
}

public function getUserDetail($userId)
{
    $this->db->select('*');
    $this->db->from('tbl_users');
    $this->db->where('userId', $userId);
    $query = $this->db->get();
    $data = $query->result();
    return $data[0];
}

public function updateVisitorEntry($visitorId, $data)
{
  $this->db->where('id', $visitorId);
  return $this->db->update('tbl_visitors', $data);
}

public function getAllAgents()
{
  $this->db->select('userId');
  $this->db->from('tbl_users');
  $this->db->where('roleId', '2');
  $this->db->where('status', '1');
  $query = $this->db->get();
  $data = $query->result();
  $ids = array();
  foreach ($data as $key => $value) {
    $ids[] = $value->userId;
  }
  return $ids;
}

public function getUsersByAgent($agentId)
{
  $this->db->select('*');
  $this->db->from('tbl_users');
  $this->db->where('roleId', '3');
  $this->db->where('status', '1');
  $this->db->where('agent_id', $agentId);
  $query = $this->db->get();
  $data = $query->result();
  return $data;
}

public function getFixedBillByAgent($agentId='')
{
  $this->db->select('*');
  $this->db->from('tbl_bill_settings');
  $this->db->where('agent_id', $agentId);
  $query = $this->db->get();
  return $query->result();
}

public function getDueBillsOfUser($userId='')
{
  $this->db->select('SUM(total_amount) as total');
  $this->db->from('tbl_bill_generated');
  $this->db->where('client_id', $userId);
  $this->db->where('status', '0');
  $query = $this->db->get();
  $data = $query->result();
  return $data[0]->total;
}

}
