<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class VENDOR_Controller extends MX_Controller
{

    protected $allowed_img_types;
    public $vendor_id;
    public $store_name;
    public $vendor_name;
    public $vendor_url;
    public $vendor_image;
    public $vendor_email;

    public function __construct()
    {
        parent::__construct();
        $this->loginCheck();
        $this->setVendorInfo();
        $this->allowed_img_types = $this->config->item('allowed_img_types');
        $vars = array();
        $vars['store_name'] = $this->store_name;
        $vars['vendor_name'] = $this->vendor_name;
        $vars['vendor_url'] = $this->vendor_url;
        $vars['vendor_image'] = $this->vendor_image;
        $vars['vendor_email'] = $this->vendor_email;
		
		$all_categories = $this->Public_model->getShopCategories();
		function buildTree1(array $elements, $parentId = 0)
        {
            $branch = array();
            foreach ($elements as $element) {
                if ($element['sub_for'] == $parentId) {
                    $children = buildTree1($elements, $element['id']);
                    if ($children) {
                        $element['children'] = $children;
                    }
                    $branch[] = $element;
                }
            }
            return $branch;
        }

        $vars['nav_categories'] = $tree = buildTree1($all_categories);
		$vars['unseenNotificationCount'] = $this->Vendorprofile_model->getUnseenNotificationsCount($this->vendor_id);
        $this->load->vars($vars);
		
        if (isset($_POST['saveVendorDetails'])) {
            $this->saveNewVendorDetails();
        }
    }

    protected function loginCheck()
    {
        if (!isset($_SESSION['logged_vendor']) && get_cookie('logged_vendor') != null) {
            $_SESSION['logged_vendor'] = get_cookie('logged_vendor');
        }
        $authPages = array(
            'vendor',
            'vendor/login',
            'vendor/register',
            'vendor/getStates',
            'vendor/getCities',
            'vendor/forgotten-password',
            'vendor/forgot-password-vefication',
            'vendor/checkUseremail',
            'vendor/verify-account',
            'vendor/shopping-approach',
             'vendor/success-story',
        );
        $urlString = uri_string();
        if (preg_match('/[a-zA-Z]{2}/', $urlString)) {
            $urlString = preg_replace('/^[a-zA-Z]{2}\//', '', $urlString);
        }
		
		$controller = $this->uri->segment(1);
		$page = $this->uri->segment(2);
		$page1 = $this->uri->segment(3);
		if(($page=='verify-account' || $page=='forgot-password-vefication' || $page1=='change-theme') && $controller=='vendor')
		{
			$urlString = 'vendor/verify-account';
		}
		
		if(!isset($_SESSION['logged_vendor']) && !in_array($urlString, $authPages)) {
            redirect(LANG_URL . '/vendor/login');
        } else if (isset($_SESSION['logged_vendor']) && in_array($urlString, $authPages)) {
            redirect(LANG_URL . '/vendor/sales-merchant');
        }
    }

    protected function setLoginSession($email, $remember_me)
    {
        if ($remember_me == true) {
            set_cookie('logged_vendor', $email, 2678400);
        }
        $_SESSION['logged_vendor'] = $email;
    }
    protected function deleteVendorInfo(){
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

    private function setVendorInfo()
    {
        $this->load->model('Vendorprofile_model');
        if (isset($_SESSION['logged_vendor'])) {
            $array = $this->Vendorprofile_model->getVendorInfoFromEmail($_SESSION['logged_vendor']);
            $this->vendor_id = $array['id'];
            $this->store_name = $array['store_name'];
            $this->vendor_name = $array['name'];
            $this->vendor_url = $array['url'];
            $this->vendor_image = $array['image'];
            $this->vendor_email = $array['email'];
            $this->vendor_express_status = $array['express_approve_status'];
        }
    }

    private function saveNewVendorDetails()
    {
        $errors = array();
        if (mb_strlen(trim($_POST['vendor_name'])) == 0) {
            $errors[] = lang('enter_vendor_name');
        }
        if (mb_strlen(trim($_POST['vendor_url'])) == 0) {
            $errors[] = lang('enter_vendor_url');
        }
        if (!$this->Vendorprofile_model->isVendorUrlFree($_POST['vendor_url'])) {
            $errors[] = lang('vendor_url_taken');
        }
        if (empty($errors)) {
            $this->session->set_flashdata('update_vend_details', lang('vendor_details_updated'));
            $this->Vendorprofile_model->saveNewVendorDetails($_POST, $this->vendor_id);
        } else {
            $this->session->set_flashdata('update_vend_err', $errors);
        }
        redirect(LANG_URL . '/vendor/me');
    }

}
