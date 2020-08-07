<?php

class Orders_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function ordersCount($onlyNew = false)
    {
        if ($onlyNew == true) {
            $this->db->where('status', '1');
            $this->db->where('delete_status', '0');
        }
        return $this->db->count_all_results('orders');
    }

    public function orders($limit, $page, $order_by)
    {
        if ($order_by != null) {
            $this->db->order_by($order_by, 'DESC');
        } else {
            $this->db->order_by('id', 'DESC');
        }
        $this->db->select('orders.*, orders_clients.first_name,'
                . ' orders_clients.last_name, orders_clients.email, orders_clients.phone, '
                . 'orders_clients.address, orders_clients.city, orders_clients.post_code,'
                . ' orders_clients.notes, discount_codes.type as discount_type, discount_codes.amount as discount_amount');
        $this->db->join('orders_clients', 'orders_clients.for_id = orders.id', 'inner');
        $this->db->join('discount_codes', 'discount_codes.code = orders.discount_code', 'left');
        $result = $this->db->get('orders', $limit, $page);
        return $result->result_array();
    }

    public function changeOrderStatus($id, $to_status)
    {
        $this->db->where('id', $id);
        $this->db->select('processed');
        $result1 = $this->db->get('orders');
        $res = $result1->row_array();

        if ($res['processed'] != $to_status) {
            $this->db->where('id', $id);
            $result = $this->db->update('orders', array('processed' => $to_status, 'viewed' => '1'));
            if ($result == true) {
                $this->manageQuantitiesAndProcurement($id, $to_status, $res['processed']);
            }
        } else {
            $result = false;
        }
        return $result;
    }

    private function manageQuantitiesAndProcurement($id, $to_status, $current)
    {
        if (($to_status == 0 || $to_status == 2) && $current == 1) {
            $operator = '+';
            $operator_pro = '-';
        }
        if ($to_status == 1) {
            $operator = '-';
            $operator_pro = '+';
        }
        $this->db->select('products');
        $this->db->where('id', $id);
        $result = $this->db->get('orders');
        $arr = $result->row_array();
        $products = unserialize($arr['products']);
        foreach ($products as $product_id => $quantity) {
            if (isset($operator)) {
                if (!$this->db->query('UPDATE products SET quantity=quantity' . $operator . $quantity . ' WHERE id = ' . $product_id)) {
                    log_message('error', print_r($this->db->error(), true));
                    show_error(lang('database_error'));
                }
            }
            if (isset($operator_pro)) {
                if (!$this->db->query('UPDATE products SET procurement=procurement' . $operator_pro . $quantity . ' WHERE id = ' . $product_id)) {
                    log_message('error', print_r($this->db->error(), true));
                    show_error(lang('database_error'));
                }
            }
        }
    }

    public function setBankAccountSettings($post)
    {
        $query = $this->db->query('SELECT id FROM bank_accounts');
        if ($query->num_rows() == 0) {
            $id = 1;
        } else {
            $result = $query->row_array();
            $id = $result['id'];
        }
        $post['id'] = $id;
        if (!$this->db->replace('bank_accounts', $post)) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
    }

    public function getBankAccountSettings()
    {
        $result = $this->db->query("SELECT * FROM bank_accounts LIMIT 1");
        return $result->row_array();
    }
    public function orderlist(){
        $this->db->select('orders.shipping_status,ordered_products.shipping_amount,orders.order_code,orders.id,orders.shipping_charges,orders.final_amount,orders. user_id,orders.mobile_no,orders.country_id,orders.state_id,orders.transation_id,orders.payment_type,orders.status,orders.created_on,ordered_products.product_image,ordered_products.price,ordered_products.product_name,ordered_products.product_size,ordered_products.product_color,ordered_products.quantity,ordered_products.product_shipping_status');
        $this->db->from('orders');
        $this->db->join('ordered_products', 'ordered_products.order_id = orders.id', 'left');        
        $query=$this->db->get();
        return $query->result_array();
    }
    public function orderCount()
    {
        return $this->db->count_all_results('orders');
    }


   public function editdetails($id)
   {
    $this->db->select('orders.order_code,orders.id,orders.shipping_charges,orders.final_amount,orders. user_id,orders.mobile_no,orders.country_id,orders.state_id,orders.transation_id,orders.payment_type,orders.status,orders.created_on,ordered_products.product_image,ordered_products.product_name,ordered_products.product_size,ordered_products.product_color,ordered_products.quantity');
        $this->db->from('orders');
        $this->db->join('ordered_products', 'ordered_products.order_id = orders.id', 'INNER');
        $this->db->where('orders.id',$id);
         $query=$this->db->get();
         //echo $this->db->last_query();
        return $query->row_array();
   }
   public function detailsedit($param,$id){
    $data=array(
               'product_name'=>$_POST['product_name'],
               'product_size'=>$_POST['product_size'],
               'product_color'=>$_POST['product_color'],
                );
    //print_r($data);die();
    $this->db->where('order_id',$id);
    $this->db->update('ordered_products', $data);  
    //echo $this->db->last_query();die(); 
    return $id;
   }
   public function order($param,$id){
    $data=array(
               'mobile_no'=>$_POST['mobile_no'],
               'payment_type'=>$_POST['payment_type'],
               'final_amount'=>$_POST['final_amount'],
                );
    $this->db->where('id',$id);
    $this->db->update('orders',$data);    
    return $id;

   }
   public function detele($id){
        $this->db-> where('id', $id);
     $query=$this->db->delete('orders');
     if($query){
        $this->db-> where('order_id', $id);
        $this->db->delete('ordered_products');
     }
    return $id;
   }


}
