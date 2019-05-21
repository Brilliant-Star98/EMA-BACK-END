<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Payment_model extends CI_Model
{



    function getPaymentData($id)
    {
        $this->db->select('tbl_payment_details.*,tbl_users.fname,tbl_users.lname');
        $this->db->from('tbl_payment_details');
        $this->db->join('tbl_users', 'tbl_users.userId = tbl_payment_details.user_id');
        $this->db->where('user_id', $id);
        $query = $this->db->get();
        return $query->result();
    }

    function getPaymentSingle($id)
    {
        $this->db->select('*');
        $this->db->from('tbl_payment_details');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result();
    }



    function getUserInfo($userId)
    {
        $this->db->select('*');
        $this->db->from('tbl_payment_details');
        $this->db->where('id', $userId);
        $query = $this->db->get();
        return $query->result();
    }



    public function deleteUser($id){
    $this->db->where('id', $id);
    $res = $this->db->delete('tbl_payment_details');
    if($res == 1)
    return true;
    else
    return false;

  }




}
