<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Blog extends ADMIN_Controller
{

    private $num_rows = 2;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Blog_model');
        $this->load->library('Pagination');
    }

    /*public function index($page = 0)
    {
        $this->login_check();
        if (isset($_GET['delete'])) {
            $this->Blog_model->deletePost($_GET['delete']);
            redirect('admin/blog');
        }
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Blog Posts';
        $head['description'] = '!';
        $head['keywords'] = '';


        if ($this->input->get('search') !== NULL) {
            $search = $this->input->get('search');
        } else {
            $search = null;
        }
        $data = array();
        $rowscount = $this->Blog_model->postsCount($search);
        $data['posts'] = $this->Blog_model->getPosts(null, $this->num_rows, $page, $search);
        $data['links_pagination'] = pagination('admin/blog', $rowscount, $this->num_rows, 3);
        $data['page'] = $page;

        $this->load->view('_parts/header', $head);
        $this->load->view('blog/blogposts', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to Blog');
    }*/

    public function getListing() {   
       $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Blog';
        $head['description'] = '!';
        $head['keywords'] = '';

        $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $total_records = $this->Blog_model->get_total();
 
        if ($total_records > 0){
            // get current page records
            $data["data"] = $this->Blog_model->getBlogs($this->num_rows, $start_index);
            $data['links'] = pagination('admin/blog', $total_records, $this->num_rows, 3);
        }

        //$data['data']=$this->Blog_model->getBlogs();
        $this->load->view('_parts/header', $head);
        $this->load->view('blog/blogList',$data);
        $this->load->view('_parts/footer');     
    }

    public function addBlog() {   
       $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - About Us';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data=$_POST;
          
        if($data){
           // print_r(base_url()."assets/uploads/product-images/"); exit;
          if($_FILES['image']['name']!=''){
              $config['upload_path']= UPLOAD_PHYSICAL_PATH."blog-images/";
              $config['allowed_types']='gif|jpg|png';
              $config['encrypt_name'] = TRUE;
              $this->load->library('upload', $config);
              $this->upload->initialize($config);

              if($this->upload->do_upload("image")){
                 $upload_data=$this->upload->data();
                 $image_name['image']=$upload_data['file_name'];
                 $data=array_merge($_POST,$image_name); 
              }
              else {
                $error = array('error' => $this->upload->display_errors());
                echo "<script> alert('<?=$error[error]?>');</script>";
                $data=$_POST;              
               }
           }
           else {
              $data=$_POST;
           }
           $blogData=$this->Blog_model->addblog($data);
           if($blogData==1){
             $this->session->set_userdata('message','Data Added have succesfully');
             redirect(WEB_ROOT."admin/blog");
           }      
        }  
      $this->load->view('_parts/header', $head);
      $this->load->view('blog/blogposts');
      $this->load->view('_parts/footer');   
          
    }

    public function removeblog($id) {   
      $del=$this->Blog_model->removeBlog($id);
      if($del==1){
         $this->session->set_userdata('del_msg','Post have deleted succesfully');
        redirect(WEB_ROOT."admin/blog");
      }
       redirect(WEB_ROOT."admin/blog");
    }



    public function updateBlog($id) {   
        $id=base64_decode($id);
        $page='about-us';
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - About Us';
        $head['description'] = '!';
        $head['keywords'] = '';
        $post=$_POST;

         if($_POST){
            //echo UPLOAD_PHYSICAL_PATH."blog_images/"; exit;
           // print_r(base_url()."assets/uploads/product-images/"); exit;
          if($_FILES['image']['name']!=''){
              $config['upload_path']= UPLOAD_PHYSICAL_PATH."blog-images/";
              $config['allowed_types']='gif|jpg|png';
              $config['encrypt_name'] = TRUE;
              $this->load->library('upload', $config);
              $this->upload->initialize($config);

              if($this->upload->do_upload("image")){
                 $upload_data=$this->upload->data();
                 $image_name['image']=$upload_data['file_name'];
                 $data=array_merge($_POST,$image_name); 
              }
              else {
                $error = array('error' => $this->upload->display_errors());
                echo "<script> alert('<?=$error[error]?>');</script>";
                $data=$_POST;              
               }
           }
           else {
              $data=$_POST;
           }
           $pageData=$this->Blog_model->updateBlog($data);
           if($pageData==1){
             $this->session->set_userdata('message','Update have succesfully');
           }      
        }
         
        $data['data']=$this->Blog_model->getDataById($id);
        $this->load->view('_parts/header', $head);
        $this->load->view('blog/updateBlog', $data);
        $this->load->view('_parts/footer');
     }   
     

}
