<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

if (!function_exists('ip_info')) {

	function ip_info($ip = NULL, $purpose = "countrycode", $deep_detect = TRUE) 
	{
		$output = NULL;
		if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
			$ip = $_SERVER["REMOTE_ADDR"];
			if ($deep_detect) {
				if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
					$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
				if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
					$ip = $_SERVER['HTTP_CLIENT_IP'];
			}
		}
		$purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
		$support    = array("country", "countrycode", "state", "region", "city", "location", "address");
		$continents = array(
			"AF" => "Africa",
			"AN" => "Antarctica",
			"AS" => "Asia",
			"EU" => "Europe",
			"OC" => "Australia (Oceania)",
			"NA" => "North America",
			"SA" => "South America",
			"IN" => "India"
		);
		if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
			$ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
			
			if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
				switch ($purpose) {
					case "location":
						$output = array(
							"city"           => @$ipdat->geoplugin_city,
							"state"          => @$ipdat->geoplugin_regionName,
							"country"        => @$ipdat->geoplugin_countryName,
							"country_code"   => @$ipdat->geoplugin_countryCode,
							"continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
							"continent_code" => @$ipdat->geoplugin_continentCode
						);
						break;
					case "address":
						$address = array($ipdat->geoplugin_countryName);
						if (@strlen($ipdat->geoplugin_regionName) >= 1)
							$address[] = $ipdat->geoplugin_regionName;
						if (@strlen($ipdat->geoplugin_city) >= 1)
							$address[] = $ipdat->geoplugin_city;
						$output = implode(", ", array_reverse($address));
						break;
					case "city":
						$output = @$ipdat->geoplugin_city;
						break;
					case "state":
						$output = @$ipdat->geoplugin_regionName;
						break;
					case "region":
						$output = @$ipdat->geoplugin_regionName;
						break;
					case "country":
						$output = @$ipdat->geoplugin_countryName;
						break;
					case "countrycode":
						$output = @$ipdat->geoplugin_countryCode;
						break;
				}
			}
		}
		$output = 'IN';
		return $output;
	}

}

if (!function_exists('shopcategories')) {
    

    function shopcategories($limit = null, $start = null)
    {
        $limit_sql = '';
        if ($limit !== null && $start !== null) {
            $limit_sql = ' LIMIT ' . $start . ',' . $limit;
        }
		
		$ci = & get_instance();

        $query = $ci->db->query('SELECT translations_first.*,shop_categories.sub_for FROM shop_categories_translations as translations_first LEFT JOIN shop_categories ON shop_categories.sub_for = translations_first.id ORDER BY translations_first.name ASC, position ASC ' . $limit_sql);
        $arr = array();
		//pr($query->result(),1);
        foreach ($query->result() as $shop_categorie) {
		//var_dump($shop_categorie->sub_for);
			if($shop_categorie->sub_for===NULL)
			{
				$arr[] = array(
					'id' => $shop_categorie->id,
					'abbr' => $shop_categorie->abbr,
					'name' => $shop_categorie->name
				);
			}
        }
        return $arr;
    }
}

if (!function_exists('formate_date')) {
    

    function formate_date($date)
    {
		$date = date('d ',strtotime($date)).substr(date('F',strtotime($date)),0,3).date(', Y',strtotime($date));
		return $date;
    }
}

if (!function_exists('escape_product_name')) {
    

    function escape_product_name($product_name)
    {
		$product_name = str_replace('{','',(str_replace('}','',(str_replace('[','',(str_replace(']','',(str_replace('+','',(str_replace('(','',(str_replace(')','',(str_replace('#','',(str_replace('*','',(str_replace('&','',(str_replace('!','',(str_replace('%','',(str_replace('"','',(str_replace("'",'',(str_replace('/','-',(str_replace(' ','-',$product_name)))))))))))))))))))))))))))))));
		return $product_name;
    }
}

if (!function_exists('save_notification')) {
    

    function save_notification($from_id,$to_id,$from_notification,$to_notification,$type,$link,$refer_id='')
    {
		$insertArr = array();
		$insertArr['from_id'] = $from_id;
		$insertArr['to_id'] = $to_id;
		$insertArr['from_notification'] = $from_notification;
		$insertArr['to_notification'] = $to_notification;
		switch ($type)
		{
			case "VENDOR_REVIEW_ADDED":
			
				$message = 'You got a rating.';
				break;
			case "PRODUCT_REVIEW_ADDED":
				$message = 'You got a rating on product.';
				break;
		}
		
		$insertArr['message'] = $message;
		$insertArr['link'] = $link;
		$insertArr['refer_id'] = $refer_id;
		$insertArr['created_on'] = date('Y-m-d H:i:s');
		$insertArr['modify_on'] = date('Y-m-d H:i:s');
		$ci = & get_instance();
		if($ci->db->insert('notifications',$insertArr))
		{
			return true;
		}else{
			return 'An error occured.Please try again later!';
		}
    }
}

if(!function_exists('get_small_image')) {
	function get_small_image($filename, $size='300') {
	    $ci = & get_instance();
		$ci->load->model('vendor/Products_model');
		$upload_physical_url = UPLOAD_PHYSICAL_PATH.'product-images/small'.$size;
		$upload_url = UPLOAD_URL.'product-images/';
		if($filename) {
			$tmp = strrpos($filename, '.');
			if($tmp != false) {
				$file = substr($filename, 0, $tmp);
				$extension = substr($filename, $tmp);
				$file = $file.'_'.$size.'x'.$size.$extension;
				$is_error = false;
				if(!file_exists($upload_physical_url.'/'.$file)) {
					$is_error = $ci->Products_model->resizeImage($filename);
				}
				if(!$is_error) 
				    return $upload_url.'small'.$size.'/'.$file;
				
			}
		}
		return $upload_url.$filename;
	}
}

if(!function_exists('truncate')) {
	function truncate($string, $length){
		if (strlen($string) > $length) {
			$string = substr($string, 0, $length) . '...';
		}

		return $string;
	}
}
