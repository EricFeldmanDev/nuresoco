<?php

class Products_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function deleteProduct($id)
    {
        $this->db->trans_begin();
        $this->db->where('for_id', $id);
        if (!$this->db->delete('products_translations')) {
            log_message('error', print_r($this->db->error(), true));
        }

        $this->db->where('id', $id);
        if (!$this->db->delete('products')) {
            log_message('error', print_r($this->db->error(), true));
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            show_error(lang('database_error'));
        } else {
            $this->db->trans_commit();
        }
    }

    public function productsCount($search_title = null, $category = null)
    {
        if ($search_title != null) {
            $search_title = trim($this->db->escape_like_str($search_title));
            $this->db->where("(products_translations.title LIKE '%$search_title%')");
        }
        if ($category != null) {
            $this->db->where('shop_categorie', $category);
        }
        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'left');
        $this->db->where('products_translations.abbr', MY_DEFAULT_LANGUAGE_ABBR);
        return $this->db->count_all_results('products');
    }

    public function acceptedProductsCount($product_name = null, $category_id = null)
    {
		$this->db->where('products.delete_status','0');
		$this->db->where('products.approval_status','APPROVED');
        if ($product_name != null) {
            $this->db->where("(products.product_name LIKE '%$product_name%')");
        }
        if ($category_id != null) {
            $this->db->where('products.category_id', $category_id);
        }
        return $this->db->count_all_results('products');
    }

    public function getAcceptedProducts($limit, $page, $product_name = null, $orderby = null, $category_id = null, $vendor_name = null)
    {
		$this->db->where('p.delete_status','0');
		$this->db->where('p.approval_status','APPROVED');
		//$this->db->where('sct.delete_status','0');
        if ($product_name != null) {
            $product_name = trim($this->db->escape_like_str($product_name));
            $this->db->where("p.product_name LIKE '%$product_name%'");
        }
        if ($orderby !== null) {
            $ord = explode('=', $orderby);
            if (isset($ord[0]) && isset($ord[1])) {
                $this->db->order_by('p.' . $ord[0], $ord[1]);
            }
        } else {
            $this->db->order_by('p.product_id', 'desc');
        }
        if ($category_id != null) {
            $this->db->where('p.category_id', $category_id);
        }
        if ($vendor_name != null) {
            $this->db->where("vendors.name LIKE '%$vendor_name%'");
        }
        $this->db->join('vendors', 'vendors.id = p.vendor_id', 'left');
        $this->db->join('shop_categories_translations sct', 'sct.id = p.category_id', 'left');
        $this->db->join('product_images as pi', 'pi.pi_id = p.main_image_id', 'left');
        $query = $this->db->select('vendors.name as vendor_name, vendors.id as vendor_id, pi.image, p.*, sct.name as category_name')->get('products p', $limit, $page);
         /* $query->result();
		 echo $this->db->last_query(); die; */
         return $query->result();
		
    }

    public function productRequestsCount($product_name = null, $category_id = null)
    {
		$this->db->where('products.delete_status','0');
		$this->db->where('products.approval_status','UNAPPROVED');
        if ($product_name != null) {
            $this->db->where("(products.product_name LIKE '%$product_name%')");
        }
        if ($category_id != null) {
            $this->db->where('products.category_id', $category_id);
        }
        return $this->db->count_all_results('products');
    }

    public function getRequestedProducts($limit, $page, $product_name = null, $orderby = null, $category_id = null, $vendor_name = null)
    {
		$this->db->where('p.delete_status','0');
		$this->db->where('p.approval_status','UNAPPROVED');
		//$this->db->where('sct.delete_status','0');
        if ($product_name != null) {
            $product_name = trim($this->db->escape_like_str($product_name));
            $this->db->where("p.product_name LIKE '%$product_name%'");
        }
        if ($orderby !== null) {
            $ord = explode('=', $orderby);
            if (isset($ord[0]) && isset($ord[1])) {
                $this->db->order_by('p.' . $ord[0], $ord[1]);
            }
        } else {
            $this->db->order_by('p.product_id', 'asc');
        }
        if ($category_id != null) {
            $this->db->where('p.category_id', $category_id);
        }
        if ($vendor_name != null) {
            $this->db->where("vendors.name LIKE '%$vendor_name%'");
        }
        $this->db->join('vendors', 'vendors.id = p.vendor_id', 'left');
        $this->db->join('shop_categories_translations sct', 'sct.id = p.category_id', 'left');
        $this->db->join('product_images as pi', 'pi.pi_id = p.main_image_id', 'left');
        $query = $this->db->select('vendors.name as vendor_name, vendors.id as vendor_id, pi.image, p.*, sct.name as category_name')->get('products p', $limit, $page);
         /* $query->result();
		 echo $this->db->last_query(); die; */
         return $query->result();
		
    }

    public function rejectedProductsCount($product_name = null, $category_id = null)
    {
		$this->db->where('products.delete_status','0');
		$this->db->where('products.approval_status','REJECTED');
        if ($product_name != null) {
            $this->db->where("(products.product_name LIKE '%$product_name%')");
        }
        if ($category_id != null) {
            $this->db->where('products.category_id', $category_id);
        }
        return $this->db->count_all_results('products');
    }

    public function getRejectedProducts($limit, $page, $product_name = null, $orderby = null, $category_id = null, $vendor_name = null)
    {
		$this->db->where('p.delete_status','0');
		$this->db->where('p.approval_status','REJECTED');
		//$this->db->where('sct.delete_status','0');
        if ($product_name != null) {
            $product_name = trim($this->db->escape_like_str($product_name));
            $this->db->where("p.product_name LIKE '%$product_name%'");
        }
        if ($orderby !== null) {
            $ord = explode('=', $orderby);
            if (isset($ord[0]) && isset($ord[1])) {
                $this->db->order_by('p.' . $ord[0], $ord[1]);
            }
        } else {
            $this->db->order_by('p.product_id', 'asc');
        }
        if ($category_id != null) {
            $this->db->where('p.category_id', $category_id);
        }
        if ($vendor_name != null) {
            $this->db->where("vendors.name LIKE '%$vendor_name%'");
        }
        $this->db->join('vendors', 'vendors.id = p.vendor_id', 'left');
        $this->db->join('shop_categories_translations sct', 'sct.id = p.category_id', 'left');
        $this->db->join('product_images as pi', 'pi.pi_id = p.main_image_id', 'left');
        $query = $this->db->select('vendors.name as vendor_name, vendors.id as vendor_id, pi.image, p.*, sct.name as category_name')->get('products p', $limit, $page);
         /* $query->result();
		 echo $this->db->last_query(); die; */
         return $query->result();	
    }

    public function numShopProducts()
    {
        return $this->db->count_all_results('products');
    }

    public function updateLabel($id, $content) {
        $data = array('filter_label'=>$content);
        $this->db->where('product_id', $id);
        $this->db->update('products', $data);
    }

    public function getOneProduct($id)
    {
        $this->db->select('vendors.name as vendor_name, vendors.id as vendor_id, products.*');
        $this->db->where('products.id', $id);
        $this->db->join('vendors', 'vendors.id = products.vendor_id', 'left');
        $query = $this->db->get('products');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function productStatusChange($id, $to_status)
    {
        $this->db->where('id', $id);
        $result = $this->db->update('products', array('visibility' => $to_status));
        return $result;
    }

    public function setProduct($post, $id = 0)
    {
        if (!isset($post['brand_id'])) {
            $post['brand_id'] = null;
        }
        if (!isset($post['virtual_products'])) {
            $post['virtual_products'] = null;
        }
        $this->db->trans_begin();
        $is_update = false;
        if ($id > 0) {
            $is_update = true;
            if (!$this->db->where('id', $id)->update('products', array(
                        'image' => $post['image'] != null ? $_POST['image'] : $_POST['old_image'],
                        'shop_categorie' => $post['shop_categorie'],
                        'quantity' => $post['quantity'],
                        'in_slider' => $post['in_slider'],
                        'position' => $post['position'],
                        'virtual_products' => $post['virtual_products'],
                        'brand_id' => $post['brand_id'],
                        'time_update' => time()
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }
        } else {
            /*
             * Lets get what is default tranlsation number
             * in titles and convert it to url
             * We want our plaform public ulrs to be in default 
             * language that we use
             */
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
                        //'in_slider' => $post['in_slider'],
                        'position' => $post['position'],
                        'virtual_products' => $post['virtual_products'],
                        'folder' => $post['folder'],
                        'brand_id' => $post['brand_id'],
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
        } else {
            $this->db->trans_commit();
        }
    }

    private function setProductTranslation($post, $id, $is_update)
    {
        $i = 0;
        $current_trans = $this->getTranslations($id);
        foreach ($post['translations'] as $abbr) {
            $arr = array();
            $emergency_insert = false;
            if (!isset($current_trans[$abbr])) {
                $emergency_insert = true;
            }
            $post['title'][$i] = str_replace('"', "'", $post['title'][$i]);
            $post['price'][$i] = str_replace(' ', '', $post['price'][$i]);
            $post['price'][$i] = str_replace(',', '.', $post['price'][$i]);
            $post['price'][$i] = preg_replace("/[^0-9,.]/", "", $post['price'][$i]);
            $post['old_price'][$i] = str_replace(' ', '', $post['old_price'][$i]);
            $post['old_price'][$i] = str_replace(',', '.', $post['old_price'][$i]);
            $post['old_price'][$i] = preg_replace("/[^0-9,.]/", "", $post['old_price'][$i]);
            $arr = array(
                'title' => $post['title'][$i],
                'basic_description' => $post['basic_description'][$i],
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
            $arr[$row->abbr]['basic_description'] = $row->basic_description;
            $arr[$row->abbr]['description'] = $row->description;
            $arr[$row->abbr]['price'] = $row->price;
            $arr[$row->abbr]['old_price'] = $row->old_price;
        }
        return $arr;
    }
	
	 public function getProductReview($id)
    {
		$this->db->where('product_id', $id);
		$this->db->order_by("pr_id", "desc");
        $query = $this->db->get('product_reviews');
        return $query->result_array();
    }
	
	 public function updateStatus($id,$statusUpdate)
    {
        $this->db->where('pr_id', $id);
		$this->db->set('status', $statusUpdate);
        $this->db->update('product_reviews');
    }
	 public function deleteReview($id)
    {
        $this->db->where('pr_id', $id);
        $this->db->delete('product_reviews');
		 //echo $this->db->last_query(); exit;
    }
	 public function insertReview($data)
    {
        $this->db->insert('product_reviews', $data);
		$id = $this->db->insert_id();
		//echo $this->db->last_query(); exit;
		return (isset($id)) ? $id : FALSE;
    }
	
	

}
