<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Notification_model extends CI_Model
{



    function getNotificationData()
    {
        $this->db->select('*');
        $this->db->from('tbl_notification_type');
        $query = $this->db->get();
        return $query->result();
    }

    function getNotificationSingle($id)
    {
        $this->db->select('*');
        $this->db->from('tbl_notification_type');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result();
    }



    function addNotification($userInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_notification_type', $userInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }



    function getUserInfo($userId)
    {
        $this->db->select('*');
        $this->db->from('tbl_notification_type');
        $this->db->where('id', $userId);
        $query = $this->db->get();
        return $query->result();
    }



    function UpdateUser($userInfo, $userId)
    {
        $this->db->where('id', $userId);
        $this->db->update('tbl_notification_type', $userInfo);
        return TRUE;
    }



    public function deleteUser($id){
    $this->db->where('id', $id);
    $res = $this->db->delete('tbl_notification_type');
    if($res == 1)
    return true;
    else
    return false;

  }




}
