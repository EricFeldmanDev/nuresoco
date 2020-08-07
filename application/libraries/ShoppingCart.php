<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * Shopping Cart class for manage products
 */

class ShoppingCart
{

    protected $CI;
    public $sumValues;
    /*
     * 1 month expire time
     */
    private $cookieExpTime = 2678400;

    public function __construct()
    {
       /* @set_cookie('shopping_cart', serialize($_SESSION['shopping_cart']), $this->cookieExpTime);
        print_r($_COOKIE); exit;*/
        $this->CI = & get_instance();
        $this->CI->load->model('admin/Home_admin_model');
    }

    public function manageShoppingCart()
    {
    	//echo "string";die();
		//pr($_POST,1);
        if ($_POST['action'] == 'add') {
            if (!isset($_SESSION['shopping_cart'])) {
                $_SESSION['shopping_cart'] = array();
            }
			if(isset($_SESSION['logged_user']))
			{
				$userData = $this->CI->Public_model->getUserInfoFromEmail($_SESSION['logged_user']['email']);
				if($userData['shopping_cart_data']!='')
				{
					$_SESSION['shopping_cart'] = unserialize($userData['shopping_cart_data']);
				}
			}
			$product_id = $this->CI->input->post('product_id');
			$quantityDetails = $this->CI->Public_model->get_size_color_details($this->CI->input->post());
			//print_r($quantityDetails);
			if(!empty($quantityDetails))
			{
				$dbQuantity = 0;
				if($quantityDetails['logistic_detail']=='custom')
				{
					$dbQuantity = $quantityDetails['variations_quantity'];
				}else{
					$dbQuantity = $quantityDetails['quantity'];
				}
			}
			$limitExceded = 'false';
			if(!empty($_SESSION['shopping_cart']))
			{
				if(isset($_SESSION['shopping_cart'][$product_id]))
				{
					$quantityUpdated = false;
					foreach($_SESSION['shopping_cart'][$product_id] as $key => $productInCart)
					{
						if($productInCart['size_id']==(int) $_POST['selectsize'] && $productInCart['color_id']==(int) $_POST['selectcolor'])
						{
							$quantityUpdated = true;
							if($productInCart['quantity']+(int) $_POST['quantity'] <= $dbQuantity)
							{
								$_SESSION['shopping_cart'][$product_id][$key]['quantity'] = $productInCart['quantity']+(int) $_POST['quantity'];
							}else{
								$limitExceded = 'true';
							}
							break;
						}
					}
					if(!$quantityUpdated)
					{
						if((int) $_POST['quantity'] <= $dbQuantity)
						{
							$tempArr = array();
							$tempArr['quantity'] = (int) $_POST['quantity'];
							$tempArr['size_id'] = (int) $_POST['selectsize'];
							$tempArr['color_id'] = (int) $_POST['selectcolor'];
							@$_SESSION['shopping_cart'][$product_id][] = $tempArr;
						}else{
							$limitExceded = 'true';
						}
					}
				}else{
					if((int) $_POST['quantity'] <= $dbQuantity)
					{
						$tempArr = array();
						$tempArr['quantity'] = (int) $_POST['quantity'];
						$tempArr['size_id'] = (int) $_POST['selectsize'];
						$tempArr['color_id'] = (int) $_POST['selectcolor'];
						@$_SESSION['shopping_cart'][$product_id][] = $tempArr;
					}else{
						$limitExceded = 'true';
					}
				}
			}else{
				if((int) $_POST['quantity'] <= $dbQuantity)
				{
					$tempArr = array();
					$tempArr['quantity'] = (int) $_POST['quantity'];
					$tempArr['size_id'] = (int) $_POST['selectsize'];
					$tempArr['color_id'] = (int) $_POST['selectcolor'];
					@$_SESSION['shopping_cart'][$product_id][] = $tempArr;
				}else{
					$limitExceded = 'true';
				}
			}
			$totalInCart = $this->getTotalInCart();
			$responseArr = array('quantityLimit'=>$limitExceded,'totalInCart'=>$totalInCart);
			echo json_encode($responseArr,true);
        }
		
        if ($_POST['action'] == 'remove') {
            if (($key = array_search($_POST['product_id'], $_SESSION['shopping_cart'])) !== false) {
                unset($_SESSION['shopping_cart'][$key]);
            }
        }
		
		if(isset($_SESSION['logged_user']))
		{
			$this->CI->db->where('email',$_SESSION['logged_user']['email']);
			$this->CI->db->update('users_public',array('shopping_cart_data'=>serialize($_SESSION['shopping_cart'])));
		}
		//pr($_SESSION['shopping_cart'],1);
        @set_cookie('shopping_cart', serialize($_SESSION['shopping_cart']), $this->cookieExpTime);
    }

    public function getTotalInCart()
    {
    	//pr($_SESSION['shopping_cart']);
		$total = 0;
		if($_SESSION['shopping_cart'])
		{
			foreach($_SESSION['shopping_cart'] as $shopping_cart)
			{
				$total += count($shopping_cart);
			}
		}
		return $total;
	}



    public function updateCartQuantity()
    {
		$post = $this->CI->input->post();
		$product_id = $post['product_id'];
		$size_id = $post['size_id'];
		$color_id = $post['color_id'];
		$type = $post['type'];
		$updateValue = $post['updateValue'];
		
		$tempArr = array();
		$tempArr['product_id'] = $product_id;
		$tempArr['selectsize'] = $size_id;
		$tempArr['selectcolor'] = $color_id;
		
		$quantityDetails = $this->CI->Public_model->get_size_color_details($tempArr);
		if(!empty($quantityDetails))
		{
			$dbQuantity = 0;
			if($quantityDetails['logistic_detail']=='custom')
			{
				$dbQuantity = $quantityDetails['variations_quantity'];
			}else{
				$dbQuantity = $quantityDetails['quantity'];
			}
		}
		if(!empty($_SESSION['shopping_cart']))
		{
			if(isset($_SESSION['shopping_cart'][$product_id]))
			{
				$quantityUpdated = false;
				foreach($_SESSION['shopping_cart'][$product_id] as $key => $productInCart)
				{
					if($productInCart['size_id']==(int) $size_id && $productInCart['color_id']==(int) $color_id)
					{
						if($type=='increase')
						{
							if($productInCart['quantity']+(int) $updateValue <= $dbQuantity)
							{
								$quantityUpdated = true;
								$_SESSION['shopping_cart'][$product_id][$key]['quantity'] = $productInCart['quantity']+(int) $updateValue;
							}else{
								$limitExceded = 'true';
							}
							break;
						}else{
							$updateQuantity = $productInCart['quantity']-(int) $updateValue;
							if($updateQuantity <= $dbQuantity && $updateQuantity > 0)
							{
								$quantityUpdated = true;
								$_SESSION['shopping_cart'][$product_id][$key]['quantity'] = $updateQuantity;
							}
							break;
						}
					}
				}
			}
			if($quantityUpdated)
			{
				echo json_encode(array('status'=>'updated'),true);
			}else
			{
				if($type=='decrease')
				{
					echo json_encode(array('status'=>'error1'),true);
				}else{
					echo json_encode(array('status'=>'error'),true);
				}
			}
		}else{
			//echo "ak"; die();
			echo json_encode(array('status'=>'no_product_in_cart'),true);
		}
		
		if(isset($_SESSION['logged_user']))
		{
			$this->CI->db->where('email',$_SESSION['logged_user']['email']);
			$this->CI->db->update('users_public',array('shopping_cart_data'=>serialize($_SESSION['shopping_cart'])));
		}
	}

    public function removeFromCart()
    {
		$post = $this->CI->input->post();
		$product_id = $post['product_id'];
		$size_id = $post['size_id'];
		$color_id = $post['color_id'];
		if(!empty($_SESSION['shopping_cart']))
		{
			foreach($_SESSION['shopping_cart'][$product_id] as $key => $shopping_cart)
			{
				if($shopping_cart['size_id']==$size_id && $shopping_cart['color_id']==$color_id)
				{
					unset($_SESSION['shopping_cart'][$product_id][$key]);
				}
			}
		}
		if(empty($_SESSION['shopping_cart'][$product_id]))
		{
			unset($_SESSION['shopping_cart'][$product_id]);
		}
        @set_cookie('shopping_cart', serialize($_SESSION['shopping_cart']), $this->cookieExpTime);
		echo 'true';
		
		if(isset($_SESSION['logged_user']))
		{
			$this->CI->db->where('email',$_SESSION['logged_user']['email']);
			$this->CI->db->update('users_public',array('shopping_cart_data'=>serialize($_SESSION['shopping_cart'])));
		}
    }

    public function getCartItems()
    { 
    	
		if(isset($_SESSION['logged_user']))
		{
			$userData = $this->CI->Public_model->getUserInfoFromEmail($_SESSION['logged_user']['email']);
			$_SESSION['shopping_cart'] = unserialize($userData['shopping_cart_data']);
		}
        if ((!isset($_SESSION['shopping_cart']) || empty($_SESSION['shopping_cart'])) && get_cookie('shopping_cart') != NULL) {
            $_SESSION['shopping_cart'] = unserialize(get_cookie('shopping_cart'));
        } elseif (!isset($_SESSION['shopping_cart']) || !is_array($_SESSION['shopping_cart'])) {
            return 0;
        }
       
		//pr($_SESSION['shopping_cart'],1);
		
        $result['array'] = $this->CI->Public_model->getShopItems($_SESSION['shopping_cart']);
        //pr($result,1);
        if (empty($result['array'])) {
            unset($_SESSION['shopping_cart']);
            @delete_cookie('shopping_cart');
            return 0;
        }
 
        //$count_articles = array_count_values($_SESSION['shopping_cart']);
		$finalSum = 0;

        foreach ($result['array'] as $key => $article) {

		
			if($_SESSION['shopping_cart'])
			{
				foreach($_SESSION['shopping_cart'][$article['product_id']] as $productDetails)
				{
					if($productDetails['size_id']==$article['size_id'] && $productDetails['color_id']==$article['color_id'])
					{
						$cart_quantity = $productDetails['quantity'];
						break;
					}
				}
				$article['cart_quantity'] = $cart_quantity;
				$article['variations_price'] = $article['variations_price'] == '' ? 0 : $article['variations_price'];
				
				if($article['shipping_type']=='free')
				{
					$article['shipping'] = 0;
				}else{
					$article['shipping'] = number_format((int)$article['shipping'], 2);
				}
				
				$article['sum_variations_price'] = ($article['variations_price'] * $cart_quantity) + ($article['shipping'] * $cart_quantity);
				$article['sum_price'] = ($article['variations_price'] * $cart_quantity) + ($article['shipping'] * $cart_quantity);
				
				if($article['logistic_detail']=='default')
				{
					$finalSum = $finalSum + $article['sum_price'];	
				}else{
					$finalSum = $finalSum + $article['sum_variations_price'];	
				}
				$article['price'] = number_format((int)$article['variations_price'], 2);
				$article['sum_price'] = number_format($article['sum_price'], 2);
				$article['sum_variations_price'] = number_format($article['sum_variations_price'], 2);
				$article['variations_price'] = $article['variations_price'] != '' ? number_format($article['variations_price'], 2) : 0;
				//pr($article,1);
				$result['array'][$key] = $article;
			}
        }
        $result['finalSum'] = number_format($finalSum,2);
        $result['totalInCart'] = $this->getTotalInCart();
		return $result;

    }

    public function clearShoppingCart()
    {
        unset($_SESSION['shopping_cart']);
        @delete_cookie('shopping_cart');
		if(isset($_SESSION['logged_user']))
		{
			$this->CI->db->where('email',$_SESSION['logged_user']['email']);
			$this->CI->db->update('users_public',array('shopping_cart_data'=>''));
		}
        if ($this->CI->input->is_ajax_request()) {
            echo 1;
        }
    }

}
