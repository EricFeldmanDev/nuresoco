<?php

class AboutUs_model extends CI_Model
{

    public function __construct() {
        parent::__construct();
    }

    
    public function getAboutData() {
        $query = $this->db->select('*')->get('about_page');
        return $query->result_array();
    }

    
    public function aboutPageUpdate($post) {          
         if(isset($post['image'])){     
            $data=array(
                'page_heading_1' => $post['page_title_1'],
                'description_1' => $post['desc1'],
                'page_heading_2' => $post['page_title_2'],
                'description_2' => $post['desc2'],
                'image' => $post['image']);
          } else {
             $data=array(
                'page_heading_1' => $post['page_title_1'],
                'description_1' => $post['desc1'],
                'page_heading_2' => $post['page_title_2'],
                'description_2' => $post['desc2']
             );
          }
         $this->db->where('id', $post['pageId']); 
            if(!$this->db->update('about_page', $data)) {
              log_message('error', print_r($this->db->error(), true));
              show_error(lang('database_error'));  
         }           
         $afftectedRows=$this->db->affected_rows();
         if($afftectedRows>0) return 1; else return 0;

       
    }

    public function getMultiContent(){
        $query = $this->db->select('*')->where('delete_status',0)->get('about_page_content');
        return $query->result_array();
    }

    public function editAboutContent($id){
        $query = $this->db->select('*')->where('id',$id)->get('about_page_content');
        return $query->result_array();   
    }

    public function updateAboutContent($post){
       $data=array('page_title'=>$post['page_title'],'description'=>$post['description'],'status'=>1,'delete_status'=>0,'created_at'=>date("Y-m-d H:i:s"),'updated_at'=>date("Y-m-d H:i:s"));
       $this->db->where('id',$post['pageId']);
       $this->db->update('about_page_content',$data);
       $aff=$this->db->affected_rows();
       if($aff==1) return 1; else return 0;
    
    }
    public function removeContent($id){
        $id=base64_decode($id);
        $data=array('delete_status'=>1);
        $this->db->where('id',$id);
        $this->db->update('about_page_content',$data);
        $aff=$this->db->affected_rows();
        if($aff==1) return 1; else return 0;    
    }


    public function addPage($post){
        $data=array('page_title'=>$post['page_title'],'description'=>$post['description'],'status'=>1,'delete_status'=>0,'created_at'=>date("Y-m-d H:i:s"),'updated_at'=>date("Y-m-d H:i:s"));
      //  print_r($data);
        $qry=$this->db->insert('about_page_content',$data);
        if(isset($qry)) return 1; else return 0;     
    }
    

}
