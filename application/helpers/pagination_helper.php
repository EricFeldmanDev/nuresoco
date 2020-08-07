<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

function pagination($url, $rowscount, $per_page, $segment = 2)
{
    $ci = & get_instance();
    $ci->load->library('pagination');

    $config = array();
    $config["base_url"] = LANG_URL . '/' . $url;
    $config["total_rows"] = $rowscount;
    $config["per_page"] = $per_page;
    $config["uri_segment"] = $segment;
    $config['full_tag_open'] = '<nav><ul class="pagination">';
    $config['full_tag_close'] = '</ul></nav>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li><a class="active">';
    $config['cur_tag_close'] = '</a></li>';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    $config['first_link'] = lang('first');
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    $config['last_link'] = lang('last');
    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';
    $config['next_link'] = lang('next');
    $config['prev_link'] = lang('previous');
    $config['reuse_query_string'] = TRUE;
    $ci->pagination->initialize($config);
	//pr($config,1);
    return $ci->pagination->create_links();
}


if (!function_exists('pr')) {
    function pr($data = null, $exit = false, $str = "") {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        if ($exit === TRUE || $exit == 1) {
            die();
		}        
		
		if ($str != "") {
            echo($str);
		}
		
    }
}
