<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Products extends VENDOR_Controller
{

    private $num_rows = 1000;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Products_model');
        $this->load->model('admin/Categories_model');
    }

    /* public function index(){
       $data = array();
       $head = array();
       $head['title'] = lang('vendor_products');
       $head['description'] = lang('vendor_products');
       $head['keywords'] = '';

       $this->load->view('_parts/header', $head);
       $this->load->view('promote');
       $this->load->view('_parts/footer');
       
    } */

    public function products(){
       $data = array();
       $head = array();
       $head['title'] = lang('vendor_products');
       $head['description'] = lang('vendor_products');
       $head['keywords'] = '';

       $this->load->view('_parts/header', $head);
       $this->load->view('promote_product');
	   $this->load->view('_parts/modals');
       $this->load->view('_parts/footer');
       
    }

    public function index($express_required = '')
    {
        if (isset($_GET['delete'])) {
            $this->Products_model->deleteProduct($_GET['delete']);
            $this->session->set_flashdata('result_delete', 'product is deleted!');
            $this->saveHistory('Delete product id - ' . $_GET['delete']);
            redirect('admin/products');
        }
        $data = array();
        $head = array();
        $head['title'] = lang('vendor_products');
        $head['description'] = lang('vendor_products');
        $head['keywords'] = '';
        //echo $this->vendor_id; die();
        $data['status']=$this->Public_model->getRequestStatus($this->vendor_id);
        $data['vendor_categories'] = $this->Public_model->getVendorCategories($this->vendor_id);
		
		if($express_required=='express')
		{
			$express_required = '1';
		}else{
			$express_required = '0';
		}
		$data['express_required'] = $express_required;
		$data['products'] = $this->Public_model->getProducts(base64_encode($this->vendor_id),'',$this->num_rows,0,'','','','',$express_required,'vendor_request');
        //print_r($data);
		$this->load->view('_parts/header', $head);
        $this->load->view('products', $data);
	    $this->load->view('_parts/modals');
        $this->load->view('_parts/footer');
    }

    public function express()
    {
        $data = array();
        $head = array();
        $head['title'] = lang('vendor_products');
        $head['description'] = lang('vendor_products');
        $head['keywords'] = '';
        $this->load->view('_parts/header', $head);
        $this->load->view('express', $data);
        $this->load->view('_parts/footer');
    }

    public function expressJoin()
    {
        $data = array();
        $head = array();
        $head['title'] = lang('vendor_products');
        $head['description'] = lang('vendor_products');
        $head['keywords'] = '';
		$data['countries'] = $this->Public_model->getCountriesFromExpress();
		//pr($data['countries'],1);
        $this->load->view('_parts/header', $head);
        $this->load->view('express-join', $data);
        $this->load->view('_parts/footer');
    }

    public function expressSuccess()
    {
        $data = array();
        $head = array();
        $head['title'] = lang('vendor_products');
        $head['description'] = lang('vendor_products');
        $head['keywords'] = '';
        $this->load->view('_parts/header', $head);
        $this->load->view('express-success', $data);
        $this->load->view('_parts/footer');
    }

    public function sendExpressRequest()
    {
        $post=$this->input->post();
        if($post){
            $loggedVendorEmail=$_SESSION['logged_vendor']; 
            $vendor_id=$this->Public_model->getVendorIdByemail($loggedVendorEmail);
           // print_r($vendor_id); exit;
            foreach ($post['country_id'] as $value) {
                $country_id=$value;
                $this->Public_model->sendExpressRequest($country_id,$vendor_id);
                $this->Public_model->changeExpressStatus($vendor_id);
            }
            redirect('vendor/express-success');
        }
    }

    //

    public function deleteVendorProduct()
    {
		if(!$this->input->is_ajax_request())
		{
			exit('No direct script allowed!');
		}
		$id = $this->input->post('product_id');
        echo $this->Products_model->deleteProduct($id, $this->vendor_id);
    }

    public function logout()
    {
        unset($_SESSION['logged_vendor']);
        delete_cookie('logged_vendor');
        redirect(LANG_URL . '/vendor/login');
    }

    public function product_bundle_list() {        
        
        $data = array();
        $head = array();
        $head['title'] = 'Product Bundles';
        $head['description'] = 'Product Bundles';
        $head['keywords'] = '';
        
        $data['products'] = $this->Public_model->getProducts(base64_encode($this->vendor_id), '', 16, 0, '', '', '', '', '0', '', 1);
        $this->_get_product_detail($data['products']);
        $data['categories'] = $this->Categories_model->getShopCategories();        
        

        $this->load->view('_parts/header', $head);
        $this->load->view('product_bundles', $data);	    
        $this->load->view('_parts/footer', $head);
    }

    public function update_product_bundle() {
        $main_bundle = $this->input->post('main_bundle');
        $product_bundles = $this->input->post('product_bundles');
        $id = $this->input->post('id');
        if(!$product_bundles || !$main_bundle) {
            echo json_encode(array('success'=>false, 'error_msg'=>'Invalid Request'));
        } else {
            $product_bundles = explode(',', $product_bundles);
            $this->Public_model->updateProductBundle($id, $main_bundle, $product_bundles);
            echo json_encode(array('success'=>true));
        }
    }

    public function delete_product_bundle() {
        $id = $this->input->post('id');
        if(!$id) {
            echo json_encode(array('success'=>false, 'error_msg'=>'Invalid Request'));
        } else {
            $this->Public_model->deleteProductBundle(base64_encode($this->vendor_id), $id);
            echo json_encode(array('success'=>true));
        }
    }
    
    public function create_product_bundle() {
        $main_bundle = $this->input->post('main_bundle');
        $product_bundles = $this->input->post('product_bundles');
        if(!$product_bundles || !$main_bundle) {
            echo json_encode(array('success'=>false, 'error_msg'=>'Invalid Request'));
        } else {
            $product_bundles = explode(',', $product_bundles);
            $this->Public_model->createProductBundles($this->vendor_id, $main_bundle, $product_bundles);
            echo json_encode(array('success'=>true));
        }
    }

    public function get_products_by_category() {
        $cat_id = $this->input->post('category_id');
        if(!$cat_id) {
            echo json_encode(array('success'=>false, 'error_msg'=>'Invalid Product'));
        } else {
            $data = $this->Public_model->getProducts(base64_encode($this->vendor_id), $cat_id, 0, 0);
            $products = array();
            if($data) {
                foreach($data as $item) {
                    $products[] = array(
                        'product_id'=>base64_encode($item['product_id']), 
                        'product_name'=>truncate($item['product_name'], 70), 
                        'real_name'=>$item['product_name'],
                        'image' => get_small_image($item['image'], 100)
                    );
                }
            }
            echo json_encode(array('success'=>true, 'products'=>$products));
        }
    }

    private function _get_product_detail(&$products) {
        foreach($products as &$product) {      
            $id = $product['product_id'];
            $product['products_addition_image'] = $this->Public_model->getAdditionalImage(base64_encode($id));
            $label = $product['filter_label'];
            $html = '';
            if($label) {
                $label = json_decode($label, true);                                            
                $style = '';
                if($label['bold']){
                    $style = 'font-weight:bold;';
                }
                if($label['color']) {
                    $style .='color:'.$label['color'].';';
                }
                if($label['label']){
                    $html = '<span';
                    if($style) $html .= ' style="'.$style.'"';
                    $html .= '>'.$label['label'].'</span>';
                }                
            }
            $product['solds'] = $html;            
        }
    }

}
