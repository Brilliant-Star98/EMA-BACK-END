<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class BillType_model extends CI_Model
{



    function getBillTypeData()
    {
        $this->db->select('*');
        $this->db->from('tbl_bill_type');
        $query = $this->db->get();
        return $query->result();
    }

    function getBillTypeSingle($id)
    {
        $this->db->select('*');
        $this->db->from('tbl_bill_type');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result();
    }



    function addBillType($userInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_bill_type', $userInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }



    function getUserInfo($userId)
    {
        $this->db->select('*');
        $this->db->from('tbl_bill_type');
        $this->db->where('id', $userId);
        $query = $this->db->get();
        return $query->result();
    }



    function UpdateUser($userInfo, $userId)
    {
        $this->db->where('id', $userId);
        $this->db->update('tbl_bill_type', $userInfo);
        return TRUE;
    }



    public function deleteUser($id){
    $this->db->where('id', $id);
    $res = $this->db->delete('tbl_bill_type');
    if($res == 1)
    return true;
    else
    return false;

  }




}
