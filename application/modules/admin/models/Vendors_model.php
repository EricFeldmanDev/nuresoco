<?php

class Vendors_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function deleteVendor($id)
    {
        $this->db->where('id', $id);
        if (!$this->db->delete('vendors')) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
    }

    public function vendorsCount($vendor_name = null, $category = null)
    {
        if ($vendor_name != null) {
            $vendor_name = trim($this->db->escape_like_str($vendor_name));
            $this->db->where("(name LIKE '%$vendor_name%' or email LIKE '%$vendor_name%')");
        }
		
        $this->db->where('delete_status', '0');
        return $this->db->count_all_results('vendors');
    }

    public function getVendors($limit, $page, $vendor_name = null, $orderby = null)
    {
        if ($vendor_name != null) {
            $vendor_name = trim($this->db->escape_like_str($vendor_name));
            $this->db->where("(vendors.name LIKE '%$vendor_name%' OR vendors.email LIKE '%$vendor_name%')");
        }
        if ($orderby !== null) {
            $ord = explode('=', $orderby);
            if (isset($ord[0]) && isset($ord[1])) {
                $this->db->order_by('vendors.' . $ord[0], $ord[1]);
            }
        } else {
            $this->db->order_by('vendors.name', 'asc');
        }
        $this->db->where('vendors.delete_status', '0');
        $query = $this->db->select('vendors.*,c.name as vendor_country,vendors.paypal_first_name, vendors.paypal_email,vendors.paypal_last_name,vendors.vender_payment_status,vendors.id, s.name as vendor_state, ct.name as vendor_city')->join('countries c','vendors.vendor_country=c.id','left')->join('states s','vendors.vendor_state=s.id','left')->join('cities ct','vendors.vendor_city=ct.id','left')->get('vendors', $limit, $page);
        return $query->result();
    }

    public function orderpayment($vid){
     // $this->db->where('user_id',$vid);
     // //$this->db->where('payment_status','SUCCESS');
     // $this->db->where('payment_status','succeeded');
     // $query=$this->db->get('orders');
     // //echo $this->db->last_query();die();
     // return $query->result_array();
       $sql="SELECT orders.* FROM `ordered_products` left join orders on ordered_products.order_id = orders.id where ordered_products.product_id in (select product_id from products where vendor_id='".$vid."') group by orders.id";
       $this->db->where('payment_status','SUCCESS');
        //   $this->db->query($sql);
        // echo $this->db->last_query();die();
          return $this->db->query($sql)->result();


    }
    public function changestatus($oid){
    $this->db->set('vender_payment_status','1'); //value that used to update column  
    $this->db->where('id', $oid); //which row want to upgrade  
    $this->db->update('orders');  //table name
    return $oid;
    }

    public function setVendor($post)
    {
        if ($post['edit'] > 0) {
            if (trim($post['password']) == '') {
                unset($post['password']);
            } else {
                $post['password'] = md5($post['password']);
            }
            $this->db->where('id', $post['edit']);
            unset($post['id'], $post['edit']);
            if (!$this->db->update('vendors', $post)) {
                log_message('error', print_r($this->db->error(), true));
                show_error(lang('database_error'));
            }
        } else {
            unset($post['edit']);
            $post['password'] = md5($post['password']);
            if (!$this->db->insert('vendors', $post)) {
                log_message('error', print_r($this->db->error(), true));
                show_error(lang('database_error'));
            }
        }
    }

}
