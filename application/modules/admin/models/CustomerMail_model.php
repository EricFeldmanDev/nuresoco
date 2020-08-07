<?php

class CustomerMail_model extends CI_Model
{

    public function __construct() {
        parent::__construct();
    }

    
    /*public function get_mails() {
        //$this->db->limit($limit, $start);
        $this->db->where('delete_status','0');
        $query = $this->db->get("customer_support");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }*/

    public function get_mails($limit, $start)  {   
        $this->db->limit($limit, $start);
        $this->db->where('delete_status','0');
        $query = $this->db->get("customer_support");
        if ($query->num_rows() > 0)  {
            foreach ($query->result() as $row){
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function total_mails() {
        $query = $this->db->select('*')->where('delete_status','0')->get('customer_support');
        return $query->num_rows();
       
    }

    public function removeData($id){
        $id=base64_decode($id);
        $data=array('delete_status'=>1);
        $this->db->where('id',$id);
        $this->db->update('customer_support',$data);
        $aff=$this->db->affected_rows();
        if($aff==1) return 1; else return 0;    
    }

    

    
    

}
