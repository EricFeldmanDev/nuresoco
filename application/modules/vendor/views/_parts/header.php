<?php
$uri1 = $this->uri->segment(1);
$uri2 = $this->uri->segment(2);
?>
<!DOCTYPE html>
<html lang="<?= MY_LANGUAGE_ABBR ?>">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="<?= $description ?>">
<title><?= $title ?></title>
<link rel="stylesheet" href="<?= base_url('assets/web/bootstrap-4.1.3-dist/css/bootstrap.min.css') ?>">
<?php if($title == 'Product Bundles') { ?>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<?php } ?>
<?php if(isset($_SESSION['vendor_theme']) && $_SESSION['vendor_theme']=='dark'){ ?>
	<link rel="stylesheet" href="<?= base_url('assets/web/css/style_dark.css') ?>">
	<link rel="stylesheet" href="<?= base_url('assets/web/css/custom_dark.css') ?>">
<?php }else{ ?>
	<link rel="stylesheet" href="<?= base_url('assets/web/css/style.css') ?>">
	<link rel="stylesheet" href="<?= base_url('assets/web/css/custom.css') ?>">
<?php } ?>
<link rel="stylesheet" href="<?= base_url('assets/web/css/font-awesome.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/web/css/owl.carousel.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/web/css/owl.theme.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/web/css/hover.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/web/css/animate.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/web/css/lightslider.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/web/css/filter.css') ?>">
<link rel="shortcut icon" href="<?= base_url('assets/web/images/favicon.png') ?>">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
<script src="<?=base_url('assets/web/js/jquery-3.2.1.min.js') ?>"></script>
<script src="<?=base_url('assets/web/jquery-3.3.1-dist/js/jquery.min.js') ?>"></script>
<style type="text/css">
#wrapper {
    padding-left: 0;
    -webkit-transition: all 0.5s ease;
    -moz-transition: all 0.5s ease;
    -o-transition: all 0.5s ease;
    transition: all 0.5s ease;
}

#wrapper.toggled {
    padding-left: 250px;
}

#sidebar-wrapper {  
	z-index: 1;  
    position: relative;
    width: 100%;
    height: 100%;
    margin-left: 0px;
    -webkit-transition: all 0.5s ease;
    -moz-transition: all 0.5s ease;
    -o-transition: all 0.5s ease;
    transition: all 0.5s ease;
	padding:0px 15px;
	border-bottom: 1px solid #ddd;
}

#wrapper.toggled #sidebar-wrapper {
    /* width: 300px; */
}

#page-content-wrapper {
    width: 100%;
    position: absolute;
    padding: 15px;
}

#wrapper.toggled #page-content-wrapper {
    position: absolute;
    /* margin-right: -300px; */
}
.box_sale_merchant {
    display: none;
}
.left-merchants_box {
    border: 1px solid #ccc;
    padding: 20px 30px;
    border-radius: 4px;
    background: #fff;
}
.right-merchants_box {
    border: 1px solid #ccc;
    padding: 20px 30px;
    background: #fff;
    border-radius: 4px;
}
.right-merchants_box .panel-default>.panel-heading {
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 3px;
}
.collhead a {
    width: 100%;
    position: relative;
    padding-left: 4px;
    padding-right: 290px;
    font-size: 17px;
    font-weight: 600;
    color: #000;
    padding: 5px auto!important;
    padding-top: 5px;
    padding-bottom: 5px;
    background: transparent;
}
@media(min-width:768px) {
    #wrapper {
        /* padding-left: 300px; */
    }

    #wrapper.toggled {
        padding-left: 0;
    }

    #sidebar-wrapper {
        /* width: 300px; */
    }

    #wrapper.toggled #sidebar-wrapper {
        width: 0;
    }

    #page-content-wrapper {
        padding: 15px;
        position: relative;
    }

    #wrapper.toggled #page-content-wrapper {
        position: relative;
        margin-right: 0;
    }
}
@media screen and (max-width: 479px){
#wrapper {
    padding-left: 0;
    -webkit-transition: all 0.5s ease;
    -moz-transition: all 0.5s ease;
    -o-transition: all 0.5s ease;
    transition: all 0.5s ease;
}

#wrapper.toggled {
    padding-left: 0px;
}

#sidebar-wrapper {
    z-index: 1000;
    position: relative;
    width: 100%;
    height: 100%;
    margin-left: 0px;
    -webkit-transition: all 0.5s ease;
    -moz-transition: all 0.5s ease;
    -o-transition: all 0.5s ease;
    transition: all 0.5s ease;
    padding:0px 15px;
}

#wrapper.toggled #sidebar-wrapper {
    width: 0px;
}

#page-content-wrapper {
    width: 100%;
    position: relative;
    padding: 15px;
}

#wrapper.toggled #page-content-wrapper {
    position: relative;
    margin-right: 0px;
}
.box_sale_merchant {
    display: none;
}

}


@media screen and (min-width: 480px) and (max-width: 767px){

#wrapper {
    padding-left: 0;
    -webkit-transition: all 0.5s ease;
    -moz-transition: all 0.5s ease;
    -o-transition: all 0.5s ease;
    transition: all 0.5s ease;
}

#wrapper.toggled {
    padding-left: 0px;
}

#sidebar-wrapper {
    z-index: 1000;
    position: relative;
    width: 100%;
    height: 100%;
    margin-left: 0px;
    -webkit-transition: all 0.5s ease;
    -moz-transition: all 0.5s ease;
    -o-transition: all 0.5s ease;
    transition: all 0.5s ease;
    padding:0px 15px;
}

#wrapper.toggled #sidebar-wrapper {
    width: 0px;
}

#page-content-wrapper {
    width: 100%;
    position: relative;
    padding: 15px;
}

#wrapper.toggled #page-content-wrapper {
    position: relative;
    margin-right: 0px;
}
.box_sale_merchant {   
    display: none;    
}
}

p.showad {
    color: #428ddc;
    cursor: pointer;
}
</style>
</head>

<body>
<header>
<section class="topbar_sectoion">
    <div class="container">
		<div class="row">
        <div class="col-md-6 col-lg-2 col-xl-2 left_topbar">
		    <div class="btn-group btn-group-lg asd asd_desktop">
				<div class="btn-group btn-group-lg">
					<div class="dropdown header_support">
					  <button type="button" class="btn btn-primary dropdown-toggle  btn-theme" data-toggle="dropdown"> Support </button>

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
				<a href="<?= LANG_URL . '/vendor/shopping-approach'?>" class="btn btn-primary btn-theme active <?=$uri2=='shopping-approach'?'active':''?>">Merchant</a>
			</div>
			<div class="short_filter short_filter_mobile">
				<div class="btn-group btn-group-lg">
					<div class="dropdown">
					  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-sort"></i>  Sort
					  </button>
					  <div class="dropdown-menu">
						<a class="dropdown-item" href="#">Lowest Price</a>
						<a class="dropdown-item" href="#">Highest Price</a>
						<a class="dropdown-item" href="#">Newly Listed</a>
					  </div>
					</div>
					<button type="button" class="btn btn-primary btn-theme">
						<i class="fa fa-sliders"></i> Filter
					</button>
				</div> 
				<div class="btn-group btn-group-lg mk_l">
					<button type="button" class="btn btn-primary btn-theme">
						<i class="fa fa-cog"></i> Theme
					</button>
				</div>
			</div>
		</div>    
        <div class="col-md-4 col-lg-4 col-xl-4 center_topbar">
		    <form id="filter_product" action="<?=LANG_URL.'/products-filter'?>" method="POST">
				<div class="input-group">
				  <input type="text" name="product_name" class="form-control search_product" placeholder="Search product..." autocomplete="off" value="<?=@$product_name?>" required>
				  <ul class="search_product_hints">
				  </ul>
				  <div class="input-group-append search_product_header">
					<span class="input-group-text search_product_button"><i class="fa fa-search" aria-hidden="true"></i></span>
					<input type="submit" name="search_product" value="" style="display:none;">
				  </div>
				</div> 
			</form> 
		</div>
        <div class="col-md-12 col-lg-6 col-xl-6 right_topbar">
		    <ul class="right_topbar_ul">
                <li><a href="<?= LANG_URL . '/vendor/sales-merchant' ?>"><i class="fa fa-user-circle"></i> <?=$vendor_name?></a></li>
                <li><a href="<?= LANG_URL . '/vendor/notifications' ?>" class="nav-notifications"><i class="fa fa-bell"></i> Notifications <?=$unseenNotificationCount>0?'<span id="notification-click">('.$unseenNotificationCount.')</span>':''?></a></li>
                <li><a href="<?= LANG_URL . '/vendor/logout' ?>"><i class="fa fa-shopping-bag"></i> logout</a></li>    
            </ul>			
		</div> 
    </div> 	
    </div> 	
</section>
<section class="main_header" data-spy="affix" data-offset-top="50">
    <div class="container"> 
	    <nav class="navbar navbar-expand-md ak_menu">
		    <a class="navbar-brand" href="<?=LANG_URL?>"><img src="<?=base_url('assets/web/images/logo.png')?>"/></a>
			<div class="mobile_search">
			       <i class="fa fa-search" onclick="myFunction()"></i>  
			       <div id="mobile_search" class="mobile_search_popup" style="display:none;">
				 <div class="input-group">
				  <input type="text" class="form-control" placeholder="Search product...">
				  <div class="input-group-append">
					<span class="input-group-text"><i class="fa fa-search" aria-hidden="true"></i></span>
				  </div>
				</div> 
			       </div>
			</div>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ak_menu">
				<i class="fa fa-bars"></i>
			</button>
			
			<div class="collapse navbar-collapse" id="ak_menu">
				<ul class="navbar-nav">
					<li class="nav-item"><a class="nav-link menu-link <?=$uri1==""?'active':''?>" href="<?=LANG_URL.''?>" href="#">Featured</a></li>
					<li class="nav-item"><a class="nav-link menu-link <?=$uri1=="express-delivery"?'active':''?>" href="<?=LANG_URL.'/express-delivery'?>">Express Delivery</a></li>
					<li class="nav-item"><a class="nav-link menu-link <?=$uri1=="gadgets"?'active':''?>" href="<?=LANG_URL.'/gadgets'?>">Gadgets</a></li>
					<li class="nav-item"><a class="nav-link menu-link <?=$uri1=="fashion"?'active':''?>" href="<?=LANG_URL.'/fashion'?>">Fashion</a></li>					
					<!-- Dropdown -->
					<li class="nav-item dropdown">
					  <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
						More
					  </a>
					  <div class="dropdown-menu">
						<?php foreach($nav_categories as $home_category){ if(!($home_category['id']==GADGETS_CATEG_ID || $home_category['id']==FASHION_CATEG_ID)){ ?>
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
								<a class="dropdown-item" href="#">Lowest Price</a>
								<a class="dropdown-item" href="#">Highest Price</a>
								<a class="dropdown-item" href="#">Newly Listed</a>
							  </div>
							</div>
							<button type="button" class="btn btn-primary btn-theme">
							    <i class="fa fa-sliders"></i> Filter
							</button>
						</div>
						<div class="btn-group btn-group-lg mk_l">
							<div class="dropdown">
							  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
								<i class="fa fa-cog"></i> Theme
							  </button>
							  <div class="dropdown-menu">
								<a class="dropdown-item <?=(!isset($_SESSION['vendor_theme']) || (isset($_SESSION['vendor_theme']) && $_SESSION['vendor_theme']=='light'))?'active-theme':''?>" href="<?=LANG_URL.'/vendor/change-theme/light'?>">
									<i class="<?=(!isset($_SESSION['vendor_theme']) || (isset($_SESSION['vendor_theme']) && $_SESSION['vendor_theme']=='light'))?'':''?>"></i> Light
								</a>
								<a class="dropdown-item <?=(isset($_SESSION['vendor_theme']) && $_SESSION['vendor_theme']=='dark')?'active-theme':''?>" href="<?=LANG_URL.'/vendor/change-theme/dark'?>">
									<i class="<?=(isset($_SESSION['vendor_theme']) && $_SESSION['vendor_theme']=='dark')?'':''?>"></i> Dark
								</a>
							  </div>
							</div>
						</div>
					</li>
					<li><div class="btn-group btn-group-lg asd asd_mobile">
				<a href="<?= LANG_URL . '/vendor/promote' ?>" class="btn btn-primary btn-theme">Promote</a>
				<a href="<?= LANG_URL . '/vendor/merchant' ?>" class="btn btn-primary btn-theme">Merchant</a>
			</div></li>
				</ul>
			</div>  
	    </nav>
	</div>
</section>
</header>

<div class="clearfix"></div>
<div id="wrapper">
<script>
	$('.search_product_button').on('click', function(){
		var search_product = $('.search_product').val();
		if(search_product!='')
		{
			$('#filter_product').submit();
			$('.search_product').focus();
		}else{
			alert('Please enter product name to search!');
		}
	});
</script>