<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Attributes extends ADMIN_Controller
{

    private $num_rows = 20;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Attribute_Categories_model', 'Languages_model'));
    }

    public function index($page = 0)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Attribute Categories';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['atribute_categories'] = $this->Attribute_Categories_model->getAttributeCategories($this->num_rows, $page);
        $data['languages'] = $this->Languages_model->getLanguages();
        $rowscount = $this->Attribute_Categories_model->categoriesCount();
        $data['links_pagination'] = pagination('admin/attributes', $rowscount, $this->num_rows, 3);
		
        if (isset($_GET['delete'])) {
            $this->saveHistory('Delete a attribute category');
            $this->Attribute_Categories_model->deleteAttributeCategory($_GET['delete']);
            $this->session->set_flashdata('result_delete', 'Attribute category is deleted!');
            redirect('admin/attributes');
        }
        if (isset($_POST['submit'])) {
            $this->Attribute_Categories_model->setAttributeCategory($_POST);
            $this->session->set_flashdata('result_add', 'Attribute category is added!');
            redirect('admin/attributes');
        }
		
        $this->load->view('_parts/header', $head);
        $this->load->view('attributes/attributesCategories', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to attribute categories');
    }

    public function colors($page = 0)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Colors';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['atribute_categories'] = $this->Attribute_Categories_model->getColors($this->num_rows, $page);
        $data['languages'] = $this->Languages_model->getLanguages();
        $rowscount = $this->Attribute_Categories_model->categoriesColorCount();
        $data['links_pagination'] = pagination('admin/colors', $rowscount, $this->num_rows, 3);
		
        if (isset($_GET['delete'])) {
            $this->saveHistory('Delete a attribute category');
            $this->Attribute_Categories_model->deleteAttributeCategory($_GET['delete']);
            $this->session->set_flashdata('result_delete', 'Color deleted!');
            redirect('admin/colors');
        }
        if (isset($_POST['submit'])) {
            $this->Attribute_Categories_model->setColor($_POST);
            $this->session->set_flashdata('result_add', 'Color added!');
            redirect('admin/colors');
        }
		
        $this->load->view('_parts/header', $head);
        $this->load->view('attributes/colors', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to attribute categories');
    }

    public function attributeSubCategories()
    {	
		$encoded_category_id = $this->uri->segment(3);
		$page = $this->uri->segment(4);
		if($page=='')
		{
			$page = 0;
		}
		$category_id = base64_decode($encoded_category_id);
		$this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Attribute Sub-Categories';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['atribute_sub_categories'] = $this->Attribute_Categories_model->getAttributeSubCategories($this->num_rows, $page, $category_id);
        $data['languages'] = $this->Languages_model->getLanguages();
        $rowscount = $this->Attribute_Categories_model->subCategoriesCount($category_id);
        $data['links_pagination'] = pagination('admin/attributeSubCategories/'.$encoded_category_id, $rowscount, $this->num_rows, 4);
		
        if (isset($_GET['delete'])) {
            $this->saveHistory('Delete a attribute sub-category');
            $this->Attribute_Categories_model->deleteAttributeSubCategory($_GET['delete']);
            $this->session->set_flashdata('result_delete', 'Attribute category is deleted!');
            redirect('admin/attributeSubCategories/'.$encoded_category_id);
        }
        if (isset($_POST['submit'])) {
            $this->Attribute_Categories_model->setAttributeSubCategory($_POST);
            $this->session->set_flashdata('result_add', 'Attribute Sub-category is added!');
            redirect('admin/attributeSubCategories/'.$encoded_category_id);
        }
		
        $this->load->view('_parts/header', $head);
        $this->load->view('attributes/attributesSubCategories', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to attribute categories');
    }

    /*
     * Called from ajax
     */

    public function changeCategoryImage()
	{
		$post = $this->input->post();
		$response = array();
		$response['error'] = 'yes';
		$response['msg'] = "You can't hit this url directly";
		if($post)
		{
			$response = $this->Attribute_Categories_model->updateCategoryImage($post);
		}
		echo json_encode($response,true);
	}
	
    public function editAttrCategory()
    {
        $this->login_check();
        $result = $this->Attribute_Categories_model->editAttrCategory($_POST);
        $this->saveHistory('Edit attribute category to ' . $_POST['name']);
    }
	
    public function editAttrSubCategory()
    {
        $this->login_check();
        $result = $this->Attribute_Categories_model->editAttrSubCategory($_POST);
        $this->saveHistory('Edit attribute sub-category to ' . $_POST['name']);
    }

    /*
     * Called from ajax
     */

    public function changeAttrPosition()
    {
        $this->login_check();
        $result = $this->Attribute_Categories_model->editAttrCategoriePosition($_POST);
        $this->saveHistory('Edit attribute category position ' . $_POST['new_pos']);
    }

    public function changeAttrColor()
    {
        $this->login_check();
        $result = $this->Attribute_Categories_model->editAttrCategorieColor($_POST);
        $this->saveHistory('Edit attribute color ' . $_POST['new_color']);
    }

}
