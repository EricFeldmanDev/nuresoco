<?php

class Reviewrating_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getProducts($limit, $page, $vendor_id)
    {
        $this->db->order_by('products.position', 'asc');
        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'left');
        $this->db->where('products_translations.abbr', MY_DEFAULT_LANGUAGE_ABBR);
        $this->db->where('vendor_id', $vendor_id);
        $query = $this->db->select('products.*, products_translations.title, products_translations.description, products_translations.price')->get('products', $limit, $page);
        return $query->result();
    }
}
