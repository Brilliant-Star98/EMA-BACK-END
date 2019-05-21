<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class SetNotification_model extends CI_Model
{



    function getSetNotificationData()
    {
        $this->db->select('notifications.*,tbl_users.fname,tbl_users.lname,tbl_notification_type.title as n_title');
        $this->db->from('notifications');
        $this->db->join('tbl_users', 'tbl_users.userId = notifications.to', 'left');
        $this->db->join('tbl_notification_type', 'tbl_notification_type.id = notifications.type');
        $this->db->where('notifications.from', $this->session->userdata('userId'));
        $query = $this->db->get();
        return $query->result();
    }

    function getDestressAlertRequests()
    {
        $this->db->select('tbl_distress.*,tbl_users.fname,tbl_users.lname');
        $this->db->from('tbl_distress');
        $this->db->join('tbl_users', 'tbl_users.userId = tbl_distress.user_id');
        $this->db->where('tbl_distress.agent_id', $this->session->userdata('userId'));
        $query = $this->db->get();
        return $query->result();
    }

    function getDestressbyId($notificationId)
    {
        $this->db->select('tbl_distress.*,tbl_users.fname,tbl_users.lname');
        $this->db->from('tbl_distress');
        $this->db->join('tbl_users', 'tbl_users.userId = tbl_distress.user_id');
        $this->db->where('tbl_distress.agent_id', $this->session->userdata('userId'));
        $this->db->where('tbl_distress.id', $notificationId);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
    		  $data = $query->result();
    		  return $data[0];
    		}else {
    		  return FALSE;
    		}
    }

    function SetNotification($id)
    {
        $this->db->select('*');
        $this->db->from('notifications');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result();
    }

    function getUserData($id)
    {
        $this->db->select('*');
        $this->db->from('tbl_users');
        $this->db->where('agent_id', $id);
        $query = $this->db->get();
        return $query->result();
    }

    function getBillType()
    {
        $this->db->select('*');
        $this->db->from('tbl_bill_type');
        $query = $this->db->get();
        return $query->result();
    }

    function TheBillType($ids)
    {
        $this->db->select('*');
        $this->db->from('tbl_bill_type');
        $this->db->where_in('id', $ids);
        $query = $this->db->get();
        return $query->result();
    }


    function NotificationType()
    {
        $this->db->select('*');
        $this->db->from('tbl_notification_type');
        $query = $this->db->get();
        return $query->result();
    }

    function getSetNotificationSingle($id)
    {
        $this->db->select('*');
        $this->db->from('notifications');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result();
    }



    function addSetNotification($userInfo)
    {
        $this->db->trans_start();
        $this->db->insert('notifications', $userInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }



    function getUserInfo($userId)
    {
        $this->db->select('*');
        $this->db->from('notifications');
        $this->db->where('id', $userId);
        $query = $this->db->get();
        return $query->result();
    }



    function UpdateUser($userInfo, $userId)
    {
        $this->db->where('id', $userId);
        $this->db->update('notifications', $userInfo);
        return TRUE;
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

	function getUserTokens()
  {
      $userId = $this->session->userdata('userId');
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



    public function deleteUser($id){
    $this->db->where('id', $id);
    $res = $this->db->delete('notifications');
    if($res == 1)
    return true;
    else
    return false;

  }

  public function deleteDistress($id)
  {
      $this->db->where('id', $id);
      $res = $this->db->delete('tbl_distress');
      if($res == 1)
      return true;
      else
      return false;
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




}
