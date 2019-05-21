<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class AddUser_model extends CI_Model
{


    /**
     * This function is used to get the user roles information
     * @return array $result : This is result of the query
     */
    function getAddUserData($id)
    {
        $this->db->select('*');
        $this->db->from('tbl_users');
        $this->db->where('roleId', '3');
        $this->db->where('userId', $id);
        $query = $this->db->get();
        return $query->result();
    }

    function getAddUserSingle($id)
    {
        $this->db->select('*');
        $this->db->from('tbl_users');
        $this->db->where('roleId', '3');
        $this->db->where('userId', $id);
        $query = $this->db->get();
        return $query->result();
    }

    function getBillType($id)
    {
        $this->db->select('*');
        $this->db->from('tbl_users');
        $this->db->where('userId', $id);
        $query = $this->db->get();
        return $query->result();
    }

    function BillType()
    {
        $this->db->select('*');
        $this->db->from('tbl_bill_type');
        $query = $this->db->get();
        return $query->result();
    }



    /**
     * This function is used to add new user to system
     * @return number $insert_id : This is last inserted id
     */

    function addNewUser($userInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_users', $userInfo);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert_id;
    }

    /**
     * This function used to get user information by id
     * @param number $userId : This is user id
     * @return array $result : This is user information
     */
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


    /**
     * This function is used to update the user information
     * @param array $userInfo : This is users updated information
     * @param number $userId : This is user id
     */
    function UpdateUser($userInfo, $userId)
    {
        $this->db->where('userId', $userId);
        $this->db->update('tbl_users', $userInfo);

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
