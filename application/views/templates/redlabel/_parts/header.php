<?php 
$uri1 = $this->uri->segment(1);
$uri2 = $this->uri->segment(2);
?>
<!DOCTYPE html>
<html lang="<?= MY_LANGUAGE_ABBR ?>">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />        
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
		
        <meta name="description" content="<?= $description ?>" />
        <meta name="keywords" content="<?= $keywords ?>" />
        <meta property="og:title" content="<?= $title ?>" />
        <meta property="og:description" content="<?= $description ?>" />
        <meta property="og:url" content="<?= LANG_URL ?>" />
        <meta property="og:type" content="website" />
		<title><?= $title ?></title>
		
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
		<!--<link rel="stylesheet" href="<?= base_url('assets/web/bootstrap-4.1.3-dist/css/bootstrap.min.css') ?>">-->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
		<?php if(isset($_SESSION['theme']) && $_SESSION['theme']=='dark'){ ?>
			<link rel="stylesheet" href="<?= base_url('assets/web/css/style_dark.css') ?>">
			<link rel="stylesheet" href="<?= base_url('assets/web/css/custom_dark.css') ?>">
		<?php }else{ ?>
			<link rel="stylesheet" href="<?= base_url('assets/web/css/style.css') ?>">
			<link rel="stylesheet" href="<?= base_url('assets/web/css/custom.css') ?>">
		<?php } ?>
		<!--<link rel="stylesheet" href="<?= base_url('assets/web/css/font-awesome.min.css') ?>">-->
		<!--<link rel="stylesheet" href="<?= base_url('assets/web/css/owl.carousel.css') ?>">-->
		<!--<link rel="stylesheet" href="<?= base_url('assets/web/css/owl.theme.css') ?>">-->
		<!--<link rel="stylesheet" href="<?= base_url('assets/web/css/hover.css') ?>">-->
		<!--<link rel="stylesheet" href="<?= base_url('assets/web/css/animate.css') ?>">-->
		<!--<link rel="stylesheet" href="<?= base_url('assets/web/css/lightslider.css') ?>">-->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css">		
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.theme.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/hover.css/2.3.1/css/hover.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.0/animate.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/css/lightslider.min.css">
		<link rel="stylesheet" href="<?= base_url('assets/web/css/filter.css') ?>">
		<link rel="shortcut icon" href="<?= base_url('assets/web/css/images/favicon.png') ?>">
    
    
		<!--<script src="<?= base_url('assets/web/js/jquery-3.2.1.min.js') ?>"></script>-->
		<!--<script src="<?= base_url('assets/web/jquery-3.3.1-dist/js/jquery.min.js') ?>"></script>-->
		<!--<script src="<?= base_url('assets/web/js/lightslider.js') ?>"></script>-->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/js/lightslider.min.js"></script>
		<script>var baseUrl="<?php echo base_url()?>";</script>
		<style type="text/css">
			.mobile_search .search_product li {
			    border-bottom: 1px solid #bebdbd;
			    padding: 5px 15px;
			    background: #fff;
			    cursor: pointer;
			    white-space: nowrap;
			    overflow: hidden;
			    text-overflow: ellipsis;
			    color: black!important;
			    width: 100%;
			}
			.mobile_search .search_product {
			    width: 100%;
			    float: left;
			    position: relative;
			}
			.mobile_search_popup {
			    z-index: 999;
			}
			.ajax_loader{
				width: 100%;
    			height: 100vh;
    			position: fixed;
    			z-index: 1000;
    			background-color: rgba(0,0,0,.3);
    			display: none;
    			justify-content: center;
				align-items: center;
			}
			.ajax_loader.show{display: flex;}
			.search_option{width: calc(100% - 39px); border:1px solid #ddd; background-color: #fff; padding:5px 20px 10px; position: absolute; z-index:2;}
			.search_option p{font-weight: bold; margin-bottom: 0;}
			.search_option_item{border:1px solid #ddd; color: #0066ff; text-align: center; width: 112px; height: 76px;
				font-weight: bold; font-size: 0.9em; padding: 3px; cursor: pointer;}
			.search_option_item.active, .search_option_item:hover{background-image: linear-gradient(#408dff, #0d5acc); color: #fff;}
			.search_option_item:after{content:" "; display:inline-block; width: 63px; height: 50px;}
			.search_option_item.product:after{background-image: url('<?=base_url('assets/web/images/dashboard/11-0.png')?>');}
			.search_option_item.product.active:after,.search_option_item.product:hover:after{background-image: url('<?=base_url('assets/web/images/dashboard/11-1.png')?>');}
			.search_option_item.product_bundle:after{background-image: url('<?=base_url('assets/web/images/dashboard/10-0.png')?>');}
			.search_option_item.product_bundle.active:after,.search_option_item.product_bundle:hover:after{background-image: url('<?=base_url('assets/web/images/dashboard/10-1.png')?>');}
			.search_button{border: none; height: 50px; color: #fff; padding: 0 15px; font-size: 1.2rem; margin-right: 20px; background-color:var(--main-color); display: none;}
			.mobile_search_panel{height: 100vh; width: 100%; z-index: 1000; position: fixed; background-color: #fff;display:none;}
			.mobile_search_panel .search_header{padding: 10px;}
			.mobile_search_panel .search-group{border: 1px solid #ddd; background-color: #ffffff; border-radius: 5px; position: relative; width: 100%; height: 42px;box-shadow: 0 6px 10px rgba(0,0,0,.14), 0 1px 18px rgba(0,0,0,.12), 0 3px 5px rgba(0,0,0,.2);}
			.mobile_search_panel .search-group .btn_search{color: #333; font-size: 1.1rem; width: 17px; margin: 7px 8px; float:left;}
			.mobile_search_panel .search-group input{width: calc(100% - 34px); border: none; background-color: transparent !important; color: #333; padding-left:0;position: absolute; left:34px;}
			.mobile_search_panel .btn_cancel_search,
			.mobile_search_panel .btn_back_search{padding: 10px; color: #000; display:inline-block; text-decoration: none;}
			.mobile_search_panel .search-group .btn_search_clear{padding: 10px; color: #000; position: absolute; right:0; line-height: 18px; display: none;}
			.mobile_search_panel .search_option{width: 93%;}
			.mobile_search_panel .search_product{width: 100%; background: #fff; position: absolute; left: 0; top: 40px; z-index: 99; border: 1px solid #ddd;}
			.mobile_search_panel .search_product li{
				border-bottom: 1px solid #bebdbd;
				padding: 5px 15px;
				background: #fff;
				cursor: pointer;
				white-space: nowrap;
				overflow: hidden;
				text-overflow: ellipsis;
				color: black;
				width: 100%;
			}
			.mobile_search_title{font-size: 1.8rem;font-weight: bold; margin: 30px 20px 0 20px;transition: all 0.3s;}
			.search_box_panel .mobile_search_title{margin:0px 20px 0 20px;}			
			@media(max-width:767px) {
				.search_button{display:block;} 
				.mobile_search_panel.search, header.search{display:none;}
				.mobile_search_panel.search_box_panel{display:block;margin: 0px -15px; height: auto; position: relative; width:calc(100% + 30px);}
				.search_box_panel .mobile_search_filter .navbar-nav{margin:0 0 10px;}
			}	
			@media(min-width:768px) {.mobile_search_panel{display:none;}}		
		</style>
	</head>
<body>
	<?php 
	if($this->uri->segment(2) == 'searchfilter') $page = 'search'; else $page = $this->uri->segment(1);
    if(isset($view_search) && $view_search) $page = 'search';
	?>
	<div class="ajax_loader"><img src="<?=base_url('assets/imgs/ajax-loader.gif')?>" width="100"></div>
	<div class="mobile_search_panel filter_product <?php echo $page ?>">
		<a href="javascript:" class="btn_back_search"><i class="fa fa-chevron-left"></i> Back</a>
		<h2 class="mobile_search_title">Search</h2>
		<div class="search_header">
			<div class="d-flex" style="padding: 4px 0 4px 0px;">
				<div class="search-group">				
					<a href="javascript:" class="btn_search"><i class="fa fa-search"></i></a>				
					<input type="text" name="search_data" class="form-control" placeholder="Search product..." autocomplete="off" value="<?php if(isset($search_data)){ echo $search_data;  } ?>" required onkeyup="liveSearch(this)">
					<ul class="search_product" style="display:none;" >
					</ul>						
					<a href="javascript:" class="btn_search_clear"><i class="fa fa-times"></i></a>					
				</div>										
				<a href="javascript:" class="btn_cancel_search" style="display:none;">Cancel</a>
			</div>
			<div class="search_option" style="display:none;">
				<?php if(!isset($search_mode)) $search_mode = 'product'; ?>
				<p>Browse by:</p>
				<div class="d-flex">
					<div class="search_option_item product flex-fill <?php if($search_mode == 'product') echo 'active'?>"><p>Product</p></div>
					<div class="search_option_item product_bundle flex-fill <?php if($search_mode == 'product_bundle') echo 'active'?>"><p>Product Bundle</p></div>
				</div>
			</div>
		</div>
	</div>
	<header class="<?php echo $page ?> m-0">
		<section class="topbar_sectoion">
			<div class="container">
				<div class="row">
				<div class="col-md-6 col-lg-2 col-xl-2 left_topbar">
					<div class="btn-group btn-group-lg asd asd_desktop">
						<div class="btn-group btn-group-lg">
							<div class="dropdown header_support">
							  <?php $uri1=$this->uri->segment(1);
							   	$support=false;
  								if($uri1=='customer-support' || $uri1=='about-us' || $uri1=='FAQ' || $uri1=='' || $uri1=='blog' || $uri1=='careers' || $uri1=='privacy-policy' || $uri1=='return-policy' )
									{
										$support = true;
									}

							  ?>

							  <button type="button" class="btn btn-primary dropdown-toggle btn-theme <?=$support?'active':''?>" data-toggle="dropdown"> Support </button>
							  <div class="dropdown-menu">
								<a class="dropdown-item <?=($uri1=='customer-support')?'active':''?>" href="<?= LANG_URL . '/customer-support' ?>">Customer support</a>
								<a class="dropdown-item <?=($uri1=='about-us')?'active':''?>" href="<?= LANG_URL . '/about-us' ?>">About us</a>
								<a class="dropdown-item <?=($uri1=='FAQ')?'active':''?>" href="<?= LANG_URL . '/FAQ' ?>">Help/FAQ</a> 
								<a class="dropdown-item <?=($uri1=='')?'active':''?>" href="<?= LANG_URL . '' ?>">Featured Products</a>
								<a class="dropdown-item <?=($uri1=='blog')?'active':''?>" href="<?= LANG_URL . '/blog' ?>">Blog</a>
								<a class="dropdown-item <?=($uri1=='careers')?'active':''?>" href="<?= LANG_URL . '/careers' ?>">Careers</a>
								<a class="dropdown-item <?=($uri1=='privacy-policy')?'active':''?>" href="<?= LANG_URL . '/privacy-policy' ?>">Privacy Policy</a>
								<a class="dropdown-item <?=($uri1=='return-policy')?>'active':''?>" href="<?= LANG_URL . '/return-policy' ?>">Return Policy</a>
							  </div>
							</div>
						</div>
						<a href="<?= LANG_URL . '/vendor/shopping-approach'?>" class="btn btn-primary btn-theme">Merchant</a>
					</div>
				</div>    
				<div class="col-md-6 col-lg-4 col-xl-4 center_topbar">					
					<form id="filter_product" action="<?php  echo base_url('home/searchfilter');?>" method="POST" class="position-relative filter_product">
						<div class="input-group">
						  	<input type="text" name="search_data" class="form-control" id="search_data" placeholder="Search product..." autocomplete="off" value="<?php if(isset($search_data)){ echo $search_data;  } ?>" required onkeyup="liveSearch(this)">
						  	<ul class="search_product">
						  	</ul>						  							
						  	<div class="input-group-append search_product_header">
								<button type="submit" class="input-group-text search_product_button"><i class="fa fa-search"></i></button>
						  	</div>
						</div> 
						<div class="search_option" style="display:none;">
							<?php if(!isset($search_mode)) $search_mode = 'product'; ?>
							<p>Browse by:</p>
							<div class="d-flex">
								<div class="search_option_item product flex-fill <?php if($search_mode == 'product') echo 'active'?>"><p>Product</p></div>
								<div class="search_option_item product_bundle flex-fill <?php if($search_mode == 'product_bundle') echo 'active'?>"><p>Product Bundle</p></div>
							</div>
						</div>
						<input type="hidden" name="search_mode" id="search_mode" value="<?php echo $search_mode ?>"/>
					</form>					
				</div>
				<div class="col-md-12 col-lg-6 col-xl-6 right_topbar">
					<ul class="right_topbar_ul">
					<?php
						if($this->session->userdata('logged_user') && !empty($this->session->userdata('logged_user')))
						{
							$logged_user = $this->session->userdata('logged_user');
					?>
						<li class="<?=$uri1=='update-profile'?'active':''?>"><a href="<?= LANG_URL . '/update-profile' ?>"><i class="fa fa-user"></i> <?=$logged_user['name']?></a></li>
						<li class="<?=$uri1=='notifications'?'active':''?>"><a href="<?= LANG_URL . '/notifications' ?>"><i class="fa fa-bell"></i> Notifications</a></li>
						<li class="<?=$uri1=='wishlist'?'active':''?>"><a href="<?= LANG_URL . '/wishlist' ?>"><i class="fa fa-bookmark"></i> Wishlist <span class="cart-wishlist-items"><?= ($wishlistProductsCount>0)?'('.$wishlistProductsCount.')':'' ?></span></a></li>
						<li class="<?=$uri1=='shopping-cart'?'active':''?>"><a href="<?= LANG_URL . '/shopping-cart' ?>"><i class="fa fa-shopping-bag"></i> My cart <span class="cart-total-items"><?=(isset($cartItems['totalInCart']) && $cartItems['totalInCart']>0)?'('.$cartItems['totalInCart'].')':''?></span></a></li>
						<li><a href="<?= LANG_URL . '/logout' ?>"><i class="fa fa-sign-out"></i> Logout</a></li>
					<?php }else{ ?>
						<li class="<?=$uri1=='shopping-cart'?'active':''?>"><a href="<?= LANG_URL . '/shopping-cart' ?>"><i class="fa fa-shopping-bag"></i> Cart <span class="cart-total-items"><?=(isset($cartItems['totalInCart']) && $cartItems['totalInCart']>0)?'('.$cartItems['totalInCart'].')':''?></span></a></li>
						<li><a href="<?= LANG_URL . '/login' ?>"><i class="fa fa-lock"></i> Login</a></li>
					<?php } ?>
					</ul>
				</div> 
			</div> 	
			</div> 	
		</section>
		<section class="main_header" data-spy="affix" data-offset-top="50">
			<div class="container"> 
				<nav class="navbar navbar-expand-md ak_menu">
					<a class="navbar-brand" href="<?=base_url()?>"><img src="<?=WEB_URL?>images/logo.png"/></a>
					<div class="ml-auto d-flex">						
						<button class="search_button"><i class="fa fa-search"></i></button>
						<div class="d-flex flex-column justify-content-center">
							<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ak_menu">
								<i class="fa fa-bars"></i>
							</button>
						</div>
					</div>
					
					<div class="collapse navbar-collapse" id="ak_menu">
						<ul class="navbar-nav">
							<li class="nav-item"><a class="nav-link menu-link <?=$uri1==""?'active':''?>" href="<?=LANG_URL.''?>" href="#">Top Picks</a></li>
							<li class="nav-item"><a class="nav-link menu-link <?=$uri1=="featured"?'active':''?>" href="<?=LANG_URL.'/featured'?>" href="#">Featured</a></li>
							<li class="nav-item"><a class="nav-link menu-link <?=$uri1=="express-delivery"?'active':''?>" href="<?=LANG_URL.'/express-delivery'?>">Express Delivery</a></li>
							<!-- <li class="nav-item"><a class="nav-link menu-link <?=$uri1=="gadgets"?'active':''?>" href="<?=LANG_URL.'/gadgets'?>">Gadgets</a></li> -->
							<li class="nav-item"><a class="nav-link menu-link <?=$uri1=="fashion"?'active':''?>" href="<?=LANG_URL.'/fashion'?>">Fashion</a></li>
							<!-- Dropdown -->
							<li class="nav-item dropdown">
							  <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
								More
							  </a>
							  <div class="dropdown-menu">
								<?php foreach($nav_categories as $home_category){ if(!($home_category['id']==FASHION_CATEG_ID)){ ?>
									<a class="dropdown-item" href="<?=LANG_URL.'/products-filter/'.base64_encode($home_category['id'])?>"><?=$home_category['name']?></a>
								<?php } } ?>
							  </div>
							</li>
							<li class="nav-item short_filter short_filter_web">
								<div class="btn-group btn-group-lg">
									<div class="dropdown">
									  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
										<i class="fa fa-sort"></i>  Sort
									  </button>
									  <div class="dropdown-menu">
										<a class="dropdown-item header_sort_products" data-sort-product="lowest" href="javascript:void(0);">Lowest Price</a>
										<a class="dropdown-item header_sort_products" data-sort-product="highest" href="javascript:void(0);">Highest Price</a>
										<a class="dropdown-item header_sort_products" data-sort-product="newest" href="javascript:void(0);">Newly Listed</a>
										<a class="dropdown-item header_sort_products" data-sort-product="faster" href="javascript:void(0);">Faster Shipping</a>
									  </div>
									</div>
									<div class="dropdown rating_color_filter">
										<button type="button" class="btn btn-primary btn-theme dropdown-toggle" data-toggle="dropdown">
											<i class="fa fa-sliders"></i> Filter
										</button>
										<div class="dropdown-menu">
											<div class="dropdown dropright">
												<a href="#" class="dropdown-toggle filter_active" data-toggle="dropdown">Colours <i class="fa fa-caret-right pull-right"></i></a>
												<div class="dropdown-menu color_header">
													<a class="dropdown-item header_color_product" data-header-color-id="" href="javascript:void(0);">
														<span class="color_name">All Colours</span> 
													</a>
													<?php foreach($color_categories as $color_category){ ?>
														<a class="dropdown-item header_color_product" data-header-color-id="<?=$color_category['id']?>" href="javascript:void(0);">
															<span class="color_box" style="background:<?=$color_category['details']?>;"></span>
															<span class="color_name"><?=$color_category['category']?></span> 
														</a>
													<?php } ?>
												</div>
											</div>
											<div class="dropdown dropright">
												<a href="#" class="dropdown-toggle filter_active" data-toggle="dropdown">Ratings <i class="fa fa-caret-right pull-right"></i></a>
												<div class="dropdown-menu ratings_header">
													<a class="dropdown-item header_filter_star" data-header-filter-stars="" href="javascript:void(0);">
														All Stars
													</a>
													<a class="dropdown-item header_filter_star" data-header-filter-stars="5" href="javascript:void(0);">
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
													</a>
													<a class="dropdown-item header_filter_star" data-header-filter-stars="4" href="javascript:void(0);">
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
													</a>
													<a class="dropdown-item header_filter_star" data-header-filter-stars="3" href="javascript:void(0);">
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
													</a>
													<a class="dropdown-item header_filter_star" data-header-filter-stars="2" href="javascript:void(0);">
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
													</a>
													<a class="dropdown-item header_filter_star" data-header-filter-stars="1" href="javascript:void(0);">
														<i class="fa fa-star"></i>
													</a>
												</div>
											</div>
										</div>
							        </div>
									<div class="dropdown rating_color_filter2">
										<button type="button" class="btn btn-primary btn-theme express_filter">
											<i class="fa fa-truck"></i> Express
										</button>										
							        </div>
								</div>
								<div class="btn-group btn-group-lg mk_l">
									<div class="dropdown">
									  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
										<i class="fa fa-cog"></i> Theme
									  </button>
									  <div class="dropdown-menu">
										<a class="dropdown-item <?=(!isset($_SESSION['theme']) || (isset($_SESSION['theme']) && $_SESSION['theme']=='light'))?'active-theme':''?>" href="<?=LANG_URL.'/change-theme/light'?>">
											<i class="<?=(!isset($_SESSION['theme']) || (isset($_SESSION['theme']) && $_SESSION['theme']=='light'))?'':''?>"></i> Light
										</a>
										<a class="dropdown-item <?=(isset($_SESSION['theme']) && $_SESSION['theme']=='dark')?'active-theme':''?>" href="<?=LANG_URL.'/change-theme/dark'?>">
											<i class="<?=(isset($_SESSION['theme']) && $_SESSION['theme']=='dark')?'':''?>"></i> Dark
										</a>
									  </div>
									</div>
								</div>
							</li>
							<li>
								<div class="btn-group btn-group-lg asd asd_mobile">
									<button type="button" class="btn btn-primary btn-theme">Promote</button>
									<button type="button" class="btn btn-primary btn-theme">Merchant</button>
								</div>
							</li>
						</ul>
					</div>  
        		</nav>
      		</div>
		</section>
	</header>

<script>
  	function liveSearch(obj) {

      	var input_data = obj.value;
      	if (input_data.length === 0) {
          	$('#suggestions').hide();
      	} else {    
            $('#productnamebysearch').val(input_data);
          	$.ajax({
              	type: "POST",
              	url: "<?php echo base_url(); ?>/home/searchdetails",
              	data: {search_data: input_data},
              	success: function (data) {
                	$('.search_product').addClass('scroll');
                	if(data=='No found'){
                		$('.search_product').removeClass('scroll');
                	}
                  	// return success
                  	if (data.length > 0) {
                      	$('#suggestions').show();
                      	$('#autoSuggestionsList').addClass('auto_list');
						  $('.search_product').html(data);
						  $(obj).siblings('.search_product').show();
                  	} else {
						$(obj).siblings('.search_product').hide();
					  }
              	}
          	});
      	}
  	}
	
	$(document).ready(function() {  
		$(document).on('focus', 'input[name="search_data"]', function() {
			var parents = $(this).parents('.filter_product');
			parents.find('.mobile_search_title').hide();
			parents.find('.btn_cancel_search').show();
			setTimeout(() => {
				$('.search_option').slideDown('fast');	
			}, 100);
		});
		$(document).on('blur', 'input[name="search_data"]', function() {		
			$(this).siblings('.search_product').hide();
		});
		$(document).on('click', function(e){
			var target = $(e.target);
			if(!(target.parents('#filter_product').length>0 || target.parents('.search_option').length>0  || target.parents('.mobile_search_panel').length>0)) {
				$('.search_option').slideUp('fast');
			}
		})
		$(document).on('keyup', 'input[name="search_data"]', function() {
			$('.search_option').slideUp('fast');
			$('input[name="search_data"]').val($(this).val());
			if($(this).val()!='')
				$('.btn_search_clear').show();
			else
				$('.btn_search_clear').hide();
		});
		$(document).on('click', '.btn_search_clear', function() {
			$('input[name="search_data"]').val('');
			$('.search_product').hide();
		});
		$(document).on('click', '.btn_cancel_search', function() {
			var parents = $(this).parents('.filter_product');
			parents.find('.mobile_search_title').show();
			$(this).hide();
			setTimeout(() => {
				$('.search_option').slideUp('fast');		
			}, 100);
		});
		$(document).on('click', '.search_option_item', function() {
			$('.search_option_item').removeClass('active');
			$(this).addClass('active');		
			var option = 'product';
			if(!$(this).hasClass('product')) option = 'product_bundle';
			$('#search_mode').val(option);
			if($('input[name="search_data"]').val()!='') {
				$('#filter_product').submit();
			} else {
				$(this).parents('.filter_product').find('input[type="text"]').focus();
			}
		});
		$(document).on('click', '.btn_back_search', function() {
			if(page != 'search') {
				$('.mobile_search_panel').hide();
				$('.mobile_search_title').show();
				$('.search_option').slideUp('fast');
				$('.btn_cancel_search').hide();
			} else {
				location.href = baseUrl;
			}
		});
		$(document).on('click', '.search_button', function() {
			$('.mobile_search_panel').show();
		});
		$('.btn_search').on('click', function() {
			if($('input[name="search_data"]').val()!='') {
				$('#filter_product').submit();
			}
		});
		$('input[name="search_data"]').on('keyup', function(e) {
			if(e.which == 13) {
				if($('input[name="search_data"]').val()!='') {
					$('#filter_product').submit();
				}
			}
		});
	});
</script>