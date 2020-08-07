<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller
{
    
    private $num_rows = 20;
    private $sellerProductLimit = SELLER_PRODUCT_LIMIT;
    private $filterProductLimit = FILTER_PRODUCT_LIMIT;
    private $filterVendorReviewLimit = FILTER_VENDOR_REVIEW_LIMIT;
    private $filterProductReviewLimit = FILTER_PRODUCT_REVIEW_LIMIT;
    
    public function __construct()
    {
        parent::__construct();
        ini_set('display_errors', 1);
        $this->load->Model('admin/Brands_model');
        $this->load->Library('phpmailer');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->Model('Public_model');
        $this->load->helper('cookie');
    }
    
    public function featured($page = 0)
    {
        $this->session->unset_userdata('mysearchids');
        $data                         = array();
        $head                         = array();
        $arrSeo                       = $this->Public_model->getSeo('home');
        $head['title']                = @$arrSeo['title'];
        $head['description']          = @$arrSeo['description'];
        $head['keywords']             = str_replace(" ", ",", $head['title']);
        $all_categories               = $this->Public_model->getShopCategories();
        $data['all_categories']       = $all_categories;
        $data['sliders']              = $this->Public_model->getSlider('featured');
        $data['home_categories']      = $this->getHomeCategories($all_categories);
        $limit                        = $this->filterProductLimit;
        $data['wishlist_Product_ids'] = $this->Public_model->getWishlistProductIds();
        // echo "string";
        // print_r($data['wishlist_Product_ids']);die();
        $data["productsCount"]        = $this->Public_model->getProductsCount('', '', '');
        if (!empty($_SESSION['logged_user']['id'])) {
            
            $user                  = $_SESSION['logged_user']['id'];
            $result                = $this->Public_model->searchid($user);
           
            $data['recentproduct'] = $this->Public_model->recentproduct($result['searchkey']); 
                  
            foreach ($data['recentproduct'] as $key => $value) {
                $searchp[] = $value['product_id'];
            }
            
            
            $full = implode(',', $searchp);
            
            $this->session->set_userdata('mysearchids', $full);
        } else {
            $searchp               = array();            
            $search                = $this->input->cookie('nonlogin', true);
            if(!empty($search)){
	            $data['recentproduct'] = $this->Public_model->recentproduct($search); //     
	            foreach ($data['recentproduct'] as $key => $value) {
	                $searchp[] = $value['product_id'];
	            }	            
	            
	            $full = implode(',', $searchp);
	            
	            $this->session->set_userdata('mysearchids', $full);
            }
        }
        $data["products"] = $this->Public_model->getProducts('', '', $limit, 0);      
        
        $data['limit']  = $limit;
        $data['offset'] = 0;
        $this->render('home', $head, $data);
    }

    public function index($page = 0) {        
        $this->session->unset_userdata('mysearchids');
        $data                         = array();
        $head                         = array();
        $arrSeo                       = $this->Public_model->getSeo('home');
        $head['title']                = @$arrSeo['title'];
        $head['description']          = @$arrSeo['description'];
        $head['keywords']             = str_replace(" ", ",", $head['title']);
        $all_categories               = $this->Public_model->getShopCategories();        
        $data['all_categories']       = $all_categories;  
        $limit                        = $this->filterProductLimit;    
        $limit_bundle = 4;  
        $data["productsCount"]        = $this->Public_model->getProductsCount('', '', '');
        $data['bundlesCount']         = $this->Public_model->getProductsCount('', '', '', true);
        $data['product_bundles']      = $this->Public_model->getProducts('', '', $limit_bundle, 0, '', '', '', '', '0', '', true);
        if (!empty($_SESSION['logged_user']['id'])) {
            
            $user                  = $_SESSION['logged_user']['id'];
            $result                = $this->Public_model->searchid($user);
           
            $recentproduct = $this->Public_model->recentproduct($result['searchkey']); 
                  
            foreach ($recentproduct as $key => $value) {
                $searchp[] = $value['product_id'];
            }
            
            
            $full = implode(',', $searchp);
            
            $this->session->set_userdata('mysearchids', $full);
        } else {
            $searchp               = array();            
            $search                = $this->input->cookie('nonlogin', true);
            if(!empty($search)){
	            $recentproduct = $this->Public_model->recentproduct($search); //     
	            foreach ($recentproduct as $key => $value) {
	                $searchp[] = $value['product_id'];
	            }	            
	            
	            $full = implode(',', $searchp);
	            
	            $this->session->set_userdata('mysearchids', $full);
            }
        }
        $products = $this->Public_model->getProducts('', '', $limit, 0);
        $data['recentproduct'] = array(); $ids = array();
        if($recentproduct) {
            $data['recentproduct'] = $recentproduct;
            foreach($recentproduct as $row) {                
                $ids[] = $row['product_id'];
            }
        }
        if($products){
            foreach($products as $row) {
                if(!in_array($row['product_id'], $ids)) {
                    array_push($data['recentproduct'], $row);                    
                }
            }
        }
        $this->_get_product_detail($data['recentproduct']); 
        $data['limit']  = $limit;
        $data['offset'] = 0;
        $data['limit_bundles'] = $limit_bundle;
        $data['offset_bundles'] = 0;
        $this->render('top_picks', $head, $data);
        $this->load->view($this->template . '_parts/bundle_modal');        
    }
    
    public function expressDelivery()
    {
        $this->session->unset_userdata('mysearchids');
        $data                         = array();
        $head                         = array();
        $arrSeo                       = $this->Public_model->getSeo('home');
        $head['title']                = @$arrSeo['title'];
        $head['description']          = @$arrSeo['description'];
        $head['keywords']             = str_replace(" ", ",", $head['title']);
        $all_categories               = $this->Public_model->getShopCategories();
        $data['all_categories']       = $all_categories;
        $data['sliders']              = $this->Public_model->getSlider('featured');
        $data['home_categories']      = $this->getHomeCategories($all_categories);
        $limit                        = $this->filterProductLimit;
        $data['wishlist_Product_ids'] = $this->Public_model->getWishlistProductIds();
        $data["productsCount"]        = $this->Public_model->getProductsCount('', '', '');
        $express_products             = '1';
        $data["products"]             = $this->Public_model->getProducts('', '', $limit, 0, '', '', '', '', $express_products);
        $this->_get_product_detail($data['products']); 
        //print_r($data['products']);
        $data['limit']                = $limit;
        $data['offset']               = 0;
        $this->render('express-delivery', $head, $data);
    }
    
    public function view_search() {
        $data                         = array();
        $head                         = array();
        $arrSeo                       = $this->Public_model->getSeo('home');
        $head['title']                = 'Search';
        $head['description']          = @$arrSeo['description'];
        $head['keywords']             = str_replace(" ", ",", $head['title']);    
        $head['view_search']          = true;
        $this->render('search', $head, $data);
    }
    
    
    public function gadgets()
    {
        $this->session->unset_userdata('mysearchids');
        //echo ip_info(NULL,'countrycode'); die;
        $data                    = array();
        $head                    = array();
        $head['title']           = 'Gadgets';
        $head['description']     = 'Gadgets';
        $all_categories          = $this->Public_model->getShopCategories();
        $data['home_categories'] = $this->getHomeCategories($all_categories);
        
        $limit                        = $this->filterProductLimit;
        $data['wishlist_Product_ids'] = $this->Public_model->getWishlistProductIds();
        $gadgets_category_id          = GADGETS_CATEG_ID;
        $data["productsCount"]        = $this->Public_model->getProductsCount('', $gadgets_category_id, '');
        $data["products"]             = $this->Public_model->getProducts('', $gadgets_category_id, $limit, 0);
        $data['limit']                = $limit;
        $data['offset']               = 0;
        
        
        $data['sliders']        = $this->Public_model->getSlider('gadget');
        //pr($data['home_categories'] ,1);
        $data['all_categories'] = $all_categories;
        $head['keywords']       = '';
        $this->render('gadgets', $head, $data);
    }
    
    public function fashion()
    {
        $this->session->unset_userdata('mysearchids');
        $data                    = array();
        $head                    = array();
        $head['title']           = 'Fashion';
        $head['description']     = 'Fashion';
        $all_categories          = $this->Public_model->getShopCategories();
        $data['home_categories'] = $this->getHomeCategories($all_categories);
        
        $limit                        = $this->filterProductLimit;
        $data['wishlist_Product_ids'] = $this->Public_model->getWishlistProductIds();
        $gadgets_category_id          = FASHION_CATEG_ID;
        $data["productsCount"]        = $this->Public_model->getProductsCount('', $gadgets_category_id, '');
        $data["products"]             = $this->Public_model->getProducts('', $gadgets_category_id, $limit, 0);
        $data['limit']                = $limit;
        $data['offset']               = 0;
        
        $data['sliders']        = $this->Public_model->getSlider('fashion');
        //pr($data['home_categories'] ,1);
        $data['all_categories'] = $all_categories;
        $head['keywords']       = '';
        $this->render('fashion', $head, $data);
    }
    
    public function change_theme($theme = 'light')
    {
        
        if ($theme == 'dark') {
            $_SESSION['theme'] = 'dark';
        } else {
            $_SESSION['theme'] = 'light';
        }
        $this->load->library('user_agent');
        $referrer = $this->agent->referrer();
        redirect($referrer);
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

    public function get_product($id) {
        $product = $this->Public_model->getProductsDetails($id);
        echo json_encode($product);
    }

    public function get_product_bundle() {
        $id = $this->input->post('id');
        $bundle_id = $this->input->post('bundle_id');
        $product_ids = $this->input->post('product_ids');
        if($product_ids!='') {
            $product_ids = explode(',', $product_ids);            
        } else {
            $product_ids = [$id];
        }
        $data = array();
        $data['product'] = $this->Public_model->getProductsDetails(base64_encode($id));
        $product_bundle = $this->Public_model->getVendorProductBundle($bundle_id);
        $exceed = true;
        $data['bundles'] = 1;
        if($product_bundle && sizeof($product_bundle)>0) {
            $data['bundles'] = sizeof($product_bundle[0]['product_bundles']) + 1;
            foreach($product_bundle[0]['product_bundles'] as $bundle) {
                if(!in_array($bundle['product_id'], $product_ids)) {
                    $product_ids[] = $bundle['product_id'];
                    $exceed = false;
                    break;
                }
            }
        }        
        $data['product_ids'] = $product_ids;
        $data['bundle_id'] = $bundle_id;
        $data['exceed'] = $exceed;
        $data['product_id'] = base64_encode($id);
        echo json_encode($data);
    }
    
    public function products_filter($category_id = '0')
    {
        $this->session->unset_userdata('mysearchids');
        $data                = array();
        $head                = array();
        $arrSeo              = $this->Public_model->getSeo('home');
        $head['title']       = @$arrSeo['title'];
        $head['description'] = @$arrSeo['description'];
        $head['keywords']    = str_replace(" ", ",", $head['title']);
        
        $data['wishlist_Product_ids'] = $this->Public_model->getWishlistProductIds();
        //print_r($data);die();
        if ($this->input->post()) {
            $post                  = $this->input->post();
            //pr($post,1);
            $product_name          = $post['product_name'];
            $limit                 = $this->filterProductLimit;
            $data["productsCount"] = $this->Public_model->getProductsCount('', '', $product_name);
            $data["products"]      = $this->Public_model->getProducts('', '', $limit, 0, $product_name);            
            $head['category_name'] = '';
            $head['product_name']  = $product_name;
            $data['limit']         = $limit;
            $data['offset']        = 0;
            $this->render('products_filter', $head, $data);
            //pr($post,1);
        } else {
            if ($category_id != '0') {
                $category_id           = base64_decode($category_id);
                $limit                 = $this->filterProductLimit;
                $data["productsCount"] = $this->Public_model->getProductsCount('', $category_id, '');
                $data["products"]      = $this->Public_model->getProducts('', $category_id, $limit, 0, '');
                $category_name         = $this->Public_model->getCategoryById($category_id);
                $head['category_name'] = $category_name;
                $head['product_name']  = '';
                $data['limit']         = $limit;
                $data['offset']        = 0;
                $this->render('products_filter', $head, $data);
            } else {
                redirect(base_url());
            }
        }
    }
    
    public function filterProducts()
    {
        $post = $this->input->post();
        
        if (!$this->input->is_ajax_request()) {
            //exit('No direct script access allowed');
        }
        $page = $this->uri->segment(3);        
        
        $product_name = $this->input->post('product_name');
        $category_id  = '';
        if ($this->input->post('category_id')) {
            $category_id = $this->input->post('category_id');
            if (base64_encode(base64_decode($category_id)) === $category_id) {
                $category_id = base64_decode($category_id);
            }
        }
        if ($page == 'gadgets') {
            $category_id = GADGETS_CATEG_ID;
        }
        if ($page == 'fashion') {
            $category_id = FASHION_CATEG_ID;
        }
        $express_required = '0';
        if ($page == 'express-delivery') {
            $express_required = '1';
        }
        $sort_product = '';
        if ($this->input->post('sort_product')) {
            $sort_product = $this->input->post('sort_product');
        }
        $header_color_id = '';
        if ($this->input->post('header_color_id')) {
            $header_color_id = $this->input->post('header_color_id');
        }
        $header_filter_star = '';
        if ($this->input->post('header_filter_star')) {
            $header_filter_star = $this->input->post('header_filter_star');
        }
        if ($this->input->post('express_filter')) {
            $express_required = '1';
        }
        $document_width = $this->input->post('document_width');
        $offset         = $this->input->post('offset');
        $limit          = $this->filterProductLimit;
        
        $productsCount = $this->Public_model->getProductsCount('', '', $product_name);
        
        if($page == 'search') {
            $product_name = explode(' ', $product_name);
            $products = $this->Public_model->get_live_items($product_name, $sort_product, $header_color_id, $header_filter_star, $express_required);
        } else {
            $products = $this->Public_model->getProducts('', $category_id, $limit, $offset, $product_name, $sort_product, $header_color_id, $header_filter_star, $express_required);
        }        
        
        $wishlist_Product_ids = $this->Public_model->getWishlistProductIds();

        if(!$sort_product) {
        	shuffle($products);
        }
        	
        if (!empty($products)) {
            $this->_get_product_detail($products);
            
            foreach ($products as $key):
                $id          = base64_encode($key['product_id']);
                $productName = escape_product_name($key['product_name']);
                if($page!='' && $page != 'express-delivery' && $page != 'search'){
            ?>
           <div class="col-md-4 col-sm-4 col-lg-3 col-xl-2 product_ak wow fadeInUp">
                <div class="row">
                    <a href="<?= LANG_URL . '/products-details/' . $productName . '/' . $id ?>"><div class="porduct_img"><img src="<?= get_small_image($key['image']) ?>"/></div></a>
                    <a href="javascript:void(0);" class="add_to_wishlist" data-product_id="<?= $id ?>">
                    <?php
                $blankHeartStyle  = '';
                $filledHeartStyle = 'style="display:none;"';
                if (in_array($key['product_id'], $wishlist_Product_ids)) {
                    $blankHeartStyle  = 'style="display:none;"';
                    $filledHeartStyle = '';
                }
            ?>
                       <i class="fa fa-heart-o" <?= $blankHeartStyle ?>></i>
                        <i class="fa fa-heart" <?= $filledHeartStyle ?>></i>
                    </a>
                    <div class="product_dsp">
                        <span><?= $key['product_name'] ?></span>
                        <div class="ww">
                            <?php
                if ($key['is_product_verified'] == '1') {
            ?>
                               <img src="<?= LANG_URL . '/assets/web/' ?>images/prd_3.png" class="express_img express_img1"/>
                            <?php
                }
            ?>
                           <?php
                if ($key['nureso_express_status'] == '1') {
            ?>
                               <img src="<?= LANG_URL . '/assets/web/' ?>images/prd_1.png" class="express_img"/>
                            <?php
                }
            ?>
                           <a href="<?= LANG_URL . '/products-details/' . $productName . '/' . $id ?>"><button class="product_btn">£ <?= $key['price'] ?></button></a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <div class="col-sm-12 col-md-4 col-lg-3 col-xl-2 filter wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                <div class="row">                    
                    <div class="filter-item" data-id="<?php echo $id ?>">
                        <div class="d-flex">
                            <div class="thumb-imgs">
                                <a href="javascript:">
                                    <img src="<?php echo get_small_image($key['image'], '100'); ?>">
                                </a>
                                <?php foreach($key['products_addition_image'] as $addImag) :?>
                                    <a href="javascript:"> 
                                        <img src="<?=get_small_image($addImag['image'], '100')?>" width='555' height='320' />
                                    </a>
                                <?php endforeach; ?>
                            </div>
                            <div class="main-img" data-href="<?php echo base_url('products-details/'.$productName.'/'.$id) ?>">
                                <img src="<?php echo get_small_image($key['image']); ?>">
                            </div>
                        </div>
                        <div class="d-flex mt-2" data-href="<?php echo base_url('products-details/'.$productName.'/'.$id) ?>">
                            <span class="p-name truncate-overflow"><?php echo $key['product_name'] ?></span>
                            <span class="p-price">£<?php echo $key['price']?></span>
                        </div>
                        <div class="d-flex mt-2 justify-content-around">
                            <?php if($key['nureso_express_status']=='1'){ ?>
                            <img src="<?=LANG_URL.'/assets/web/'?>images/prd_1.png" class="express_img"/>
                            <?php } ?>
                            <?php if($key['is_product_verified']=='1'){ ?>
                            <img src="<?=LANG_URL.'/assets/web/'?>images/prd_3.png" class="express_img express_img1"/>
                            <?php } ?>
                            <?php if($key['solds']) { ?>
                            <span class="b-button"><?php echo $key['solds'] ?></span>
                            <?php } ?>
                            <a href="javascript:" class="b-button">Buy</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php }
        endforeach;
            if ($productsCount > $offset + $limit && $page!='search') {
            ?>
               <div class="row load_more_seller_products" style="display:none;">
                    <div class="clearfix"></div>
                    <img src="<?= IMG_URL . 'ajax-loader.gif' ?>" class="ajax-loader"/>
                    <?php
                if ($document_width <= '768') {
            ?>
                       <input type="button" id="loadMore" value="Load More" class="btm btn-primary"/>
                    <?php
                }
            ?>
               </div>
        <?php
            }
        } elseif ($offset < 1 && $page!='search') {
        ?>
           <br><h1 style="color: #ccc;" class="no-product-found">No Product Found !</h1>
        <?php
        } else {
            echo 'finish';
        }
    }

    public function filterProductBundles()
    {
        $post = $this->input->post();
        
        if (!$this->input->is_ajax_request()) {
            //exit('No direct script access allowed');
        }
        $page = $this->uri->segment(3);           
        
        $product_name = $this->input->post('product_name');
        $category_id  = '';
        if ($this->input->post('category_id')) {
            $category_id = $this->input->post('category_id');
            if (base64_encode(base64_decode($category_id)) === $category_id) {
                $category_id = base64_decode($category_id);
            }
        }
        if ($page == 'gadgets') {
            $category_id = GADGETS_CATEG_ID;
        }
        if ($page == 'fashion') {
            $category_id = FASHION_CATEG_ID;
        }
        $express_required = '0';
        if ($page == 'express-delivery') {
            $express_required = '1';
        }
        $sort_product = '';
        if ($this->input->post('sort_product')) {
            $sort_product = $this->input->post('sort_product');
        }
        $header_color_id = '';
        if ($this->input->post('header_color_id')) {
            $header_color_id = $this->input->post('header_color_id');
        }
        $header_filter_star = '';
        if ($this->input->post('header_filter_star')) {
            $header_filter_star = $this->input->post('header_filter_star');
        }
        if ($this->input->post('express_filter')) {
            $express_required = '1';
        }
        $document_width = $this->input->post('document_width');
        $offset         = $this->input->post('offset');
        $limit          = 4;
        
        $productsCount = $this->Public_model->getProductsCount('', '', $product_name, true);
        
        if($page == 'search') {
            $product_name = explode(' ', $product_name);            
            $products = $this->Public_model->get_live_items($product_name, $sort_product, $header_color_id, $header_filter_star, $express_required, true);
        } else {
            $products = $this->Public_model->getProducts('', $category_id, $limit, $offset, $product_name, $sort_product, $header_color_id, $header_filter_star, $express_required, '', 1);
        }        

        if(!$sort_product) {
        	shuffle($products);
        }
        $grid_mode = $this->input->post('grid_mode');
        if (!empty($products)) {
            $this->_get_product_detail($products);            
            $rows = ''; $data = array();
            foreach ($products as $row){
                $id = base64_encode($row['main_bundle']);
                $product_id = base64_encode($row['product_id']);
				$productName = escape_product_name($row['product_name']); 
				$product_ids = [base64_encode($row['product_id'])]; $express = ''; $verified = '';$price = $row['price'];
				if($row['nureso_express_status']== '1') 
					$express = '<img src="'.LANG_URL.'/assets/web/images/prd_1.png" class="express_img"/>';
				if($row['is_product_verified']== '1')
                    $verified = '<img src="'.LANG_URL.'/assets/web/images/prd_3.png" class="express_img express_img1"/>';		

                $item = '<div class="filter-item" data-id="'.base64_encode($row['product_id']).'">
                            <div class="d-flex">
                                <div class="bundle_images" data-href="'.base_url('product_bundle-details/'.$productName.'/'.$product_id.'/'.$id).'">
                                    <div class="image_container"><img src="'.get_small_image($row['image']).'" style="width:100%"/></div>';
                                    if(sizeof($row['product_bundles'])>0) {
                                        foreach($row['product_bundles'] as $bundle) {
                                            $item .= '<div class="image_container"><img src="'.get_small_image($bundle['image']).'" style="width:100%"/></div>';
                                            $product_ids[] = base64_encode($bundle['product_id']);
                                            $price += $bundle['price'];
                                        }
                                    }
                    $item .= ' 	</div>
                            </div>
                            <div class="express_container">
                                '.$verified.$express.'<span class="p-price">£'.$price.'</span>	
                                <button class="btn btn-primary btn-buy-bundle" data-id="'.$row['product_id'].'" data-bundle="'.$row['main_bundle'].'">Buy Bundle</button>
                            </div>
                            <input type="hidden" name="product_ids" value="'.implode(',', $product_ids).'"/>							
                        </div>';			
                if($grid_mode) {                    
                    $rows .= '<div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 filter wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                        <div class="row">'.$item.'
                        </div>
                    </div>';
                } else {
                    $row = '<div class="fadeInUp">'.$item.'
                    </div>';
                    $data[] = $row;
                }
            }
            if($grid_mode) {
                echo json_encode(array('data'=>$rows));
            } else {
                echo json_encode(array('data'=>$data));
            }
        } else {
            echo json_encode(array('data'=>'finish'));
        }
    }    
    
    public function product_details($product_name, $product_id)
    {
        /*if(isset($_SESSION['logged_user'])){
        echo 'yes'; exit;
        }*/
        
        $data                            = array();
        $head                            = array();
        $arrSeo                          = $this->Public_model->getSeo('home');
        //$head['title'] = @$arrSeo['title'];
        $head['title']                   = 'Product Details - ' . str_replace('-', ' ', $product_name);
        $head['description']             = @$arrSeo['description'];
        $head['keywords']                = str_replace(" ", ",", $head['title']);
        $data["products"]                = $this->Public_model->getProducts();
        $data["relatedProducts"]         = $this->Public_model->getRelatedProducts(base64_decode($product_id));
        $data["products_addition_image"] = $this->Public_model->getAdditionalImage($product_id);
        $products_detail                 = $this->Public_model->getProductsDetails($product_id);
        if ($products_detail['nureso_express_status'] == '1' && $products_detail['express_approve_status'] != 'ACCEPT') {
            redirect('/');
        }
        //pr($products_detail,1);
        $vendor_id                    = $products_detail['vendor_id'];
        $data['wishlist_Product_ids'] = $this->Public_model->getWishlistProductIds();
        
        $logged_user           = $this->session->userdata('logged_user');
        $user_id               = $logged_user['id'];
        $data['messageStatus'] = $this->Public_model->checkIfmessagedOnProduct(base64_decode($product_id), $user_id, $vendor_id);
        
        $vendorReviewLimit          = $this->filterVendorReviewLimit;
        $data['vendorReviewLimit']  = $vendorReviewLimit;
        $data['offset']             = 0;
        $data["vendorReviewsCount"] = $this->Public_model->getVendorReviewsCount($vendor_id);
        $data["vendorAvgReviews"]   = $this->Public_model->getVendorReviewsAvg($vendor_id);
        $data['vendor_reviews']     = $this->Public_model->getVendorReviews($vendor_id, $vendorReviewLimit, 0);
        //print_r($data['vendor_reviews']);
        
        $product_id                  = base64_decode($product_id);
        $productReviewLimit          = $this->filterProductReviewLimit;
        $data['productReviewLimit']  = $productReviewLimit;
        $data['product_offset']      = 0;
        $data["productReviewsCount"] = $this->Public_model->getProductReviewsCount($product_id);
        $data["productAvgReviews"]   = $this->Public_model->getProductReviewsAvg($product_id, false);
        
        $data['product_reviews'] = $this->Public_model->getProductReviews($product_id, $productReviewLimit, 0);
        if (!empty($products_detail)) {
            $data['products_detail'] = $products_detail;
        } else {
            redirect('');
        }
        
        /*if($checkStatusExpressProduct){
        $data['products_detail'] = $products_detail;                  
        }
        else {
        redirect('');    
        }*/
        
        $this->render('product-detail', $head, $data);
        $this->load->view($this->template . 'modals');
    }

    public function product_bundle_details($product_name, $product_id, $bundle_id)
    {
        
        $data                            = array();
        $head                            = array();
        $arrSeo                          = $this->Public_model->getSeo('home');
        //$head['title'] = @$arrSeo['title'];
        $head['title']                   = 'Product Bundle Details - ' . str_replace('-', ' ', $product_name);
        $head['description']             = @$arrSeo['description'];
        $head['keywords']                = str_replace(" ", ",", $head['title']);        
        $data["relatedProductBundles"]   = $this->Public_model->getRelatedProductBundles(base64_decode($product_id));
        $vendorProductBundle             = $this->Public_model->getVendorProductBundle(base64_decode($bundle_id));
        $this->_get_product_detail($vendorProductBundle);
        if($vendorProductBundle && sizeof($vendorProductBundle)>0) {
            $this->_get_product_detail($vendorProductBundle[0]['product_bundles']);
            $data["vendorProductBundle"] = $vendorProductBundle[0];
        }
        $data["products_addition_image"] = $this->Public_model->getAdditionalImage($product_id);
        $products_detail                 = $this->Public_model->getProductsDetails($product_id);
        if ($products_detail['nureso_express_status'] == '1' && $products_detail['express_approve_status'] != 'ACCEPT') {
            redirect('/');
        }
        
        $vendor_id                    = $products_detail['vendor_id'];
        $data['wishlist_Product_ids'] = $this->Public_model->getWishlistProductIds();
        
        $logged_user           = $this->session->userdata('logged_user');
        $user_id               = $logged_user['id'];
        $data['messageStatus'] = $this->Public_model->checkIfmessagedOnProduct(base64_decode($product_id), $user_id, $vendor_id);
        
        $vendorReviewLimit          = $this->filterVendorReviewLimit;
        $data['vendorReviewLimit']  = $vendorReviewLimit;
        $data['offset']             = 0;
        $data["vendorReviewsCount"] = $this->Public_model->getVendorReviewsCount($vendor_id);
        $data["vendorAvgReviews"]   = $this->Public_model->getVendorReviewsAvg($vendor_id);
        $data['vendor_reviews']     = $this->Public_model->getVendorReviews($vendor_id, $vendorReviewLimit, 0);
        //print_r($data['vendor_reviews']);
        
        $product_id                  = base64_decode($product_id);
        $productReviewLimit          = $this->filterProductReviewLimit;
        $data['productReviewLimit']  = $productReviewLimit;
        $data['product_offset']      = 0;
        $data["productReviewsCount"] = $this->Public_model->getProductReviewsCount($product_id);
        $data["productAvgReviews"]   = $this->Public_model->getProductReviewsAvg($product_id, false);
        
        $data['product_reviews'] = $this->Public_model->getProductReviews($product_id, $productReviewLimit, 0);
        if (!empty($products_detail)) {
            $data['products_detail'] = $products_detail;
        } else {
            redirect('');
        }
        $data['product_id'] = $product_id;
        $data['bundle_id'] = base64_decode($bundle_id);
        $data['is_main'] = ($product_id == $data["vendorProductBundle"]['product_id']);
        $this->render('product_bundle-detail', $head, $data);
        $this->load->view($this->template . '_parts/bundle_modal');
        $this->load->view($this->template . 'modals');
    }
    
    public function filterSellerReviews($vendor_id)
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        $vendor_id    = base64_decode($vendor_id);
        $filter_stars = $this->input->post('filter_stars');
        if ($filter_stars == 'all') {
            $filter_stars = '';
        }
        $callfrom = '';
        if ($this->input->post('callfrom')) {
            $callfrom = 'vendor';
        }
        $offset             = $this->input->post('offset');
        $limit              = $this->filterVendorReviewLimit;
        $vendorReviewsCount = $this->Public_model->getVendorReviewsCount($vendor_id, $filter_stars);
        $vendor_reviews     = $this->Public_model->getVendorReviews($vendor_id, $limit, $offset, $filter_stars);
        if (!empty($vendor_reviews)) {
            foreach ($vendor_reviews as $vendor_review) {
?>
           <?php
                if ($callfrom == '') {
?>
               <div class="col-md-6 col-sm-6 col-lg-4 col-xl-3">
            <?php
                } else {
?>
               <div class="col-md-6 col-sm-6 col-lg-4 col-xl-4">
            <?php
                }
?>
               <div class="col-md-12 review_post">
                    <h6 title="<?= $vendor_review['name'] ?>"><?= strlen($vendor_review['name']) > 21 ? substr($vendor_review['name'], 0, 21) . '...' : $vendor_review['name'] ?><br>
                    <?php
                for ($i = 0; $i < (int) $vendor_review['rating']; $i++) {
?>
                       <i class="fa fa-star"></i>
                    <?php
                }
?>
                   </h6>
                    <small><?= formate_date($vendor_review['modify_on']) ?><br>
                    <i class="fa fa-heart"></i>
                    </small>
                    <p>
                        <?= strlen($vendor_review['review']) > 190 ? substr($vendor_review['review'], 0, 190) . '...' . '<a href="javascript:void(0);" class="view-rating" data-rater-name="' . $vendor_review['name'] . '">MORE</a>' : $vendor_review['review'] ?>
                       <span class="product_full_review" style="display:none;"><?= $vendor_review['review'] ?></span>
                        <span class="product_modify_on" style="display:none;"><?= formate_date($vendor_review['modify_on']) ?></span>
                        <span class="product_stars_html" style="display:none;">
                            <?php
                for ($i = 0; $i < (int) $vendor_review['rating']; $i++) {
?>
                               <i class="fa fa-star"></i>
                            <?php
                }
?>
                       </span>
                    </p>
                </div> 
            </div> 
        <?php
            }
            if ($vendorReviewsCount > $limit + $offset) {
?>
           <div class="row load_more_seller_products">
                <div class="clearfix"></div>
                <input type="button" id="loadMore" value="Load More" class="btm btn-primary"/>
            </div>
        <?php
            }
        } elseif ($filter_stars == '') {
            echo 'all_products_loaded';
        } else {
            echo '<h1 style="color:#ccc;">No Review Yet!</h1>';
        }
    }
    
    public function filterProductReviews($product_id)
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        $product_id   = base64_decode($product_id);
        $filter_stars = $this->input->post('filter_stars');
        if ($filter_stars == 'all') {
            $filter_stars = '';
        }
        
        $offset             = $this->input->post('product_offset');
        $limit              = $this->filterProductReviewLimit;
        $vendorReviewsCount = $this->Public_model->getProductReviewsCount($product_id, $filter_stars);
        $product_reviews    = $this->Public_model->getProductReviews($product_id, $limit, $offset, $filter_stars);
        if (!empty($product_reviews)) {
            foreach ($product_reviews as $product_review) {
?>
           <div class="col-md-6 col-sm-6 col-lg-4 col-xl-3">
                <div class="col-md-12 review_post">
                    <h6 title="<?= $product_review['name'] ?>"><?= strlen($product_review['name']) > 21 ? substr($product_review['name'], 0, 21) . '...' : $product_review['name'] ?><br>
                    <?php
                for ($i = 0; $i < (int) $product_review['rating']; $i++) {
?>
                       <i class="fa fa-star"></i>
                    <?php
                }
?>
                   </h6>
                    <small><?= formate_date($product_review['modify_on']) ?><br>
                    <i class="fa fa-heart"></i>
                    </small>
                    <p>
                        <?= strlen($product_review['review']) > 190 ? substr($product_review['review'], 0, 190) . '...' . '<a href="javascript:void(0);" class="view-rating" data-rater-name="' . $product_review['name'] . '">MORE</a>' : $product_review['review'] ?>
                       <span class="product_full_review" style="display:none;"><?= $product_review['review'] ?></span>
                        <span class="product_modify_on" style="display:none;"><?= formate_date($product_review['modify_on']) ?></span>
                        <span class="product_stars_html" style="display:none;">
                            <?php
                for ($i = 0; $i < (int) $product_review['rating']; $i++) {
?>
                               <i class="fa fa-star"></i>
                            <?php
                }
?>
                       </span>
                    </p>
                </div> 
            </div> 
        <?php
            }
            if ($vendorReviewsCount > $limit + $offset) {
?>
           <div class="row load_more_seller_products">
                <div class="clearfix"></div>
                <input type="button" id="loadMore" value="Load More" class="btm btn-primary"/>
            </div>
        <?php
            }
        } elseif ($filter_stars == '') {
            echo 'all_products_loaded';
        } else {
            echo '<h1 style="color:#ccc;">No Review Yet!</h1>';
        }
    }
    
    public function get_size_color_details()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        $response = $this->Public_model->get_size_color_details($this->input->post());
        echo json_encode($response, true);
    }
    
    public function logout()
    {
        unset($_SESSION['logged_user']);
        unset($_SESSION['shopping_cart']);
        @delete_cookie('shopping_cart');
        redirect(LANG_URL);
    }
    
    public function checkUserLogin()
    {
        if (!$this->session->userdata('logged_user')) {
            redirect(LANG_URL . '/login');
        }
    }
    
    
    
    public function check_useremail()
    {
        $json       = array();
        $user_email = $this->input->post('vendor_email');
        
        $data = $this->Public_model->check_user_email($user_email);
        
        if ($data > 0) {
            $isAvailable = false;
            $json        = array(
                'valid' => $isAvailable
            );
        } else {
            $isAvailable = true;
            $json        = array(
                'valid' => $isAvailable
            );
        }
        echo json_encode($json);
        exit;
    }
    
    public function checkUserPassword()
    {
        $this->checkUserLogin();
        $json     = array();
        $password = $this->input->post('old_password');
        
        $data = $this->Public_model->check_user_pass($password);
        
        if ($data > 0) {
            $isAvailable = false;
            $json        = array(
                'valid' => $isAvailable
            );
        } else {
            $isAvailable = true;
            $json        = array(
                'valid' => $isAvailable
            );
        }
        echo json_encode($json);
        exit;
    }
    
    public function changePassword()
    {
        $this->checkUserLogin();
        $data                = array();
        $head                = array();
        $arrSeo              = $this->Public_model->getSeo('home');
        $head['title']       = @$arrSeo['title'];
        $head['description'] = @$arrSeo['description'];
        $head['keywords']    = str_replace(" ", ",", $head['title']);
        $logged_user         = $this->session->userdata('logged_user');
        
        if ($this->input->post()) {
            $post = $this->input->post();
            if ($post['old_password'] == '' || $post['passsword'] == '' || $post['confirm_passsword'] == '') {
                $this->session->set_flashdata('flashError', "Please fill all required fields!");
                redirect(LANG_URL . '/change-password');
                exit;
            }
            
            $this->db->where('id', $logged_user['id']);
            $this->db->where('password', md5($post['old_password']));
            $checkRecord = $this->db->count_all_results('users_public');
            if ($checkRecord < 1) {
                $this->session->set_flashdata('flashError', "Old password is incorrect.Please fill correct password.!");
                redirect(LANG_URL . '/change-password');
                exit;
            }
            
            $updatArr             = array();
            $updatArr['password'] = md5($post['passsword']);
            $this->db->where('id', $logged_user['id']);
            $updateStatus = $this->db->update('users_public', $updatArr);
            
            if ($updateStatus) {
                $this->session->set_flashdata('flashSuccess', 'Profile updated successfully.');
            } else {
                $this->session->set_flashdata('flashError', 'An error occured.Please try again later!');
            }
            redirect(LANG_URL . '/change-password');
        }
        
        $data['userDetails'] = $this->Public_model->getUserProfileInfo($logged_user['id']);
        $this->render('user_related/change_pass', $head, $data);
        $this->load->view($this->template . 'modals');
    }
    
    public function payment_setting()
    {
        $data                = array();
        $head                = array();
        $arrSeo              = $this->Public_model->getSeo('home');
        $head['title']       = @$arrSeo['title'];
        $head['description'] = @$arrSeo['description'];
        $head['keywords']    = str_replace(" ", ",", $head['title']);
        $logged_user         = $this->session->userdata('logged_user');
        
        $this->load->library('user_agent');
        $referrer = $this->agent->referrer();
        if ($this->input->post()) {
            $post = $this->input->post();
            if ($post['getpaid_bank_name'] == '') {
                $this->session->set_flashdata('result_failed', "Bank Name can't be blank!");
                redirect($referrer);
            }
            $updateArr                           = array();
            $updateArr['getpaid_country']        = $post['getpaid_country'];
            $updateArr['getpaid_bank_name']      = $post['getpaid_bank_name'];
            $updateArr['getpaid_account_holder'] = $post['getpaid_account_holder'];
            $updateArr['getpaid_short_code']     = $post['getpaid_short_code'];
            $updateArr['getpaid_account_number'] = $post['getpaid_account_number'];
            $this->db->where('id', $logged_user['id']);
            $this->db->update('users_public', $updateArr);
            
            $this->session->set_flashdata('result_success', "Details updated successfully!");
            redirect($referrer);
        }
        
        $data['countries']   = $this->Public_model->getCountries();
        $data['userDetails'] = $this->Public_model->getUserProfileInfo($logged_user['id']);
        $this->render('user_related/payment_setting', $head, $data);
        $this->load->view($this->template . 'modals');
    }
    
    public function update_profile()
    {
        $this->checkUserLogin();
        $data                = array();
        $head                = array();
        $arrSeo              = $this->Public_model->getSeo('home');
        $head['title']       = @$arrSeo['title'];
        $head['description'] = @$arrSeo['description'];
        $head['keywords']    = str_replace(" ", ",", $head['title']);
        $logged_user         = $this->session->userdata('logged_user');
        
        if ($this->input->post()) {
            $post     = $this->input->post();
            $updatArr = array();
            if ($post['name'] == '') {
                $this->session->set_flashdata('flashError', "Name can't be blank!");
                redirect(LANG_URL . '/update-profile');
            }
            $updatArr['name']    = $post['name'];
            $updatArr['phone']   = $post['phone'];
            $updatArr['address'] = $post['address'];
            
            $this->db->where('id', $logged_user['id']);
            $updateStatus = $this->db->update('users_public', $updatArr);
            
            if ($updateStatus) {
                $this->session->set_flashdata('flashSuccess', 'Profile updated successfully.');
            } else {
                $this->session->set_flashdata('flashError', 'An error occured.Please try again later!');
            }
            redirect(LANG_URL . '/update-profile');
        }
        
        $data['userDetails'] = $this->Public_model->getUserProfileInfo($logged_user['id']);
        $this->render('user_related/update_profile', $head, $data);
        $this->load->view($this->template . 'modals');
    }
    
    public function notifications()
    {
        $this->checkUserLogin();
        $data                = array();
        $head                = array();
        $arrSeo              = $this->Public_model->getSeo('home');
        $head['title']       = @$arrSeo['title'];
        $head['description'] = @$arrSeo['description'];
        $head['keywords']    = str_replace(" ", ",", $head['title']);
        $logged_user         = $this->session->userdata('logged_user');
        
        $data['userDetails'] = $this->Public_model->getUserProfileInfo($logged_user['id']);
        $this->render('user_related/notifications', $head, $data);
        $this->load->view($this->template . 'modals');
    }
    
    public function inbox($product_id = '')
    {
        $this->checkUserLogin();
        $data                = array();
        $head                = array();
        $arrSeo              = $this->Public_model->getSeo('home');
        $head['title']       = @$arrSeo['title'];
        $head['description'] = @$arrSeo['description'];
        $head['keywords']    = str_replace(" ", ",", $head['title']);
        $logged_user         = $this->session->userdata('logged_user');
        
        $data['userDetails'] = $this->Public_model->getUserProfileInfo($logged_user['id']);
        if ($product_id != '') {
            $data['chatMessages'] = $this->Public_model->getChatMessages(base64_decode($product_id), $logged_user['id']);
        }
        $data['chatProducts'] = $this->Public_model->getChatProducts($logged_user['id']);
        $this->render('user_related/inbox', $head, $data);
        $this->load->view($this->template . 'modals');
    }
    
    public function getChatMessages()
    {
        $this->checkUserLogin();
        $logged_user = $this->session->userdata('logged_user');
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        if ($this->input->post()) {
            $product_id   = $this->input->post('product_id');
            $chatMessages = $this->Public_model->getChatMessages(base64_decode($product_id), $logged_user['id']);
            //pr($chatMessages,1);
            if (!empty($chatMessages)) {
                foreach ($chatMessages as $chatMessage) {
                    if ($chatMessage['message_from'] == 'USER') {
?>
                       <div class="chat_ww chat_right">
                            <p class="text-left"><?= $chatMessage['message'] ?><time><?= date('d/m/Y h:i A', strtotime($chatMessage['created_on'])) ?> </time></p>
                            <img src="<?= (is_file(UPLOAD_PHYSICAL_PATH . 'user-images/' . $chatMessage['user_profile_image']) && $chatMessage['user_profile_image'] != "") ? UPLOAD_URL . 'user-images/' . $chatMessage['user_profile_image'] : WEB_URL . 'images/profile_user.png' ?>"/> 
                        </div>
            <?php
                    } else {
?>
                       <div class="chat_ww chat_left">
                            <img src="<?= (is_file(UPLOAD_PHYSICAL_PATH . 'vendor-images/' . $chatMessage['vendor_profile_image']) && $chatMessage['vendor_profile_image'] != "") ? UPLOAD_URL . 'vendor-images/' . $chatMessage['vendor_profile_image'] : WEB_URL . 'images/profile_user.png' ?>"/> 
                            <p class="text-left"><?= $chatMessage['message'] ?><time><?= date('d/m/Y h:i A', strtotime($chatMessage['created_on'])) ?> </time></p>
                        </div>
            <?php
                    }
                }
            }
        } else {
            exit('No direct script access allowed');
        }
    }
    
    public function send_message_by_ajax()
    {
        $this->checkUserLogin();
        
        if (!$this->input->is_ajax_request()) {
            exit('No direct script allowed.');
        }
        if ($this->input->post()) {
            $product_id     = $this->input->post('product_id');
            $product_id     = base64_decode($product_id);
            $productDetails = $this->Public_model->getProductDetails($product_id);
            if ($productDetails != '') {
                $logged_user   = $this->session->userdata('logged_user');
                $user_id       = $logged_user['id'];
                $vendor_id     = $productDetails['vendor_id'];
                $messageStatus = $this->Public_model->checkIfmessagedOnProduct($product_id, $user_id, $vendor_id);
                if (!$messageStatus) {
                    $insertArr               = array();
                    $insertArr['product_id'] = $product_id;
                    $insertArr['user_id']    = $user_id;
                    $insertArr['vendor_id']  = $vendor_id;
                    $insertArr['created_on'] = date('Y-m-d H:i:s');
                    $insertArr['modify_on']  = date('Y-m-d H:i:s');
                    if ($this->db->insert('message_products', $insertArr)) {
                        $mp_id   = $this->db->insert_id();
                        $message = $this->input->post('message');
                        
                        $insertMessageArr                 = array();
                        $insertMessageArr['mp_id']        = $mp_id;
                        $insertMessageArr['message_from'] = 'USER';
                        $insertMessageArr['message']      = $message;
                        $insertMessageArr['message_type'] = 'TEXT';
                        $insertMessageArr['created_on']   = date('Y-m-d H:i:s');
                        $insertMessageArr['modify_on']    = date('Y-m-d H:i:s');
                        $this->db->insert('messages', $insertMessageArr);
                        
                        $this->db->where('mp_id', $mp_id);
                        $this->db->update('message_products', array(
                            'last_message_on' => date('Y-m-d H:i:s')
                        ));
                        echo 'sent';
                    } else {
                        echo 'error';
                    }
                } else {
                    $mp_id   = $messageStatus;
                    $message = $this->input->post('message');
                    
                    $insertMessageArr                 = array();
                    $insertMessageArr['mp_id']        = $mp_id;
                    $insertMessageArr['message_from'] = 'USER';
                    $insertMessageArr['message']      = $message;
                    $insertMessageArr['message_type'] = 'TEXT';
                    $insertMessageArr['created_on']   = date('Y-m-d H:i:s');
                    $insertMessageArr['modify_on']    = date('Y-m-d H:i:s');
                    $this->db->insert('messages', $insertMessageArr);
                    
                    $this->db->where('mp_id', $mp_id);
                    $this->db->update('message_products', array(
                        'last_message_on' => date('Y-m-d H:i:s')
                    ));
                    echo 'sent';
                }
            } else {
                echo 'error';
            }
        } else {
            exit('No direct script allowed.');
        }
    }
    
    public function send_message($product_id)
    {
        $this->checkUserLogin();
        
        $this->load->library('user_agent');
        $referrer = $this->agent->referrer();
        if ($this->input->post()) {
            $product_id     = base64_decode($product_id);
            $productDetails = $this->Public_model->getProductDetails($product_id);
            if ($productDetails != '') {
                $logged_user   = $this->session->userdata('logged_user');
                $user_id       = $logged_user['id'];
                $vendor_id     = $productDetails['vendor_id'];
                $messageStatus = $this->Public_model->checkIfmessagedOnProduct($product_id, $user_id, $vendor_id);
                if (!$messageStatus) {
                    $insertArr               = array();
                    $insertArr['product_id'] = $product_id;
                    $insertArr['user_id']    = $user_id;
                    $insertArr['vendor_id']  = $vendor_id;
                    $insertArr['created_on'] = date('Y-m-d H:i:s');
                    $insertArr['modify_on']  = date('Y-m-d H:i:s');
                    if ($this->db->insert('message_products', $insertArr)) {
                        $mp_id   = $this->db->insert_id();
                        $message = $this->input->post('message');
                        
                        $insertMessageArr                 = array();
                        $insertMessageArr['mp_id']        = $mp_id;
                        $insertMessageArr['message_from'] = 'USER';
                        $insertMessageArr['message']      = $message;
                        $insertMessageArr['message_type'] = 'TEXT';
                        $insertMessageArr['created_on']   = date('Y-m-d H:i:s');
                        $insertMessageArr['modify_on']    = date('Y-m-d H:i:s');
                        if ($this->db->insert('messages', $insertMessageArr)) {
                            $this->db->where('mp_id', $mp_id);
                            $this->db->update('message_products', array(
                                'last_message_on' => date('Y-m-d H:i:s')
                            ));
                            redirect(LANG_URL . '/inbox/' . base64_encode($product_id));
                        } else {
                            $this->session->set_flashdata('flashError', '');
                            redirect($referrer);
                        }
                    } else {
                        redirect($referrer);
                    }
                } else {
                    redirect($referrer);
                }
            } else {
                redirect($referrer);
            }
        } else {
            redirect($referrer);
        }
    }
    
    public function get_product_detail2(){
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
    
    public function wishlist()
    {
        $this->checkUserLogin();
        $data                   = array();
        $head                   = array();
        $arrSeo                 = $this->Public_model->getSeo('home');
        $head['title']          = @$arrSeo['title'];
        $head['description']    = @$arrSeo['description'];
        $head['keywords']       = str_replace(" ", ",", $head['title']);
        $all_categories         = $this->Public_model->getShopCategories();
        $data['all_categories'] = $all_categories;
        
        $data['products'] = $this->Public_model->getWishlistProducts();
        $this->render('user_related/wishlist', $head, $data);
    }
    
    public function wishlistFilter()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        $product_name = $this->input->post('product_name');
        $category_id  = $this->input->post('category_id');
        if ($category_id == 'all') {
            $category_id = '';
        }
        $products = $this->Public_model->getWishlistProducts($category_id, $product_name);
        if (!empty($products)) {
            foreach ($products as $key):
                $id          = base64_encode($key['product_id']);
                $productName = escape_product_name($key['product_name']);
?>
           <div class="col-md-3 col-sm-6 col-lg-3 col-xl-2 product_ak wow fadeInUp">
                <div class="row">
                    <a href="<?= LANG_URL . '/products-details/' . $productName . '/' . $id ?>"><div class="porduct_img"><img src="<?= get_small_image($key['image']) ?>"/></div></a>
                    <a href="javascript:void(0);" class="wishlist_close" data-product_id="<?= $id ?>"><i class="fa fa-close"></i></a>
                    <div class="product_dsp">
                        <span><?= $key['product_name'] ?></span>
                        <a href="<?= LANG_URL . '/products-details/' . $productName . '/' . $id ?>"><button class="product_btn">£ <?= $key['price'] ?></button></a>
                    </div>
                </div>
            </div>
        <?php
            endforeach;
        } else {
?>
           <br>
           <h1 style="color: #ccc;">No related product found!</h1>
        <?php
        }
    }
    
    public function addToWishlist()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        $product_id  = base64_decode($this->input->post('product_id'));
        $logged_user = $this->session->userdata('logged_user');
        $userId      = $logged_user['id'];
        if ($userId && $product_id) {
            echo $this->Public_model->addToWishlist($product_id, $userId);
        } else {
            echo '';
        }
    }
    
    public function removeFromWishlist()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        $product_id  = base64_decode($this->input->post('product_id'));
        $logged_user = $this->session->userdata('logged_user');
        $userId      = $logged_user['id'];
        if ($userId && $product_id) {
            echo $this->Public_model->removeFromWishlist($product_id, $userId);
        } else {
            echo '';
        }
    }
    
    public function checkOrder()
    {
        $this->checkUserLogin();
        $data                = array();
        $head                = array();
        $arrSeo              = $this->Public_model->getSeo('home');
        $head['title']       = @$arrSeo['title'];
        $head['description'] = @$arrSeo['description'];
        $head['keywords']    = str_replace(" ", ",", $head['title']);
        $logged_user         = $this->session->userdata('logged_user');
        
        $data['userDetails'] = $this->Public_model->getUserProfileInfo($logged_user['id']);
        $this->render('user_related/check-order', $head, $data);
        $this->load->view($this->template . 'modals');
    }
    Public function userrating()
    {
        //print_r($_POST);die();
        $rating              = $this->input->post('selected_rating');
        $productid           = $this->input->post('productid');
        $reviews             = $this->input->post('reviews');
        $orderid             = $this->input->post('orderid');
        $date                = date('Y-m-d H:i:s');
        $data                = array();
        $head                = array();
        $head['title']       = @$arrSeo['title'];
        $head['description'] = @$arrSeo['description'];
        $head['keywords']    = str_replace(" ", ",", $head['title']);
        if ($this->session->userdata('logged_user')) {
            $logged_user = $this->session->userdata('logged_user');
            $user_id     = $logged_user['id'];
            
            $data   = array(
                'product_id' => $productid,
                'user_id' => $user_id,
                'rating' => $rating,
                'review' => $reviews,
                'order_id' => $orderid,
                'created_on' => $date,
                'approval_status' => "APPROVED",
                'status' => '1'
            );
            //print_r($data);die();
            $result = $this->db->insert('product_reviews', $data);
            //echo $this->db->last_query();die();
            if ($request) {
                $this->session->set_flashdata('success', 'your successfully rate for this product');
                redirect(base_url('order-history'));
            } else {
                $this->session->set_flashdata('failed', 'failed');
                redirect(base_url('order-history'));
            }
        }
    }
    
    
    
    public function seller($vendor_id)
    {
        $data                = array();
        $head                = array();
        $arrSeo              = $this->Public_model->getSeo('home');
        $head['title']       = @$arrSeo['title'];
        $head['description'] = @$arrSeo['description'];
        $head['keywords']    = str_replace(" ", ",", $head['title']);
        $logged_user         = $this->session->userdata('logged_user');
        $vendor_id           = base64_decode($vendor_id);
        
        $vendorRatingStatus = false;
        if ($this->session->userdata('logged_user')) {
            $logged_user        = $this->session->userdata('logged_user');
            $user_id            = $logged_user['id'];
            $vendorRatingStatus = $this->Public_model->checkIfVendorRated($user_id, $vendor_id);
        }
        
        $this->load->library('user_agent');
        $referrer = $this->agent->referrer();
        if ($this->input->post()) {
            if ($this->session->userdata('logged_user')) {
                $review = $this->input->post('review');
                $rating = $this->input->post('rating');
                if ($vendorRatingStatus) {
                    $inserArr                    = array();
                    $inserArr['vendor_id']       = $vendor_id;
                    $inserArr['user_id']         = $user_id;
                    $inserArr['review']          = $review;
                    $inserArr['rating']          = $rating;
                    $inserArr['approval_status'] = 'APPROVED';
                    $inserArr['created_on']      = date('Y-m-d H:i:s');
                    $inserArr['modify_on']       = date('Y-m-d H:i:s');
                    $link                        = base_url('vendor/review-rating');
                    save_notification($user_id, $vendor_id, 'USER', 'VENDOR', 'VENDOR_REVIEW_ADDED', $link, '');
                    if ($this->db->insert('vendor_reviews', $inserArr)) {
                        $this->session->set_flashdata('success', 'Feedback added successfully!');
                    } else {
                        $this->session->set_flashdata('error', 'An error occured.Please try again later!');
                    }
                    redirect($referrer);
                } else {
                    $this->session->set_flashdata('error', 'You have already wrote a review for this seller!');
                    /* $updateArr = array();
                    $updateArr['review'] = $review;
                    $updateArr['rating'] = $rating;
                    $updateArr['modify_on'] = date('Y-m-d H:i:s');
                    $this->db->where(array('user_id'=>$user_id,'vendor_id'=>$vendor_id));
                    if($this->db->update('vendor_reviews',$updateArr))
                    {
                    $this->session->set_flashdata('success','Feedback updated successfully.We will review your feedback before show on site.');
                    }else{
                    $this->session->set_flashdata('error','An error occured.Please try again later!');
                    } */
                    redirect($referrer);
                }
            } else {
                redirect($referrer);
            }
        }
        
        $data['total_vendor_reviews'] = $this->Public_model->getVendorReviewsCount($vendor_id);
        $data['wishlist_Product_ids'] = $this->Public_model->getWishlistProductIds();
        $data["vendorCategories"]     = $this->Public_model->getVendorCategories($vendor_id);
        //pr($data["vendorCategories"],1);
        $vendorDetails                = $this->Public_model->getVendorDetails(base64_encode($vendor_id));
        if (!empty($vendorDetails)) {
            $data["vendorDetails"] = $vendorDetails;
        } else {
            redirect($referrer);
        }
        $limit                      = $this->sellerProductLimit;
        $data["productsCount"]      = $this->Public_model->getProductsCount(base64_encode($vendor_id), '');
        $data["productsLimit"]      = $limit;
        $data['vendorRatingStatus'] = $vendorRatingStatus;
        $data["products"]           = $this->Public_model->getProducts(base64_encode($vendor_id), '', $limit);
        $this->render('seller', $head, $data);
    }
    
    public function write_review($vendor_id)
    {
        $data                = array();
        $head                = array();
        $arrSeo              = $this->Public_model->getSeo('home');
        $head['title']       = @$arrSeo['title'];
        $head['description'] = @$arrSeo['description'];
        $head['keywords']    = str_replace(" ", ",", $head['title']);
        $logged_user         = $this->session->userdata('logged_user');
        
        $data['wishlist_Product_ids'] = $this->Public_model->getWishlistProductIds();
        $data["vendorCategories"]     = $this->Public_model->getVendorCategories(base64_decode($vendor_id));
        $vendorDetails                = $this->Public_model->getVendorDetails($vendor_id);
        if (!empty($vendorDetails)) {
            $data["vendorDetails"] = $vendorDetails;
        } else {
            redirect('/');
        }
        $limit                 = $this->sellerProductLimit;
        $data["productsCount"] = $this->Public_model->getProductsCount($vendor_id, '');
        $data["productsLimit"] = $limit;
        $data["products"]      = $this->Public_model->getProducts($vendor_id, '', $limit);
        $this->render('seller', $head, $data);
    }
    
    public function filterSellerProducts($vendor_id)
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        $category_id = $this->input->post('category_id');
        $offset      = $this->input->post('offset');
        if ($category_id == 'all') {
            $category_id = '';
        }
        $limit                = $this->sellerProductLimit;
        $productsCount        = $this->Public_model->getProductsCount($vendor_id, $category_id);
        $products             = $this->Public_model->getProducts($vendor_id, $category_id, $limit, $offset);
        $wishlist_Product_ids = $this->Public_model->getWishlistProductIds();
        if (!empty($products)) {
            foreach ($products as $key):
                $id          = base64_encode($key['product_id']);
                $productName = escape_product_name($key['product_name']);
?>
           <div class="col-md-3 col-sm-6 col-lg-3 col-xl-3 product_ak wow fadeInUp">
                <div class="row">
                    <a href="<?= LANG_URL . '/products-details/' . $productName . '/' . $id ?>"><div class="porduct_img"><img src="<?= get_small_image($key['image']) ?>"/></div></a>
                    <a href="javascript:void(0);" class="add_to_wishlist" data-product_id="<?= $id ?>">
                    <?php
                $blankHeartStyle  = '';
                $filledHeartStyle = 'style="display:none;"';
                if (in_array($key['product_id'], $wishlist_Product_ids)) {
                    $blankHeartStyle  = 'style="display:none;"';
                    $filledHeartStyle = '';
                }
?>
                       <i class="fa fa-heart-o" <?= $blankHeartStyle ?>></i>
                        <i class="fa fa-heart" <?= $filledHeartStyle ?>></i>
                    </a>
                    <div class="product_dsp">
                        <span><?= $key['product_name'] ?></span>
                        <a href="<?= LANG_URL . '/products-details/' . $productName . '/' . $id ?>"><button class="product_btn">£ <?= $key['price'] ?></button></a>
                    </div>
                </div>
            </div>
        <?php
            endforeach;
            if ($productsCount > $offset + $limit) {
?>
               <div class="row load_more_seller_products">
                    <div class="clearfix"></div>
                    <input type="button" id="loadMore" value="Load More" class="btm btn-primary"/>
                </div>
        <?php
            }
        } elseif ($offset < 1) {
?>
           <br><h1 style="color: #ccc;" class="no-product-found">No Product Found !</h1>
        <?php
        } else {
            echo 'all_products_loaded';
        }
    }
    
    /* public function searchProductHeader()
    {
    if (!$this->input->is_ajax_request()) {
    exit('No direct script access allowed');
    }
    $product_name = $this->input->post('product_name');
    $offset = $this->input->post('offset');
    $limit = $this->productLimit;
    $productsCount = $this->Public_model->getProductsCount('','',$product_name);
    $products = $this->Public_model->getProducts('','',$limit,$offset,$product_name);
    if (!empty($products)) {
    foreach($products as $key) :
    $id=base64_encode($key['product_id']);
    $productName = escape_product_name($key['product_name']);
    ?>
    <div class="col-md-3 col-sm-6 col-lg-3 col-xl-3 product_ak wow fadeInUp">
    <div class="row">
    <div class="porduct_img"><a href="<?=LANG_URL.'/products-details/'.$productName.'/'.$id?>"><img src="<?=UPLOAD_URL.'product-images/'.$key['image']?>"/></a></div>
    <div class="product_dsp">
    <span><?=$key['product_name']?></span>
    <a href="<?=LANG_URL.'/products-details/'.$productName.'/'.$id?>"><button class="product_btn">£ <?=$key['price']?></button></a>
    </div>
    </div>
    </div>
    <?php  endforeach; 
    if($productsCount>$offset+$limit){
    ?>
    <div class="row load_more_seller_products">
    <div class="clearfix"></div>
    <input type="button" id="loadMore" value="Load More" class="btm btn-primary"/>
    </div>
    <?php }
    } elseif($offset<1) { ?>
    <br><h1 style="color: #ccc;" class="no-product-found">No Product Found !</h1>
    <?php }else{
    echo 'all_products_loaded';
    }
    } */
    
    public function searchProductHeaderHint()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        $product_name = $this->input->post('product_name');
        
        $limit    = $this->sellerProductLimit;
        $products = $this->Public_model->searchProductHeaderHint($product_name);
        foreach ($products as $product) {
            $id          = base64_encode($product['product_id']);
            $productName = escape_product_name($product['product_name']);
            echo '<li id="product-list-drop" data-product_id="' . $product['product_id'] . '"><a href="#" id="product-drop" >' . $product['product_name'] . '</a></li>';
        }
    }
    
    public function orderHistory()
    {
        $this->checkUserLogin();
        $data                = array();
        $head                = array();
        $arrSeo              = $this->Public_model->getSeo('home');
        $head['title']       = @$arrSeo['title'];
        $head['description'] = @$arrSeo['description'];
        $head['keywords']    = str_replace(" ", ",", $head['title']);
        $logged_user         = $this->session->userdata('logged_user');
        
        $data['userDetails']  = $this->Public_model->getUserProfileInfo($logged_user['id']);
        $data['orderhistory'] = $this->Public_model->getorderhistory($logged_user['id']);
        
        $this->render('user_related/order-history', $head, $data);
        $this->load->view($this->template . 'modals');
    }
    
    public function orderTrack($encoded_orderId)
    {
        $orderId = base64_decode($encoded_orderId);
        
        $this->checkUserLogin();
        $data                = array();
        $head                = array();
        $arrSeo              = $this->Public_model->getSeo('home');
        $head['title']       = @$arrSeo['title'];
        $head['description'] = @$arrSeo['description'];
        $head['keywords']    = str_replace(" ", ",", $head['title']);
        $logged_user         = $this->session->userdata('logged_user');
        
        $data['userDetails'] = $this->Public_model->getUserProfileInfo($logged_user['id']);
        $this->render('user_related/order-track', $head, $data);
        $this->load->view($this->template . 'modals');
    }
    
    public function writeReview($encoded_productId)
    {
        $product_id = base64_decode($encoded_productId);
        
        $this->checkUserLogin();
        $data                = array();
        $head                = array();
        $arrSeo              = $this->Public_model->getSeo('home');
        $head['title']       = @$arrSeo['title'];
        $head['description'] = @$arrSeo['description'];
        $head['keywords']    = str_replace(" ", ",", $head['title']);
        $logged_user         = $this->session->userdata('logged_user');
        
        $productRatingStatus = false;
        if ($this->session->userdata('logged_user')) {
            $logged_user         = $this->session->userdata('logged_user');
            $user_id             = $logged_user['id'];
            $productRatingStatus = $this->Public_model->checkIfProductRated($user_id, $product_id);
        }
        //echo $this->db->last_query(); die;
        if (!$productRatingStatus) {
            $this->session->set_flashdata('error', 'You have already wrote a review for this product!');
            redirect('order-history');
        }
        
        if ($this->input->post()) {
            if ($this->session->userdata('logged_user')) {
                $review = $this->input->post('review');
                $rating = $this->input->post('rating');
                if ($productRatingStatus) {
                    $inserArr                    = array();
                    $inserArr['product_id']      = $product_id;
                    $inserArr['user_id']         = $user_id;
                    $inserArr['review']          = $review;
                    $inserArr['rating']          = $rating;
                    $inserArr['approval_status'] = 'APPROVED';
                    $inserArr['created_on']      = date('Y-m-d H:i:s');
                    $inserArr['modify_on']       = date('Y-m-d H:i:s');
                    //pr($inserArr,1);
                    if ($this->db->insert('product_reviews', $inserArr)) {
                        $productAvgReviews = $this->Public_model->getProductReviewsAvg($product_id, true);
                        $product_details   = $this->Public_model->getProductDetails($product_id);
                        $product_name      = escape_product_name($product_details['product_name']);
                        $vendor_id         = $product_details['vendor_id'];
                        $link              = base_url('products-details/' . $product_name . '/' . base64_encode($product_id));
                        save_notification($user_id, $vendor_id, 'USER', 'VENDOR', 'PRODUCT_REVIEW_ADDED', $link, '');
                        $this->session->set_flashdata('success', 'Feedback added successfully!');
                    } else {
                        $this->session->set_flashdata('error', 'An error occured.Please try again later!');
                    }
                    redirect('order-history');
                } else {
                    $this->session->set_flashdata('error', 'You have already wrote a review for this product!');
                    redirect('order-history');
                }
            } else {
                redirect('login');
            }
        }
        
        
        
        $data['userDetails'] = $this->Public_model->getUserProfileInfo($logged_user['id']);
        $this->render('user_related/write-review', $head, $data);
        $this->load->view($this->template . 'modals');
    }
    
    public function aboutUs()
    {
        $page                = 'about-us';
        $page                = $this->Public_model->getAboutPage();
        $lpage               = $this->Public_model->getAboutListPage();
        $data                = array();
        $head                = array();
        $arrSeo              = $this->Public_model->getSeo('home');
        $head['title']       = 'About Us';
        $head['description'] = @$arrSeo['description'];
        $head['keywords']    = str_replace(" ", ",", $head['title']);
        $data['content']     = $page;
        $data['listContent'] = $lpage;
        $this->render('about_us', $head, $data);
    }
    
    public function privacyPolicy()
    {
        $page = 'privacy-policy';
        $page = $this->Public_model->getOnePage($page);
        $this->goOut($page);
        $data                = array();
        $head                = array();
        $arrSeo              = $this->Public_model->getSeo('home');
        $head['title']       = 'Privacy Policy';
        $head['description'] = @$arrSeo['description'];
        $head['keywords']    = str_replace(" ", ",", $head['title']);
        $data['content']     = $page['content'];
        $this->render('privacy_policy', $head, $data);
    }
    
    public function FAQ()
    {
        $data                = array();
        $head                = array();
        $arrSeo              = $this->Public_model->getSeo('home');
        $arrSeo              = $this->Public_model->getFAQdata();
        $head['title']       = 'FAQ';
        $head['description'] = @$arrSeo['description'];
        $head['keywords']    = str_replace(" ", ",", $head['title']);
        $data['data']        = $arrSeo;
        
        $this->render('faq', $head, $data);
    }
    
    public function returnPolicy()
    {
        $page = 'return-policy';
        $page = $this->Public_model->getOnePage($page);
        $this->goOut($page);
        $data                = array();
        $head                = array();
        $arrSeo              = $this->Public_model->getSeo('home');
        $head['title']       = 'Return Policy';
        $head['description'] = @$arrSeo['description'];
        $head['keywords']    = str_replace(" ", ",", $head['title']);
        $data['content']     = $page['content'];
        
        $this->render('return_policy', $head, $data);
    }
    
    public function customerSupport()
    {
        $data   = array();
        $head   = array();
        $arrSeo = $this->Public_model->getSeo('home');
        
        $this->form_validation->set_rules('c_name', 'Name', 'required');
        $this->form_validation->set_rules('c_mail', 'Email Id', 'required');
        $this->form_validation->set_rules('subject', 'Subject', 'required');
        $this->form_validation->set_rules('message', 'Message', 'required');
        $post = $_POST;
        if ($this->form_validation->run() == TRUE) {
            $this->_field_data = array();
            $data              = $this->Public_model->addCustomerForm($post);
            if (isset($data)) {
                $mail = $this->sendmail->sendTo($post['c_mail'], 'Admin', SITE_NAME . ' - Customer Support', 'Hello ! Thanks for contacting with us.. we will reach you soon..');
                if ($mail == 1) {
                    $this->session->set_userdata('suc_msg', 'Thanks for contacting with us.. we will reach you soon..');
                } else {
                    $this->session->set_userdata('err_msg', 'Oops ! Something went wrong in Email');
                }
            }
        } else {
            $data['error'] = validation_errors('*');
        }
        $head['title']       = 'Customer Support';
        $head['description'] = @$arrSeo['description'];
        $head['keywords']    = str_replace(" ", ",", $head['title']);
        
        $this->render('customer_support', $head, $data);
    }
    
    public function careers()
    {
        $page = 'careers';
        $page = $this->Public_model->getOnePage($page);
        $this->goOut($page);
        $data                = array();
        $head                = array();
        $arrSeo              = $this->Public_model->getSeo('home');
        $head['title']       = 'Careers';
        $head['description'] = @$arrSeo['description'];
        $head['keywords']    = str_replace(" ", ",", $head['title']);
        $data['content']     = $page['content'];
        $this->render('career', $head, $data);
    }
    
    private function goOut($page)
    {
        if ($page == null) {
            redirect();
        }
    }
    
    public function changeProfileImage()
    {
        $this->checkUserLogin();
        $response          = array();
        $response['error'] = 'yes';
        $response['msg']   = "You can't hit this url directly";
        if ($_FILES) {
            $response = $this->Public_model->updateProfileImage();
        }
        echo json_encode($response, true);
    }
    
    /*
     * Used from greenlabel template
     * shop page
     */
    
    public function shop($page = 0)
    {
        $data                     = array();
        $head                     = array();
        $arrSeo                   = $this->Public_model->getSeo('shop');
        $head['title']            = @$arrSeo['title'];
        $head['description']      = @$arrSeo['description'];
        $head['keywords']         = str_replace(" ", ",", $head['title']);
        $all_categories           = $this->Public_model->getShopCategories();
        $data['home_categories']  = $this->getHomeCategories($all_categories);
        $data['all_categories']   = $all_categories;
        $data['showBrands']       = $this->Home_admin_model->getValueStore('showBrands');
        $data['brands']           = $this->Brands_model->getBrands();
        $data['showOutOfStock']   = $this->Home_admin_model->getValueStore('outOfStock');
        $data['shippingOrder']    = $this->Home_admin_model->getValueStore('shippingOrder');
        $data['products']         = $this->Public_model->getProducts($this->num_rows, $page, $_GET);
        $rowscount                = $this->Public_model->productsCount($_GET);
        $data['links_pagination'] = pagination('home', $rowscount, $this->num_rows);
        $this->render('shop', $head, $data);
    }
    
    private function getHomeCategories($categories)
    {
        
        /*
         * Tree Builder for categories menu
         */
        
        function buildTree(array $elements, $parentId = 0)
        {
            $branch = array();
            foreach ($elements as $element) {
                if ($element['sub_for'] == $parentId) {
                    $children = buildTree($elements, $element['id']);
                    if ($children) {
                        $element['children'] = $children;
                    }
                    $branch[] = $element;
                }
            }
            return $branch;
        }
        
        return buildTree($categories);
    }
    
    /*
     * Called to add/remove quantity from cart
     * If is ajax request send POST'S to class ShoppingCart
     */
    
    public function manageShoppingCart()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        $r = $this->shoppingcart->manageShoppingCart();
    }
    
    /*
     * Called to remove product from cart
     * If is ajax request and send $_GET variable to the class
     */
    
    public function removeFromCart()
    {
        //echo "string"; die();
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        $r = $this->shoppingcart->removeFromCart();
    }
    
    public function updateCartQuantity()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        $r = $this->shoppingcart->updateCartQuantity();
    }
    
    public function clearShoppingCart()
    {
        $this->shoppingcart->clearShoppingCart();
    }
    
    public function viewProduct($id)
    {
        $data                         = array();
        $head                         = array();
        $data['product']              = $this->Public_model->getOneProduct($id);
        $data['sameCagegoryProducts'] = $this->Public_model->sameCagegoryProducts($data['product']['shop_categorie'], $id);
        if ($data['product'] === null) {
            show_404();
        }
        $vars['publicDateAdded'] = $this->Home_admin_model->getValueStore('publicDateAdded');
        $this->load->vars($vars);
        $head['title']       = $data['product']['title'];
        $description         = url_title(character_limiter(strip_tags($data['product']['description']), 130));
        $description         = str_replace("-", " ", $description) . '..';
        $head['description'] = $description;
        $head['keywords']    = str_replace(" ", ",", $data['product']['title']);
        $this->render('view_product', $head, $data);
    }
    
    public function confirmLink($md5)
    {
        if (preg_match('/^[a-f0-9]{32}$/', $md5)) {
            $result = $this->Public_model->confirmOrder($md5);
            if ($result === true) {
                $data                = array();
                $head                = array();
                $head['title']       = '';
                $head['description'] = '';
                $head['keywords']    = '';
                $this->render('confirmed', $head, $data);
            } else {
                show_404();
            }
        } else {
            show_404();
        }
    }
    
    public function discountCodeChecker()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        $result = $this->Public_model->getValidDiscountCode($_POST['enteredCode']);
        if ($result == null) {
            echo 0;
        } else {
            $this->session->set_userdata('discount_code', $result['code']);
            $this->session->set_userdata('discount_code_percentage', $result['amount']);
            echo json_encode($result);
        }
    }
    
    public function search()
    {
        $search_data = $_POST['search_data'];
        $search      = explode(" ", $search_data);
        if ($search_data == '') {
            redirect(base_url());
        }
        $query = $this->Public_model->get_live_items($search);
        if ($query) {
            foreach ($query as $row):
                $id          = base64_encode($row['product_id']);
            //$purl=str_replace(" ","-",$row['product_name']);
                $productName = escape_product_name($row['product_name']);
                if ($productName) {
                    echo '<li><a href="' . base_url('products-details/' . $productName . '/' . $id) . '"">' . $row["product_name"] . '</a></li>';
                }
            endforeach;
        } else {
            echo "No found";
        }
    }
    
    public function searchfilter()
    {
        
        if (!$this->input->post('search_data')) {
            redirect(base_url());
        }
        $search_data = $_POST['search_data'];
        if (isset($_SESSION)) {
            
            $user = $_SESSION['logged_user']['id'];
            if ($_SESSION['logged_user']['id']) {
                $result = $this->Public_model->searchid($user);
                if ($result['userid'] > 0) {
                    $data = array(
                        'searchkey' => $search_data
                    );
                    $this->db->where('userid', $user);
                    $this->db->update('searchreview', $data);
                } else {
                    $data = array(
                        'userid' => $user,
                        'searchkey' => $search_data
                    );
                    $this->db->insert('searchreview', $data);
                    //echo "successfully";
                }
            } else {
                $cookie = array(
                    'name' => 'nonlogin',
                    'value' => $search_data,
                    'expire' => '36000000'
                );
                $this->input->set_cookie($cookie);
                //echo "Congragulatio Cookie Set";
                //echo $this->input->cookie('nonlogin',true);die();
                
            }
            
        }
        $search = explode(" ", $search_data);
        $search_mode = $this->input->post('search_mode');
        if(!$search_mode) $search_mode = 'product';
        $is_bundle = false;
        if($search_mode == 'product_bundle') $is_bundle = true;
        $data                = array();
        $head                = array();
        $data['filter']      = $this->Public_model->get_live_items($search, '', '', '', '0', $is_bundle);
        $this->_get_product_detail($data['filter']);        
        $data['pname']       = $search_data;
        $head['title']       = 'Search';
        $head['description'] = @$arrSeo['description'];
        $head['keywords']    = str_replace(" ", ",", $head['title']);    
        $head['search_data'] = $search_data;        
        $head['search_mode'] = $search_mode;
        $this->render('searchfilter', $head, $data);
        $this->load->view($this->template . '_parts/bundle_modal'); 
    }
    
    
    public function sitemap()
    {
        header("Content-Type:text/xml");
        echo '<?xml version="1.0" encoding="UTF-8"?>
                <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        $products  = $this->Public_model->sitemap();
        $blogPosts = $this->Public_model->sitemapBlog();
        
        foreach ($blogPosts->result() as $row1) {
            echo '<url>

      <loc>' . base_url('blog/' . $row1->url) . '</loc>

      <changefreq>monthly</changefreq>

      <priority>0.1</priority>

   </url>';
        }
        
        foreach ($products->result() as $row) {
            echo '<url>

      <loc>' . base_url($row->url) . '</loc>

      <changefreq>monthly</changefreq>

      <priority>0.1</priority>

   </url>';
        }
        
        echo '</urlset>';
    }
    
}
?>