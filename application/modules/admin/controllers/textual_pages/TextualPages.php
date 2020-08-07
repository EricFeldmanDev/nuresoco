<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class TextualPages extends ADMIN_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Textual_pages_model');
    }

    public function pageEdit($page = null)
    {
        $this->login_check();
        if ($page == null) {
            redirect('admin/pages');
        }
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Pages Manage';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['page'] = $this->Textual_pages_model->getOnePageForEdit($page);
        if (empty($data['page'])) {
            redirect('admin/pages');
        }
        if (isset($_POST['updatePage'])) {
            $this->Textual_pages_model->setEditPageTranslations($_POST);
            $this->saveHistory('Page ' . $_POST['pageId'] . ' updated!');
            redirect('admin/pageedit/' . $page);
        }

        $this->load->view('_parts/header', $head);
        $this->load->view('textual_pages/pageEdit', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Edit page - ' . $page);
    }

    /*public function aboutUsPage()
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
           $pageData=$this->Textual_pages_model->setEditCMSPageTranslations($data);
           if($pageData==1){
             $this->session->set_userdata('message','Update have succesfully');
           }      
        }

         

        $data['page'] = $this->Textual_pages_model->getCMSPageForEdit();
        $this->load->view('_parts/header', $head);
        $this->load->view('textual_pages/aboutUsPage', $data);
        $this->load->view('_parts/footer');
        
    }*/

    public function changePageStatus()
    {
        $this->login_check();
        $result = $this->Textual_pages_model->changePageStatus($_POST['id'], $_POST['status']);
        if ($result == true) {
            echo 1;
        } else {
            echo 0;
        }
        $this->saveHistory('Page status Changed');
    }

}
