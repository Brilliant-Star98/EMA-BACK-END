<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class BillGenerated_model extends CI_Model
{



    function getBillGeneratedData()
    {
        $this->db->select('tbl_bill_generated.*,tbl_users.fname,tbl_users.lname');
        $this->db->from('tbl_bill_generated');
        $this->db->join('tbl_users', 'tbl_users.userId = tbl_bill_generated.client_id');
        $this->db->where('tbl_bill_generated.agent_id', $this->session->userdata('userId'));
        $query = $this->db->get();
        return $query->result();
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


	function getUserData($id)
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



    function BillMonthData($mont)
    {
        $this->db->select('tbl_bill_generated.*,tbl_users.fname,tbl_users.lname');
        $this->db->from('tbl_bill_generated');
        $this->db->join('tbl_users', 'tbl_users.userId = tbl_bill_generated.client_id');
        $this->db->where('tbl_bill_generated.agent_id', $this->session->userdata('userId'));
        $this->db->where('YEAR(tbl_bill_generated.bill_month) = YEAR("'.$mont.'-01")');
        $this->db->where('MONTH(tbl_bill_generated.bill_month) = MONTH("'.$mont.'-01")');
        $query = $this->db->get();
        return $query->result();
    }

    function MonthPendingFilter($mont)
    {
        $this->db->select('tbl_bill_generated.*,tbl_users.fname,tbl_users.lname');
        $this->db->from('tbl_bill_generated');
        $this->db->join('tbl_users', 'tbl_users.userId = tbl_bill_generated.client_id');
        $this->db->where('tbl_bill_generated.agent_id', $this->session->userdata('userId'));
        $this->db->where('tbl_bill_generated.status', '0');
        $this->db->where('YEAR(tbl_bill_generated.bill_month) = YEAR("'.$mont.'-01")');
        $this->db->where('MONTH(tbl_bill_generated.bill_month) = MONTH("'.$mont.'-01")');
        $query = $this->db->get();
        return $query->result();
    }

    function MonthPaidFilter($mont)
    {
        $this->db->select('tbl_bill_generated.*,tbl_users.fname,tbl_users.lname');
        $this->db->from('tbl_bill_generated');
        $this->db->join('tbl_users', 'tbl_users.userId = tbl_bill_generated.client_id');
        $this->db->where('tbl_bill_generated.agent_id', $this->session->userdata('userId'));
        $this->db->where('tbl_bill_generated.status', '1');
        $this->db->where('YEAR(tbl_bill_generated.bill_month) = YEAR("'.$mont.'-01")');
        $this->db->where('MONTH(tbl_bill_generated.bill_month) = MONTH("'.$mont.'-01")');
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

    function MyBillType($id)
    {
        $this->db->select('*');
        $this->db->from('tbl_users');
        $this->db->where('userId', $id);
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
        $this->db->where('ismanual', '0');
        $this->db->where_in('id', $ids);
        $query = $this->db->get();
        return $query->result();
    }


    function getUser()
    {
        $this->db->select('*');
        $this->db->from('tbl_users');
        $this->db->where('roleId', '3');
        $this->db->where('agent_id', $this->session->userdata('userId'));
        $query = $this->db->get();
        return $query->result();
    }

    function getBillGeneratedSingle($id)
    {
      $this->db->select('tbl_bill_generated.*,tbl_users.fname,tbl_users.lname,tbl_users.email,tbl_users.full_address,tbl_bill_type.bill_title');
      $this->db->from('tbl_bill_generated');
      $this->db->join('tbl_users', 'tbl_users.userId = tbl_bill_generated.client_id');
      $this->db->join('tbl_bill_type', 'tbl_bill_type.id = tbl_bill_generated.bill_type');
      $this->db->where('tbl_bill_generated.id', $id);
      $query = $this->db->get();
      return $query->result();

        // $this->db->select('*');
        // $this->db->from('tbl_bill_generated');
        // $this->db->where('id', $id);
        // $query = $this->db->get();
        // return $query->result();
    }



    function addBillGenerated($userInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_bill_generated', $userInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }



    function getUserInfo($userId)
    {
        $this->db->select('*');
        $this->db->from('tbl_bill_generated');
        $this->db->where('id', $userId);
        $query = $this->db->get();
        return $query->result();
    }



    function UpdateUser($userInfo, $userId)
    {
        $this->db->where('id', $userId);
        $this->db->update('tbl_bill_generated', $userInfo);
        return TRUE;
    }



    public function deleteUser($id){
    $this->db->where('id', $id);
    $res = $this->db->delete('tbl_bill_generated');
    if($res == 1)
    return true;
    else
    return false;

  }

  public function deletePreviousBillSetting($userId='')
  {
    $this->db->where('agent_id', $userId);
    $res = $this->db->delete('tbl_bill_settings');
    if($res == 1)
    return true;
    else
    return false;
  }

  public function setBillSettingsAmount($dataInfo)
  {
    return $this->db->insert_batch('tbl_bill_settings', $dataInfo);
  }

  function getFixedBillType()
  {
      $userId = $this->session->userdata('userId');
      $this->db->select('A.*,B.amount, B.late_fee');
      $this->db->from('tbl_bill_type A');
      $this->db->join('tbl_bill_settings B', "A.id = B.bill_type_id AND B.agent_id = $userId", 'left');
    //  $this->db->where('B.agent_id', $userId);
      $this->db->where('A.ismanual', '1');
      $query = $this->db->get();
      return $query->result();
  }



}
