<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class sliders extends ADMIN_Controller
{

    private $num_rows = 20;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Sliders_model', 'Languages_model'));
    }

    public function index($pagename = 'featured', $page = 0)
    {
        $this->login_check();
		
		if(!($pagename=='featured' || $pagename=='express' || $pagename=='gadget' || $pagename=='fashion'))
		{
			redirect('admin/sliders/featured');
		}
		
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Sliders';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['sliders'] = $this->Sliders_model->getsliders($pagename);
		$data['languages'] = $this->Languages_model->getLanguages();
		
		$this->load->library('user_agent');
		$referrer = $this->agent->referrer();
		
		if (isset($_GET['delete'])) {
            $this->saveHistory('Delete a slider');
            $this->Sliders_model->deleteSlider($_GET['delete']);
            $this->session->set_flashdata('result_delete', 'Slider is deleted!');
            redirect($referrer);
        }
		
        if (isset($_POST['submit'])) {
            $this->Sliders_model->setSlider($this->input->post(),$referrer);
            $this->session->set_flashdata('result_add', 'Slider is added!');
            redirect($referrer);
        }
		
        $this->load->view('_parts/header', $head);
        $this->load->view('sliders/sliders', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to slider');
    }

    /*
     * Called from ajax
     */

    public function changeSliderImage()
	{
		$post = $this->input->post();
		$response = array();
		$response['error'] = 'yes';
		$response['msg'] = "You can't hit this url directly";
		if($post)
		{
			$response = $this->Sliders_model->changeSliderImage($post);
		}
		echo json_encode($response,true);
	}
	
    public function updateSliderText()
    {
        $this->login_check();
		$result = $this->Sliders_model->updateSliderText($_POST);
        $this->saveHistory('Edit slider text to ' . $_POST['slider_text']);
    }

    /*
     * Called from ajax
     */

    public function updateSliderPosition()
    {
        $this->login_check();
        $result = $this->Sliders_model->updateSliderPosition($_POST);
        $this->saveHistory('Edit shop categorie position ' . $_POST['name']);
    }

}
