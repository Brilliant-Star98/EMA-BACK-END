<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class UserApproval_model extends CI_Model
{


    function getUserApprovalData($id)
    {
        $this->db->select('*');
        $this->db->from('tbl_users');
        $this->db->where('roleId', '3');
        $this->db->where('status', '1');
        $this->db->where('agent_id', $id);
        $query = $this->db->get();
        return $query->result();
    }

    function getPendingUserData($id)
    {
        $this->db->select('*');
        $this->db->from('tbl_users');
        $this->db->where('roleId', '3');
        $this->db->where('status', '0');
        $this->db->where('agent_id', $id);
        $query = $this->db->get();
        return $query->result();
    }


    function getblockedUserData($id)
    {
        $this->db->select('*');
        $this->db->from('tbl_users');
        $this->db->where('roleId', '3');
        $this->db->where('status', '2');
        $this->db->where('agent_id', $id);
        $query = $this->db->get();
        return $query->result();
    }

    function getAgentSingle($id)
    {
        $this->db->select('*');
        $this->db->from('tbl_users');
        $this->db->where('roleId', '2');
        $this->db->where('userId', $id);
        $query = $this->db->get();
        return $query->result();
    }

    function addNewUser($userInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_users', $userInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    function getUserInfo($userId)
    {
        $this->db->select('*');
        $this->db->from('tbl_users');
        $this->db->where('isDeleted', 0);
		    $this->db->where('roleId !=', 1);
        $this->db->where('userId', $userId);
        $query = $this->db->get();
        return $query->result();
    }

    function BlockUserNow($userId)
    {
        $Info = array('status'=>'2');
        $this->db->where('userId', $userId);
        $this->db->update('tbl_users', $Info);
        return TRUE;
    }

    function approveNow($userId)
    {
        $Info = array('status'=>'1');
        $this->db->where('userId', $userId);
        $this->db->update('tbl_users', $Info);
        return TRUE;
    }

    public function deleteUser($id){
    $this->db->where('userId', $id);
    $res = $this->db->delete('tbl_users');
    if($res == 1)
    return true;
    else
    return false;
  }



}
