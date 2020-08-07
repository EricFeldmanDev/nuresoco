<?php

class Textual_pages_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getOnePageForEdit($pname)
    {
        $this->db->join('textual_pages_tanslations', 'textual_pages_tanslations.for_id = active_pages.id', 'left');
        $this->db->join('languages', 'textual_pages_tanslations.abbr = languages.abbr', 'left'); 
        $this->db->where('active_pages.enabled', 1);
        $this->db->where('active_pages.name', $pname);
        $query = $this->db->select('active_pages.id, textual_pages_tanslations.description, textual_pages_tanslations.abbr, textual_pages_tanslations.name, languages.name as lname, languages.flag')->get('active_pages');
        return $query->result_array();
    }

   /* public function getCMSPageForEdit()
    {
        $query = $this->db->select('*')->get('about_page');
        return $query->result_array();
    }*/

    public function setEditPageTranslations($post)
    {
        $i = 0;
        foreach ($post['translations'] as $abbr) {
            $this->db->where('abbr', $abbr);
            $this->db->where('for_id', $post['pageId']); 
            if (!$this->db->update('textual_pages_tanslations', array(
                        'name' => $post['name'][$i],
                        'description' => $post['description'][$i]
                    ))) {
                log_message('error', print_r($this->db->error(), true));
                show_error(lang('database_error'));
            }
            $i++;
        }
    }

    /*public function setEditCMSPageTranslations($post)
    {          

             if(isset($post['image'])){
                    
                $data=array(
                    'page_heading_1' => $post['page_title_1'],
                    'description_1' => $post['desc1'],
                    'page_heading_2' => $post['page_title_2'],
                    'description_2' => $post['desc2'],
                    'image' => $post['image']);
              }
              else {
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

       
    }*/

    public function changePageStatus($id, $to_status)
    {
        $result = $this->db->where('id', $id)->update('active_pages', array('enabled' => $to_status));
        return $result;
    }

}
