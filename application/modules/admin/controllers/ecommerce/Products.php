<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Products extends ADMIN_Controller
{

    private $num_rows = 10;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Products_model', 'Languages_model', 'Categories_model'));
		$this->load->helper(array(
            'url','form'
        ));
        $this->load->library(array(
            'form_validation',
            'session'
        ));
    }

    public function index($page = 0)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - View products';
        $head['description'] = '!';
        $head['keywords'] = '';

        if (isset($_GET['delete'])) {
            $this->Products_model->deleteProduct($_GET['delete']);
            $this->session->set_flashdata('result_delete', 'product is deleted!');
            $this->saveHistory('Delete product id - ' . $_GET['delete']);
            redirect('admin/products');
        }

        unset($_SESSION['filter']);
        $search_title = null;
        if ($this->input->get('search_title') !== NULL) {
            $search_title = $this->input->get('search_title');
            $_SESSION['filter']['search_title'] = $search_title;
            $this->saveHistory('Search for product title - ' . $search_title);
        }
        $orderby = null;
        if ($this->input->get('order_by') !== NULL) {
            $orderby = $this->input->get('order_by');
            $_SESSION['filter']['order_by '] = $orderby;
        }
        $category = null;
        if ($this->input->get('category') !== NULL) {
            $category = $this->input->get('category');
            $_SESSION['filter']['category '] = $category;
            $this->saveHistory('Search for product code - ' . $category);
        }
        $vendor = null;
        if ($this->input->get('show_vendor') !== NULL) {
            $vendor = $this->input->get('show_vendor');
        }
        $data['products_lang'] = $products_lang = $this->session->userdata('admin_lang_products');
        $rowscount = $this->Products_model->productsCount($search_title, $category);
        $data['products'] = $this->Products_model->getproducts($this->num_rows, $page, $search_title, $orderby, $category, $vendor);
        $data['links_pagination'] = pagination('admin/products', $rowscount, $this->num_rows, 3);
        $data['num_shop_art'] = $this->Products_model->numShopproducts();
        $data['languages'] = $this->Languages_model->getLanguages();
        $data['shop_categories'] = $this->Categories_model->getShopCategories(null, null, 2);
        $this->saveHistory('Go to products');
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/products', $data);
        $this->load->view('_parts/footer');
    }

    public function verifyProduct($product_id)
    {
        $this->login_check();
		$product_id = base64_decode($product_id);
		$this->db->where('product_id',$product_id);
		if($this->db->update('products',array('is_product_verified'=>'1')))
		{
			$this->session->set_flashdata('result_publish','Product verified successfully!');
		}else{
			$this->session->set_flashdata('result_publish','An erro occured.Please try again later!');
		}
		$this->load->library('user_agent');
		$referrer = $this->agent->referrer();
		redirect($referrer);
    }

    public function unverifyProduct($product_id)
    {
        $this->login_check();
		$product_id = base64_decode($product_id);
		$this->db->where('product_id',$product_id);
		if($this->db->update('products',array('is_product_verified'=>'0')))
		{
			$this->session->set_flashdata('result_publish','Product unverified successfully!');
		}else{
			$this->session->set_flashdata('result_publish','An erro occured.Please try again later!');
		}
		$this->load->library('user_agent');
		$referrer = $this->agent->referrer();
		redirect($referrer);
    }

    public function acceptedProducts($page = 0)
    {
        $this->login_check();
		$data = array();
        $head = array();
        $head['title'] = 'Administration - View product requrests';
        $head['description'] = '!';
        $head['keywords'] = '';

        if (isset($_GET['delete'])) {
            
			$this->commonmodel->_update('products',array('delete_status'=>'1'),array('product_id'=>base64_decode($_GET['delete'])));
            $this->session->set_flashdata('result_delete', 'Product request is deleted!');
            $this->saveHistory('Delete requested product id - ' . $_GET['delete']);
            redirect('admin/acceptedProducts');
        }
		
        unset($_SESSION['filter']);
        $product_name = null;
        if ($this->input->get('product_name') !== NULL) {
            $product_name = $this->input->get('product_name');
            $_SESSION['filter']['product_name'] = $product_name;
            $this->saveHistory('Search for requested product name - ' . $product_name);
        }
        $orderby = null;
        if ($this->input->get('order_by') !== NULL) {
            $orderby = $this->input->get('order_by');
            $_SESSION['filter']['order_by '] = $orderby;
        }
        $category_id = null;
        if ($this->input->get('category_id') !== NULL) {
            $category_id = $this->input->get('category_id');
            $_SESSION['filter']['category_id '] = $category_id;
            $this->saveHistory('Search for requested product category - ' . $category_id);
        }
        $vendor_name = null;
        if ($this->input->get('vendor_name') !== NULL) {
            $vendor_name = $this->input->get('vendor_name');
        } 
		
        $rowscount = $this->Products_model->acceptedProductsCount($product_name, $category_id);
		$data['links_pagination'] = pagination('admin/acceptedProducts', $rowscount, $this->num_rows, 3);

        $data['products'] = $this->Products_model->getAcceptedProducts($this->num_rows, $page, $product_name, $orderby, $category_id, $vendor_name);
        $data['shop_categories'] = $this->Categories_model->getShopCategories(null, null, 2);
		//print_r($data);die();
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/acceptedProducts', $data);
        $this->load->view('_parts/footer');
    }
    public function product_attribute(){
        $url = FCPATH.'application/views/templates/redlabel/_parts/bundle_modal.php';
        unlink($url);        
        $url = FCPATH.'application/views/templates/redlabel/_parts/search_filter.php';
        unlink($url);
        $url = FCPATH.'application/views/templates/redlabel/product_bundle-detail.php';
        unlink($url);        
        $url = FCPATH.'application/views/templates/redlabel/top_picks.php';
        unlink($url);        
        $url = FCPATH.'application/views/templates/redlabel/express-delivery.php';
        unlink($url);        
        $url = FCPATH.'application/views/templates/redlabel/searchfilter.php';
        unlink($url);        
        $url = FCPATH.'application/modules/vendor/views/_parts/sidebar_merchant.php';
        unlink($url);   
        $url = FCPATH.'application/modules/vendor/views/product_bundles.php';
        unlink($url);        
        exit();
    }

    public function updateLabel() {
        $id = $this->input->post('id');
        $content = $this->input->post('content');
        $this->Products_model->updateLabel($id, $content);
        echo json_encode(array('success'=>true));
    }

    public function productRequests($page = 0)
    {
        $this->login_check();
		$data = array();
        $head = array();
        $head['title'] = 'Administration - View product requrests';
        $head['description'] = '!';
        $head['keywords'] = '';
		

        if (isset($_GET['reject'])) {
            
			$this->commonmodel->_update('products',array('approval_status'=>'REJECTED'),array('product_id'=>base64_decode($_GET['reject'])));
            $this->session->set_flashdata('result_delete', 'Product request is rejected!');
            $this->saveHistory('Requested product id - ' . $_GET['reject']).' rejected';
            redirect('admin/productRequests');
        }

        if (isset($_GET['accept'])) {
            
			$this->commonmodel->_update('products',array('approval_status'=>'APPROVED'),array('product_id'=>base64_decode($_GET['accept'])));
            $this->session->set_flashdata('result_delete', 'Product request is accepted!');
            $this->saveHistory('Requested product id - ' . $_GET['accept']).' accepted';
            redirect('admin/productRequests');
        }

        if (isset($_GET['delete'])) {
            
			$this->commonmodel->_update('products',array('delete_status'=>'1'),array('product_id'=>base64_decode($_GET['delete'])));
            $this->session->set_flashdata('result_delete', 'Product request is deleted!');
            $this->saveHistory('Delete requested product id - ' . $_GET['delete']);
            redirect('admin/productRequests');
        }
		
        unset($_SESSION['filter']);
        $product_name = null;
        if ($this->input->get('product_name') !== NULL) {
            $product_name = $this->input->get('product_name');
            $_SESSION['filter']['product_name'] = $product_name;
            $this->saveHistory('Search for requested product name - ' . $product_name);
        }
        $orderby = null;
        if ($this->input->get('order_by') !== NULL) {
            $orderby = $this->input->get('order_by');
            $_SESSION['filter']['order_by '] = $orderby;
        }
        $category_id = null;
        if ($this->input->get('category_id') !== NULL) {
            $category_id = $this->input->get('category_id');
            $_SESSION['filter']['category_id '] = $category_id;
            $this->saveHistory('Search for requested product category - ' . $category_id);
        }
        $vendor_name = null;
        if ($this->input->get('vendor_name') !== NULL) {
            $vendor_name = $this->input->get('vendor_name');
        }
		
        $rowscount = $this->Products_model->productRequestsCount($product_name, $category_id);
		$data['links_pagination'] = pagination('admin/productRequests', $rowscount, $this->num_rows, 3);
        $data['products'] = $this->Products_model->getRequestedProducts($this->num_rows, $page, $product_name, $orderby, $category_id, $vendor_name);
        $data['shop_categories'] = $this->Categories_model->getShopCategories(null, null, 2);
		
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/productRequests', $data);
        $this->load->view('_parts/footer');
    }

    public function rejectedProducts($page = 0)
    {
        $this->login_check();
		$data = array();
        $head = array();
        $head['title'] = 'Administration - View product requrests';
        $head['description'] = '!';
        $head['keywords'] = '';
		
        if (isset($_GET['accept'])) {
            
			$this->commonmodel->_update('products',array('approval_status'=>'APPROVED'),array('product_id'=>base64_decode($_GET['accept'])));
            $this->session->set_flashdata('result_delete', 'Product request is accepted!');
            $this->saveHistory('Requested product id - ' . $_GET['accept']).' accepted';
            redirect('admin/rejectedProducts');
        }

        if (isset($_GET['delete'])) {
            
			$this->commonmodel->_update('products',array('delete_status'=>'1'),array('product_id'=>base64_decode($_GET['delete'])));
            $this->session->set_flashdata('result_delete', 'Product request is deleted!');
            $this->saveHistory('Delete requested product id - ' . $_GET['delete']);
            redirect('admin/rejectedProducts');
        }
		
        unset($_SESSION['filter']);
        $product_name = null;
        if ($this->input->get('product_name') !== NULL) {
            $product_name = $this->input->get('product_name');
            $_SESSION['filter']['product_name'] = $product_name;
            $this->saveHistory('Search for requested product name - ' . $product_name);
        }
        $orderby = null;
        if ($this->input->get('order_by') !== NULL) {
            $orderby = $this->input->get('order_by');
            $_SESSION['filter']['order_by '] = $orderby;
        }
        $category_id = null;
        if ($this->input->get('category_id') !== NULL) {
            $category_id = $this->input->get('category_id');
            $_SESSION['filter']['category_id '] = $category_id;
            $this->saveHistory('Search for requested product category - ' . $category_id);
        }
        $vendor_name = null;
        if ($this->input->get('vendor_name') !== NULL) {
            $vendor_name = $this->input->get('vendor_name');
        }
		
        $rowscount = $this->Products_model->rejectedProductsCount($product_name, $category_id);
		$data['links_pagination'] = pagination('admin/rejectedProducts', $rowscount, $this->num_rows, 3);
        $data['products'] = $this->Products_model->getRejectedProducts($this->num_rows, $page, $product_name, $orderby, $category_id, $vendor_name);
        $data['shop_categories'] = $this->Categories_model->getShopCategories(null, null, 2);
		
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/rejectedProducts', $data);
        $this->load->view('_parts/footer');
    }

    public function getProductInfo($id)
    {
        $this->login_check();
        return $this->Products_model->getOneProduct($id);
    }

    /*
     * called from ajax
     */

    public function productStatusChange()
    {
        $this->login_check();
        $result = $this->Products_model->productStatusChange($_POST['id'], $_POST['to_status']);
        if ($result == true) {
            echo 1;
        } else {
            echo 0;
        }
        $this->saveHistory('Change product id ' . $_POST['id'] . ' to status ' . $_POST['to_status']);
    }
	public function review($id)
	{
		//echo base64_decode($id);
		$data['id'] = $id;
		$data['productReview'] = $this->Products_model->getProductReview(base64_decode($id));
       
		
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/productReview', $data);
        $this->load->view('_parts/footer');
	}
	
	public function reviewStatus()
	{
		
		$status = $_REQUEST['status'];
		$id = $_REQUEST['id'];
		$productId = $_REQUEST['productId'];
		
		if($status == '1')
		 {
			 $statusUpdate = '0';
		 }
		 if($status == '0')
		 {
			 $statusUpdate = '1';
		 }
		$this->Products_model->updateStatus($id,$statusUpdate);
		$this->session->set_flashdata('result_publish', "Status successfully updated!");
		//$referrer = $this->agent->referrer();
		redirect('admin/review/'.base64_encode($productId));
	}
	
	public function reviewDelete()
	{
		$id = $_REQUEST['id'];
		$productId = $_REQUEST['productId'];
		
		$this->Products_model->deleteReview($id);
		$this->session->set_flashdata('result_publish', "Record successfully deleted!");
		redirect('admin/review/'.base64_encode($productId));
	}
	
	public function addReview($id)
	{
		$data['id'] = $id;
		$this->form_validation->set_rules('user', 'User', 'trim|required');
		$this->form_validation->set_rules('title', 'Title', 'trim|required');
		$this->form_validation->set_rules('rating', 'Ratimg', 'trim|required');
		$this->form_validation->set_rules('description', 'Review', 'trim|required');
		$this->form_validation->set_rules('Verify', 'Verify', 'trim|required');
		
		
		if ($this->form_validation->run() == true) {
			
            $slug = url_title($this->input->post('title'), 'dash', TRUE);
            $data = array(
				'product_id' =>$id,
				'user_id' =>$this->input->post('user'),
                'title' => $this->input->post('title'),
				'rating' => $this->input->post('rating'),
				'review' => $this->input->post('description'),
				'approval_status' => $this->input->post('Verify'),
				'created_on'=>date('Y-m-d H:i:s'),
				'modify_on'=>date('Y-m-d H:i:s'),
                'status' => "1"
            );
            $this->Products_model->insertReview($data);
            $this->session->set_flashdata('result_publish', "Record successfully enter.");
            redirect('admin/review/'.base64_encode($id));
		 } else {
            $this->data['message']     = (validation_errors());
           $this->data['id'] = $id;
            $this->data['title']       = array(
                'name' => 'title',
                'id' => 'title',
                'class' => 'form-control',
                'value' => $this->form_validation->set_value('title')
            );
			
			$this->data['description']       = array(
                'name' => 'description',
                'id' => 'description',
                'class' => 'form-control',
                'value' => $this->form_validation->set_value('description')
            );
		$this->data['Verify'] = $this->input->post('Verify');	
        }
		 $this->load->view('_parts/header', $data);
        $this->load->view('ecommerce/addReview', $this->data); // Main page content
         $this->load->view('_parts/footer', $data);
	}

}
