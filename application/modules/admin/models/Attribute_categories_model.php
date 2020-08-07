<?php

class Attribute_categories_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function categoriesCount()
    {
		$this->db->where('attribute_type','size');
        return $this->db->count_all_results('attributes_categories');
    }

    public function categoriesColorCount()
    {
		$this->db->where('attribute_type','color');
        return $this->db->count_all_results('attributes_categories');
    }

    public function subCategoriesCount($category_id)
    {
		$this->db->where('size_category_id',$category_id);
        return $this->db->count_all_results('attributes_sub_categories');
    }

    public function getAttributeCategories($limit = null, $start = null)
    {
        $limit_sql = '';
        if ($limit !== null && $start !== null) {
            $limit_sql = ' LIMIT ' . $start . ',' . $limit;
        }
        $query = $this->db->query('SELECT * FROM attributes_categories WHERE attribute_type = "size" AND status = "1" AND delete_status = "0" ORDER BY position, category ASC ' . $limit_sql);
        $arr = $query->result_array();
        return $arr;
    }

    public function getColors($limit = null, $start = null)
    {
        $limit_sql = '';
        if ($limit !== null && $start !== null) {
            $limit_sql = ' LIMIT ' . $start . ',' . $limit;
        }
        $query = $this->db->query('SELECT * FROM attributes_categories WHERE attribute_type = "color" AND status = "1" AND delete_status = "0" ORDER BY position, category ASC ' . $limit_sql);
        $arr = $query->result_array();
        return $arr;
    }

    public function getAllAttributeCategories($attribute_type = 'size')
    {
        $query = $this->db->query('SELECT id,category,type,details FROM attributes_categories WHERE attribute_type = "'.$attribute_type.'" AND status = "1" AND delete_status = "0" ORDER BY position, category ASC ');
        $arr = $query->result_array();
		$response = array();
		foreach($arr as $categ)
		{
			$query1 = $this->db->query('SELECT id,size,size_category_id FROM attributes_sub_categories WHERE size_category_id = "'.$categ['id'].'" AND status = "1" AND delete_status = "0" ORDER BY size ASC ');
			$arr1 = $query1->result_array();
			$categ['sub_categories'] = $arr1;
			$response[] = $categ;
		}
        return $response;
    }

    public function getAllColorCategories()
    {
        $query = $this->db->query('SELECT id,category,type,details FROM attributes_categories WHERE attribute_type = "color" AND status = "1" AND delete_status = "0" ORDER BY position ASC , category ASC ');
        $response = $query->result_array();
        return $response;
    }

    public function getAttributeSubCategories($limit = null, $start = null, $category_id)
    {
        $limit_sql = '';
        if ($limit !== null && $start !== null) {
            $limit_sql = ' LIMIT ' . $start . ',' . $limit;
        }
        $query = $this->db->query('SELECT * FROM attributes_sub_categories WHERE size_category_id = "'.$category_id.'" AND status = "1" AND delete_status = "0" ORDER BY size ASC ' . $limit_sql);
        $arr = $query->result_array();
        return $arr;
    }

    public function deleteAttributeCategory($id)
    {
		$id = base64_decode($id);
        $this->db->where('id', $id);
        if (!$this->db->update('attributes_categories',array('delete_status'=>'1'))) {
            log_message('error', print_r($this->db->error(), true));
			show_error(lang('database_error'));
        }
    }

    public function deleteAttributeSubCategory($id)
    {
		$id = base64_decode($id);
        $this->db->where('id', $id);
        if (!$this->db->update('attributes_sub_categories',array('delete_status'=>'1'))) {
            log_message('error', print_r($this->db->error(), true));
			show_error(lang('database_error'));
        }
    }

    public function setAttributeCategory($post)
    {
		//pr($post,1);
		$arr = array();
		$arr['category'] = $post['categorie_name'];
		$arr['position'] = $post['position'];
		$arr['type'] = 'checkbox';
		$arr['attribute_type'] = 'size';
		
		if (!$this->db->insert('attributes_categories', $arr)) {
			log_message('error', print_r($this->db->error(), true));
		}
    }

    public function setAttributeSubCategory($post)
    {
		//pr($post,1);
		$arr = array();
		$arr['size'] = $post['categorie_name'];
		$arr['size_category_id'] = base64_decode($post['category_id']);
		$arr['create_date'] = date('Y-m-d H:i:s');
		$arr['modify_date'] = date('Y-m-d H:i:s');
		if (!$this->db->insert('attributes_sub_categories', $arr)) {
			log_message('error', print_r($this->db->error(), true));
		}
    }

    public function setColor($post)
    {
		//pr($post,1);
		$arr = array();
		$arr['category'] = $post['categorie_name'];
		$arr['details'] = $post['details'];
		$arr['position'] = $post['position'];
		$arr['type'] = 'checkbox';
		$arr['attribute_type'] = 'color';
		
		if (!$this->db->insert('attributes_categories', $arr)) {
			log_message('error', print_r($this->db->error(), true));
		}
    }
	
	public function do_upload($referrer,$submited_name)
	{
		
		$filename = $_FILES[$submited_name]['name'];
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		
		$random_key = $this->random_key(10);
		$image_name =date("Ymdhis").$random_key.$ext;
		$folderPath = UPLOAD_PHYSICAL_PATH.'categories/';
		if(!is_dir($folderPath))
		{
			mkdir($folderPath,777,true);
		}
		
		$config['file_name']         	= $image_name;
		$config['upload_path']          = $folderPath;
		$config['allowed_types']        = 'jpg|jpeg|png';
		$config['max_size']             = 1024;
		$config['max_width']            = 1024;
		$config['max_height']           = 768;
		$this->load->library('upload', $config);
		if(!$this->upload->do_upload($submited_name))
		{
			$this->session->set_flashdata('flashError',$this->upload->display_errors());
			redirect($referrer);
		}else{
			$data = array('upload_data' => $this->upload->data());
			return $data;
		}
	}

    public function updateCategoryImage($post)
    {
        $category_id = $this->input->post('category_id');
		$response = array();
		if($category_id!="")
		{
			if($_FILES['categorie_image']['name']!="")
			{
				$result = $this->do_upload_by_ajax('categorie_image');
				if($result['error']=='no')
				{
					$imgName = $result['upload_data']['file_name'];
					$arr = array();
					$arr['image'] = $imgName;
					
					$this->db->where('id',$category_id);
					$this->db->update('attributes_categories_translations',$arr);
					$response['error'] = 'no';
					$response['msg'] = UPLOAD_URL.'categories/'.$imgName;
				}else{
					$response['error'] = 'yes';
					$response['msg'] = $result['msg'];
				}
			}
		}else{
			$response['error'] = 'yes';
			$response['msg'] = 'Category id can not be blank.';
		}
		return $response;
    }
	
	public function do_upload_by_ajax($submited_name)
	{
		
		$filename = $_FILES[$submited_name]['name'];
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		
		$random_key = $this->random_key(10);
		$image_name =date("Ymdhis").$random_key.$ext;
		$folderPath = UPLOAD_PHYSICAL_PATH.'categories/';
		if(!is_dir($folderPath))
		{
			mkdir($folderPath,777,true);
		}
		
		$config['file_name']         	= $image_name;
		$config['upload_path']          = $folderPath;
		$config['allowed_types']        = 'jpg|jpeg|png';
		$config['max_size']             = 1024;
		$config['max_width']            = 1024;
		$config['max_height']           = 768;
		$this->load->library('upload', $config);
		if(!$this->upload->do_upload($submited_name))
		{
			$data = array('error' => 'yes','msg' => $this->upload->display_errors());
		}else{
			$data = array('error' => 'no','upload_data' => $this->upload->data());
		}
		return $data;
	}
	
	public function random_key($length=10)
	{
		$characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
		$email_token = '';
		for ($i = 0; $i < $length; $i++) {
			  $email_token .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $email_token;
	}

    public function editAttributeCategorySub($post)
    {
        $result = true;
        if ($post['editSubId'] != $post['newSubIs']) {
            $this->db->where('id', $post['editSubId']);
            if (!$this->db->update('attributes_categories', array(
                        'sub_for' => $post['newSubIs']
                    ))) {
                log_message('error', print_r($this->db->error(), true));
                show_error(lang('database_error'));
            }
        } else {
            $result = false;
        }
        return $result;
    }

    public function editAttrCategory($post)
    {
        $this->db->where('id', $post['for_id']);
        if (!$this->db->update('attributes_categories', array(
                    'category' => $post['name']
                ))) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
    }

    public function editAttrSubCategory($post)
    {
        $this->db->where('id', $post['for_id']);
        if (!$this->db->update('attributes_sub_categories', array(
                    'size' => $post['name']
                ))) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
    }

    public function editAttrCategoriePosition($post)
    {
        $this->db->where('id', $post['editid']);
        if (!$this->db->update('attributes_categories', array(
                    'position' => $post['new_pos']
                ))) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
    }

    public function editAttrCategorieColor($post)
    {
        $this->db->where('id', $post['editid']);
        if (!$this->db->update('attributes_categories', array(
                    'details' => $post['new_color']
                ))) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
    }

}
