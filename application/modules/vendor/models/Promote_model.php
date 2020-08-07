<?php

class Promote_model extends CI_Model
{

    public function __construct() {
        parent::__construct();
    }


    
    public function getProducts($v_id){
        
        $this->db->select('products.product_id,products.vendor_id, products.product_name,products.main_image_id as image_id,products.price , product_images.image');
        $this->db->join('product_images','product_images.pi_id = products.main_image_id','left');
        $this->db->where('products.status', '1');
        $this->db->where('product_images.type', 'MAIN');
        $this->db->where('products.vendor_id',$v_id);
        $query = $this->db->get('products');
        if ($query->num_rows() > 0)  {
            foreach ($query->result_array() as $row){
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
     
    public function submitForm($post,$v_id){
       $data=array('product_id'=>$post['p_id'],'vendor_id'=>$v_id,'where_to_send'=>'','budget'=>$post['budget'],'duration'=>$post['duration'],'paid_amount'=>'','payment_status'=>'PENDING','pause_spending'=>'0','status'=>'1','delete_status'=>'0', 'created_on'=>date('Y-m-d H:i:s'),'modify_data'=>date('Y-m-d H:i:s'));

       $qry=$this->db->insert('product_pramotions',$data);
       if($qry==1) return 1; else return 0;      
    } 
    
    

    

}
