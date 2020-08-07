<?php

class Sliders_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getsliders($pagename)
    {
		$pagename = strtolower($pagename);
        $this->db->select('*');
        $this->db->from('sliders');
        $this->db->where('status','1');
        $this->db->where('slider_type',$pagename);
        $this->db->where('delete_status','0');
        $this->db->order_by('slider_possition','ASC');
		$query = $this->db->get();
		$response = array();
        if($query->num_rows()>0)
		{
			$response = $query->result_array();
		}
        return $response;
    }

    public function deleteSlider($id)
    {
		$updateArr = array();
		$updateArr['delete_status'] = '1';
        $this->db->where('slider_id', $id);
		$this->db->update('sliders',$updateArr);
    }

    public function setSlider($post,$referrer)
    {
		if($this->input->post())
		{
			$post = $this->input->post();
			if(!$_FILES)
			{
				$this->session->set_flashdata('result_error', 'Please select slider image!');
				redirect($referrer);
			}else{
				$result = $this->do_upload($referrer,'slider_image');
				$slider_image = $result['upload_data']['file_name'];
				$insertArr = array();
				$insertArr['slider_type'] = $post['slider_type'];
				$insertArr['slider_text'] = $post['slider_text'];
				$insertArr['slider_possition'] = $post['slider_possition'];
				$insertArr['slider_image'] = $slider_image;
				$insertArr['created_on'] = date('Y-m-d H:i:s');
				$insertArr['modify_date'] = date('Y-m-d H:i:s');
				if(!empty($insertArr))
				{
					if($this->commonmodel->_insert('sliders',$insertArr))
					{
						$this->session->set_flashdata('result_add','Slider has been added successfully!');
						redirect($referrer);
					}else{
						$this->session->set_flashdata('result_error','An error occured.Please try again later!');
						redirect($referrer);
					}
				}
			}
			//result_error;
		}
    }
	
	public function do_upload($referrer,$submited_name)
	{
		
		$filename = $_FILES[$submited_name]['name'];
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		
		$random_key = $this->random_key(10);
		$image_name =date("Ymdhis").$random_key.$ext;
		$folderPath = UPLOAD_PHYSICAL_PATH.'sliders/';
		if(!is_dir($folderPath))
		{
			mkdir($folderPath,777,true);
		}
		
		$config['file_name']         	= $image_name;
		$config['upload_path']          = $folderPath;
		$config['allowed_types']        = 'jpg|jpeg|png';
		$config['max_size']             = 2048;
		$config['max_width']            = 1366;
		$config['max_height']           = 420;
		$this->load->library('upload', $config);
		if(!$this->upload->do_upload($submited_name))
		{
			$this->session->set_flashdata('result_error',$this->upload->display_errors());
			redirect($referrer);
		}else{
			$data = array('upload_data' => $this->upload->data());
			return $data;
		}
	}

    public function changeSliderImage($post)
    {
        $slider_id = $this->input->post('slider_id');
		$response = array();
		if($slider_id!="")
		{
			if($_FILES['slider_image']['name']!="")
			{
				$result = $this->do_upload_by_ajax('slider_image');
				if($result['error']=='no')
				{
					$imgName = $result['upload_data']['file_name'];
					$arr = array();
					$arr['slider_image'] = $imgName;
					
					$this->db->where('slider_id',$slider_id);
					$this->db->update('sliders',$arr);
					$response['error'] = 'no';
					$response['msg'] = UPLOAD_URL.'sliders/'.$imgName;
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
		$folderPath = UPLOAD_PHYSICAL_PATH.'sliders/';
		if(!is_dir($folderPath))
		{
			mkdir($folderPath,777,true);
		}
		
		$config['file_name']         	= $image_name;
		$config['upload_path']          = $folderPath;
		$config['allowed_types']        = 'jpg|jpeg|png';
		$config['max_size']             = 2048;
		$config['max_width']            = 1366;
		$config['max_height']           = 420;
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

    public function updateSliderText($post)
    {
        $this->db->where('slider_id', $post['for_id']);
        if (!$this->db->update('sliders', array(
                    'slider_text' => $post['slider_text']
                ))) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
    }

    public function updateSliderPosition($post)
    {
        $this->db->where('slider_id', $post['editid']);
        if (!$this->db->update('sliders', array(
                    'slider_possition' => $post['new_pos']
                ))) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
    }

}
