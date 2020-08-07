<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class ReviewRating extends VENDOR_Controller
{

	private $filterVendorReviewLimit;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Reviewrating_model');
		$this->filterVendorReviewLimit = 15;
    }

    public function index()
    {
        $data = array();
        $head = array();
        $head['title'] = lang('vendor_dashboard');
        $head['description'] = lang('vendor_home_page');
        $head['keywords'] = '';
		$vendor_id = $this->vendor_id;
		$vendorReviewLimit = $this->filterVendorReviewLimit;
		$data['vendorReviewLimit'] = $vendorReviewLimit;
		$data['offset'] = 0;
		$data["vendorReviewsCount"] = $this->Public_model->getVendorReviewsCount($vendor_id);
		$data["vendorAvgReviews"] = $this->Public_model->getVendorReviewsAvg($vendor_id);
		$data['vendor_reviews'] = $this->Public_model->getVendorReviews($vendor_id,$vendorReviewLimit,0);
		
        //$data['ordersByMonth'] = $this->Vendorprofile_model->getOrdersByMonth($this->vendor_id);
        $this->load->view('_parts/header', $head);
        $this->load->view('review_rating', $data);
	    $this->load->view('_parts/modals');
        $this->load->view('_parts/footer');
    }
}
