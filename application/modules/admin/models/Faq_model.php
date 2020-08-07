<?php

class Faq_model extends CI_Model
{

    public function __construct() {
        parent::__construct();
    }

    
    public function getContent() {
        $query = $this->db->select('*')->where('delete_status',0)->get('faq_content');
        return $query->result_array();
    }

    public function addFAQ($post){
        $data=array('page_title'=>$post['page_title'],'description'=>$post['description'],'status'=>1,'delete_status'=>0,'created_at'=>date("Y-m-d H:i:s"),'updated_at'=>date("Y-m-d H:i:s"));
      //  print_r($data);
        $qry=$this->db->insert('faq_content',$data);
        if(isset($qry)) return 1; else return 0;     
    }

    public function removeFAQ($id){
        $id=base64_decode($id);
        $data=array('delete_status'=>1);
        $this->db->where('id',$id);
        $this->db->update('faq_content',$data);
        $aff=$this->db->affected_rows();
        if($aff==1) return 1; else return 0;    
    }

    public function updateFAQ($post){
       $data=array('page_title'=>$post['page_title'],'description'=>$post['description'],'status'=>1,'delete_status'=>0,'created_at'=>date("Y-m-d H:i:s"),'updated_at'=>date("Y-m-d H:i:s"));
       $this->db->where('id',$post['pageId']);
       $this->db->update('faq_content',$data);
       $aff=$this->db->affected_rows();
       if($aff==1) return 1; else return 0;
    
    }

    public function getFAQbyId($id){
        $query = $this->db->select('*')->where('id',$id)->get('faq_content');
        return $query->result_array();   
    }

    
}
