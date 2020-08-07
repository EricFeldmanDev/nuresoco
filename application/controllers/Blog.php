<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends MY_Controller
{

    private $num_rows = 2;

    public function __construct()
    {
        parent::__construct();
        if (!in_array('blog', $this->nonDynPages)) {
            show_404();
        }
        $this->load->Library('Pagination');
        $this->load->Model('admin/Blog_model');
        $this->arhives = $this->Public_model->getArchives();
    }

    /*public function index($page = 0) {
        $data = array();
        $head = array();
        $arrSeo = $this->Public_model->getSeo('blog');
        $head['title'] = @$arrSeo['title'];
        $head['description'] = @$arrSeo['description'];
        $head['keywords'] = str_replace(" ", ",", $head['title']);
        if (isset($_GET['find'])) {
            $find = $_GET['find'];
        } else {
            $find = null;
        }
        if (isset($_GET['from']) && isset($_GET['to'])) {
            $month = $_GET;
        } else {
            $month = null;
        }
        /* $data['posts'] = $this->Public_model->getPosts($this->num_rows, $page, $find, $month);
        $data['archives'] = $this->getBlogArchiveHtml();
        $data['bestSellers'] = $this->Public_model->getbestSellers(); 
        $rowscount = $this->Blog_model->postsCount($find);
        $data['links_pagination'] = pagination('blog', $rowscount, $this->num_rows);
        $this->render('blog', $head, $data);
    }*/


    public function index(){
        $data = array();
        $head = array();
        $arrSeo = $this->Public_model->getSeo('blog');
        $head['title'] = @$arrSeo['title'];
        $head['description'] = @$arrSeo['description'];
        $head['keywords'] = str_replace(" ", ",", $head['title']);
        
        $start_index = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $total_records = $this->Public_model->get_total(); 
        if ($total_records > 0){
            $data["data"] = $this->Public_model->getBlog($this->num_rows, $start_index);
            $data['links'] = pagination('blog', $total_records, $this->num_rows, 2);
        }
        $data['popular_post']=$this->Public_model->getPopularPosts();
        $data['recent_post']=$this->Public_model->getRecentPosts();
         
        //$data['data']=$this->Public_model->getBlog();   
        $this->render('blog', $head, $data);
    }



    public function viewPost($id)
    {
        if (!is_numeric($id) || $id <= 0) {
            show_404();
        }
        $data = array();
        $head = array();
        $data['article'] = $this->Public_model->getOnePost($id);
        if ($data['article'] == null) {
            show_404();
        }
        $data['archives'] = $this->getBlogArchiveHtml();
        $head['title'] = $data['article']['title'];
        $head['description'] = url_title(character_limiter(strip_tags($data['article']['description']), 130));
        $head['keywords'] = str_replace(" ", ",", $data['article']['title']);
        $this->render('view_blog_post', $head, $data);
    }

    public function blogDetail($id){
        $id=$this->uri->segment(2);  
        $data = array();
        $head = array();
        $arrSeo = $this->Public_model->getSeo('blog');
        $head['title'] = @$arrSeo['title'];
        $head['description'] = @$arrSeo['description'];
        $head['keywords'] = str_replace(" ", ",", $head['title']);
        $data['data']=$this->Public_model->getBlogById($id);
        $data['popular_post']=$this->Public_model->getPopularPosts();
        $data['recent_post']=$this->Public_model->getRecentPosts();
        
        $this->render('blog-detail', $head, $data);
    }

    private function getBlogArchiveHtml()
    {
        $html = '
		<div class="alone title cloth-bg-color">
					<span>' . lang('archive') . '</span>
				</div>
				';
        if ($this->arhives !== false) {

            $html .= '<ul class="blog-artchive">';

            foreach ($this->arhives as $archive) {
                $html .= '
					<li class="item">» <a href="' . LANG_URL . '/blog?from='
                        . $archive['mintime'] . '&to=' . $archive['maxtime'] . '">'
                        . $archive['month'] . '</a></li>
				';
            }
            $html .= '</ul>';
        } else {
            $html = '<div class="alert alert-info">' . lang('no_archives') . '</div>';
        }
        return $html;
    }








}
