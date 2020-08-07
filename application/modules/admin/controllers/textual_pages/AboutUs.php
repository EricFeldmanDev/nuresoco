<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class AboutUs extends ADMIN_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('AboutUs_model');
        
    }

    
    public function aboutUsPage()
    {   
        $page='about-us';
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - About Us';
        $head['description'] = '!';
        $head['keywords'] = '';

        if($_POST){
           // print_r(base_url()."assets/uploads/product-images/"); exit;
          if($_FILES['image']['name']!=''){
              $config['upload_path']= UPLOAD_PHYSICAL_PATH."page_images/";
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
           $pageData=$this->AboutUs_model->aboutPageUpdate($data);
           if($pageData==1){
             $this->session->set_userdata('message','Update have succesfully');
           }      
        }

         
        $data['data']=$this->AboutUs_model->getMultiContent();
        $data['page'] = $this->AboutUs_model->getAboutData();
        $this->load->view('_parts/header', $head);
        $this->load->view('textual_pages/About-us/aboutUsPage', $data);
        $this->load->view('_parts/footer');
        
    }


    public function editAboutMultiContent($id) {
        $id=base64_decode($id);
        $page='about-us';
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - About Us';
        $head['description'] = '!';
        $head['keywords'] = '';  
        if($_POST){
          $data=$this->AboutUs_model->updateAboutContent($_POST);
          if($data==1){
            $this->session->set_userdata('upd_cont_msg','Update List have succesfully');
            redirect(WEB_ROOT."admin/aboutUsPage");  
          } 
        }
        $data['data']=$this->AboutUs_model->editAboutContent($id);
        $this->load->view('_parts/header', $head);
        $this->load->view('textual_pages/About-us/aboutContent', $data);
        $this->load->view('_parts/footer');
    }

    public function removeAboutContent($id) {   
      $del=$this->AboutUs_model->removeContent($id);
      if($del==1){
         $this->session->set_userdata('del_cont_msg','List have deleted succesfully');
        redirect(WEB_ROOT."admin/aboutUsPage");
      }
       redirect(WEB_ROOT."admin/aboutUsPage");
    }

    public function addAboutPage() {   
       $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - About Us';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data=$_POST;
        if($data){
           $addData=$this->AboutUs_model->addPage($data);
           if($addData==1){
             $this->session->set_userdata('message','List Have Added');
             redirect(WEB_ROOT."admin/aboutUsPage");
           }

     }

      $this->load->view('_parts/header', $head);
      $this->load->view('textual_pages/About-us/addAboutPage');
      $this->load->view('_parts/footer');   
          
    }


   
    
}
