<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Visitors_model extends CI_Model
{
    public function getVisitorsData()
    {
		 $userId = $this->session->userdata('userId');
        $this->db->select('*');
        $this->db->from('tbl_visitors');
        $this->db->where('guard_id', $userId);
        $this->db->limit('20');
        $query = $this->db->get();
        return $query->result();
    }

    public function getVisitorsSingle($id)
    {
        $this->db->select('*');
        $this->db->from('tbl_visitors');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result();
    }



    public function addVisitors($userInfo) 
    {
        $this->db->trans_start();
        $this->db->insert('tbl_visitors', $userInfo);
        $insert_id = $this->db->insert_id(); 
        $this->db->trans_complete();
        return $insert_id;
    }



    public function getUserInfo($userId)
    {
        $this->db->select('*');
        $this->db->from('tbl_visitors');
        $this->db->where('id', $userId);
        $query = $this->db->get();
        return $query->result();
    }

    public function getUsersData()
    {
		$userId = $this->session->userdata('userId');
        $this->db->select('agent_id');
        $this->db->from('tbl_users');
        $this->db->where('userId', $userId);
        $query = $this->db->get();
        $data = $query->result();
		
		$agent_id = $data[0]->agent_id;
		$this->db->flush_cache();
		
		$this->db->select('*');
        $this->db->from('tbl_users');
        $this->db->where('agent_id', $agent_id);
        $this->db->where('status', '1');
        $this->db->where('roleId', '3');
        $query = $this->db->get();
        return $query->result();
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




    public function UpdateUser($userInfo, $userId)
    {
        $this->db->where('id', $userId);
        $this->db->update('tbl_visitors', $userInfo);
        return true;
    }



    public function deleteUser($id)
    {
        $this->db->where('id', $id);
        $res = $this->db->delete('tbl_visitors');
        if ($res == 1) {
            return true;
        } else {
            return false;
        }
    }
}
