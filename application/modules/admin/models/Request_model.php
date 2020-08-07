<?php

class Request_model extends CI_Model
{

    public function __construct() {
        parent::__construct();
    }

    
    public function requestList() {
        $this->db->select('*');
        $this->db->from('vendors');
        $this->db->where('status','1');
        $this->db->where('delete_status','0');
        $this->db->where('express_approve_status !=','NONE');
        $get=$this->db->get();
        //echo $this->db->last_query(); exit;
        if($get->num_rows()>0){
          $result=$get->result_array();
          return $result;
        }
        else {
          return '';
        }
    }

    public function acceptRequest($vendor_id,$status) {
      $vendor_id=base64_decode($vendor_id);
      $status=base64_decode($status);
      if($status!=''){
        $data=array('express_approve_status'=>$status);
        $this->db->where('id',$vendor_id);
        $this->db->update('vendors',$data);
      }
      else {
        $data=array('express_approve_status'=>'ACCEPT');
        $this->db->where('id',$vendor_id);
        $this->db->update('vendors',$data);
      }

        
    }

    public function rejectRequest($vendor_id,$status) {
      $vendor_id=base64_decode($vendor_id);
      $status=base64_decode($status);
      if($status!=''){
        $data=array('express_approve_status'=>$status);
        $this->db->where('id',$vendor_id);
        $this->db->update('vendors',$data);
      }
      else {
        $data=array('express_approve_status'=>'REJECT');
        $this->db->where('id',$vendor_id);
        $this->db->update('vendors',$data);
      }   
    }

    public function getCountries($vendor_id) {
       $this->db->select('c.*');
       $this->db->from('vendor_express_countries vec');
       $this->db->join('countries c','c.id=vec.country_id','left');
       $this->db->where('vec.vendor_id',$vendor_id);
       $this->db->where('vec.status','1');
       $this->db->group_by('c.name');
       $get=$this->db->get();
       if($get->num_rows()>0){
          $result=$get->result_array();
          return $result;
       }
       else {
          return '';
       }   
    }    
    
    

    

}
