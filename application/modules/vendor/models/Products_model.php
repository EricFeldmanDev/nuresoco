<?php

class Products_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }
    
    public function getProductDetails($product_id) {
	
		$this->db->select('p.*,pi.image');
		$this->db->join('product_images pi','pi.pi_id=p.main_image_id','LEFT');
        $this->db->where('p.status', '1');
        $this->db->where('p.product_id',$product_id);
        $query = $this->db->get('products p');
        //echo $this->db->last_query();die();
		$response = array();
		if($query->num_rows()>0)
		{
			$productData = $query->row_array();
			//print_r($productData);die();
			$productData['additional_images'] = array();
			$this->db->select('pi.pi_id,pi.image');
			$this->db->from('product_additional_images_mapping paim');
			$this->db->join('product_images pi','pi.pi_id = paim.pi_id','LEFT');
			$this->db->where('paim.status','1');
			$this->db->where('paim.delete_status','1');
			$this->db->where('pi.status','1');
			$this->db->where('pi.delete_status','0');
			$this->db->where('paim.product_id',$product_id);
			$query1 = $this->db->get();
			
			if($query1->num_rows()>0)
			{
				$productData['additional_images'] = $query1->result_array();
			}
			
			$productData['tags'] = array();
			$this->db->select('pt.product_tag_id,pt.tag_id,t.tag');
			$this->db->from('product_tags pt');
			$this->db->join('tags t','t.tag_id = pt.tag_id','LEFT');
			$this->db->where('t.status','1');
			$this->db->where('t.delete_status','0');
			$this->db->where('pt.status','1');
			$this->db->where('pt.delete_status','0');
			$this->db->where('pt.product_id',$product_id);
			$query2 = $this->db->get();
			
			if($query2->num_rows()>0)
			{
				$productData['tags'] = $query2->result_array();
			}
			return $productData;
		}else{
			return '';
		}
    }

    public function getTags($tags)
    {
        $this->db->select("tag,tag_id");
        $this->db->where("tag LIKE '%$tags%'");
        $this->db->where('status', '1');
        $this->db->where('delete_status', '0');
        $query = $this->db->get('tags');
        if ($query->num_rows() > 0) {
			$responseHtml = '<span>disabled</span>
								<ul>';
			$response = $query->result_array();
			foreach($response as $tag)
			{
				$responseHtml .= '<li data-tag-val="'.$tag['tag'].'" data-tag-id="'.$tag['tag_id'].'">'.$tag['tag'].'</li>';
			}
			$responseHtml .= '</ul>';
            return $responseHtml;
        } else {
			$responseHtml = '<span>disabled</span>
								<ul>';
			$responseHtml .= '<li class="active" data-tag-val="'.$tags.'" data-tag-id="0">No tags found, CLICK here to create tag </li>';
			$responseHtml .= '</ul>';
            return $responseHtml;
        }
    }

    public function uploadProductImage($vendor_id='',$post)
    {
		$userEmail = $this->session->userdata('logged_vendor');
		$response = array();
		if($vendor_id!="")
		{
			if($_FILES['product_image']['name']!="")
			{
				$result = $this->do_upload_by_ajax('product_image');
				if($result['error']=='no')
				{
					$imgName = $result['upload_data']['file_name'];
					$this->resizeImage($imgName);

					$arr = array();
					$arr['image'] = $imgName;
					$arr['type'] = $post['type'];
					
					$this->db->insert('product_images',$arr);
					$imgId = $this->db->insert_id();
					
					$response['error'] = 'no';
					$response['msg'] = UPLOAD_URL.'product-images/'.$imgName;
					$response['imageId'] = $imgId;
				}else{
					$response['error'] = 'yes';
					$response['msg'] = $result['msg'];
				}
			}
		}else{
			$response['error'] = 'yes';
			$response['msg'] = 'User id can not be blank.';
		}
		return $response;
    }

    
    
	public function do_upload_by_ajax($submited_name)
	{
		
		$filename = $_FILES[$submited_name]['name'];
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		
		$random_key = $this->random_key(10);
		$image_name =date("Ymdhis").$random_key.$ext;
		$folderPath = UPLOAD_PHYSICAL_PATH.'product-images/';
		if(!is_dir($folderPath))
		{
			mkdir($folderPath,777,true);
		}
		
		$config['file_name']         	= $image_name;
		$config['upload_path']          = $folderPath;
		$config['allowed_types']        = 'jpg|jpeg|png';
/*		$config['max_size']             = 1024;
		$config['max_width']            = 800;
		$config['max_height']           = 800;
		$config['min_width']            = 800;
		$config['min_height']           = 800;*/
		$this->load->library('upload', $config);
		if(!$this->upload->do_upload($submited_name))
		{
			$data = array('error' => 'yes','msg' => $this->upload->display_errors());
		}else{
			$data = array('error' => 'no','upload_data' => $this->upload->data());
		}
		return $data;
	}

	 /**
    * Manage uploadImage
    *
    * @return Response
   */
  	public function resizeImage($filename)
  	{
		$size = '300';
	   	$source_path = UPLOAD_PHYSICAL_PATH.'product-images/'. $filename;
	   	$target_path = UPLOAD_PHYSICAL_PATH.'product-images/small'.$size.'/';
	   	$marker = '_'.$size.'x'.$size;
	   	$is_error = false;
	   	$config_manip = array(
		   'image_library' => 'gd2',
		   'source_image' => $source_path,
		   'new_image' => $target_path,
		   'maintain_ratio' => TRUE,
		   'create_thumb' => TRUE,
		   'thumb_marker' => $marker,
		   'width' => $size,
		   'height' => $size
	   	);

	   	$this->load->library('image_lib');
	   	$this->image_lib->initialize($config_manip);	   	
	   
	   	if (!$this->image_lib->resize()) {
		   $is_error = true;//$this->image_lib->display_errors();
	   	}
	   	if(!$is_error) {

		    $this->image_lib->clear();
		
    		$size = '100';
    		$target_path = UPLOAD_PHYSICAL_PATH.'product-images/small'.$size.'/';
    		$marker = '_'.$size.'x'.$size;
    		$config_manip['new_image'] = $target_path;
    		$config_manip['thumb_marker'] = $marker;
    		$config_manip['width'] = $size;
    		$config_manip['height'] = $size;
    		
    	   	$this->image_lib->initialize($config_manip);	   	
    	   
    	   	if (!$this->image_lib->resize()) {
    		   //$this->image_lib->display_errors();
    		   $is_error = true;
    	   	}
    
    		$this->image_lib->clear();
	   	}
	   	return $is_error;
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
	
	public function add_product($post,$vendor_id)
	{
		//pr($post,1);
		$insertArr = array();
		$insertArr['vendor_id'] 	= 	$vendor_id;
		$insertArr['product_name'] 	= 	$post['product_name'];
		$insertArr['category_id'] 	= 	$post['category_id'];
		$insertArr['description'] 	= 	$post['description'];
		$insertArr['unique_id'] 	= 	$post['unique_id'];
		$insertArr['main_image_id'] = 	$post['main_image_id'];
		$insertArr['price'] 		= 	$post['price'];
		$insertArr['quantity']		= 	$post['quantity'];
		$insertArr['shipping_type'] = 	$post['shipping_type'];
		if($post['shipping_type']=='free')
		{
			$insertArr['shipping'] 		= 	0;
		}else{
			$insertArr['shipping'] 		= 	$post['shipping'];
		}
		$insertArr['earnings'] 		= 	$post['earnings'];
		$insertArr['shipping_time'] = 	$post['shipping_time'];
		if($post['shipping_time']=='')
		{
			$updateArr['min_estimate'] 	= 	$post['min_estimate'];
			$updateArr['max_estimate'] 	= 	$post['max_estimate'];
		}else{
			$updateArr['min_estimate'] 	= 	0;
			$updateArr['max_estimate'] 	= 	0;
		}
		$insertArr['min_estimate'] 	= 	$post['min_estimate'];
		$insertArr['max_estimate'] 	= 	$post['max_estimate'];
		$insertArr['default_declared_name'] 	= 	$post['default_declared_name'];
		$insertArr['default_local_name']		= 	$post['default_local_name'];
		$insertArr['default_pieces_included'] 	= 	$post['default_pieces_included'];
		$insertArr['default_package_length'] 	= 	$post['default_package_length'];
		$insertArr['default_package_width'] 	= 	$post['default_package_width'];
		$insertArr['default_package_height'] 	= 	$post['default_package_height'];
		$insertArr['default_package_weight'] 	=	$post['default_package_weight'];
		$insertArr['default_country_of_origin'] 	= 	$post['default_country_of_origin'];
		$insertArr['default_custom_hs_code'] 	= 	$post['default_custom_hs_code'];
		$insertArr['default_custom_declared_value'] = 	$post['default_custom_declared_value'];
		$insertArr['default_contains_powder'] 	= 	$post['default_contains_powder'];
		$insertArr['default_contains_liquid'] 	= 	$post['default_contains_liquid'];
		$insertArr['default_contains_battery'] 	= 	$post['default_contains_battery'];
		$insertArr['default_contains_metal'] 	= 	$post['default_contains_metal'];
		$insertArr['msrp'] 			= 	$post['msrp'];
		$insertArr['brand'] 		= 	$post['brand'];
		$insertArr['upc'] 			= 	$post['upc'];
		$insertArr['approval_status'] 			= 	'APPROVED';
		$insertArr['max_quantity'] 	= 	$post['max_quantity'];
		$insertArr['landing_page_url'] = 	$post['landing_page_url'];
		if($post['express_required']!='' && $post['express_required']=='express' )
		{			
			$insertArr['nureso_express_status'] = '1';
		}
		$insertArr['created_on'] 	= date('Y-m-d H:i:s');
		$insertArr['modify_on'] 	= date('Y-m-d H:i:s');
		
		$this->db->insert('products',$insertArr);
		//$product_id = 10;
		$product_id = $this->db->insert_id();
		if($product_id)
		{
			$tags =	$post['tags'];
			if($tags!='')
			{
				$allTags = explode(',',$tags);
				foreach($allTags as $tag)
				{
					$previousTagId = $this->getPreviousTag($tag);
					if($previousTagId<1)
					{
						$insertTags = array();
						$insertTags['tag'] = $tag;
						$insertTags['created_on'] = date('Y-m-d H:i:s');
						$insertTags['modify_on'] = date('Y-m-d H:i:s');
						$tag_id = $this->commonmodel->_insert('tags',$insertTags);
						
						$insertProductTagArr = array();
						$insertProductTagArr['tag_id'] = $tag_id;
						$insertProductTagArr['product_id'] = $product_id;
						$insertTags['created_on'] = date('Y-m-d H:i:s');
						$insertTags['modify_on'] = date('Y-m-d H:i:s');
						$this->commonmodel->_insert('product_tags',$insertProductTagArr);
					}else{
						$insertProductTagArr = array();
						$insertProductTagArr['tag_id'] = $previousTagId;
						$insertProductTagArr['product_id'] = $product_id;
						$insertTags['created_on'] = date('Y-m-d H:i:s');
						$insertTags['modify_on'] = date('Y-m-d H:i:s');
						$this->commonmodel->_insert('product_tags',$insertProductTagArr);
					}
				}
			}
			
			$additional_image = $post['additional_image'];
			if(!empty($additional_image))
			{
				$finalImgArr = array();
				foreach($additional_image as $imgId)
				{
					if($imgId!='' && $imgId!=0)
					{
						$tempImgArr = array();
						$tempImgArr['product_id'] = $product_id;
						$tempImgArr['pi_id'] = $imgId;
						$tempImgArr['created_on'] = date('Y-m-d H:i:s');
						$tempImgArr['modify_on'] = date('Y-m-d H:i:s');
						$finalImgArr[] = $tempImgArr;
					}
				}
				if(!empty($finalImgArr))
				{
					$this->db->insert_batch('product_additional_images_mapping',$finalImgArr);
				}
			}
			
			if(isset($post['size_color']))
			{
				if(!empty($post['size_color']))
				{
					$size_colors = $post['size_color'];
					$finalSizeColorArr = array();
					foreach($size_colors as $size_id => $size_color)
					{
						foreach($size_color as $color_id => $size_color_data)
						{
							$tempSizeColorArr = array();
							$tempSizeColorArr['product_id'] 			= 	$product_id;
							$tempSizeColorArr['vendor_id'] 				= 	$vendor_id;
							$tempSizeColorArr['size_id'] 				= 	$size_id;
							$tempSizeColorArr['color_id'] 				= 	$color_id;
							$tempSizeColorArr['variations_unique_id'] 	= 	$size_color_data['variations_unique_id'];
							$tempSizeColorArr['variations_price'] 		=	$size_color_data['variations_price'];
							$tempSizeColorArr['quantity'] 			  	=	$size_color_data['quantity'];
							$tempSizeColorArr['variations_earnings'] 	=	$size_color_data['variations_earnings'];
							$tempSizeColorArr['logistic_detail'] 		= 	$size_color_data['logistic_detail'];
							$tempSizeColorArr['declared_name'] 			= 	$size_color_data['declared_name'];
							$tempSizeColorArr['local_name']				= 	$size_color_data['local_name'];
							$tempSizeColorArr['pieces_included'] 		= 	$size_color_data['pieces_included'];
							$tempSizeColorArr['package_length'] 		= 	$size_color_data['package_length'];
							$tempSizeColorArr['package_width'] 			= 	$size_color_data['package_width'];
							$tempSizeColorArr['package_height'] 		= 	$size_color_data['package_height'];
							$tempSizeColorArr['package_weight'] 		=	$size_color_data['package_weight'];
							$tempSizeColorArr['package_weight'] 		= 	$size_color_data['country_of_origin'];
							$tempSizeColorArr['custom_hs_code'] 		= 	$size_color_data['custom_hs_code'];
							$tempSizeColorArr['custom_declared_value'] 	= 	$size_color_data['custom_declared_value'];
							$tempSizeColorArr['contains_powder'] 		= 	$size_color_data['contains_powder'];
							$tempSizeColorArr['contains_liquid'] 		= 	$size_color_data['contains_liquid'];
							$tempSizeColorArr['contains_battery'] 		= 	$size_color_data['contains_battery'];
							$tempSizeColorArr['contains_battery'] 		= 	$size_color_data['contains_battery'];
							$tempSizeColorArr['created_on'] 			= 	date('Y-m-d H:i:s');
							$tempSizeColorArr['modify_on'] 				= 	date('Y-m-d H:i:s');
							$finalSizeColorArr[] 						= 	$tempSizeColorArr;
						}
					}
					//pr($finalSizeColorArr,1);
					if(!empty($finalSizeColorArr))
					{
						$this->db->insert_batch('product_size_color',$finalSizeColorArr);
					}
				}
			}elseif(isset($post['size']))
			{
				if(!empty($post['size']))
				{
					$sizes = $post['size'];
					$finalSizeArr = array();
					foreach($sizes as $size_id => $size)
					{
						$tempSizeArr = array();
						$tempSizeArr['product_id'] 				= 	$product_id;
						$tempSizeArr['vendor_id'] 				= 	$vendor_id;
						$tempSizeArr['size_id'] 				= 	$size_id;
						$tempSizeArr['variations_unique_id'] 	= 	$size['variations_unique_id'];
						$tempSizeArr['variations_price'] 		=	$size['variations_price'];
						$tempSizeArr['quantity'] 			  	=	$size['quantity'];
						$tempSizeArr['logistic_detail'] 		= 	$size['logistic_detail'];
						$tempSizeArr['declared_name'] 			= 	$size['declared_name'];
						$tempSizeArr['local_name']				= 	$size['local_name'];
						$tempSizeArr['pieces_included'] 		= 	$size['pieces_included'];
						$tempSizeArr['package_length'] 			= 	$size['package_length'];
						$tempSizeArr['package_width'] 			= 	$size['package_width'];
						$tempSizeArr['package_height'] 			= 	$size['package_height'];
						$tempSizeArr['package_weight'] 			=	$size['package_weight'];
						$tempSizeArr['package_weight'] 			= 	$size['country_of_origin'];
						$tempSizeArr['custom_hs_code'] 			= 	$size['custom_hs_code'];
						$tempSizeArr['custom_declared_value'] 	= 	$size['custom_declared_value'];
						$tempSizeArr['contains_powder'] 		= 	$size['contains_powder'];
						$tempSizeArr['contains_liquid'] 		= 	$size['contains_liquid'];
						$tempSizeArr['contains_battery'] 		= 	$size['contains_battery'];
						$tempSizeArr['contains_battery'] 		= 	$size['contains_battery'];
						$tempSizeArr['created_on'] 				= 	date('Y-m-d H:i:s');
						$tempSizeArr['modify_on'] 				= 	date('Y-m-d H:i:s');
						$finalSizeArr[] 						= 	$tempSizeArr;
					}
					if(!empty($finalSizeArr))
					{
						$this->db->insert_batch('product_size_color',$finalSizeArr);
					}
				}
			}elseif(isset($post['color']))
			{
				if(!empty($post['color']))
				{
					$colors = $post['color'];
					$finalSizeArr = array();
					foreach($colors as $color_id => $color)
					{
						$tempSizeArr = array();
						$tempSizeArr['product_id'] 				= 	$product_id;
						$tempSizeArr['vendor_id'] 				= 	$vendor_id;
						$tempSizeArr['color_id'] 				= 	$color_id;
						$tempSizeArr['variations_unique_id'] 	= 	$color['variations_unique_id'];
						$tempSizeArr['variations_price'] 		=	$color['variations_price'];
						$tempSizeArr['quantity'] 			  	=	$color['quantity'];
						$tempSizeArr['logistic_detail'] 		= 	$color['logistic_detail'];
						$tempSizeArr['declared_name'] 			= 	$color['declared_name'];
						$tempSizeArr['local_name']				= 	$color['local_name'];
						$tempSizeArr['pieces_included'] 		= 	$color['pieces_included'];
						$tempSizeArr['package_length'] 			= 	$color['package_length'];
						$tempSizeArr['package_width'] 			= 	$color['package_width'];
						$tempSizeArr['package_height'] 			= 	$color['package_height'];
						$tempSizeArr['package_weight'] 			=	$color['package_weight'];
						$tempSizeArr['package_weight'] 			= 	$color['country_of_origin'];
						$tempSizeArr['custom_hs_code'] 			= 	$color['custom_hs_code'];
						$tempSizeArr['custom_declared_value'] 	= 	$color['custom_declared_value'];
						$tempSizeArr['contains_powder'] 		= 	$color['contains_powder'];
						$tempSizeArr['contains_liquid'] 		= 	$color['contains_liquid'];
						$tempSizeArr['contains_battery'] 		= 	$color['contains_battery'];
						$tempSizeArr['contains_battery'] 		= 	$color['contains_battery'];
						$tempSizeArr['created_on'] 				= 	date('Y-m-d H:i:s');
						$tempSizeArr['modify_on'] 				= 	date('Y-m-d H:i:s');
						$finalSizeArr[] 						= 	$tempSizeArr;
					}
					if(!empty($finalSizeArr))
					{
						$this->db->insert_batch('product_size_color',$finalSizeArr);
					}
				}
			}
			return true;
			//pr($finalSizeColorArr,1);
		}else{
			return false;
		}
	}
	
	
	public function add_product_bulk($posts,$vendor_id)
	{
	
	    foreach($posts as $post){
	    
		$insertArr = array();
		if(!$post['max_quantity']){
		$post['max_quantity']=0;
		}
		$post['shipping_type']='free';
		$post['earnings']=0;
		$insertArr['vendor_id'] 	= 	$vendor_id;//done
		$insertArr['product_name'] 	= 	$post['product_name'];//done
		$insertArr['category_id'] 	= 	'2';//done
		$insertArr['description'] 	= 	$post['description'];//done
		$insertArr['unique_id'] 	= 	$post['unique_id'];//doone
		//$insertArr['main_image_url'] = 	$post['mainurl'];//done
		$insertArr['price'] 		= 	$post['price'];//done
		$insertArr['quantity']		= 	$post['quantity'];//done
		$insertArr['shipping_type'] = 	$post['shipping_type'];//done
		if($post['shipping_type']=='free')
		{
			$insertArr['shipping'] 		= 	0;
		}else{
			$insertArr['shipping'] 		= 	$post['shipping'];
		}
		$insertArr['earnings'] 		= 	$post['earnings'];//done
		$insertArr['shipping_time'] = 	$post['shipping_time'];
		if($post['shipping_time']=='')
		{
			$updateArr['min_estimate'] 	= 	0;
			$updateArr['max_estimate'] 	= 	0;
		}else{
			$updateArr['min_estimate'] 	= 	0;
			$updateArr['max_estimate'] 	= 	0;
		}
		$insertArr['min_estimate'] 	= 	0;
		$insertArr['max_estimate'] 	= 	0;
		if($post['declared_name'])
		$insertArr['default_declared_name'] 	= 	$post['declared_name'];//done
		else
		$insertArr['default_declared_name'] 	='test';
		
		if($post['declared_local_name'])
		$insertArr['default_local_name']		= 	$post['declared_local_name'];//done
		
		if($post['pieces_included'])
		$insertArr['default_pieces_included'] 	= 	$post['pieces_included'];//done
		
		if($post['length'])
		$insertArr['default_package_length'] 	= 	$post['length'];//done
		
		if($post['width'])
		$insertArr['default_package_width'] 	= 	$post['width'];//done
		
		if($post['height'])
		$insertArr['default_package_height'] 	= 	$post['height'];//done
		
		if($post['declared_name'])
		$insertArr['default_package_weight'] 	=	$post['weight'];//done
		
		if($post['country_of_origin'])
		$insertArr['default_country_of_origin'] 	= 	$post['country_of_origin'];//done
		
		if($post['custom_hs_code'])
		$insertArr['default_custom_hs_code'] 	= 	$post['custom_hs_code'];//done
		
		if($post['custom_declared_value'])
		$insertArr['default_custom_declared_value'] = 	$post['custom_declared_value'];//done
		
		if($post['contains_powder'])
		$insertArr['default_contains_powder'] 	= 	$post['contains_powder'];//done
		
		if($post['contains_liquid'])
		$insertArr['default_contains_liquid'] 	= 	$post['contains_liquid'];//done
		
		if($post['contains_battery'])
		$insertArr['default_contains_battery'] 	= 	$post['contains_battery'];//done
		
		if($post['contains_metal'])
		$insertArr['default_contains_metal'] 	= 	$post['contains_metal'];//done
		
		if($post['msrp'])
		$insertArr['msrp'] 			= 	$post['msrp'];//done
		
		if($post['brand_id'])
		$insertArr['brand'] 		= 	$post['brand_id'];//done
		
		if($post['upc'])
		$insertArr['upc'] 			= 	$post['upc'];//done
		
	
		$insertArr['approval_status'] 			= 	'APPROVED';//done
		
		if($post['max_quantity'])
		$insertArr['max_quantity'] 	= 	$post['max_quantity'];//done
		
		if($post['landing_img'])
		$insertArr['landing_page_url'] = 	$post['landing_img'];
		
		
		if($post['express_required']=='1' )
		{			
			$insertArr['nureso_express_status'] = '1';
		}
		$insertArr['created_on'] 	= date('Y-m-d H:i:s');
		$insertArr['modify_on'] 	= date('Y-m-d H:i:s');
		//echo '<pre>';
		
		$this->db->insert('products',$insertArr);
		$this->db->error(); 
		
		//$product_id = 10;
		 $product_id = $this->db->insert_id();
		//print_r($insertArr);exit;
		if($product_id)
		{
			$tags =	$post['tag'];
			if($tags!='')
			{
				$allTags = explode(',',$tags);
				foreach($allTags as $tag)
				{
					$previousTagId = $this->getPreviousTag($tag);
					if($previousTagId<1)
					{
						$insertTags = array();
						$insertTags['tag'] = $tag;
						$insertTags['created_on'] = date('Y-m-d H:i:s');
						$insertTags['modify_on'] = date('Y-m-d H:i:s');
						$tag_id = $this->commonmodel->_insert('tags',$insertTags);
						
						$insertProductTagArr = array();
						$insertProductTagArr['tag_id'] = $tag_id;
						$insertProductTagArr['product_id'] = $product_id;
						$insertTags['created_on'] = date('Y-m-d H:i:s');
						$insertTags['modify_on'] = date('Y-m-d H:i:s');
						$this->commonmodel->_insert('product_tags',$insertProductTagArr);
					}else{
						$insertProductTagArr = array();
						$insertProductTagArr['tag_id'] = $previousTagId;
						$insertProductTagArr['product_id'] = $product_id;
						$insertTags['created_on'] = date('Y-m-d H:i:s');
						$insertTags['modify_on'] = date('Y-m-d H:i:s');
						$this->commonmodel->_insert('product_tags',$insertProductTagArr);
					}
				}
			}
			
			$additional_image = $post['additional_image'];
			if(!empty($additional_image))
			{
				$finalImgArr = array();
				foreach($additional_image as $imgId)
				{
					if($imgId!='' && $imgId!=0)
					{
						$tempImgArr = array();
						$tempImgArr['product_id'] = $product_id;
						$tempImgArr['image_url'] = $imgId;
						$tempImgArr['created_on'] = date('Y-m-d H:i:s');
						$tempImgArr['modify_on'] = date('Y-m-d H:i:s');
						$finalImgArr[] = $tempImgArr;
					}
				}
				if(!empty($finalImgArr))
				{
					$this->db->insert_batch('product_additional_images_mapping',$finalImgArr);
				}
			}
			
			if(isset($post['size_color']))
			{
				if(!empty($post['size_color']))
				{
					$size_colors = $post['size_color'];
					$finalSizeColorArr = array();
					foreach($size_colors as $size_id => $size_color)
					{
						foreach($size_color as $color_id => $size_color_data)
						{
							$tempSizeColorArr = array();
							$tempSizeColorArr['product_id'] 			= 	$product_id;
							$tempSizeColorArr['vendor_id'] 				= 	$vendor_id;
							$tempSizeColorArr['size_id'] 				= 	$size_id;
							$tempSizeColorArr['color_id'] 				= 	$color_id;
							$tempSizeColorArr['variations_unique_id'] 	= 	$size_color_data['variations_unique_id'];
							$tempSizeColorArr['variations_price'] 		=	$size_color_data['variations_price'];
							$tempSizeColorArr['quantity'] 			  	=	$size_color_data['quantity'];
							$tempSizeColorArr['variations_earnings'] 	=	$size_color_data['variations_earnings'];
							$tempSizeColorArr['logistic_detail'] 		= 	$size_color_data['logistic_detail'];
							$tempSizeColorArr['declared_name'] 			= 	$size_color_data['declared_name'];
							$tempSizeColorArr['local_name']				= 	$size_color_data['local_name'];
							$tempSizeColorArr['pieces_included'] 		= 	$size_color_data['pieces_included'];
							$tempSizeColorArr['package_length'] 		= 	$size_color_data['package_length'];
							$tempSizeColorArr['package_width'] 			= 	$size_color_data['package_width'];
							$tempSizeColorArr['package_height'] 		= 	$size_color_data['package_height'];
							$tempSizeColorArr['package_weight'] 		=	$size_color_data['package_weight'];
							$tempSizeColorArr['package_weight'] 		= 	$size_color_data['country_of_origin'];
							$tempSizeColorArr['custom_hs_code'] 		= 	$size_color_data['custom_hs_code'];
							$tempSizeColorArr['custom_declared_value'] 	= 	$size_color_data['custom_declared_value'];
							$tempSizeColorArr['contains_powder'] 		= 	$size_color_data['contains_powder'];
							$tempSizeColorArr['contains_liquid'] 		= 	$size_color_data['contains_liquid'];
							$tempSizeColorArr['contains_battery'] 		= 	$size_color_data['contains_battery'];
							$tempSizeColorArr['contains_battery'] 		= 	$size_color_data['contains_battery'];
							$tempSizeColorArr['created_on'] 			= 	date('Y-m-d H:i:s');
							$tempSizeColorArr['modify_on'] 				= 	date('Y-m-d H:i:s');
							$finalSizeColorArr[] 						= 	$tempSizeColorArr;
						}
					}
					//pr($finalSizeColorArr,1);
					if(!empty($finalSizeColorArr))
					{
						$this->db->insert_batch('product_size_color',$finalSizeColorArr);
					}
				}
			}elseif(isset($post['size']))
			{
				if(!empty($post['size']))
				{
					$sizes = $post['size'];
					$finalSizeArr = array();
					foreach($sizes as $size_id => $size)
					{
						$tempSizeArr = array();
						$tempSizeArr['product_id'] 				= 	$product_id;
						$tempSizeArr['vendor_id'] 				= 	$vendor_id;
						$tempSizeArr['size_id'] 				= 	$size_id;
						$tempSizeArr['variations_unique_id'] 	= 	$size['variations_unique_id'];
						$tempSizeArr['variations_price'] 		=	$size['variations_price'];
						$tempSizeArr['quantity'] 			  	=	$size['quantity'];
						$tempSizeArr['logistic_detail'] 		= 	$size['logistic_detail'];
						$tempSizeArr['declared_name'] 			= 	$size['declared_name'];
						$tempSizeArr['local_name']				= 	$size['local_name'];
						$tempSizeArr['pieces_included'] 		= 	$size['pieces_included'];
						$tempSizeArr['package_length'] 			= 	$size['package_length'];
						$tempSizeArr['package_width'] 			= 	$size['package_width'];
						$tempSizeArr['package_height'] 			= 	$size['package_height'];
						$tempSizeArr['package_weight'] 			=	$size['package_weight'];
						$tempSizeArr['package_weight'] 			= 	$size['country_of_origin'];
						$tempSizeArr['custom_hs_code'] 			= 	$size['custom_hs_code'];
						$tempSizeArr['custom_declared_value'] 	= 	$size['custom_declared_value'];
						$tempSizeArr['contains_powder'] 		= 	$size['contains_powder'];
						$tempSizeArr['contains_liquid'] 		= 	$size['contains_liquid'];
						$tempSizeArr['contains_battery'] 		= 	$size['contains_battery'];
						$tempSizeArr['contains_battery'] 		= 	$size['contains_battery'];
						$tempSizeArr['created_on'] 				= 	date('Y-m-d H:i:s');
						$tempSizeArr['modify_on'] 				= 	date('Y-m-d H:i:s');
						$finalSizeArr[] 						= 	$tempSizeArr;
					}
					if(!empty($finalSizeArr))
					{
						$this->db->insert_batch('product_size_color',$finalSizeArr);
					}
				}
			}elseif(isset($post['color']))
			{
				if(!empty($post['color']))
				{
					$colors = $post['color'];
					$finalSizeArr = array();
					foreach($colors as $color_id => $color)
					{
						$tempSizeArr = array();
						$tempSizeArr['product_id'] 				= 	$product_id;
						$tempSizeArr['vendor_id'] 				= 	$vendor_id;
						$tempSizeArr['color_id'] 				= 	$color_id;
						$tempSizeArr['variations_unique_id'] 	= 	$color['variations_unique_id'];
						$tempSizeArr['variations_price'] 		=	$color['variations_price'];
						$tempSizeArr['quantity'] 			  	=	$color['quantity'];
						$tempSizeArr['logistic_detail'] 		= 	$color['logistic_detail'];
						$tempSizeArr['declared_name'] 			= 	$color['declared_name'];
						$tempSizeArr['local_name']				= 	$color['local_name'];
						$tempSizeArr['pieces_included'] 		= 	$color['pieces_included'];
						$tempSizeArr['package_length'] 			= 	$color['package_length'];
						$tempSizeArr['package_width'] 			= 	$color['package_width'];
						$tempSizeArr['package_height'] 			= 	$color['package_height'];
						$tempSizeArr['package_weight'] 			=	$color['package_weight'];
						$tempSizeArr['package_weight'] 			= 	$color['country_of_origin'];
						$tempSizeArr['custom_hs_code'] 			= 	$color['custom_hs_code'];
						$tempSizeArr['custom_declared_value'] 	= 	$color['custom_declared_value'];
						$tempSizeArr['contains_powder'] 		= 	$color['contains_powder'];
						$tempSizeArr['contains_liquid'] 		= 	$color['contains_liquid'];
						$tempSizeArr['contains_battery'] 		= 	$color['contains_battery'];
						$tempSizeArr['contains_battery'] 		= 	$color['contains_battery'];
						$tempSizeArr['created_on'] 				= 	date('Y-m-d H:i:s');
						$tempSizeArr['modify_on'] 				= 	date('Y-m-d H:i:s');
						$finalSizeArr[] 						= 	$tempSizeArr;
					}
					if(!empty($finalSizeArr))
					{
						$this->db->insert_batch('product_size_color',$finalSizeArr);
					}
				}
			}
			
			return true;
			//pr($finalSizeColorArr,1);
		}else{
			return false;
		}
		}
	}
	
	public function edit_product($post,$product_id)
	{
		//print_r($post);die();
		//print_r($product_id);die();
		//pr($post,1);
		$updateArr = array();
		$updateArr['product_name'] 	= 	$post['product_name'];
		$updateArr['category_id'] 	= 	$post['category_id'];
		$updateArr['description'] 	= 	$post['description'];
		//$updateArr['unique_id'] 	= 	$post['unique_id'];
		$updateArr['main_image_id'] = 	$post['main_image_id'];
		$updateArr['price'] 		= 	$post['price'];
		$updateArr['quantity']		= 	$post['quantity'];
		$updateArr['shipping_type'] = 	$post['shipping_type'];
		if($post['shipping_type']=='free')
		{
			$updateArr['shipping'] 		= 	0;
		}else{
			$updateArr['shipping'] 		= 	$post['shipping'];
		}
		$updateArr['earnings'] 		= 	$post['earnings'];
		$updateArr['shipping_time'] = 	$post['shipping_time'];
		if($post['shipping_time']=='')
		{
			$updateArr['min_estimate'] 	= 	$post['min_estimate'];
			$updateArr['max_estimate'] 	= 	$post['max_estimate'];
		}else{
			$updateArr['min_estimate'] 	= 	0;
			$updateArr['max_estimate'] 	= 	0;
		}
		$updateArr['default_declared_name'] 	= 	$post['default_declared_name'];
		$updateArr['default_local_name']		= 	$post['default_local_name'];
		$updateArr['default_pieces_included'] 	= 	$post['default_pieces_included'];
		$updateArr['default_package_length'] 	= 	$post['default_package_length'];
		$updateArr['default_package_width'] 	= 	$post['default_package_width'];
		$updateArr['default_package_height'] 	= 	$post['default_package_height'];
		$updateArr['default_package_weight'] 	=	$post['default_package_weight'];
		$updateArr['default_country_of_origin'] 	= 	$post['default_country_of_origin'];
		$updateArr['default_custom_hs_code'] 	= 	$post['default_custom_hs_code'];
		$updateArr['default_custom_declared_value'] = 	$post['default_custom_declared_value'];
		$updateArr['default_contains_powder'] 	= 	$post['default_contains_powder'];
		$updateArr['default_contains_liquid'] 	= 	$post['default_contains_liquid'];
		$updateArr['default_contains_battery'] 	= 	$post['default_contains_battery'];
		$updateArr['default_contains_metal'] 	= 	$post['default_contains_metal'];
		$updateArr['msrp'] 			= 	$post['msrp'];
		$updateArr['brand'] 		= 	$post['brand'];
		$updateArr['upc'] 			= 	$post['upc'];
		$updateArr['approval_status'] 			= 	'APPROVED';
		$updateArr['max_quantity'] 	= 	$post['max_quantity'];
		$updateArr['landing_page_url'] = 	$post['landing_page_url'];
		$updateArr['modify_on'] 	= date('Y-m-d H:i:s');
		
		$this->db->where('product_id',$product_id);
		$this->db->update('products',$updateArr);
		if($product_id)
		{
			$tags =	$post['tags'];
			if($tags!='')
			{
				$allTags = explode(',',$tags);
				foreach($allTags as $tag)
				{
					$tag_id = $this->getPreviousTag($tag);
					if($tag_id<1)
					{
						$insertTags = array();
						$insertTags['tag'] = $tag;
						$insertTags['created_on'] = date('Y-m-d H:i:s');
						$insertTags['modify_on'] = date('Y-m-d H:i:s');
						$tag_id = $this->commonmodel->_insert('tags',$insertTags);
						
						$insertProductTagArr = array();
						$insertProductTagArr['tag_id'] = $tag_id;
						$insertProductTagArr['product_id'] = $product_id;
						$insertTags['created_on'] = date('Y-m-d H:i:s');
						$insertTags['modify_on'] = date('Y-m-d H:i:s');
						$productTagId = $this->commonmodel->_insert('product_tags',$insertProductTagArr);
					}else{
						$productTagId = $this->checkProductPreviousTag($tag_id,$product_id);
						if($productTagId<1)
						{
							$insertProductTagArr = array();
							$insertProductTagArr['tag_id'] = $tag_id;
							$insertProductTagArr['product_id'] = $product_id;
							$insertTags['created_on'] = date('Y-m-d H:i:s');
							$insertTags['modify_on'] = date('Y-m-d H:i:s');
							$productTagId = $this->commonmodel->_insert('product_tags',$insertProductTagArr);
						}
					}
					$finalProductTagId[] = $productTagId;
				}
				if(!empty($finalProductTagId))
				{
					$finalProductTagId = implode(',',$finalProductTagId);
					
					$this->db->where('product_tag_id NOT IN ('.$finalProductTagId.')');
					$this->db->where('product_id',$product_id);
					$this->db->update('product_tags',array('delete_status'=>'1'));
				}
			}
			
			$additional_image = $post['additional_image'];
			if(!empty($additional_image))
			{
				$finalImgArr = array();
				foreach($additional_image as $imgId)
				{
					if($imgId!='' && $imgId!=0)
					{
						$tempImgArr = array();
						$tempImgArr['product_id'] = $product_id;
						$tempImgArr['pi_id'] = $imgId;
						$tempImgArr['created_on'] = date('Y-m-d H:i:s');
						$tempImgArr['modify_on'] = date('Y-m-d H:i:s');
						$finalImgArr[] = $tempImgArr;
					}
				}
				if(!empty($finalImgArr))
				{
					$this->db->insert_batch('product_additional_images_mapping',$finalImgArr);
				}
			}
			
			$old_additional_image = $post['old_additional_image'];
			if(!empty($old_additional_image))
			{
				$finalImgArr = array();
				foreach($old_additional_image as $key => $imgId)
				{
					if($imgId!='' && $imgId!=0)
					{
						if(is_numeric($imgId))
						{
							$this->db->where('product_id',$product_id);
							$this->db->where('pi_id',$key);
							$this->db->update('product_additional_images_mapping',array('delete_status'=>'0'));
							
							$tempImgArr = array();
							$tempImgArr['product_id'] = $product_id;
							$tempImgArr['pi_id'] = $imgId;
							$tempImgArr['created_on'] = date('Y-m-d H:i:s');
							$tempImgArr['modify_on'] = date('Y-m-d H:i:s');
							$finalImgArr[] = $tempImgArr;
						}
					}else{
						$this->db->where('product_id',$product_id);
						$this->db->where('pi_id',$key);
						$this->db->update('product_additional_images_mapping',array('delete_status'=>'0'));
					}
				}
				if(!empty($finalImgArr))
				{
					$this->db->insert_batch('product_additional_images_mapping',$finalImgArr);
				}
			}
			
			//pr($post['old_size_color'],1);
			//$old_ids = array_keys($post['old_size_color']);
			if(isset($post['old_size_color']))
			{
				if(!empty($post['old_size_color']))
				{
					$psc_size_colors = $post['old_size_color'];
					foreach($psc_size_colors as $psc_id => $psc)
					{
						foreach($psc as $size_id => $old_size_color)
						{
							foreach($old_size_color as $color_id => $size_color_data)
							{
								$tempSizeColorArr = array();
								$tempSizeColorArr['size_id'] 				= 	$size_id;
								$tempSizeColorArr['color_id'] 				= 	$color_id;
								$tempSizeColorArr['variations_unique_id'] 	= 	$size_color_data['variations_unique_id'];
								$tempSizeColorArr['variations_price'] 		=	$size_color_data['variations_price'];
								$tempSizeColorArr['quantity'] 			  	=	$size_color_data['quantity'];
								$tempSizeColorArr['variations_earnings'] 	=	$size_color_data['variations_earnings'];
								$tempSizeColorArr['logistic_detail'] 		= 	$size_color_data['logistic_detail'];
								$tempSizeColorArr['declared_name'] 			= 	$size_color_data['declared_name'];
								$tempSizeColorArr['local_name']				= 	$size_color_data['local_name'];
								$tempSizeColorArr['pieces_included'] 		= 	$size_color_data['pieces_included'];
								$tempSizeColorArr['package_length'] 		= 	$size_color_data['package_length'];
								$tempSizeColorArr['package_width'] 			= 	$size_color_data['package_width'];
								$tempSizeColorArr['package_height'] 		= 	$size_color_data['package_height'];
								$tempSizeColorArr['package_weight'] 		=	$size_color_data['package_weight'];
								$tempSizeColorArr['package_weight'] 		= 	$size_color_data['country_of_origin'];
								$tempSizeColorArr['custom_hs_code'] 		= 	$size_color_data['custom_hs_code'];
								$tempSizeColorArr['custom_declared_value'] 	= 	$size_color_data['custom_declared_value'];
								$tempSizeColorArr['contains_powder'] 		= 	$size_color_data['contains_powder'];
								$tempSizeColorArr['contains_liquid'] 		= 	$size_color_data['contains_liquid'];
								$tempSizeColorArr['contains_battery'] 		= 	$size_color_data['contains_battery'];
								$tempSizeColorArr['contains_battery'] 		= 	$size_color_data['contains_battery'];
								$tempSizeColorArr['modify_on'] 				= 	date('Y-m-d H:i:s');
								
								$this->db->where('psc_id',$psc_id);
								$this->db->update('product_size_color',$tempSizeColorArr);
							}
						}
					}
				}
			}elseif(isset($post['old_size']))
			{
				if(!empty($post['old_size']))
				{
					$old_size = $post['old_size'];
					foreach($old_size as $psc_id => $ps)
					{
						foreach($ps as $size_id => $size)
						{
							$tempSizeArr = array();
							$tempSizeArr['size_id'] 				= 	$size_id;
							$tempSizeArr['variations_unique_id'] 	= 	$size['variations_unique_id'];
							$tempSizeArr['variations_price'] 		=	$size['variations_price'];
							$tempSizeArr['quantity'] 			  	=	$size['quantity'];
							$tempSizeArr['logistic_detail'] 		= 	$size['logistic_detail'];
							$tempSizeArr['declared_name'] 			= 	$size['declared_name'];
							$tempSizeArr['local_name']				= 	$size['local_name'];
							$tempSizeArr['pieces_included'] 		= 	$size['pieces_included'];
							$tempSizeArr['package_length'] 			= 	$size['package_length'];
							$tempSizeArr['package_width'] 			= 	$size['package_width'];
							$tempSizeArr['package_height'] 			= 	$size['package_height'];
							$tempSizeArr['package_weight'] 			=	$size['package_weight'];
							$tempSizeArr['package_weight'] 			= 	$size['country_of_origin'];
							$tempSizeArr['custom_hs_code'] 			= 	$size['custom_hs_code'];
							$tempSizeArr['custom_declared_value'] 	= 	$size['custom_declared_value'];
							$tempSizeArr['contains_powder'] 		= 	$size['contains_powder'];
							$tempSizeArr['contains_liquid'] 		= 	$size['contains_liquid'];
							$tempSizeArr['contains_battery'] 		= 	$size['contains_battery'];
							$tempSizeArr['contains_battery'] 		= 	$size['contains_battery'];
							$tempSizeArr['modify_on'] 				= 	date('Y-m-d H:i:s');
							
							$this->db->where('psc_id',$psc_id);
							$this->db->update('product_size_color',$tempSizeColorArr);
						}
					}
				}
			}elseif(isset($post['old_color']))
			{
				if(!empty($post['old_color']))
				{
					$old_colors = $post['old_color'];
					foreach($old_colors as $psc_id => $pc)
					{
						foreach($pc as $color_id => $color)
						{
							$tempSizeArr = array();
							$tempSizeArr['color_id'] 				= 	$color_id;
							$tempSizeArr['variations_unique_id'] 	= 	$color['variations_unique_id'];
							$tempSizeArr['variations_price'] 		=	$color['variations_price'];
							$tempSizeArr['quantity'] 			  	=	$color['quantity'];
							$tempSizeArr['logistic_detail'] 		= 	$color['logistic_detail'];
							$tempSizeArr['declared_name'] 			= 	$color['declared_name'];
							$tempSizeArr['local_name']				= 	$color['local_name'];
							$tempSizeArr['pieces_included'] 		= 	$color['pieces_included'];
							$tempSizeArr['package_length'] 			= 	$color['package_length'];
							$tempSizeArr['package_width'] 			= 	$color['package_width'];
							$tempSizeArr['package_height'] 			= 	$color['package_height'];
							$tempSizeArr['package_weight'] 			=	$color['package_weight'];
							$tempSizeArr['package_weight'] 			= 	$color['country_of_origin'];
							$tempSizeArr['custom_hs_code'] 			= 	$color['custom_hs_code'];
							$tempSizeArr['custom_declared_value'] 	= 	$color['custom_declared_value'];
							$tempSizeArr['contains_powder'] 		= 	$color['contains_powder'];
							$tempSizeArr['contains_liquid'] 		= 	$color['contains_liquid'];
							$tempSizeArr['contains_battery'] 		= 	$color['contains_battery'];
							$tempSizeArr['contains_battery'] 		= 	$color['contains_battery'];
							$tempSizeArr['modify_on'] 				= 	date('Y-m-d H:i:s');
							
							$this->db->where('psc_id',$psc_id);
							$this->db->update('product_size_color',$tempSizeArr);
						}
					}
				}
			}
			if(!empty($old_ids)){
			$this->db->where_not_in('psc_id',$old_ids);
			$this->db->update('product_size_color',array('delete_status'=>'1'));
			}
			// if(isset($post['size_color']))
			// {
			// 	if(!empty($post['size_color']))
			// 	{
			// 		$size_colors = $post['size_color'];
			// 		$finalSizeColorArr = array();
			// 		foreach($size_colors as $size_id => $size_color)
			// 		{
			// 			foreach($size_color as $color_id => $size_color_data)
			// 			{
			// 				$tempSizeColorArr = array();
			// 				$tempSizeColorArr['product_id'] 			= 	$product_id;
			// 				$tempSizeColorArr['vendor_id'] 				= 	'5';
			// 				$tempSizeColorArr['size_id'] 				= 	$size_id;
			// 				$tempSizeColorArr['color_id'] 				= 	$color_id;
			// 				$tempSizeColorArr['variations_unique_id'] 	= 	$size_color_data['variations_unique_id'];
			// 				$tempSizeColorArr['variations_price'] 		=	$size_color_data['variations_price'];
			// 				$tempSizeColorArr['quantity'] 			  	=	$size_color_data['quantity'];
			// 				$tempSizeColorArr['variations_earnings'] 	=	$size_color_data['variations_earnings'];
			// 				$tempSizeColorArr['logistic_detail'] 		= 	$size_color_data['logistic_detail'];
			// 				$tempSizeColorArr['declared_name'] 			= 	$size_color_data['declared_name'];
			// 				$tempSizeColorArr['local_name']				= 	$size_color_data['local_name'];
			// 				$tempSizeColorArr['pieces_included'] 		= 	$size_color_data['pieces_included'];
			// 				$tempSizeColorArr['package_length'] 		= 	$size_color_data['package_length'];
			// 				$tempSizeColorArr['package_width'] 			= 	$size_color_data['package_width'];
			// 				$tempSizeColorArr['package_height'] 		= 	$size_color_data['package_height'];
			// 				$tempSizeColorArr['package_weight'] 		=	$size_color_data['package_weight'];
			// 				$tempSizeColorArr['package_weight'] 		= 	$size_color_data['country_of_origin'];
			// 				$tempSizeColorArr['custom_hs_code'] 		= 	$size_color_data['custom_hs_code'];
			// 				$tempSizeColorArr['custom_declared_value'] 	= 	$size_color_data['custom_declared_value'];
			// 				$tempSizeColorArr['contains_powder'] 		= 	$size_color_data['contains_powder'];
			// 				$tempSizeColorArr['contains_liquid'] 		= 	$size_color_data['contains_liquid'];
			// 				$tempSizeColorArr['contains_battery'] 		= 	$size_color_data['contains_battery'];
			// 				$tempSizeColorArr['contains_battery'] 		= 	$size_color_data['contains_battery'];
			// 				$tempSizeColorArr['created_on'] 			= 	date('Y-m-d H:i:s');
			// 				$tempSizeColorArr['modify_on'] 				= 	date('Y-m-d H:i:s');
			// 				$finalSizeColorArr[] 						= 	$tempSizeColorArr;
			// 			}
			// 		}
			// 		//pr($finalSizeColorArr,1);
			// 		if(!empty($finalSizeColorArr))
			// 		{
			// 			$this->db->insert_batch('product_size_color',$finalSizeColorArr);
			// 		}
			// 	}
			// }elseif(isset($post['size']))
			// {
			// 	if(!empty($post['size']))
			// 	{
			// 		$sizes = $post['size'];
			// 		$finalSizeArr = array();
			// 		foreach($sizes as $size_id => $size)
			// 		{
			// 			$tempSizeArr = array();
			// 			$tempSizeArr['product_id'] 				= 	$product_id;
			// 			$tempSizeArr['vendor_id'] 				= 	$vendor_id;
			// 			$tempSizeArr['size_id'] 				= 	$size_id;
			// 			$tempSizeArr['variations_unique_id'] 	= 	$size['variations_unique_id'];
			// 			$tempSizeArr['variations_price'] 		=	$size['variations_price'];
			// 			$tempSizeArr['quantity'] 			  	=	$size['quantity'];
			// 			$tempSizeArr['logistic_detail'] 		= 	$size['logistic_detail'];
			// 			$tempSizeArr['declared_name'] 			= 	$size['declared_name'];
			// 			$tempSizeArr['local_name']				= 	$size['local_name'];
			// 			$tempSizeArr['pieces_included'] 		= 	$size['pieces_included'];
			// 			$tempSizeArr['package_length'] 			= 	$size['package_length'];
			// 			$tempSizeArr['package_width'] 			= 	$size['package_width'];
			// 			$tempSizeArr['package_height'] 			= 	$size['package_height'];
			// 			$tempSizeArr['package_weight'] 			=	$size['package_weight'];
			// 			$tempSizeArr['package_weight'] 			= 	$size['country_of_origin'];
			// 			$tempSizeArr['custom_hs_code'] 			= 	$size['custom_hs_code'];
			// 			$tempSizeArr['custom_declared_value'] 	= 	$size['custom_declared_value'];
			// 			$tempSizeArr['contains_powder'] 		= 	$size['contains_powder'];
			// 			$tempSizeArr['contains_liquid'] 		= 	$size['contains_liquid'];
			// 			$tempSizeArr['contains_battery'] 		= 	$size['contains_battery'];
			// 			$tempSizeArr['contains_battery'] 		= 	$size['contains_battery'];
			// 			$tempSizeArr['created_on'] 				= 	date('Y-m-d H:i:s');
			// 			$tempSizeArr['modify_on'] 				= 	date('Y-m-d H:i:s');
			// 			$finalSizeArr[] 						= 	$tempSizeArr;
			// 		}
			// 		if(!empty($finalSizeArr))
			// 		{
			// 			$this->db->insert_batch('product_size_color',$finalSizeArr);
			// 		}
			// 	}
			// }elseif(isset($post['color']))
			// {
			// 	if(!empty($post['color']))
			// 	{
			// 		$colors = $post['color'];
			// 		$finalSizeArr = array();
			// 		foreach($colors as $color_id => $color)
			// 		{
			// 			$tempSizeArr = array();
			// 			$tempSizeArr['product_id'] 				= 	$product_id;
			// 			$tempSizeArr['vendor_id'] 				= 	$vendor_id;
			// 			$tempSizeArr['color_id'] 				= 	$color_id;
			// 			$tempSizeArr['variations_unique_id'] 	= 	$color['variations_unique_id'];
			// 			$tempSizeArr['variations_price'] 		=	$color['variations_price'];
			// 			$tempSizeArr['quantity'] 			  	=	$color['quantity'];
			// 			$tempSizeArr['logistic_detail'] 		= 	$color['logistic_detail'];
			// 			$tempSizeArr['declared_name'] 			= 	$color['declared_name'];
			// 			$tempSizeArr['local_name']				= 	$color['local_name'];
			// 			$tempSizeArr['pieces_included'] 		= 	$color['pieces_included'];
			// 			$tempSizeArr['package_length'] 			= 	$color['package_length'];
			// 			$tempSizeArr['package_width'] 			= 	$color['package_width'];
			// 			$tempSizeArr['package_height'] 			= 	$color['package_height'];
			// 			$tempSizeArr['package_weight'] 			=	$color['package_weight'];
			// 			$tempSizeArr['package_weight'] 			= 	$color['country_of_origin'];
			// 			$tempSizeArr['custom_hs_code'] 			= 	$color['custom_hs_code'];
			// 			$tempSizeArr['custom_declared_value'] 	= 	$color['custom_declared_value'];
			// 			$tempSizeArr['contains_powder'] 		= 	$color['contains_powder'];
			// 			$tempSizeArr['contains_liquid'] 		= 	$color['contains_liquid'];
			// 			$tempSizeArr['contains_battery'] 		= 	$color['contains_battery'];
			// 			$tempSizeArr['contains_battery'] 		= 	$color['contains_battery'];
			// 			$tempSizeArr['created_on'] 				= 	date('Y-m-d H:i:s');
			// 			$tempSizeArr['modify_on'] 				= 	date('Y-m-d H:i:s');
			// 			$finalSizeArr[] 						= 	$tempSizeArr;
			// 		}
			// 		if(!empty($finalSizeArr))
			// 		{
			// 			$this->db->insert_batch('product_size_color',$finalSizeArr);
			// 		}
			// 	}
			// }
			return true;
			//pr($finalSizeColorArr,1);
		}else{
			return false;
		}
	}

    public function getSizeCategory($size_id)
    {
		$this->db->select('attributes_sub_categories.size_category_id');
		$this->db->from('attributes_sub_categories');
		$this->db->where('id =', $size_id);
		$this->db->where('status','1');
		$this->db->where('delete_status','0');
        $query = $this->db->get();
		if($query->num_rows()>0)
		{
			$result = $query->row_array();
			return $result['size_category_id'];
		}else{
			return array();
		}
    }

    public function checkProductPreviousTag($tag_id,$product_id)
    {
		$this->db->select('product_tag_id');
		$this->db->where('tag_id', $tag_id);
		$this->db->where('product_id', $product_id);
        $query = $this->db->get('product_tags');
		if($query->num_rows()>0)
		{
			$result = $query->row_array();
			$result = $result['product_tag_id'];
			return $result;
		}else{
			return 0;
		}
	}

    public function getPreviousTag($tag)
    {
		$this->db->select('tag_id');
		$this->db->where('tag', $tag);
        $query = $this->db->get('tags');
		if($query->num_rows()>0)
		{
			$tagDetail = $query->row_array();
			return $tagDetail['tag_id'];
		}else{
			return 0;
		}
	}

    public function setProduct($post, $id = 0)
    {
        $this->db->trans_begin();
        $is_update = false;
        if ($id > 0) {
            $is_update = true;
            if (!$this->db->where('id', $id)->where('vendor_id', $post['vendor_id'])->update('products', array(
                        'image' => $post['image'] != null ? $_POST['image'] : $_POST['old_image'],
                        'shop_categorie' => $post['shop_categorie'],
                        'quantity' => $post['quantity'],
                        'position' => $post['position'],
                        'time_update' => time()
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }
        } else {
            $i = 0;
            foreach ($_POST['translations'] as $translation) {
                if ($translation == MY_DEFAULT_LANGUAGE_ABBR) {
                    $myTranslationNum = $i;
                }
                $i++;
            }
            if (!$this->db->insert('products', array(
                        'image' => $post['image'],
                        'shop_categorie' => $post['shop_categorie'],
                        'quantity' => $post['quantity'],
                        'position' => $post['position'],
                        'folder' => $post['folder'],
                        'vendor_id' => $post['vendor_id'],
                        'time' => time()
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }
            $id = $this->db->insert_id();

            $this->db->where('id', $id);
            if (!$this->db->update('products', array(
                        'url' => except_letters($_POST['title'][$myTranslationNum]) . '_' . $id
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }
        }
        $this->setProductTranslation($post, $id, $is_update);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            show_error(lang('database_error'));
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    private function setProductTranslation($post, $id, $is_update = false)
    {
        $i = 0;
        $current_trans = $this->getTranslations($id, 'product');
        foreach ($post['translations'] as $abbr) {
            $arr = array();
            $emergency_insert = false;
            if (!isset($current_trans[$abbr])) {
                $emergency_insert = true;
            }
            $post['title'][$i] = str_replace('"', "'", $post['title'][$i]);
            $post['price'][$i] = str_replace(' ', '', $post['price'][$i]);
            $post['price'][$i] = str_replace(',', '', $post['price'][$i]);
            $arr = array(
                'title' => $post['title'][$i],
                'description' => $post['description'][$i],
                'price' => $post['price'][$i],
                'old_price' => $post['old_price'][$i],
                'abbr' => $abbr,
                'for_id' => $id
            );
            if ($is_update === true && $emergency_insert === false) {
                $abbr = $arr['abbr'];
                unset($arr['for_id'], $arr['abbr'], $arr['url']);
                if (!$this->db->where('abbr', $abbr)->where('for_id', $id)->update('products_translations', $arr)) {
                    log_message('error', print_r($this->db->error(), true));
                }
            } else {
                if (!$this->db->insert('products_translations', $arr)) {
                    log_message('error', print_r($this->db->error(), true));
                }
            }
            $i++;
        }
    }

    public function getTranslations($id)
    {
        $this->db->where('for_id', $id);
        $query = $this->db->get('products_translations');
        $arr = array();
        foreach ($query->result() as $row) {
            $arr[$row->abbr]['title'] = $row->title;
            $arr[$row->abbr]['description'] = $row->description;
            $arr[$row->abbr]['price'] = $row->price;
            $arr[$row->abbr]['old_price'] = $row->old_price;
        }
        return $arr;
    }

    public function getProducts($limit, $page, $vendor_id)
    {
        $this->db->order_by('products.position', 'asc');
        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'left');
        $this->db->where('products_translations.abbr', MY_DEFAULT_LANGUAGE_ABBR);
        $this->db->where('vendor_id', $vendor_id);
        $query = $this->db->select('products.*, products_translations.title, products_translations.description, products_translations.price')->get('products', $limit, $page);
        return $query->result();
    }

    public function productsCount($vendor_id)
    {
        $this->db->where('vendor_id', $vendor_id);
        return $this->db->count_all_results('products');
    }

    public function deleteProduct($id)
    {
		$this->db->where('product_id',base64_decode($id));
		if($this->db->update('products',array('delete_status'=>'1')))
		{
			return 'true';
		}else{
			return 'false';
		}
    }

}
