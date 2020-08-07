<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class AddProduct extends VENDOR_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
            'Products_model',
            'admin/Languages_model',
            'admin/Categories_model',
            'admin/Attribute_categories_model'
        ));
        $this->load->library('excel');
    }

    public function index($express_required='')
    {
		if($_POST)
		{
			$post = $this->input->post();
			$post['express_required'] = $express_required;
			//pr($post,1);
			$result = $this->Products_model->add_product($post,$this->vendor_id);
            if ($result === true) {
                $result_msg = lang('vendor_product_published');
            } else {
                $result_msg = lang('vendor_product_publish_err');
            }
            $this->session->set_flashdata('result_publish', $result_msg);
			$this->load->library('user_agent');
			$referrer = $this->agent->referrer();
            redirect($referrer);
		}    
        $data = array();
        $head = array();
        $head['title'] = lang('vendor_add_product');
        $head['description'] = lang('vendor_add_product');
        $head['keywords'] = '';
        $data['languages'] = $this->Languages_model->getLanguages();
        $data['shop_categories'] = $this->Categories_model->getShopCategories();
        $data['vendor_categories'] = $this->Public_model->getVendorCategories($this->vendor_id);
        $data['size_categories'] = $this->Attribute_categories_model->getAllAttributeCategories('size');
        $data['color_categories'] = $this->Attribute_categories_model->getAllColorCategories();
        $this->load->view('_parts/header', $head);
        $this->load->view('add_product', $data);
	    $this->load->view('_parts/modals');
        $this->load->view('_parts/footer');
    }
    public function bulk($express_required='')
    {
     
   
		if(isset($_FILES["upload_excel"]["name"]))
		{
		$path = $_FILES["upload_excel"]["tmp_name"];
		$object = PHPExcel_IOFactory::load($path);
		foreach($object->getWorksheetIterator() as $worksheet)
		{
		$highestRow = $worksheet->getHighestRow();
		$highestColumn = $worksheet->getHighestColumn();
		for($row=2; $row<=$highestRow; $row++)
		{
		if($worksheet->getCellByColumnAndRow(0, $row)->getValue()){
		 $parent_unique_id = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
		 $unique_id = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
		 $product_name = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
		 $description = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
		 $tag = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
		
		 $price = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
		 $shipping = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
		 $msrp = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
		 $quantity = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
		 $color = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
		 $size = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
		 $mainurl = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
		 $clean_image = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
		 $variation_image = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
		 $extra_img [] = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
		 $extra_img[] = $worksheet->getCellByColumnAndRow(15, $row)->getValue();
		 $extra_img[] = $worksheet->getCellByColumnAndRow(16, $row)->getValue();
		 $extra_img[]= $worksheet->getCellByColumnAndRow(17, $row)->getValue();
		 $extra_img[] = $worksheet->getCellByColumnAndRow(18, $row)->getValue();
		 $extra_img[] = $worksheet->getCellByColumnAndRow(19, $row)->getValue();
		 $extra_img[] = $worksheet->getCellByColumnAndRow(20, $row)->getValue();
		 $extra_img[] = $worksheet->getCellByColumnAndRow(21, $row)->getValue();
		 $extra_img[] = $worksheet->getCellByColumnAndRow(22, $row)->getValue();
		 $extra_img[] = $worksheet->getCellByColumnAndRow(23, $row)->getValue();
		 $landing_img = $worksheet->getCellByColumnAndRow(24, $row)->getValue();
		 $upc = $worksheet->getCellByColumnAndRow(25, $row)->getValue();
		
		 $shipping_time1 = $worksheet->getCellByColumnAndRow(26, $row)->getValue(); 
		 $shipping_time=date('Y-m-d H:i:s', ($shipping_time1-25569)*86400);
		  
		//$worksheet->getCellByColumnAndRow(26, $row)->getValue();
		 
		 $max_quantity = $worksheet->getCellByColumnAndRow(27, $row)->getValue();
		 $brand_id = $worksheet->getCellByColumnAndRow(28, $row)->getValue();
		 $AU = $worksheet->getCellByColumnAndRow(29, $row)->getValue();
		 $BE = $worksheet->getCellByColumnAndRow(30, $row)->getValue();
		 $BR = $worksheet->getCellByColumnAndRow(31, $row)->getValue();
		 $CA = $worksheet->getCellByColumnAndRow(32, $row)->getValue();
		 $CL = $worksheet->getCellByColumnAndRow(33, $row)->getValue();
		 $DE = $worksheet->getCellByColumnAndRow(34, $row)->getValue();
		 $ES = $worksheet->getCellByColumnAndRow(35, $row)->getValue();
		 $FI = $worksheet->getCellByColumnAndRow(36, $row)->getValue();
		 $FR = $worksheet->getCellByColumnAndRow(37, $row)->getValue();
		 $GB = $worksheet->getCellByColumnAndRow(38, $row)->getValue();
		 $IT = $worksheet->getCellByColumnAndRow(39, $row)->getValue();
		 $JP = $worksheet->getCellByColumnAndRow(40, $row)->getValue();
		 $KR = $worksheet->getCellByColumnAndRow(41, $row)->getValue();
		 $MX = $worksheet->getCellByColumnAndRow(42, $row)->getValue();
		 $NL = $worksheet->getCellByColumnAndRow(43, $row)->getValue();
		 $NO = $worksheet->getCellByColumnAndRow(44, $row)->getValue();
		 $SE = $worksheet->getCellByColumnAndRow(45, $row)->getValue();
		 $US = $worksheet->getCellByColumnAndRow(46, $row)->getValue();
		 $declared_name = $worksheet->getCellByColumnAndRow(47, $row)->getValue();
		 $declared_local_name = $worksheet->getCellByColumnAndRow(48, $row)->getValue();
		 $pieces_included = $worksheet->getCellByColumnAndRow(49, $row)->getValue();
		 $length = $worksheet->getCellByColumnAndRow(50, $row)->getValue();
		$width = $worksheet->getCellByColumnAndRow(51, $row)->getValue();
		$height = $worksheet->getCellByColumnAndRow(52, $row)->getValue();
		$weight = $worksheet->getCellByColumnAndRow(53, $row)->getValue();
		$country_of_origin = $worksheet->getCellByColumnAndRow(54, $row)->getValue();
		$custom_hs_code = $worksheet->getCellByColumnAndRow(55, $row)->getValue();
		$custom_declared_value = $worksheet->getCellByColumnAndRow(56, $row)->getValue();
		$contains_powder = $worksheet->getCellByColumnAndRow(57, $row)->getValue();
		$contains_liquid = $worksheet->getCellByColumnAndRow(58, $row)->getValue();
		$contains_battery = $worksheet->getCellByColumnAndRow(59, $row)->getValue();
		$contains_metal = $worksheet->getCellByColumnAndRow(60, $row)->getValue();
		//$category_id = $worksheet->getCellByColumnAndRow(61, $row)->getValue();
		//$shipping_type = $worksheet->getCellByColumnAndRow(62, $row)->getValue();
		//$earnings = $worksheet->getCellByColumnAndRow(62, $row)->getValue();


		 $data_product[] = array(
		  'parent_unique_id'  => $parent_unique_id,
		  'unique_id'   => $unique_id,
		  'product_name'    => $product_name,
		  'description'  => $description,
		  'tag'   => $tag,
		  'price'   => $price,
		  'shipping'   => $shipping,
		  'msrp'   => $msrp,
		  'quantity'   => $quantity,
		  'color'   => $color,
		  'size'   => $size,
		  'mainurl'   => $mainurl,
		  'clean_image'   => $clean_image,
		'variation_image'   => $variation_image,
		'additional_image'   => $extra_img,
		'landing_img'   => $landing_img,
		'upc'   => $upc,
		'shipping_time'   => $shipping_time,
		'max_quantity'   => $max_quantity,
		'brand_id'   => $brand_id,
		'AU'   => $AU,
		'BE'   => $BE,
		'BR'   => $BR,
		'CA'   => $CA,
		'CL'   => $CL,
		'DE'   => $DE,
		'ES'   => $ES,
		'FI'   => $FI,
        'FR'   => $FR,
		'GB'   => $GB,
		'IT'   => $IT,
		'JP'   => $JP,
		'KR'   => $KR,
		'MX'   => $MX,
		'NL'   => $NL,
		'NO'   => $NO,
'SE'   => $SE,
'US'   => $US,
'declared_name'   => $declared_name,
'declared_local_name'   => $declared_local_name,
'pieces_included'   => $pieces_included,
'length'   => $length,
'width'   => $width,
'height'   => $height,
'weight'   => $weight,
'country_of_origin'   => $country_of_origin,
'custom_hs_code'   => $custom_hs_code,
'custom_declared_value'   => $custom_declared_value,
'contains_powder'   => $contains_powder,
'contains_liquid'   => $contains_liquid,
'contains_battery'   => $contains_battery,
'contains_metal'   => $contains_metal,

'express_required' => $express_required

  
		 );
		 }
		}
		}
		
		$result = $this->Products_model->add_product_bulk($data_product,$this->vendor_id);
            if ($result === true) {
                $result_msg = lang('vendor_product_published');
            } else {
                $result_msg = lang('vendor_product_publish_err');
            }
            $this->session->set_flashdata('result_publish', $result_msg);
			$this->load->library('user_agent');
			$referrer = $this->agent->referrer();
            redirect($referrer);
		//echo 'Data Imported successfully';
		}   
		
        $data = array();
        $head = array();
        $head['title'] = "Upload buld product";
        $head['description'] = "Upload buld product";
        $head['keywords'] = '';
        $data['languages'] = $this->Languages_model->getLanguages();
        $data['shop_categories'] = $this->Categories_model->getShopCategories();
        $data['vendor_categories'] = $this->Public_model->getVendorCategories($this->vendor_id);
        $data['size_categories'] = $this->Attribute_categories_model->getAllAttributeCategories('size');
        $data['color_categories'] = $this->Attribute_categories_model->getAllColorCategories();
        $this->load->view('_parts/header', $head);
        $this->load->view('add_bulk', $data);
	    $this->load->view('_parts/modals');
        $this->load->view('_parts/footer');
    }
    public function edit_product($id = 0)
    {
		$this->load->library('user_agent');
		$referrer = $this->agent->referrer();
		if($id===0)
		{
			redirect($referrer);			
		}
		if($_POST)
		{
			$post = $this->input->post();
			//pr($post,1);
			$result = $this->Products_model->edit_product($post,base64_decode($id));
            if ($result === true) {
                $result_msg = 'Product updated successfully!';
            } else {
                $result_msg = 'Error in product updation!';
            }
            $this->session->set_flashdata('result_publish', $result_msg);
            redirect(base_url() . '/vendor/edit/product/'.$id);
        }
        $data = array();
        $head = array();
        $head['title'] = 'Edit Product';
        $head['description'] = 'Edit Product';
        $head['keywords'] = '';
        $data['languages'] = $this->Languages_model->getLanguages();
        $data['shop_categories'] = $this->Categories_model->getShopCategories();
        $data['vendor_categories'] = $this->Public_model->getVendorCategories($this->vendor_id);
        $data['size_categories'] = $this->Attribute_categories_model->getAllAttributeCategories('size');
        $data['color_categories'] = $this->Attribute_categories_model->getAllColorCategories();
		$data['vendor_categories'] = $this->Public_model->getVendorCategories($this->vendor_id);
		$data['productDetails'] = $this->Products_model->getProductDetails(base64_decode($id));
        //print_r($data);die();
		$data['productSizeColor'] = $this->Public_model->get_size_color_details(array('product_id'=>base64_decode($id)),'all');
		$data['selectedColorIDs'] = array_unique(array_column($data['productSizeColor'],'color_id'));
		$data['selectedSizeIDs'] = array_column($data['productSizeColor'],'size_id');
		$data['sizeMainId'] = $this->Products_model->getSizeCategory($data['selectedSizeIDs'][0]);
		//pr($data['productSizeColor'],1);
        $this->load->view('_parts/header', $head);
        $this->load->view('edit_product', $data);
	    $this->load->view('_parts/modals');
        $this->load->view('_parts/footer');
    }



    public function addProductImage() {
        $response = array();
        $response['error'] = 'yes';
        $response['msg'] = "You can't hit this url directly";
	
		if($_FILES && $this->input->post())
        {
			$post = $this->input->post();
            $response = $this->Products_model->uploadProductImage($this->vendor_id,$post);
        }
        echo json_encode($response,true);
    }

    public function getTags()
    {
        $response = array();
        $response['error'] ='yes';
        $response['msg'] = "You can't hit this url directly";		
		if($this->input->post())
        {
			$post = $this->input->post();
			$tags = $post['tags'];
            $response = $this->Products_model->getTags($tags);
        }
		//echo json_encode($response,true);
		echo $response;
    }

    private function uploadImage()
    {
        $config['upload_path'] = './attachments/shop_images/';
        $config['allowed_types'] = $this->allowed_img_types;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if(!$this->upload->do_upload('userfile')) {
            log_message('error', 'Image Upload Error: ' . $this->upload->display_errors());
        }
        $img = $this->upload->data();
        return $img['file_name'];
    }

    /*
     * called from ajax
     */

    /*public function street(){

    }*/

    public function do_upload_others_images()
    {
        if ($this->input->is_ajax_request()) {
            $upath = '.' . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . 'shop_images' . DIRECTORY_SEPARATOR . $_POST['folder'] . DIRECTORY_SEPARATOR;
            if (!file_exists($upath)) {
                mkdir($upath, 0777);
            }

            $this->load->library('upload');

            $files = $_FILES;
            $cpt = count($_FILES['others']['name']);
            for ($i = 0; $i < $cpt; $i++) {
                unset($_FILES);
                $_FILES['others']['name'] = $files['others']['name'][$i];
                $_FILES['others']['type'] = $files['others']['type'][$i];
                $_FILES['others']['tmp_name'] = $files['others']['tmp_name'][$i];
                $_FILES['others']['error'] = $files['others']['error'][$i];
                $_FILES['others']['size'] = $files['others']['size'][$i];

                $this->upload->initialize(array(
                    'upload_path' => $upath,
                    'allowed_types' => $this->allowed_img_types
                ));
                $this->upload->do_upload('others');
            }
        }
    }

    public function loadOthersImages()
    {
        $output = '';
        if (isset($_POST['folder']) && $_POST['folder'] != null) {
            $dir = 'attachments' . DIRECTORY_SEPARATOR . 'shop_images' . DIRECTORY_SEPARATOR . $_POST['folder'] . DIRECTORY_SEPARATOR;
            if (is_dir($dir)) {
                if ($dh = opendir($dir)) {
                    $i = 0;
                    while (($file = readdir($dh)) !== false) {
                        if (is_file($dir . $file)) {
                            $output .= '
                                <div class="other-img" id="image-container-' . $i . '">
                                    <img src="' . base_url('attachments/shop_images/' . $_POST['folder'] . '/' . $file) . '" style="width:100px; height: 100px;">
                                    <a href="javascript:void(0);" onclick="removeSecondaryProductImage(\'' . $file . '\', \'' . $_POST['folder'] . '\', ' . $i . ')">
                                        <span class="glyphicon glyphicon-remove"></span>
                                    </a>
                                </div>
                               ';
                        }
                        $i++;
                    }
                    closedir($dh);
                }
            }
        }
        if ($this->input->is_ajax_request()) {
            echo $output;
        } else {
            return $output;
        }
    }

    /*
     * called from ajax
     */

    public function removeSecondaryImage()
    {
        if ($this->input->is_ajax_request()) {
            $img = '.' . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . 'shop_images' . DIRECTORY_SEPARATOR . '' . $_POST['folder'] . DIRECTORY_SEPARATOR . $_POST['image'];
            unlink($img);
        }
    }

}
