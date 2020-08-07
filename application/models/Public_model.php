<?php

class Public_model extends CI_Model
{

    private $showOutOfStock;
    private $showInSliderProducts;
    private $multiVendor;
	private $cookieExpTime = 2678400;
	
    public function __construct()
    {
        parent::__construct();
        $this->load->Model('Home_admin_model');
        $this->showOutOfStock = $this->Home_admin_model->getValueStore('outOfStock');
        $this->showInSliderProducts = $this->Home_admin_model->getValueStore('showInSlider');
        $this->multiVendor = $this->Home_admin_model->getValueStore('multiVendor');
    }

    public function getUserInfoFromEmail($email)
    {
        $this->db->where('email', $email);
        $result = $this->db->get('users_public');
        return $result->row_array();
    }
    public function searchid($id){
    	$this->db->where('userid',$id);
    	$result=$this->db->get('searchreview');
    	return $result->row_array();
    }
    public function ratecheck($oid,$uid,$pid){
    	$this->db->where('order_id',$oid);
    	$this->db->where('product_id',$pid);
    	$this->db->where('user_id',$uid);

    	$query=$this->db->get('product_reviews');
    	//echo $this->db->last_query();die();
    	return $query->row_array();
    }

    public function get_live_items($search_data, $sort_product='',$header_color_id='',$header_filter_star='',$express_required='0', $is_bundle=false) {      
		$select = '';
		if($is_bundle) {
			$select = ', product_bundles.id AS main_bundle, product_bundles.product_bundles, product_bundles.bundle_price';
		}
        $this->db->select("products.product_name,products.product_id,product_images.image,products.price,products.nureso_express_status,products.is_product_verified,products.filter_label".$select);
        $this->db->from('products');
        $this->db->group_start();
        if(count($search_data) == "1") {        	
	        $this->db->like('products.product_name', $search_data[0]);
        }else{
        	foreach ($search_data as $key => $value) {         		
          		$this->db->like('products.product_name', $value);          		
           	}
        }        
        $this->db->group_end();
        $this->db->join('product_images', 'product_images.pi_id = products.main_image_id', 'left');       
        $this->db->join('vendors','vendors.id = products.vendor_id','left');        
        $this->db->where('products.status', '1');
        $this->db->where('products.delete_status', '0');
        $this->db->where('vendors.status', '1');
        $this->db->where('vendors.delete_status', '0');        
		$this->db->where('products.approval_status', 'APPROVED');

		if($header_color_id!=''){
			$this->db->join('product_size_color psc','psc.product_id = products.product_id','left');			
			$this->db->where('psc.color_id', $header_color_id);
			$this->db->group_by('psc.product_id');
		}
		if($header_filter_star!='')	{
			if($header_filter_star==1){
				$this->db->where('products.avg_rating <= "'.$header_filter_star.'" AND products.avg_rating >= "'.($header_filter_star-1).'"');
			}else{
				$this->db->where('products.avg_rating <= "'.$header_filter_star.'" AND products.avg_rating > "'.($header_filter_star-1).'" ');
			}
		}
		if($express_required=='1'){
			$this->db->where('products.nureso_express_status', '1');
		}		
		if($sort_product=='lowest')	{
			if($is_bundle) {
				$this->db->order_by('product_bundles.bundle_price','ASC');
			} else {
				$this->db->order_by('products.price','ASC');
			}
		}elseif($sort_product=='highest'){
			if($is_bundle) {
				$this->db->order_by('product_bundles.bundle_price','DESC');
			} else {
				$this->db->order_by('products.price','DESC');
			}
		}elseif($sort_product=='newest'){
			$this->db->order_by('products.product_id','DESC');
		}else{
			$this->db->order_by('products.product_id','DESC');
		}
		if($is_bundle) {
			$this->db->join('product_bundles','product_bundles.product_id = products.product_id');			
		}

        $this->db->group_by('products.product_id');
        //$this->db->limit(30);        
		$query = $this->db->get(); 				
        //echo $this->db->last_query();die();    
		$result = $query->result_array();
		if($is_bundle) {
			$result = $this->_getProductBundles($result);
		}
		return $result;
    }

    public function recentproduct($key){
    $as=explode(" ",$key);
    $this->db->select("products.product_name,products.is_product_verified,products.nureso_express_status,products.product_id,product_images.image,products.price, products.filter_label");
    $this->db->join('vendors','vendors.id = products.vendor_id','left'); 
        $this->db->from('products');
        $this->db->where('vendors.status', '1');
        $this->db->where('vendors.delete_status', '0'); 
        $this->db->where('products.delete_status','0');        
        $this->db->where('products.approval_status', 'APPROVED');
        $this->db->group_start();

        if(count($as) == "1") {        	
	        $this->db->like('products.product_name', $as[0]);
        }else{
        	foreach ($as as $key => $value) {        		
          		$this->db->like('products.product_name', $value);          		
           	}
        }

        $this->db->group_end();
        $this->db->join('product_images', 'product_images.pi_id = products.main_image_id', 'left');
        $this->db->order_by("products.product_id", 'desc');
        $this->db->limit(30);             
        $query = $this->db->get();          
        return $query->result_array();
    }

    public function sendExpressRequest($country_id="",$vendor_id) {
    	if($country_id!=""){
        	$data=array('country_id'=>$country_id,'vendor_id'=>$vendor_id,'created_on'=>date('Y-m-d H:i:s'),'modified_on'=>date('Y-m-d H:i:s'));
	        $this->db->insert('vendor_express_countries', $data);
	        
        }
    }

    public function changeExpressStatus($vendor_id) {
    	$data=array('express_approve_status'=>'PENDING','updated_at'=>date('Y-m-d H:i:s'));
	    $this->db->where('id', $vendor_id);
	    $this->db->update('vendors', $data);        
    }

    public function getorderhistory($id){
	 $this->db->select('orders.id,orders.street,orders.shipping_status,orders.order_code,orders.shipping_charges,orders.final_amount,orders. user_id,orders.mobile_no,orders.country_id,orders.state_id,orders.city_id,orders.address,orders.transation_id,orders.payment_type,orders.status,orders.created_on,ordered_products.product_image,ordered_products.shipping_amount,ordered_products.price,ordered_products.product_name,ordered_products.product_shipping_status,ordered_products.product_id,ordered_products.product_size,ordered_products.product_color,ordered_products.quantity');
		$this->db->from('orders');
		$this->db->order_by("id", "DESC");
		$this->db->join('ordered_products', 'ordered_products.order_id = orders.id', 'left');
		$this->db->where('orders.user_id',$id);
		//$this->db->order_by('id', 'DESC');
		$query=$this->db->get();
        //echo $this->db->last_query();die();
        return $query->result_array();
    }

    public function getVendorIdByemail($vendor_mail="") {
    	if($vendor_mail!=''){
	        $this->db->select('id');
	        $this->db->where('email', $vendor_mail);
	        $get = $this->db->get('vendors');
	        if($get->num_rows()>0){
	        	$result=$get->row_array();
	          	return $result['id'];
	        }
	        else {
	        	return '';
	        }	
    	}
    	else {
    		return '';
    	}
    }

    //

    public function productsCount($big_get)
    {
        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'left');
        $this->db->where('products_translations.abbr', MY_LANGUAGE_ABBR);
        if (!empty($big_get) && isset($big_get['category'])) {
            $this->getFilter($big_get);
        }
        $this->db->where('visibility', 1);
        if ($this->showOutOfStock == 0) {
            $this->db->where('quantity >', 0);
        }
        if ($this->showInSliderProducts == 0) {
            $this->db->where('in_slider', 0);
        }
        if ($this->multiVendor == 0) {
            $this->db->where('vendor_id', 0);
        }
        return $this->db->count_all_results('products');
    }

    public function getNewProducts()
    {
        $this->db->select('vendors.url as vendor_url, products.id, products.quantity, products.image, products.url, products_translations.price, products_translations.title, products_translations.old_price');
        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'left');
        $this->db->join('vendors', 'vendors.id = products.vendor_id', 'left');
        $this->db->where('products_translations.abbr', MY_LANGUAGE_ABBR);
        $this->db->where('products.in_slider', 0);
        $this->db->where('visibility', 1);
        if ($this->showOutOfStock == 0) {
            $this->db->where('quantity >', 0);
        }
        $this->db->order_by('products.id', 'desc');
        $this->db->limit(5);
        $query = $this->db->get('products');
        return $query->result_array();
    }

    public function getLastBlogs()
    {
        $this->db->limit(5);
        $this->db->join('blog_translations', 'blog_translations.for_id = blog_posts.id', 'left');
        $this->db->where('blog_translations.abbr', MY_LANGUAGE_ABBR);
        $query = $this->db->select('blog_posts.id, blog_translations.title, blog_translations.description, blog_posts.url, blog_posts.time, blog_posts.image')->get('blog_posts');
        return $query->result_array();
    }

    public function getPosts($limit, $page, $search = null, $month = null)
    {
        if ($search !== null) {
            $search = $this->db->escape_like_str($search);
            $this->db->where("(blog_translations.title LIKE '%$search%' OR blog_translations.description LIKE '%$search%')");
        }
        if ($month !== null) {
            $from = intval($month['from']);
            $to = intval($month['to']);
            $this->db->where("time BETWEEN $from AND $to");
        }
        $this->db->join('blog_translations', 'blog_translations.for_id = blog_posts.id', 'left');
        $this->db->where('blog_translations.abbr', MY_LANGUAGE_ABBR);
        $query = $this->db->select('blog_posts.id, blog_translations.title, blog_translations.description, blog_posts.url, blog_posts.time, blog_posts.image')->get('blog_posts', $limit, $page);
        return $query->result_array();
    }

    public function getProducts($vendor_id='',$category_id='',$limit=12,$offset=0,$product_name='',$sort_product='',$header_color_id='',$header_filter_star='',$express_required='0',$requestFrom='', $is_bundle=0) 
	{
		
		$vendor_ids = array();
		if($requestFrom!='vendor_request') {
			$vendor_ids = $this->_getExpressVenderIds();
		}
		
		$select = '';
		if($product_name!='') {
			$select = ', COUNT(pt.tag_id) AS matchedTags';
		}
		if($is_bundle) {
			$select .= ',pb.id AS main_bundle, pb.product_bundles, pb.bundle_price, p.category_id';
		}
        $this->db->select('p.product_id,p.earnings,p.product_name,p.vendor_id,p.main_image_id as image_id,p.price,p.filter_label, product_images.image, shop_categories_translations.name as category_name,p.is_product_verified ,p.nureso_express_status '.$select.', vendors.express_approve_status');
        $this->db->join('product_images','product_images.pi_id = p.main_image_id','left');
        $this->db->join('shop_categories_translations','shop_categories_translations.id = p.category_id','left');
		$this->db->join('vendors','vendors.id = p.vendor_id','left');
		//$this->db->join('provider_paypal_details ppd','p.vendor_id = ppd.provider_id','left');
		if($product_name!='')
		{
			$this->db->join('product_tags pt','pt.product_id = p.product_id','LEFT');
			$nameQuery = $this->productNameGenerateFilterQuery($product_name);
			$tagQuery = $this->productNameGenerateFilterQueryForTags($product_name);
			if($nameQuery!=' ' && $tagQuery!=' '){

				$this->db->where(" ( pt.tag_id IN (SELECT tag_id FROM tags as t WHERE ".$tagQuery." ) OR (".$nameQuery.") )");
			}else if($nameQuery!=' ' && $tagQuery==' ' ){
				$this->db->where(" ( pt.tag_id IN (".$nameQuery.") )");
			}else if($nameQuery==' ' && $tagQuery!=' ' ){
				$this->db->where(" ( pt.tag_id IN (SELECT tag_id FROM tags as t WHERE ".$tagQuery." ) )");
			}
		}
		if($header_color_id!='')
		{
			$this->db->join('product_size_color psc','psc.product_id = p.product_id','left');			
			$this->db->where('psc.color_id', $header_color_id);
			$this->db->group_by('psc.product_id');
		}
		if($header_filter_star!='')
		{
			if($header_filter_star==1)
			{
				$this->db->where('p.avg_rating <= "'.$header_filter_star.'" AND p.avg_rating >= "'.($header_filter_star-1).'"');
			}else{
				$this->db->where('p.avg_rating <= "'.$header_filter_star.'" AND p.avg_rating > "'.($header_filter_star-1).'" ');
			}
		}
		if($vendor_id!='')
		{
			$vendor_id = base64_decode($vendor_id);
			$this->db->where('p.vendor_id', $vendor_id);
			//$this->db->get('products p');
			//echo $this->db->last_query(); exit;
			//$this->db->where('vendors.stripe_payment_details_status', '1');
		}
		if($category_id!='')
		{
			//$category_id = base64_decode($category_id);
			$this->db->where('p.category_id', $category_id);
		}
		if($express_required=='1')
		{
			$this->db->where('p.nureso_express_status', '1');
		}
		
        $this->db->where('p.status', '1');
        $this->db->where('p.delete_status', '0');
        $this->db->where('vendors.status', '1');
        $this->db->where('vendors.delete_status', '0');
        $this->db->where('p.approval_status', 'APPROVED');
		$this->db->group_by('p.product_id');

		if($limit>0)
        	$this->db->limit($limit,$offset);
		 
        if(!$this->uri->segment(3)=='products' && !$this->uri->segment(2)=='vendor'){
			if(!empty($_SESSION['logged_user']['id'])){
				$ignore = $this->session->userdata('mysearchids');	        
				if($ignore) {	
					if(empty($sort_product)){
					$this->db->where('p.product_id NOT IN('.$ignore.')');
					}
				}
			}else if(!empty($this->input->cookie('nonlogin',true))){
				if(empty($sort_product)){
				$ignore = $this->session->userdata('mysearchids');          
				if($ignore) {                
					$this->db->where('p.product_id NOT IN('.$ignore.')');
				}
			}
			}
		}
		
		if($is_bundle) {
			$this->db->join('product_bundles pb','pb.product_id = p.product_id');			
		}
			
		if($sort_product=='lowest')	{
			if($is_bundle) {
				$this->db->order_by('pb.bundle_price', 'ASC');
			} else {
				$this->db->order_by('p.price','ASC');
			}
		}elseif($sort_product=='highest'){
			if($is_bundle) {
				$this->db->order_by('pb.bundle_price', 'DESC');
			} else {
				$this->db->order_by('p.price','DESC');
			}			
		}elseif($sort_product=='newest'){
			$this->db->order_by('p.product_id','DESC');
		}else{
			$this->db->order_by('p.product_id','DESC');
		}
		if($product_name!='')
		{
			//$this->db->having('COUNT(*) > 0');
		}
        //$this->db->where('product_images.type', 'MAIN');
          
	    // or
	    //$this->db->order_by('rand()');
		
		if($requestFrom!='vendor_request' && sizeof($vendor_ids)>0) {				
			$this->db->group_start()
				->where('p.nureso_express_status<>', '1')
				->or_where("(p.nureso_express_status='1' AND p.vendor_id IN (".implode(',', $vendor_ids)."))")
				->group_end();
		}
		
        $query = $this->db->get('products as p');
		
        //echo $this->db->last_query(); die();
        if ($query->num_rows() > 0)  {
			//echo $this->db->last_query(); die;
			$products=$query->result_array();
			if($is_bundle) {
				$products = $this->_getProductBundles($products);
			}
			$i=0;
			$finalArr = array();
			//pr($products,1);
			/*
			foreach ($products as $value) 
			{
				
				if($value['nureso_express_status']=='1')
				{
					if($requestFrom!='vendor_request')
					{
						$vendor_id=$value['vendor_id']; 
						$express_approve_status=$value['express_approve_status']; 
						$this->db->select('c.sortname');   
						$this->db->join('countries c','c.id=vec.country_id','left');  
						$this->db->where('vec.vendor_id',$vendor_id); 
						$get=$this->db->get('vendor_express_countries vec');
						$country_code=$get->result_array();
						if(!empty($country_code) && $express_approve_status=='ACCEPT'){
							$country_codes = array_column($country_code,'sortname');
							$currentCountryCode = ip_info(NULL,'countrycode');
							//pr($currentCountryCode,1);
							if(in_array($currentCountryCode,$country_codes))
							{
								$finalArr[] = $value;
							}
						}

					}else{
						$finalArr[] = $value;
					}
				}else{
					$finalArr[] = $value;
				}
			} 
			return $finalArr;
			*/
			return $products;
			
        }else{
			return array();
		}
    }
	private function _getExpressVenderIds() {
		$currentCountryCode = ip_info(NULL,'countrycode');		
		$query = $this->db->select('c.sortname, vec.vendor_id')
				->from('vendor_express_countries vec')
				->join('countries c','c.id=vec.country_id','left')
				->join('vendors v','v.id = vec.vendor_id','left')
				->where('v.express_approve_status', 'ACCEPT')				
				->get();
		$vendor_ids = array();
		if($query) {
			if($result = $query->result_array()) {										
				foreach($result as $row) {
					if($row['sortname'] == $currentCountryCode && !in_array($row['vendor_id'], $vendor_ids)) {
						$vendor_ids[] = $row['vendor_id'];
					}
				}
			}
		}				
		return $vendor_ids;
	}

	private function _getProductBundles($data) {
		$ids = array();
		foreach($data as $item) {
			$product_bundles = $item['product_bundles'];
			if($product_bundles) {
				$product_bundles = explode(',', $product_bundles);
				$ids = array_unique (array_merge ($ids, $product_bundles));
			}
		}
		if(sizeof($ids)>0) {
			$this->db->select('p.product_id,p.earnings,p.product_name,p.vendor_id,p.main_image_id as image_id,p.price,p.filter_label, product_images.image, shop_categories_translations.name as category_name,p.is_product_verified ,p.nureso_express_status, vendors.express_approve_status');
			$this->db->join('product_images','product_images.pi_id = p.main_image_id','left');
			$this->db->join('shop_categories_translations','shop_categories_translations.id = p.category_id','left');
			$this->db->join('vendors','vendors.id = p.vendor_id','left');
			$this->db->where('p.status', '1');
			$this->db->where('p.delete_status', '0');
			$this->db->where('vendors.status', '1');
			$this->db->where('vendors.delete_status', '0');
			$this->db->where('p.approval_status', 'APPROVED');
			$this->db->where_in('product_id', $ids);
			$query = $this->db->get('products as p');
			$products = array();
			if($query->num_rows()>0) {
				$result = $query->result_array();
				foreach($result as $row) {
					$products[$row['product_id']] = $row;
				}
				foreach($data as &$item) {
					$product_bundles = $item['product_bundles'];
					$item['product_bundles'] = [];
					if($product_bundles) {
						$product_bundles = explode(',', $product_bundles);
						foreach($product_bundles as $id) {
							if(array_key_exists($id, $products))
								$item['product_bundles'][] = $products[$id];
						}
					}
				}
			}
		}
		return $data;
	}

	public function updateProductBundle($id, $main_bundle, $product_bundles) {
		$data = array('product_id'=>base64_decode($main_bundle));
		$product = $this->getProductDetails($data['product_id']);
		$price = $product['price'];
		foreach($product_bundles as &$bundle) {
			$bundle = base64_decode($bundle);
			$product = $this->getProductDetails($bundle);
			$price += $product['price'];
		}
		$data['product_bundles'] = implode(',', $product_bundles);	
		$data['bundle_price'] = $price;			
		$this->db->where('id', base64_decode($id));
		$this->db->update('product_bundles', $data);
	}

	public function createProductBundles($vendor_id, $main_bundle, $product_bundles) {
		$data = array(
			'vendor_id'=> $vendor_id, 
			'product_id'=>base64_decode($main_bundle)			
		);
		$product = $this->getProductDetails($data['product_id']);
		$price = $product['price'];
		foreach($product_bundles as &$bundle) {
			$bundle = base64_decode($bundle);
			$product = $this->getProductDetails($bundle);
			$price += $product['price'];
		}
		$data['product_bundles'] = implode(',', $product_bundles);	
		$data['bundle_price'] = $price;
		$this->db->insert('product_bundles', $data);		
	}

	public function deleteProductBundle($vendor_id, $id) {				
		$this->db->where('id', base64_decode($id));
		$this->db->delete('product_bundles');
	}

    public function searchProductHeaderHint($product_name) 
	{
		//print_r($product_name);die();
        $this->db->select('p.product_id,p.product_name');
		//$this->db->where("p.product_name LIKE '%".$product_name."%' ");
		$this->db->join('provider_paypal_details ppd','p.vendor_id = ppd.provider_id','left');
		if($product_name!='')  
		{
			$this->db->join('product_tags pt','pt.product_id = p.product_id','LEFT');
			$nameQuery = $this->productNameGenerateFilterQuery($product_name);
			$tagQuery = $this->productNameGenerateFilterQueryForTags($product_name);
			if($nameQuery!=' ' && $tagQuery!=' '){

				$this->db->where(" ( pt.tag_id IN (SELECT tag_id FROM tags as t WHERE ".$tagQuery." ) OR (".$nameQuery.") )");
			}else if($nameQuery!=' ' && $tagQuery==' ' ){
				$this->db->where(" ( pt.tag_id IN (".$nameQuery.") )");
			}else if($nameQuery==' ' && $tagQuery!=' ' ){
				$this->db->where(" ( pt.tag_id IN (SELECT tag_id FROM tags as t WHERE ".$tagQuery." ) )");
			}
			//echo $tagQuery; exit;
			//$this->db->where(" ( pt.tag_id IN (SELECT tag_id FROM tags as t WHERE ".$tagQuery." ) OR (".$nameQuery.") )");
		}
		$this->db->where('p.status', '1');
        $this->db->where('p.delete_status', '0');
        $this->db->where('p.approval_status', 'APPROVED');
		$this->db->where('ppd.paypal_email != ','');
		$this->db->group_by('p.product_id');
		$this->db->limit(8);
        $query = $this->db->get('products as p');
        if ($query->num_rows() > 0)  {
            return $query->result_array();
        }else{
			return array();
		}
    }

    public function getWishlistProductIds()
	{
		$logged_user = $this->session->userdata('logged_user');
		if($logged_user)
		{
			$user_id = $logged_user['id'];
			$this->db->select('wishlist.product_id');
			$this->db->join('products','products.product_id = wishlist.product_id','left');
			$this->db->join('vendors','products.vendor_id = vendors.id','left');
			$this->db->where('wishlist.user_id',$user_id);
			$this->db->where('products.status','1');
			$this->db->where('products.delete_status','0');
			$this->db->where('vendors.status','1');
			$this->db->where('vendors.delete_status','0');
			$wishlist = $this->db->get('wishlist');
			if($wishlist->num_rows()>0)
			{
				$responseArr = array();
				$wishlists = $wishlist->result_array();
				foreach($wishlists as $wishlist)
				{
					$responseArr[] = $wishlist['product_id'];
				}
				return $responseArr;
			}else{
				return array();
			}
		}else{
			return array();
		}
	}

    public function getWishlistProducts($category_id='',$product_name='')
	{
		$logged_user = $this->session->userdata('logged_user');
		if($logged_user)
		{
			$user_id = $logged_user['id'];
			$this->db->select('products.product_id,products.product_name,products.main_image_id as image_id,products.price , product_images.image');
			$this->db->join('products','wishlist.product_id=products.product_id','left');
			$this->db->join('product_images','product_images.pi_id = products.main_image_id','left');
			$this->db->join('vendors','vendors.id = products.vendor_id','left');
			//$this->db->join('provider_paypal_details ppd','products.vendor_id = ppd.provider_id','left');
			$this->db->where('user_id',$user_id);
			$this->db->where('products.status','1');
			$this->db->where('products.delete_status','0');
			$this->db->where('vendors.status','1');
			$this->db->where('vendors.delete_status','0');
			//$this->db->where('ppd.paypal_email != ','');
			if($category_id!='')
			{
				$this->db->where('category_id',$category_id);
			}
			if($product_name!='')
			{
				$this->db->where("products.product_name LIKE '%".$product_name."%' ");
			}
			$wishlist = $this->db->get('wishlist');
			
			if($wishlist->num_rows()>0)
			{
				$wishlists = $wishlist->result_array();
				return $wishlists;
			}else{
				return array();
			}
		}else{
			return array();
		}
	}
	
    public function getProductsCount($vendor_id='',$category_id='',$product_name='', $is_bundle=false) 
	{
        $this->db->select('p.product_id');
		//$this->db->join('provider_paypal_details ppd','p.vendor_id = ppd.provider_id','left');
		if($vendor_id!='')
		{
			$vendor_id = base64_decode($vendor_id);
			$this->db->where('p.vendor_id', $vendor_id);
		}
		if($category_id!='')
		{
			//$category_id = base64_decode($category_id);
			$this->db->where('p.category_id', $category_id);
		}
		if($product_name!='')
		{
			$this->db->join('product_tags pt','pt.product_id = p.product_id','LEFT');
			$nameQuery = $this->productNameGenerateFilterQuery($product_name);
			$tagQuery = $this->productNameGenerateFilterQueryForTags($product_name);
			if($nameQuery!=' ' && $tagQuery!=' '){

				$this->db->where(" ( pt.tag_id IN (SELECT tag_id FROM tags as t WHERE ".$tagQuery." ) OR (".$nameQuery.") )");
			}else if($nameQuery!=' ' && $tagQuery==' ' ){
				$this->db->where(" ( pt.tag_id IN (".$nameQuery.") )");
			}else if($nameQuery==' ' && $tagQuery!=' ' ){
				$this->db->where(" ( pt.tag_id IN (SELECT tag_id FROM tags as t WHERE ".$tagQuery." ) )");
			}
			//$this->db->where(" ( pt.tag_id IN (SELECT tag_id FROM tags as t WHERE ".$tagQuery." ) OR (".$nameQuery.") )");
		}
        $this->db->where('p.status', '1');
        $this->db->where('p.delete_status', '0');
        $this->db->where('p.approval_status', 'APPROVED');
		//$this->db->where('ppd.paypal_email != ','');
		$this->db->group_by('p.product_id');
		if($is_bundle) {
			$this->db->join('product_bundles pb','pb.product_id = p.product_id');	
		}
        $query = $this->db->get('products as p');
		//echo $this->db->last_query();die();
		
        return $query->num_rows();
    }
	
    public function getRelatedProducts($product_id='',$vendor_id='',$limit=8) {
		
		if($product_id=='')
		{
			return array();
		}else
		{
			$productName = $this->commonmodel->_get_data('products',array('product_id'=>$product_id),'product_name');
			$productName = '';
			if($productName)
			{
				$productName = $productName[0]['product_name'];
			}
			
			$this->db->select('p.*, COUNT(*) AS matchedTags, p.main_image_id as image_id, product_images.image');
			$this->db->join('product_images','product_images.pi_id = p.main_image_id','left');
			$this->db->join('product_tags pt','pt.product_id = p.product_id','INNER');
			//$this->db->join('provider_paypal_details ppd','p.vendor_id = ppd.provider_id','left');
            $this->db->join('vendors','vendors.id = p.vendor_id','left');

			
			if($productName!='')
			{
				$nameQuery = $this->productNameGenerateFilterQuery($productName);
				$this->db->where(" ( pt.tag_id IN (SELECT tag_id FROM product_tags WHERE product_id = '".$product_id."') OR (".$nameQuery.") )");
			}else{
				$this->db->where("pt.tag_id IN (SELECT tag_id FROM product_tags WHERE product_id = '".$product_id."')");
			}
			
			if($vendor_id!='')
			{
				$this->db->where('p.vendor_id',$vendor_id);
			}
            $this->db->where('vendors.status','1');
            $this->db->where('vendors.delete_status','0');
			$this->db->where('p.product_id !=', $product_id);
			$this->db->where('p.status', '1');
			$this->db->where('p.delete_status', '0');
			$this->db->where('p.approval_status', 'APPROVED');
			//$this->db->where('ppd.paypal_email != ','');
			$this->db->group_by('p.product_id');
			$this->db->order_by('matchedTags','DESC');
			$this->db->having('COUNT(*) > 0');
			$this->db->limit($limit);
			$query = $this->db->get('products p');
			//echo $this->db->last_query(); die;
			if ($query->num_rows() > 0)  {
				return $query->result_array();
			}else{
				return array();
			}
		}
	}
	
	
    public function getRelatedProductBundles($product_id='',$vendor_id='',$limit=8) {
		
		if($product_id=='')	{
			return array();
		}else
		{
			$productName = $this->commonmodel->_get_data('products',array('product_id'=>$product_id),'product_name');
			$productName = '';
			if($productName){
				$productName = $productName[0]['product_name'];
			}
			
			$this->db->select('p.*, COUNT(*) AS matchedTags, p.main_image_id as image_id, product_images.image, pb.id AS main_bundle, pb.product_bundles');
			$this->db->join('product_images','product_images.pi_id = p.main_image_id','left');
			$this->db->join('product_tags pt','pt.product_id = p.product_id','INNER');
			$this->db->join('product_bundles pb','pb.product_id = p.product_id');
            $this->db->join('vendors','vendors.id = p.vendor_id','left');

			
			if($productName!='')
			{
				$nameQuery = $this->productNameGenerateFilterQuery($productName);
				$this->db->where(" ( pt.tag_id IN (SELECT tag_id FROM product_tags WHERE product_id = '".$product_id."') OR (".$nameQuery.") )");
			}else{
				$this->db->where("pt.tag_id IN (SELECT tag_id FROM product_tags WHERE product_id = '".$product_id."')");
			}
			
			if($vendor_id!='')
			{
				$this->db->where('p.vendor_id',$vendor_id);
			}
            $this->db->where('vendors.status','1');
            $this->db->where('vendors.delete_status','0');
			$this->db->where('p.product_id !=', $product_id);
			$this->db->where('p.status', '1');
			$this->db->where('p.delete_status', '0');
			$this->db->where('p.approval_status', 'APPROVED');
			//$this->db->where('ppd.paypal_email != ','');
			$this->db->group_by('p.product_id');
			$this->db->order_by('matchedTags','DESC');
			$this->db->having('COUNT(*) > 0');
			$this->db->limit($limit);
			$query = $this->db->get('products p');
			//echo $this->db->last_query(); die;
			if ($query->num_rows() > 0)  {
				$result = $query->result_array();
				$result = $this->_getProductBundles($result);
				return $result;
			}else{
				return array();
			}
		}
	}
	
	public function getVendorProductBundle($bundle_id='') {
		
		if($bundle_id=='')	{
			return array();
		}else {
			$this->db->select('p.*, p.main_image_id as image_id, product_images.image, pb.id AS main_bundle, pb.product_bundles');
			$this->db->join('product_images','product_images.pi_id = p.main_image_id','left');
			$this->db->join('product_tags pt','pt.product_id = p.product_id','INNER');
			$this->db->join('product_bundles pb','pb.product_id = p.product_id');
            $this->db->join('vendors','vendors.id = p.vendor_id','left');

            $this->db->where('vendors.status','1');
            $this->db->where('vendors.delete_status','0');
			$this->db->where('p.status', '1');
			$this->db->where('p.delete_status', '0');
			$this->db->where('p.approval_status', 'APPROVED');
			$this->db->where('pb.id', $bundle_id);
			
			$query = $this->db->get('products p');
			
			if ($query->num_rows() > 0)  {
				$result = $query->result_array();
				$result = $this->_getProductBundles($result);
				return $result;
			}else{
				return array();
			}
		}
    }
    
    public function productNameGenerateFilterQuery($product_name)
	{
		$product_name_expl = explode(' ',$product_name);
		$queryTempArr = array();
		foreach($product_name_expl as $product_nam)
		{
			$product_nam = trim($product_nam);
			if(strlen($product_nam)>1 && $product_nam !='')
			{
				if(strlen($product_nam)>2)
				{
					$queryTempArr[] = 'p.product_name LIKE "%'.$product_nam.'%"';
				}else{
					$queryTempArr[] = 'p.product_name LIKE "'.$product_nam.'"';
				}
			}
		}
		if(!empty($queryTempArr))
		{
			$prodNameQuery = implode(' AND ',$queryTempArr);
			//pr($prodNameQuery,1);
			return $prodNameQuery;
			//$this->db->where($prodNameQuery);
		}else{
			return ' ';
		}
	}
    
    public function productNameGenerateFilterQueryForTags($product_name)
	{
		$product_name_expl = explode(' ',$product_name);
		$queryTempArr = array();
		foreach($product_name_expl as $product_nam)
		{
			$product_nam = trim($product_nam);
			if(strlen($product_nam)>1 && $product_nam !='')
			{
				$queryTempArr[] = 't.tag LIKE "'.$product_nam.'"';
			}
		}
		if(!empty($queryTempArr))
		{
			$prodNameQuery = implode(' AND ',$queryTempArr);
			return $prodNameQuery;
			//$this->db->where($prodNameQuery);
		}else{
			return ' ';
		}
	}
	
    public function getProductDetails($product_id) {
	
		$this->db->select('products.*');
        $this->db->where('products.status', '1');
        $this->db->where('products.product_id',$product_id);
        $query = $this->db->get('products');
		$response = array();
		if($query->num_rows()>0)
		{
			$productData = $query->row_array();
			return $productData;
		}else{
			return '';
		}
    }
    
    public function checkIfmessagedOnProduct($product_id,$user_id,$vendor_id) {
	
		$this->db->select('message_products.*');
        $this->db->where('message_products.product_id', $product_id);
        $this->db->where('message_products.user_id', $user_id);
        $this->db->where('message_products.vendor_id', $vendor_id);
        $this->db->where('message_products.status', '1');
        $this->db->where('message_products.delete_status', '0');
        $this->db->where('message_products.product_id',$product_id);
        $query = $this->db->get('message_products');
		if($query->num_rows()>0)
		{
			$response = $query->row_array();
			$mp_id = $response['mp_id'];
			return $mp_id;
		}else{
			return false;
		}
    }
    
    public function getChatProducts($user_id='',$vendor_id='') 
	{
		if($user_id!='')
		{
			$message_from = 'VENDOR';
		}elseif($vendor_id!='')
		{
			$message_from = 'USER';
		}
		$this->db->select('mp.*,u.name as user_name, v.name as vendor_name, p.product_name, pi.image, (SELECT COUNT(message_id) as messages FROM messages m WHERE m.read_status = "0" AND m.mp_id = mp.mp_id AND message_from = "'.$message_from.'" AND status = "1" AND delete_status = "0") as unread_messages');
		$this->db->join('users_public u','u.id = mp.user_id','LEFT');
		$this->db->join('products p','p.product_id = mp.product_id','LEFT');
		$this->db->join('product_images pi','p.main_image_id = pi.pi_id','LEFT');
		$this->db->join('vendors v','v.id = mp.vendor_id','LEFT');
		if($user_id!='')
		{
			$this->db->where('mp.user_id', $user_id);
		}elseif($vendor_id!='')
		{
			$this->db->where('mp.vendor_id', $vendor_id);
		}
        $this->db->where('mp.status', '1');
        $this->db->where('mp.delete_status', '0');
        $this->db->order_by('mp.last_message_on', 'DESC');
        $query = $this->db->get('message_products mp');
		if($query->num_rows()>0)
		{
			return $query->result_array();
		}else{
			return array();
		}
    }
    
    public function getChatMessages($product_id,$user_id='',$vendor_id='') 
	{
	
		$this->db->select('mp.mp_id');
		$this->db->from('message_products mp');
        $this->db->where('mp.product_id', $product_id);
		if($user_id!='' && $vendor_id=='')
		{
			$this->db->where('mp.user_id', $user_id);
		}elseif($user_id!='' && $vendor_id!=''){
			$this->db->where('mp.user_id', $user_id);
			$this->db->where('mp.vendor_id', $vendor_id);
		}
        $this->db->where('mp.status', '1');
        $this->db->where('mp.delete_status', '0');
		$getMPId = $this->db->get();
		if($getMPId->num_rows()>0)
		{ 
			$MP_id = $getMPId->row_array();
			$mp_id = $MP_id['mp_id'];
			$this->db->select('m.*,u.name as user_name,u.profile_image as user_profile_image, v.name as vendor_name,v.image as vendor_profile_image');
			$this->db->join('messages m','m.mp_id = mp.mp_id','RIGHT');
			$this->db->join('users_public u','u.id = mp.user_id','LEFT');
			$this->db->join('vendors v','v.id = mp.vendor_id','LEFT');
			$this->db->where('m.mp_id', $mp_id);
			$this->db->order_by('m.message_id', 'DESC');
			//$this->db->limit(20);
			$query = $this->db->get('message_products mp');
			if($query->num_rows()>0)
			{
				$this->db->where('mp_id',$mp_id);
				if($user_id!='' && $vendor_id=='')
				{
					$this->db->where('message_from','VENDOR');
				}elseif($user_id!='' && $vendor_id!=''){
					$this->db->where('message_from','USER');
				}
				$this->db->update('messages',array('read_status'=>'1'));
				//echo $this->db->last_query(); die;
				$response = $query->result_array();
				return array_reverse($response);
			}else{
				return array();
			}
		}else{
			return array();
		}
    }
    
    public function getProductsDetails($id) {
	
        $id=base64_decode($id); 
		$this->db->select('products.*,products.main_image_id as image_id, product_images.image, vendors.express_approve_status, vendors.name as vendor_name, vendors.store_name, shop_categories_translations.name as category_name');
        $this->db->join('product_images','product_images.pi_id = products.main_image_id','left');
        $this->db->join('shop_categories_translations','shop_categories_translations.id = products.category_id','left');
        $this->db->join('vendors','vendors.id = products.vendor_id','left');
        $this->db->where('products.status', '1');
        $this->db->where('product_images.type', 'MAIN');
        $this->db->where('products.product_id',$id);
        $this->db->where('vendors.status','1');
        $this->db->where('vendors.delete_status','0');

        $query = $this->db->get('products');
		$response = array();
		if($query->num_rows()>0)
		{
			$productData = $query->row_array();
			
			$this->db->select('asc.id,asc.size');
			$this->db->from('product_size_color psc');
			$this->db->join('attributes_sub_categories asc','psc.size_id = asc.id','LEFT');
			$this->db->where('psc.product_id',$productData['product_id']);
			$this->db->where('psc.size_id !=','0');
			$query1 = $this->db->get();
			//echo $this->db->last_query(); die;
			$sizeArr = array();
			if($query1->num_rows()>0)
			{
				$sizes = $query1->result_array();
				//pr($sizes,1);
				foreach($sizes as $size)
				{
					$sizeArr[$size['id']] = $size['size'];
				}
			}
			$productData['sizes'] = $sizeArr;
			
			$this->db->select('ac.id,ac.category as color');
			$this->db->from('product_size_color psc');
			$this->db->join('attributes_categories ac','psc.color_id = ac.id','LEFT');
			$this->db->where('psc.product_id',$productData['product_id']);
			$this->db->where('psc.color_id !=','0');
			$query2 = $this->db->get();
			//echo $this->db->last_query(); die;
			$colorArr = array();
			if($query2->num_rows()>0)
			{
				$colors = $query2->result_array();
				foreach($colors as $color)
				{
					$colorArr[$color['id']] = $color['color'];
				}
			}
			$productData['colors'] = $colorArr;
			//pr($productData,1);
			$response = $productData;
		}
		return $response;
    }

    public function getAdditionalImage($id) {
       $id=base64_decode($id);
       $this->db->select('pi.image,pi.pi_id');
        $this->db->join('product_additional_images_mapping paim','paim.pi_id = pi.pi_id','left');
        $this->db->where('pi.status', '1');
        $this->db->where('pi.type', 'ADDITIONAL');
        $this->db->where('paim.product_id',$id);
        $query = $this->db->get('product_images pi');
        return $query->result_array(); 
    }
    

    public function get_products_total() {
        $this->db->select('products.product_name,products.main_image_id as image_id,products.price , product_images.image');
        $this->db->join('product_images','product_images.pi_id = products.main_image_id','left');
        $this->db->where('products.status', '1');
        $this->db->where('product_images.type', 'MAIN');
        $query = $this->db->get('products');
        return $query->num_rows(); 
    }

    

    /*public function getProducts($limit = null, $start = null, $big_get, $vendor_id = false)
    {

        if ($limit !== null && $start !== null) {
            $this->db->limit($limit, $start);
        }
        if (!empty($big_get) && isset($big_get['category'])) {
            $this->getFilter($big_get);
        }
        $this->db->select('vendors.url as vendor_url, products.id,products.image, products.quantity, products_translations.title, products_translations.price, products_translations.old_price, products.url');
        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'left');
        $this->db->join('vendors', 'vendors.id = products.vendor_id', 'left');
        $this->db->where('products_translations.abbr', MY_LANGUAGE_ABBR);
        $this->db->where('visibility', 1);

        if ($vendor_id !== false) {
            $this->db->where('vendor_id', $vendor_id);
        }
        if ($this->showOutOfStock == 0) {
            $this->db->where('quantity >', 0);
        }
        if ($this->showInSliderProducts == 0) {
            $this->db->where('in_slider', 0);
        }
        if ($this->multiVendor == 0) {
            $this->db->where('vendor_id', 0);
        }
        $this->db->order_by('position', 'asc');
        $query = $this->db->get('products');
        // echo $this->db->last_query(); exit;
        return $query->result_array();
    }*/

    public function getOneLanguage($myLang)
    {
        $this->db->select('*');
        $this->db->where('abbr', $myLang);
        $result = $this->db->get('languages');
        return $result->row_array();
    }

    private function getFilter($big_get)
    {

        if ($big_get['category'] != '') {
            (int) $big_get['category'];
            $findInIds = array();
            $findInIds[] = $big_get['category'];
            $query = $this->db->query('SELECT id FROM shop_categories WHERE sub_for = ' . $this->db->escape($big_get['category']));
            foreach ($query->result() as $row) {
                $findInIds[] = $row->id;
            }
            $this->db->where_in('products.shop_categorie', $findInIds);
        }
        if ($big_get['in_stock'] != '') {
            if ($big_get['in_stock'] == 1)
                $sign = '>';
            else
                $sign = '=';
            $this->db->where('products.quantity ' . $sign, '0');
        }
        if ($big_get['search_in_title'] != '') {
            $this->db->like('products_translations.title', $big_get['search_in_title']);
        }
        if ($big_get['search_in_body'] != '') {
            $this->db->like('products_translations.description', $big_get['search_in_body']);
        }
        if ($big_get['order_price'] != '') {
            $this->db->order_by('products_translations.price', $big_get['order_price']);
        }
        if ($big_get['order_procurement'] != '') {
            $this->db->order_by('products.procurement', $big_get['order_procurement']);
        }
        if ($big_get['order_new'] != '') {
            $this->db->order_by('products.id', $big_get['order_new']);
        } else {
            $this->db->order_by('products.id', 'DESC');
        }
        if ($big_get['quantity_more'] != '') {
            $this->db->where('products.quantity > ', $big_get['quantity_more']);
        }
        if ($big_get['quantity_more'] != '') {
            $this->db->where('products.quantity > ', $big_get['quantity_more']);
        }
        if ($big_get['brand_id'] != '') {
            $this->db->where('products.brand_id = ', $big_get['brand_id']);
        }
        if ($big_get['added_after'] != '') {
            $time = strtotime($big_get['added_after']);
            $this->db->where('products.time > ', $time);
        }
        if ($big_get['added_before'] != '') {
            $time = strtotime($big_get['added_before']);
            $this->db->where('products.time < ', $time);
        }
        if ($big_get['price_from'] != '') {
            $this->db->where('products_translations.price >= ', $big_get['price_from']);
        }
        if ($big_get['price_to'] != '') {
            $this->db->where('products_translations.price <= ', $big_get['price_to']);
        }
    }

    public function getShopCategories()
    {
        $this->db->select('shop_categories.sub_for, shop_categories.id, shop_categories_translations.name, shop_categories_translations.image');
        $this->db->where('abbr', MY_LANGUAGE_ABBR);
        $this->db->order_by('shop_categories_translations.name', 'asc');
        $this->db->order_by('position', 'asc');
        $this->db->join('shop_categories', 'shop_categories.id = shop_categories_translations.for_id', 'INNER');
        $query = $this->db->get('shop_categories_translations');
        $arr = array();
        if ($query !== false) {
            foreach ($query->result_array() as $row) {
                $arr[] = $row;
            }
        }
        return $arr;
    }

    public function getCategoryById($category_id)
	{
		$this->db->select('name as category_name');
		$this->db->where('id',$category_id);
		$query = $this->db->get('shop_categories_translations');
		if($query->num_rows()>0)
		{
			$result = $query->row_array();
			return $result['category_name'];
		}
	}

    public function checkIfVendorRated($user_id,$vendor_id)
	{
		$this->db->where('user_id',$user_id);
		$this->db->where('vendor_id',$vendor_id);
		$this->db->where('status','1');
		$this->db->where('delete_status','0');
		$query = $this->db->get('vendor_reviews');
		if($query->num_rows()<1)
		{
			return true;
		}else{
			return false;
		}
	}

    public function checkIfProductRated($user_id,$product_id)
	{
		$this->db->where('user_id',$user_id);
		$this->db->where('product_id',$product_id);
		$this->db->where('status','1');
		$this->db->where('delete_status','0');
		$query = $this->db->get('product_reviews');
		if($query->num_rows()<1)
		{
			return true;
		}else{
			return false;
		}
	}
		
    public function getVendorCategories($vendor_id)
    {
        $this->db->select('shop_categories.sub_for, shop_categories.id, shop_categories_translations.name, shop_categories_translations.image,(SELECT count(product_id) as product_count from products where products.category_id = vendor_categories.category_id AND products.vendor_id = '.$vendor_id.' AND status="1" AND delete_status="0" AND approval_status="APPROVED") as products_in_category');
        $this->db->where('abbr', MY_LANGUAGE_ABBR);
        $this->db->where('vendor_categories.vendor_id', $vendor_id);
        $this->db->order_by('shop_categories_translations.name', 'asc');
        $this->db->order_by('position', 'asc');
        $this->db->join('shop_categories_translations', 'shop_categories_translations.id = vendor_categories.category_id', 'INNER');
        $this->db->join('shop_categories', 'shop_categories.id = shop_categories_translations.for_id', 'INNER');
        $this->db->group_by('id');
        $query = $this->db->get('vendor_categories');
        $arr = array();
        if ($query !== false) {
            foreach ($query->result_array() as $row) {
                $arr[] = $row;
            }
        }
        return $arr;
    }

    public function getSeo($page)
    {
        $this->db->where('page_type', $page);
        $this->db->where('abbr', MY_LANGUAGE_ABBR);
        $query = $this->db->get('seo_pages_translations');
      
        $arr = array();
        if ($query !== false) {
            foreach ($query->result_array() as $row) {
                $arr['title'] = $row['title'];
                $arr['description'] = $row['description'];
            }
        }
        return $arr;
    }

    public function getRequestStatus($vendor_id)
    {
    	//echo $vander_id;die();
        $this->db->select('express_approve_status');
        $this->db->where('id',$vendor_id);
        $get = $this->db->get('vendors');
    	if($get->num_rows()>0){
 		 	$result=$get->row_array();
 		 	return $result;	
    	}	
    	else {
    		return '';
    	}

    }

    public function getOneProduct($id)
    {
        $this->db->where('products.id', $id);

        $this->db->select('vendors.url as vendor_url, products.*, products_translations.title,products_translations.description, products_translations.price, products_translations.old_price, products.url, shop_categories_translations.name as categorie_name');

        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'left');
        $this->db->where('products_translations.abbr', MY_LANGUAGE_ABBR);

        $this->db->join('shop_categories_translations', 'shop_categories_translations.for_id = products.shop_categorie', 'inner');
        $this->db->where('shop_categories_translations.abbr', MY_LANGUAGE_ABBR);
        $this->db->join('vendors', 'vendors.id = products.vendor_id', 'left');
        $this->db->where('visibility', 1);
        $query = $this->db->get('products');
        return $query->row_array();
    }

    public function getCountQuantities()
    {
        $query = $this->db->query('SELECT SUM(IF(quantity<=0,1,0)) as out_of_stock, SUM(IF(quantity>0,1,0)) as in_stock FROM products WHERE visibility = 1');
        return $query->row_array();
    }

    public function addCustomerForm($post) {
      $data=array('customer_name'=>$post['c_name'],'customer_email'=>$post['c_mail'],'subject'=>$post['subject'],'message'=>$post['message'],'status'=>1,'delete_status'=>'0','created_at'=>date("Y-m-d H:i:s"),'updated_at'=>date("Y-m-d H:i:s"));
      $qry=$this->db->insert('customer_support',$data);
      if($qry==1) return 1; else return 0;
    }

    public function addToWishlist($product_id,$userId) {
	
      $insertArr = array();
	  $insertArr['product_id'] = $product_id;
	  $insertArr['user_id'] = $userId;
	  $insertArr['create_date'] = date("Y-m-d H:i:s");
	  $insertArr['modify_date'] = date("Y-m-d H:i:s");
	  
	  $checkOldEntry = $this->db->where(array('product_id'=>$product_id,'user_id'=>$userId))->get('wishlist');
	  if($checkOldEntry->num_rows()<1)
	  {
		  $qry=$this->db->insert('wishlist',$insertArr);
		  if($qry==1) return 1; else return 0;
	  }else{
		  echo 'already';
	  }
    }

    public function removeFromWishlist($product_id,$userId) {
	
      $condition = array();
	  $condition['product_id'] = $product_id;
	  $condition['user_id'] = $userId;
	  
	  $checkOldEntry = $this->db->where(array('product_id'=>$product_id,'user_id'=>$userId))->get('wishlist');
	  if($checkOldEntry->num_rows()>0)
	  {
		  $qry=$this->db->delete('wishlist',$condition);
		  if($qry==1) return 1; else return 0;
	  }else{
		  echo 'already';
	  }
    }

    public function getCountries()
    {
		$data = $this->db->from('countries')->order_by('name','ASC')->get();
		$rows = $data->num_rows();
		if($rows>0)
		{
			$result = array();
			$countries = $data->result_array();
			foreach($countries as $country)
			{
				$result[$country['id']] = $country['name'];
			}
			return $result;
		}else{
		
			return '';
		}
    }

    public function getCountriesFromExpress()
    {
		$data = $this->db->from('countries')->order_by('name','ASC')->get();
		$rows = $data->num_rows();
		if($rows>0)
		{
			$result = array();
			$expressResult = array();
			$countries = $data->result_array();
			foreach($countries as $country)
			{
				if($country['express_prime']=='0')
				{
					$result[$country['id']] = $country['name'];
				}else{
					$expressResult[$country['id']] = $country['name'];
				}
			}
			$response = array();
			$response['countries'] = $result;
			$response['expressCountries'] = $expressResult;
			return $response;
		}else{
		
			return '';
		}
    }

    public function getStates($country_id)
    {
		$data = $this->db->from('states')->where('country_id',$country_id)->order_by('name','ASC')->get();
		$rows = $data->num_rows();
		if($rows>0)
		{
			$result = '<option value="">-- Select State --</option>';
			$states = $data->result_array();
			foreach($states as $state)
			{
				$result .= '<option value="'.$state['id'].'">'.$state['name'].'</option>';
			}
			return $result;
		}else{
		
			return '';
		}
    }

    public function getCities($state_id)
    {
		$data = $this->db->from('cities')->where('state_id',$state_id)->order_by('name','ASC')->get();
		$rows = $data->num_rows();
		if($rows>0)
		{
			$result = '<option value="">-- Select City --</option>';
			$cities = $data->result_array();
			foreach($cities as $city)
			{
				$result .= '<option value="'.$city['id'].'">'.$city['name'].'</option>';
			}
			return $result;
		}else{
		
			return '';
		}
    }

    public function getShopItems($array_items)
    {
		if (count($array_items) < 1) {
			return array();
		}else{
			$this->db->select('p.product_id,p.min_estimate,p.max_estimate,p.shipping_time,p.vendor_id, p.product_name, pi.image, p.quantity, p.price, psc.variations_price, psc.quantity as variations_quantity, psc.size_id, asc.size, psc.color_id, ac.category as color,psc.logistic_detail, p.shipping_type, p.shipping');
			$this->db->from('products p');
			$this->db->join('product_images pi','p.main_image_id = pi.pi_id','LEFT');
			$this->db->join('vendors v','v.id = p.vendor_id','LEFT');
			//$this->db->join('provider_paypal_details ppd','v.id = ppd.provider_id','LEFT');
			$this->db->join('product_size_color psc','psc.product_id = p.product_id','LEFT');
			$this->db->join('attributes_sub_categories asc','psc.size_id = asc.id','LEFT');
			$this->db->join('attributes_categories ac','psc.color_id = ac.id','LEFT');
			if (count($array_items) > 0) {
			
				$tempArr = array();
				if(!empty($array_items))
				{
					foreach ($array_items as $product_id => $product_data) {
						foreach ($product_data as $productData) {
					
							$tempArr[] = '( p.product_id = '.$product_id.' AND psc.size_id = '.$productData['size_id'].' AND psc.color_id = '.$productData['color_id'].')';
						}
					}
					$where = '(';
					$where .= implode(' OR ',$tempArr);
					$where .= ')';
					$this->db->where($where);
				}
			}
			$this->db->where('p.status','1');
			$this->db->where('p.delete_status','0');
			$this->db->where('v.status','1');
			$this->db->where('v.delete_status','0');
			//$this->db->where('ppd.paypal_email != ','');
			$query = $this->db->get();
			if($query->num_rows()>0)
			{
				return $query->result_array();
			}else{
				return array();
			}
		}
    }

    public function get_size_color_details($post,$allDetails='')
    {
		if($this->uri->segment(3)!='' && $allDetails=='')
		{
			$product_id = base64_decode($this->uri->segment(3));
		}else{
			$product_id = $post['product_id'];
		}
		if($allDetails=='')
		{
			$selectsize = $post['selectsize'];
			$selectcolor = $post['selectcolor'];
			$this->db->select('p.price, psc.psc_id, psc.variations_price, p.quantity, psc.quantity as variations_quantity, psc.logistic_detail');
		}else{
			$this->db->select('psc.*,asc.size as size_text,ac.category as color_text,ac.details as color_code');
		}
        $this->db->from('product_size_color psc');
        $this->db->join('products p','p.product_id = psc.product_id','LEFT');
        $this->db->join('attributes_sub_categories asc','psc.size_id = asc.id','LEFT');
        $this->db->join('attributes_categories ac','psc.color_id = ac.id','LEFT');
		if($allDetails=='')
		{
			$this->db->where('psc.size_id =', $selectsize);
			$this->db->where('psc.color_id =', $selectcolor);
		}
		$this->db->where('psc.product_id =', $product_id);
		$this->db->where('p.status','1');
		$this->db->where('p.delete_status','0');
        $query = $this->db->get();
		if($query->num_rows()>0)
		{
			if($allDetails=='')
			{
				return $query->row_array();
			}else{
				return $query->result_array();
			}
		}else{
			return array();
		}
    }

    /*
		* Users for notification by email
     */

    public function getNotifyUsers()
    {
        $result = $this->db->query('SELECT email FROM users WHERE notify = 1');
        $arr = array();
        foreach ($result->result_array() as $email) {
            $arr[] = $email['email'];
        }
        return $arr;
    }

    public function setOrder($post)
    {   
        
        $q = $this->db->query('SELECT MAX(order_id) as order_id FROM orders');
        $rr = $q->row_array();
        if ($rr['order_id'] == 0) {
            $rr['order_id'] = 1233;
        }
        $post['order_id'] = $rr['order_id'] + 1;

        $i = 0;
        $post['products'] = array();
        foreach ($post['id'] as $product) {
            $post['products'][$product] = $post['quantity'][$i];
            $i++;
        }
        
        $proId=implode(',', $post['id']);
        $this->db->select('*');
        $this->db->from('products');
        $this->db->where('id IN('.$proId.')');
        $vId=$this->db->get()->result_array();
        $post['date'] = time();
        $post['products'] = serialize($post['products']);

               
        foreach ($post['id'] as $index => $productId) {
            
             //print_r($vId[$index]);
             $this->db->insert('order_items',array('order_id'=>$post['order_id'],'product_id'=>$productId,'quantity'=>$post['quantity'][$index],'price'=>$post['price'][$index],'vendor_id'=>$vId[$index]['vendor_id'],'status'=>1));   
             
             $totQty=$vId[$index]['quantity'];
             $purQty=$post['quantity'][$index]; 
             $leftQty=$totQty - $purQty;
             
             $this->db->set('quantity', $leftQty);   
             $this->db->where('id', $productId);   
             $this->db->update('products'); 
             //echo $this->db->last_query();

        } 
          
        // exit;
       
        
        $this->db->trans_begin();
        if(!$this->db->insert('orders', array(
                    'order_id' => $post['order_id'],
                    'products' => $post['products'],
                    'date' => $post['date'],
                    'referrer' => $post['referrer'],
                    'clean_referrer' => $post['clean_referrer'],
                    'payment_type' => $post['payment_type'],
                    'paypal_status' => @$post['paypal_status'],
                    'discount_code' => @$post['discountCode'],
                    'user_id' => $post['user_id']
                ))) {
            log_message('error', print_r($this->db->error(), true));
        }

            /*$product_id=$post['id'];
            $data = array();
            for ($i = 0; $i < count($post['id']); $i++){
                $data[$i] = array(
                    'order_id' => $post['order_id'],
                    'product_id' => $product_id[$i],
                    'status'=>1
                );
            }     
          $this->db->insert_batch('order_items',$data);  
          $this->db->last_query();*/

      
        $lastId = $this->db->insert_id();
        if (!$this->db->insert('orders_clients', array(
                    'for_id' => $lastId,
                    'first_name' => $post['first_name'],
                    'last_name' => $post['last_name'],
                    'email' => $post['email'],
                    'phone' => $post['phone'],
                    'address' => $post['address'],
                    'city' => $post['city'],
                    'post_code' => $post['post_code'],
                    'notes' => $post['notes']
                ))) { 
            log_message('error', print_r($this->db->error(), true));
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return $post['order_id'];
        }
    }

    public function setVendorOrder($post)
    {
       
        $i = 0;
        $post['products'] = array();
        foreach ($post['id'] as $product) {
            $post['products'][$product] = $post['quantity'][$i];
            $i++;
        }

        /*
         * Loop products and check if its from vendor - save order for him
         */
        foreach ($post['products'] as $product_id => $product_quantity) {
            $productInfo = $this->getOneProduct($product_id);
            if ($productInfo['vendor_id'] > 0) {

                $q = $this->db->query('SELECT MAX(order_id) as order_id FROM vendors_orders');
                $rr = $q->row_array();
                if ($rr['order_id'] == 0) {
                    $rr['order_id'] = 1233;
                }
                
                $post['order_id'] = $rr['order_id'] + 1;

                unset($post['id'], $post['quantity']);
                $post['date'] = time();
                $post['products'] = serialize(array($product_id => $product_quantity));
                $this->db->trans_begin();
                if (!$this->db->insert('vendors_orders', array(
                            'order_id' => $post['order_id'],
                            'products' => $post['products'],
                            'date' => $post['date'],
                            'referrer' => $post['referrer'],
                            'clean_referrer' => $post['clean_referrer'],
                            'payment_type' => $post['payment_type'],
                            'paypal_status' => @$post['paypal_status'],
                            'discount_code' => @$post['discountCode'],
                            'vendor_id' => $productInfo['vendor_id']
                        ))) {
                    log_message('error', print_r($this->db->error(), true));
                }
                $lastId = $this->db->insert_id();
                if (!$this->db->insert('vendors_orders_clients', array(
                            'for_id' => $lastId,
                            'first_name' => $post['first_name'],
                            'last_name' => $post['last_name'],
                            'email' => $post['email'],
                            'phone' => $post['phone'],
                            'address' => $post['address'],
                            'city' => $post['city'],
                            'post_code' => $post['post_code'],
                            'notes' => $post['notes']
                        ))) {
                    log_message('error', print_r($this->db->error(), true));
                }
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    return false;
                } else {
                    $this->db->trans_commit();
                }
            }
        }
    }

    public function setActivationLink($link, $orderId)
    {
        $result = $this->db->insert('confirm_links', array('link' => $link, 'for_order' => $orderId));
        return $result;
    }

    public function getSlider($pageName)
    {
        $this->db->select('slider_id,slider_text,slider_image');
        $this->db->where('slider_type',$pageName);
        $this->db->where('status','1');
        $this->db->where('delete_status','0');
        $this->db->order_by('slider_possition','ASC');
        $query = $this->db->get('sliders');
		$response = array();
		if($query->num_rows()>0)
		{
			$response = $query->result_array();		
		}
		return $response;
    }

    public function getSliderProducts()
    {
        $this->db->select('vendors.url as vendor_url, products.id, products.quantity, products.image, products.url, products_translations.price, products_translations.title, products_translations.basic_description, products_translations.old_price');
        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'left');
        $this->db->join('vendors', 'vendors.id = products.vendor_id', 'left');
        $this->db->where('products_translations.abbr', MY_LANGUAGE_ABBR);
        $this->db->where('visibility', 1);
        $this->db->where('in_slider', 1);
        if ($this->showOutOfStock == 0) {
            $this->db->where('quantity >', 0);
        }
        $query = $this->db->get('products');
        return $query->result_array();
    }

    public function getbestSellers($categorie = 0, $noId = 0)
    {
        $this->db->select('vendors.url as vendor_url, products.id, products.quantity, products.image, products.url, products_translations.price, products_translations.title, products_translations.old_price');
        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'left');
        $this->db->join('vendors', 'vendors.id = products.vendor_id', 'left');
        if ($noId > 0) {
            $this->db->where('products.id !=', $noId);
        }
        $this->db->where('products_translations.abbr', MY_LANGUAGE_ABBR);
        if ($categorie != 0) {
            $this->db->where('products.shop_categorie !=', $categorie);
        }
        $this->db->where('visibility', 1);
        if ($this->showOutOfStock == 0) {
            $this->db->where('quantity >', 0);
        }
        $this->db->order_by('products.procurement', 'desc');
        $this->db->limit(5);
        $query = $this->db->get('products');
        return $query->result_array();
    }

    public function sameCagegoryProducts($categorie, $noId, $vendor_id = false)
    {
        $this->db->select('vendors.url as vendor_url, products.id, products.quantity, products.image, products.url, products_translations.price, products_translations.title, products_translations.old_price');
        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'left');
        $this->db->join('vendors', 'vendors.id = products.vendor_id', 'left');
        $this->db->where('products.id !=', $noId);
        if ($vendor_id !== false) {
            $this->db->where('vendor_id', $vendor_id);
        }
        $this->db->where('products.shop_categorie =', $categorie);
        $this->db->where('products_translations.abbr', MY_LANGUAGE_ABBR);
        $this->db->where('visibility', 1);
        if ($this->showOutOfStock == 0) {
            $this->db->where('quantity >', 0);
        }
        $this->db->order_by('products.id', 'desc');
        $this->db->limit(5);
        $query = $this->db->get('products');
        return $query->result_array();
    }

    public function getOnePost($id)
    {
        $this->db->select('blog_translations.title, blog_translations.description, blog_posts.image, blog_posts.time');
        $this->db->where('blog_posts.id', $id);
        $this->db->join('blog_translations', 'blog_translations.for_id = blog_posts.id', 'left');
        $this->db->where('blog_translations.abbr', MY_LANGUAGE_ABBR);
        $query = $this->db->get('blog_posts');
        return $query->row_array();
    }

    public function getArchives()
    {
        $result = $this->db->query("SELECT DATE_FORMAT(FROM_UNIXTIME(time), '%M %Y') as month, MAX(time) as maxtime, MIN(time) as mintime FROM blog_posts GROUP BY DATE_FORMAT(FROM_UNIXTIME(time), '%M %Y')");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        }
        return false;
    }

    public function getFooterCategories()
    {
        $this->db->select('shop_categories.id, shop_categories_translations.name');
        $this->db->where('abbr', MY_LANGUAGE_ABBR);
        $this->db->where('shop_categories.sub_for =', 0);
        $this->db->join('shop_categories', 'shop_categories.id = shop_categories_translations.for_id', 'INNER');
        $this->db->limit(10);
        $query = $this->db->get('shop_categories_translations');
        $arr = array();
        if ($query !== false) {
            foreach ($query->result_array() as $row) {
                $arr[$row['id']] = $row['name'];
            }
        }
        return $arr;
    }

    public function setSubscribe($array)
    {
        $num = $this->db->where('email', $arr['email'])->count_all_results('subscribed');
        if ($num == 0) {
            $this->db->insert('subscribed', $array);
        }
    }

    public function getDynPagesLangs($dynPages)
    {
        if (!empty($dynPages)) {
            $this->db->join('textual_pages_tanslations', 'textual_pages_tanslations.for_id = active_pages.id', 'left');
            $this->db->where_in('active_pages.name', $dynPages);
            $this->db->where('textual_pages_tanslations.abbr', MY_LANGUAGE_ABBR);
            $result = $this->db->select('textual_pages_tanslations.name as lname, active_pages.name as pname')->get('active_pages');
            $ar = array();
            $i = 0;
            foreach ($result->result_array() as $arr) {
                $ar[$i]['lname'] = $arr['lname'];
                $ar[$i]['pname'] = $arr['pname'];
                $i++;
            }
            return $ar;
        } else
            return $dynPages;
    }

    public function getOnePage($page)
    {
        $this->db->join('textual_pages_tanslations', 'textual_pages_tanslations.for_id = active_pages.id', 'left');
        $this->db->where('textual_pages_tanslations.abbr', MY_LANGUAGE_ABBR);
        $this->db->where('active_pages.name', $page);
        $result = $this->db->select('textual_pages_tanslations.description as content, textual_pages_tanslations.name')->get('active_pages');
       // echo $this->db->last_query(); exit;
        return $result->row_array();
    }

    public function getAboutPage() {

        $result = $this->db->select('*')->get('about_page');
        return $result->row_array();
    }

    public function getBlog($limit, $start)  {  
        $this->db->where('delete_status','0');
        $this->db->limit($limit, $start);
        $this->db->order_by('blog_date','DESC');
        $query = $this->db->get("blogs");
        if ($query->num_rows() > 0)  {
            foreach ($query->result_array() as $row){
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function get_total(){
        $query = $this->db->select('*')->where('delete_status','0')->get('blogs'); 
        return $query->num_rows(); 
    }

    public function getVendorDetails($vendor_id){
		$vendor_id = base64_decode($vendor_id);
        $query = $this->db->select('*')->where('id',$vendor_id)->where('status','1')->where('delete_status','0')->get('vendors');
		if($query->num_rows()>0)
		{
			return $query->row_array();
		}else{
			return array();
		}
    }

    public function getVendorReviews($vendor_id,$limit=12,$offset=0,$filter_stars='')
	{
		$this->db->select('vr.*,u.name as name');
		$this->db->from('vendor_reviews vr');
		$this->db->join('users_public u','u.id=vr.user_id','left');
		$this->db->where('vr.vendor_id',$vendor_id);
		if($filter_stars!='')
		{
			$this->db->where('vr.rating',$filter_stars);
		}
		$this->db->where('vr.status','1');
		$this->db->where('vr.delete_status','0');
		$this->db->where('vr.approval_status','APPROVED');
		$this->db->order_by('vr.modify_on','DESC');
		$this->db->limit($limit,$offset);
		$query = $this->db->get();
		if($query->num_rows()>0)
		{
			return $query->result_array();
		}else{
			return array();
		}
    }

    public function getVendorReviewsCount($vendor_id,$filter_stars='')
	{
		$this->db->select('vr.vr_id');
		$this->db->from('vendor_reviews vr');
		$this->db->where('vr.vendor_id',$vendor_id);
		if($filter_stars!='')
		{
			$this->db->where('vr.rating',$filter_stars);
		}
		$this->db->where('vr.status','1');
		$this->db->where('vr.delete_status','0');
		$this->db->where('vr.approval_status','APPROVED');
		$query = $this->db->get();
		return $query->num_rows();
    }

    public function getVendorReviewsAvg($vendor_id)
	{
		$this->db->select('rating, count(rating) as rating_count');
		$this->db->from('vendor_reviews vr');
		$this->db->where('vr.vendor_id',$vendor_id);
		$this->db->where('vr.status','1');
		$this->db->where('vr.delete_status','0');
		$this->db->where('vr.approval_status','APPROVED');
		$this->db->group_by('vr.rating');
		$this->db->order_by('vr.rating','DESC');
		$query = $this->db->get();
		if($query->num_rows()>0)
		{
			$details = $query->result_array();
			//pr($details);
			$total_ratings = 0;
			$main_rating = 0;
			$tempArr = array();
			$star1=0;
			$star2=0;
			$star3=0;
			$star4=0;
			$star5=0;
			foreach($details as $detail)
			{
				$main_rating += (int)$detail['rating']*$detail['rating_count'];
				$total_ratings += $detail['rating_count'];
				$var = "star".(int)$detail['rating'];
				$$var = (int)$detail['rating']*$detail['rating_count'];
			}
			$tempArr = array();
			for ($i=1;$i<=5;++$i) {
				$var = "star$i";
				$count = $$var;
				$percent = $count * 100 / $main_rating;
				$tempArr[$i] = number_format((float)$percent, 2, '.', '');
			}
			$avg_rating = $main_rating/$total_ratings;
			$avg_rating = number_format((float)$avg_rating, 2, '.', '');
			$responseArr = array();
			$responseArr['avg_rating'] = $avg_rating;
			$responseArr['eachPercentage'] = $tempArr;
			//pr($responseArr,1);
			return $responseArr;
		}else{
			$responseArr = array();
			$responseArr['avg_rating'] = 0;
			$responseArr['eachPercentage'] = array();
			return $responseArr;
		}
		
		/* $this->db->select('(SUM(vr.rating)/(COUNT(vr.vr_id)*5)) * 100 as avg_rating');
		$this->db->from('vendor_reviews vr');
		$this->db->where('vr.vendor_id',$vendor_id);
		$this->db->where('vr.status','1');
		$this->db->where('vr.delete_status','0');
		$this->db->where('vr.approval_status','APPROVED');
		$query = $this->db->get();
		if($query->num_rows()>0)
		{
			$details = $query->row_array();
			return number_format((float)$details['avg_rating'], 2, '.', '');
		}else{
			return 0;
		} */
    }

    public function getProductReviews($product_id,$limit=12,$offset=0,$filter_stars='')
	{
		$this->db->select('pr.*,u.name as name');
		$this->db->from('product_reviews pr');
		$this->db->join('users_public u','u.id=pr.user_id','left');
		$this->db->where('pr.product_id',$product_id);
		if($filter_stars!='')
		{
			$this->db->where('pr.rating',$filter_stars);
		}
		$this->db->where('pr.status','1');
		$this->db->where('pr.delete_status','0');
		$this->db->where('pr.approval_status','APPROVED');
		$this->db->order_by('pr.modify_on','DESC');
		$this->db->limit($limit,$offset);
		$query = $this->db->get();
		if($query->num_rows()>0)
		{
			return $query->result_array();
		}else{
			return array();
		}
    }


    

    public function checkStatusExpressProduct($vendor_id='') {
		if($vendor_id!=''){
    		$vendor_id=base64_decode($vendor_id);
			$this->db->select('*');
			$this->db->from('products p');
			$this->db->join('vendors v','v.id=p.vendor_id','left');
			$this->db->where('v.express_approve_status','ACCEPT');
			$this->db->where('p.nureso_express_status','1');
			$this->db->where('p.vendor_id',$vendor_id);
			$get=$this->db->get();
			if($get->num_rows()>0){
				echo 'true'; exit;
			}
			else {
				echo 'false1'; exit;

			}
		}
		else {
				echo 'false'; exit;

	
		}
    }

    public function getProductReviewsCount($product_id,$filter_stars='')
	{
		$this->db->select('pr.pr_id');
		$this->db->from('product_reviews pr');
		$this->db->where('pr.product_id',$product_id);
		if($filter_stars!='')
		{
			$this->db->where('pr.rating',$filter_stars);
		}
		$this->db->where('pr.status','1');
		$this->db->where('pr.delete_status','0');
		$this->db->where('pr.approval_status','APPROVED');
		$query = $this->db->get();
		return $query->num_rows();
    }

    public function getProductReviewsAvg($product_id,$updateFlag=false)
	{
	
		$this->db->select('rating, count(rating) as rating_count');
		$this->db->from('product_reviews pr');
		$this->db->where('pr.product_id',$product_id);
		$this->db->where('pr.status','1');
		$this->db->where('pr.delete_status','0');
		$this->db->where('pr.approval_status','APPROVED');
		$this->db->group_by('pr.rating');
		$this->db->order_by('pr.rating','DESC');
		$query = $this->db->get();
		if($query->num_rows()>0)
		{
			$details = $query->result_array();
			//pr($details);
			$total_ratings = 0;
			$main_rating = 0;
			$tempArr = array();
			$star1=0;
			$star2=0;
			$star3=0;
			$star4=0;
			$star5=0;
			foreach($details as $detail)
			{
				$main_rating += (int)$detail['rating']*$detail['rating_count'];
				$total_ratings += $detail['rating_count'];
				$var = "star".(int)$detail['rating'];
				$$var = (int)$detail['rating']*$detail['rating_count'];
			}
			$tempArr = array();
			for ($i=1;$i<=5;++$i) {
				$var = "star$i";
				$count = $$var;
				$percent = $count * 100 / $main_rating;
				$tempArr[$i] = number_format((float)$percent, 2, '.', '');
			}
			
			if($updateFlag)
			{
				$avg_rating = $main_rating/$total_ratings;
				$avg_rating = number_format((float)$avg_rating, 2, '.', '');
				$this->db->where('product_id',$product_id);
				$this->db->update('products',array('avg_rating'=>$avg_rating));
			}else{
				$this->db->select('avg_rating');
				$this->db->where('product_id',$product_id);
				$qury = $this->db->get('products');
				$details = $qury->row_array();
				$avg_rating = $details['avg_rating'];
			}
			
			$responseArr = array();
			$responseArr['avg_rating'] = $avg_rating;
			$responseArr['eachPercentage'] = $tempArr;
			//pr($responseArr,1);
			return $responseArr;
		}else{
			$responseArr = array();
			$responseArr['avg_rating'] = 0;
			$responseArr['eachPercentage'] = array();
			return $responseArr;
		}
    }

    public function getBlogById($id){
        $id=base64_decode($id);
        $query = $this->db->select('*')->where('blog_id',$id)->get('blogs'); 
        return $query->result_array(); 
    }

    public function getPopularPosts(){ 
        $query = $this->db->select('*')->where('delete_status','0')->where('is_popular_post','1')->order_by('blog_id','DESC')->get('blogs'); 
        return $query->result_array(); 
    }

    public function getRecentPosts(){ 
        $query = $this->db->select('*')->where('delete_status','0')->where('is_recent_post','1')->order_by('blog_id','DESC')->get('blogs'); 
        return $query->result_array(); 
    }

    

    public function getAboutListPage() {
        $result = $this->db->select('*')->where('delete_status','0')->get('about_page_content');
        return $result->result();
    }

    public function getFAQdata() {
        $result = $this->db->select('*')->where('delete_status','0')->get('faq_content');
        return $result->result();
    }

    public function changePaypalOrderStatus($order_id, $status)
    {
        $processed = 0;
        if ($status == 'canceled') {
            $processed = 2;
        }
        $this->db->where('order_id', $order_id);
        if (!$this->db->update('orders', array(
                    'paypal_status' => $status,
                    'processed' => $processed
                ))) {
            log_message('error', print_r($this->db->error(), true));
        }
    }

    public function getCookieLaw()
    {
        $this->db->join('cookie_law_translations', 'cookie_law_translations.for_id = cookie_law.id', 'inner');
        $this->db->where('cookie_law_translations.abbr', MY_LANGUAGE_ABBR);
        $this->db->where('cookie_law.visibility', '1');
        $query = $this->db->select('link, theme, message, button_text, learn_more')->get('cookie_law');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function confirmOrder($md5)
    {
        $this->db->limit(1);
        $this->db->where('link', $md5);
        $result = $this->db->get('confirm_links');
        $row = $result->row_array();
        if (!empty($row)) {
            $orderId = $row['for_order'];
            $this->db->limit(1);
            $this->db->where('order_id', $orderId);
            $result = $this->db->update('orders', array('confirmed' => '1'));
            return $result;
        }
        return false;
    }

    public function getValidDiscountCode($code)
    {
        $time = time();
        $this->db->select('type, amount,code');
        $this->db->where('code', $code);
        $this->db->where('status', '1');
        $this->db->where($time . ' BETWEEN valid_from_date AND valid_to_date');
        $query = $this->db->get('discount_codes');
        return $query->row_array();
    }

    public function countPublicUsersWithEmail($email, $id = 0)
    {
        if ($id > 0) {
            $this->db->where('id !=', $id);
        }
		
        $this->db->where('email', $email);
        $this->db->where('delete_status', '0');
        //$this->db->where('verification_status', '1');
        return $this->db->count_all_results('users_public');
    }

    public function registerUser($post)
    {
		$this->db->where('email', $post['email']);
        $this->db->where('verification_status != ', '1');
		$entryCheck = $this->db->count_all_results('users_public');
		
		if($entryCheck>0)
		{
			$this->db->where('email', $post['email']);
			$this->db->delete('users_public');
		}
		
		$verification_token = hash('sha256',md5($post['email'].rand(10001,99999)));
		$verificationLink = base_url('verify-account/'.$post['email'].'/'.$verification_token);
		
		
		$input = array(
						'name' => $post['name'],
						'email' => $post['email'],
						'password' => md5($post['pass']),
						'verification_token' => trim($verification_token),
					);
		$myDomain = 'w3ondemand';
		$response = $this->sendmail->sendTo($post['email'], 'Verify your account', 'Verification link for ' . $myDomain, 'Hello,<br> your verification link is <a href="'.$verificationLink.'" target="_blank">'.$verificationLink.'</a>');
		$this->db->insert('users_public', $input);
        return $this->db->insert_id();
    }

    public function verifyUserAccount($email,$verification_token)
    {
        $this->db->where('email', $email);
        $this->db->where('verification_token', $verification_token);
        $this->db->where('verification_status', '0');
        $checkRecord = $this->db->count_all_results('users_public');
		if($checkRecord>0)
		{
			$updateArr = array();
			$updateArr['verification_status'] = 1;
			$updateArr['verification_token'] = '';
			$this->session->set_flashdata('success', 'Your email id is verfied.You can login now!');
			$this->db->where('email',$email);
			$this->db->update('users_public',$updateArr);
		}else{
			$this->session->set_flashdata('login_error', 'Link is expired or you already used before!');
		}
		redirect(LANG_URL . '/login');
    }

    public function updateProfile($post)
    {
        $array = array(
            'name' => $post['name'],
            'phone' => $post['phone'],
            'email' => $post['email']
        );
        if (trim($post['pass']) != '') {
            $array['password'] = md5($post['pass']);
        }
        $this->db->where('id', $post['id']);
        $this->db->update('users_public', $array);
    }

    public function checkPublicUserIsValid($post)
    {
        $this->db->where('email', $post['email']);
        $this->db->where('password', md5($post['pass']));
        $query = $this->db->get('users_public');
        $result = $query->row_array();
		if (empty($result)) {
            return false;
        } else {
			$this->setCartArray($result);
            return $result;
        }
    }

    public function setCartArray($result)
    {
		$shopping_cart_data = $result['shopping_cart_data'];
		if($shopping_cart_data!='')
		{
			$shopping_cart_data = unserialize($shopping_cart_data);
			if(isset($_SESSION['shopping_cart']) && !empty($_SESSION['shopping_cart']))
			{
				$updatedArr = $this->regenerateCartArray($shopping_cart_data,$_SESSION['shopping_cart']);
			}else{
				$updatedArr = $shopping_cart_data;
			}
			//pr($updatedArr,1);
			$this->db->where('id',$result['id']);
			$this->db->update('users_public',array('shopping_cart_data'=>serialize($updatedArr)));
			$_SESSION['shopping_cart'] = $updatedArr;
			@set_cookie('shopping_cart', serialize($updatedArr), $this->cookieExpTime);
		}elseif(isset($_SESSION['shopping_cart']) && !empty($_SESSION['shopping_cart'])){
			$shopping_cart = $_SESSION['shopping_cart'];
			$this->db->where('id',$result['id']);
			$this->db->update('users_public',array('shopping_cart_data'=>serialize($shopping_cart)));
			$_SESSION['shopping_cart'] = $shopping_cart;
			@set_cookie('shopping_cart', serialize($shopping_cart), $this->cookieExpTime);
		}
	}

    public function regenerateCartArray($userCartItems,$sessionItems)
    {
		/* pr($userCartItems);
		pr($sessionItems); */
	
		$finalArr = array();
		foreach($userCartItems as $key => $userCartItem)
		{
			if(isset($sessionItems[$key]))
			{
				foreach($userCartItem as $userCartItm)
				{
					foreach($sessionItems[$key] as $productDetail)
					{
						if($userCartItm['size_id']==$productDetail['size_id'] && $userCartItm['color_id']==$productDetail['color_id'])
						{
							$productDetailsArr = array();
							$productDetailsArr['product_id'] = $key;
							$productDetailsArr['selectsize'] = $userCartItm['size_id'];
							$productDetailsArr['selectcolor'] = $userCartItm['color_id'];
							$quantityDetails = $this->get_size_color_details($productDetailsArr);
							$dbQuantity = 0;
							if(!empty($quantityDetails))
							{
								if($quantityDetails['logistic_detail']=='custom')
								{
									$dbQuantity = $quantityDetails['variations_quantity'];
								}else{
									$dbQuantity = $quantityDetails['quantity'];
								}
							}
							$updatedQuantity = $userCartItm['quantity']+$productDetail['quantity'];
							if($updatedQuantity>$dbQuantity)
							{
								$updatedQuantity = $dbQuantity;
							}
							if(isset($finalArr[$key]))
							{
								foreach($finalArr[$key] as $thisKey => $finalProductdata)
								{
									if($finalProductdata['size_id']==$productDetail['size_id'] && $finalProductdata['color_id']==$productDetail['color_id'])
									{
										$finalArr[$key][$thisKey] = array(
																'quantity'=>$updatedQuantity,
																'size_id'=>$userCartItm['size_id'],
																'color_id'=>$userCartItm['color_id'],
															);
									}
								}
							}else{								
								$finalArr[$key][] = array(
														'quantity'=>$updatedQuantity,
														'size_id'=>$userCartItm['size_id'],
														'color_id'=>$userCartItm['color_id'],
													);
							}
						}else{
							$finalArr[$key][] = array(
														'quantity'=>$userCartItm['quantity'],
														'size_id'=>$userCartItm['size_id'],
														'color_id'=>$userCartItm['color_id'],
													);
							$finalArr[$key][] = array(
														'quantity'=>$productDetail['quantity'],
														'size_id'=>$productDetail['size_id'],
														'color_id'=>$productDetail['color_id'],
													);
						}
					}
				}
			}else{
				$finalArr[$key] = $userCartItem;
			}
		}
		
		foreach($sessionItems as $key => $sessionItem)
		{
			if(!array_key_exists($key,$userCartItems))
			{
				$finalArr[$key] = $sessionItem;
			}
		}
		//pr($finalArr,1);
		return $finalArr;
	}

    public function updateProfileImage()
    {
		$userDetails = $this->session->userdata('logged_user');
		$id = $userDetails['id'];
		$response = array();
		if($id!="")
		{
			if($_FILES['profile_image']['name']!="")
			{
				$result = $this->do_upload_by_ajax('profile_image');
				if($result['error']=='no')
				{
					$imgName = $result['upload_data']['file_name'];
					$arr = array();
					$arr['profile_image'] = $imgName;
					
					$this->db->where('id',$id);
					$this->db->update('users_public',$arr);
					$response['error'] = 'no';
					$response['msg'] = UPLOAD_URL.'user-images/'.$imgName;
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
		$folderPath = UPLOAD_PHYSICAL_PATH.'user-images/';
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

    public function getUserProfileInfo($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('users_public');
        return $query->row_array();
    }

    public function sitemap()
    {
        $query = $this->db->select('url')->get('products');
        return $query;
    }

    public function sitemapBlog()
    {
        $query = $this->db->select('url')->get('blog_posts');
        return $query;
    }
	
	public function check_user_pass($password){
	
		$logged_user = $this->session->userdata('logged_user');
		$id = $logged_user['id'];
		$this->db->select('email')
					->from('users_public')
					->where('id',$id)
					->where('password',md5($password));
		$data = $this->db->get();
		
		if($data->num_rows() > 0){
			return 0;
		}else{
			return 1;
		}
	}	
	
	public function check_user_email($user_email){
		$this->db->select('email')
					->from('users_public')
					->where('email',$user_email)
					->where('verification_status','1');
		//$this->db->where('status','1');
		$this->db->where('delete_status','0');
		$data = $this->db->get();
		
		if($data->num_rows() > 0){
			return 1;
		}else{
			return 0;
		}
	}

    public function getAllColorCategories()
    {
        $query = $this->db->query('SELECT id,category,type,details FROM attributes_categories WHERE attribute_type = "color" AND status = "1" AND delete_status = "0" ORDER BY position ASC , category ASC ');
        $response = $query->result_array();
        return $response;
    }
   public function getstate($id){
   	$this->db->where('id',$id);
   	$query=$this->db->get('states');
   	return $query->row_array();
   }
   public function getcountry($id){
   	$this->db->where('id',$id);
   	$query=$this->db->get('countries');
   	return $query->row_array();
   }
   public function getcity($id){
   	$this->db->where('id',$id);
   	$query=$this->db->get('cities');
   	return $query->row_array();
   }
   public function getvenderid($id){
   	//echo $id;die();
    $this->db->where('product_id',$id);
   	$query=$this->db->get('products');
   	return $query->row_array();
   }
   	public function getProductSolds($product_id) {
	   	$query = $this->db->select('SUM(quantity) AS quantity')
				   ->from('ordered_products')
				   ->where('product_id', $product_id)
				   ->get();
		if($result = $query->result_array()) {
			$solds = $result[0]['quantity'];			
			if($solds>=10000) {
				$solds = number_format($solds/10000, 2).'+';
			} else if($solds>=1000) {
				$solds = number_format($solds/1000, 2).'+';
			} else {
				$solds = number_format($solds);
			}
			return $solds;
		} else {
			return 0;
		}
   	}
}
