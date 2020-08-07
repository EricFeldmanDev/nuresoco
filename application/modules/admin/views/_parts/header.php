<?php
$uri2 = $this->uri->segment(2);
$uri3 = $this->uri->segment(3);
//echo $uri2; die;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="<?= $description ?>">
        <title><?= $title ?></title>
        <script src="<?=base_url('assets/js/jquery.min.js') ?>"></script>
        <link href="<?=base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
        <script src="<?=base_url('assets/js/bootstrap.min.js') ?>"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?=base_url('assets/bootstrap-select-1.12.1/bootstrap-select.min.css') ?>">
        <link href="<?= base_url('assets/css/custom-admin.css') ?>" rel="stylesheet">
        <link href='https://fonts.googleapis.com/css?family=Inconsolata' rel='stylesheet' type='text/css'>
        <!-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script> -->
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

        <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
        <style type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css"></style>
        <style type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css"></style>
        <script type="text/javascript">
            jQuery(document).ready(function() {
                jQuery('#example').DataTable();
            } );
            var baseUrl = "<?php echo base_url() ?>";
        </script>
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
		
<style>
	ul.sidebar-menu.dropdown_menu {margin: 0!important;}
	div.left-side ul.sidebar-menu li a {background: #1c1c1c;margin: 0px 0px 3px 0px;text-decoration: none;}
	ul.sidebar-menu.dropdown_menu li a {margin: 0px!important;background: #0e0e0e!important;}
	ul.sidebar-menu.dropdown_menu li a.active, ul.sidebar-menu.dropdown_menu li a:hover {background: #ffffff!important;}
	.sidebar-menu .panel-group .panel-default {background: none;border: 0;}
	.sidebar-menu .panel-group {margin-bottom: 0;}
	
</style>
    </head>
    <body>
        <div id="wrapper">
            <div id="content">
                <?php if ($this->session->userdata('logged_in')) { ?>
                    <nav class="navbar navbar-default">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                <i class="fa fa-lg fa-bars"></i>
                            </button>
                        </div>
                        <div id="navbar" class="collapse navbar-collapse">
                            <ul class="nav navbar-nav">
                                <li><a href="<?= base_url('admin') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                                <li><a href="<?= base_url() ?>" target="_blank"><i class="glyphicon glyphicon-star"></i> Go To Website</a></li>
                                <li>
                                    <a href="javascript:void(0);" class="h-settings"><i class="fa fa-key" aria-hidden="true"></i> Change Password</a>
                                    <div class="relative">
                                        <div class="settings">
                                            <div class="panel panel-primary" >
                                                <div class="panel-heading">
                                                    <div class="panel-title">Security</div>
                                                </div>     
                                                <div class="panel-body">
                                                    <label>Change my password</label> <span class="bg-success" id="pass_result">Changed!</span>
                                                    <form class="form-inline" role="form">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control new-pass-field" placeholder="New password" name="new_pass">
                                                        </div>
                                                        <a href="javascript:void(0);" onclick="changePass()" class="btn btn-sm btn-primary">Update</a>
                                                        <hr>
                                                        <span>Password Strength:</span>
                                                        <div class="progress">
                                                            <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0;">
                                                            </div>
                                                        </div>
                                                        <button type="button" class="btn btn-default generate-pwd">Generate Password</button> 
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <!--<li><a href="javascript:void(0);" data-toggle="modal" data-target="#modalCalculator"><i class="fa fa-calculator" aria-hidden="true"></i> Calculator</a></li>-->
                            </ul>
                            <ul class="nav navbar-nav navbar-right">
                                <li><a href="<?= base_url('admin/logout') ?>"><i class="fa fa-sign-out"></i> Logout</a></li>
                            </ul>
                        </div>
                    </nav>
                <?php } ?>
                <div class="container-fluid">
                    <div class="row">
                        <?php if ($this->session->userdata('logged_in')) { ?>
                            <div class="col-sm-3 col-md-3 col-lg-2 left-side navbar-default">
                                <div class="show-menu">
                                    <a id="show-xs-nav" class="visible-xs" href="javascript:void(0)">
                                        <span class="show-sp">
                                            Show menu
                                            <i class="fa fa-arrow-circle-o-down" aria-hidden="true"></i>
                                        </span>
                                        <span class="hidde-sp">
                                            Hide menu
                                            <i class="fa fa-arrow-circle-o-up" aria-hidden="true"></i>
                                        </span>
                                    </a>
                                </div>
                                <ul class="sidebar-menu">
								 <div class="panel-group" id="accordion">
                                    <li class="sidebar-search">
                                        <div class="input-group custom-search-form">
                                            <form method="GET" action="<?= base_url('admin/products') ?>">
                                                <div class="input-group">
                                                    <input class="form-control" name="search_title" value="<?= isset($_GET['search_title']) ? $_GET['search_title'] : '' ?>" type="text" placeholder="Search in products...">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" value="" placeholder="Find product.." type="submit">
                                                            <i class="fa fa-search"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </form>
                                        </div>
                                    </li>
									<li class="panel panel-default"><a data-toggle="collapse" data-parent="#accordion" class="header" href="#user">Users <i class="fa fa-angle-down pull-right"></i></a>
									    <div id="user" class="panel-collapse collapse <?= (urldecode(uri_string()) == 'admin/adminusers' || urldecode(uri_string()) == 'admin/vendors' || urldecode(uri_string()) == 'admin/users')?'in':'' ?>">
											<ul class="sidebar-menu dropdown_menu">
												<!--<li><a href="<?= base_url('admin/adminusers') ?>" <?= urldecode(uri_string()) == 'admin/adminusers' ? 'class="active"' : '' ?>><i class="fa fa-user" aria-hidden="true"></i> Admin Users</a></li>-->
												<li><a href="<?= base_url('admin/vendors') ?>" <?= urldecode(uri_string()) == 'admin/vendors' ? 'class="active"' : '' ?>><i class="fa fa-users" aria-hidden="true"></i> Vendors</a></li>
												<li><a href="<?= base_url('admin/users') ?>" <?= urldecode(uri_string()) == 'admin/users' ? 'class="active"' : '' ?>><i class="fa fa-users" aria-hidden="true"></i> Users</a></li> 
											</ul>
									    </div>
									</li>  
									
									<li class="panel panel-default"><a data-toggle="collapse" data-parent="#accordion" class="header" href="#ecommerce">ECOMMERCE<i class="fa fa-angle-down pull-right"></i></a>
										<div id="ecommerce" class="panel-collapse collapse <?= ($uri2 == 'shopcategories' || $uri2 == 'productRequests' || $uri2 == 'rejectedProducts' || $uri2 == 'acceptedProducts')?'in':'' ?>">
											<ul class="sidebar-menu dropdown_menu">
												<li><a href="<?= base_url('admin/acceptedProducts') ?>" <?= urldecode(uri_string()) == 'admin/acceptedProducts' ? 'class="active"' : '' ?>><i class="fa fa-files-o" aria-hidden="true"></i> Products</a></li>
												<!--
												<li><a href="<?= base_url('admin/productRequests') ?>" <?= urldecode(uri_string()) == 'admin/productRequests' ? 'class="active"' : '' ?>><i class="fa fa-files-o" aria-hidden="true"></i> Product Requests</a></li>
												
												<li><a href="<?= base_url('admin/rejectedProducts') ?>" <?= urldecode(uri_string()) == 'admin/rejectedProducts' ? 'class="active"' : '' ?>><i class="fa fa-files-o" aria-hidden="true"></i> Rejected Products</a></li>
												
												<li><a href="<?= base_url('admin/publish') ?>" <?= urldecode(uri_string()) == 'admin/publish' ? 'class="active"' : '' ?>><i class="fa fa-edit" aria-hidden="true"></i> Publish product</a></li>
												<?php if ($showBrands == 1) { ?>
													<li><a href="<?= base_url('admin/brands') ?>" <?= urldecode(uri_string()) == 'admin/brands' ? 'class="active"' : '' ?>><i class="fa fa-registered" aria-hidden="true"></i> Brands</a></li>
												<?php } ?>
												-->
												<li><a href="<?= base_url('admin/shopcategories') ?>" <?= urldecode(uri_string()) == 'admin/shopcategories' ? 'class="active"' : '' ?>><i class="fa fa-list-alt" aria-hidden="true"></i> Shop Categories</a></li>
                                                
                                                <li><a href="<?= base_url('admin/shoporder') ?>" <?= urldecode(uri_string()) == 'admin/shoporder' ? 'class="active"' : '' ?>><i class="fa fa-list-alt" aria-hidden="true"></i> Order</a></li>
											</ul>
										</div>
									</li>


									<li class="panel panel-default"><a data-toggle="collapse" data-parent="#accordion" class="header" href="#attributes">ATTRIBUTES<i class="fa fa-angle-down pull-right"></i></a>
									    <div id="attributes" class="panel-collapse collapse <?= ($uri2 == 'attributes' || $uri2 == 'attributeSubCategories')?'in':'' ?>">
											<ul class="sidebar-menu dropdown_menu">
												<li><a href="<?= base_url('admin/attributes') ?>" <?= ($uri2 == 'attributes' || $uri2 == 'attributeSubCategories') ? 'class="active"' : '' ?>><i class="fa fa-list-alt" aria-hidden="true"></i> Size Category</a></li>
												
												<li><a href="<?= base_url('admin/colors') ?>" <?= ($uri2 == 'colors') ? 'class="active"' : '' ?>><i class="fa fa-list-alt" aria-hidden="true"></i> Colors</a></li>
												
												<li><a href="<?= base_url('admin/discounts') ?>" <?= urldecode(uri_string()) == 'admin/discounts' ? 'class="active"' : '' ?>><i class="fa fa-percent" aria-hidden="true"></i> Coupon Codes</a></li>
												
												<!--<li>
													<a href="<?= base_url('admin/orders') ?>" <?= urldecode(uri_string()) == 'admin/orders' ? 'class="active"' : '' ?>>
														<i class="fa fa-money" aria-hidden="true"></i> Orders 
														<?php if ($numNotPreviewOrders > 0) { ?>
															<img src="<?= base_url('assets/imgs/exlamation-hi.png') ?>" style="position: absolute; right:10px; top:7px;" alt="">
														<?php } ?>
													</a>
												</li>
											
												<li><a href="<?= base_url('admin/discounts') ?>" <?= urldecode(uri_string()) == 'admin/discounts' ? 'class="active"' : '' ?>><i class="fa fa-percent" aria-hidden="true"></i> Discount Codes</a></li>
												-->
												<?php /* if (in_array('blog', $activePages)) { ?>
													<li class="header">BLOG</li>
													<li><a href="<?= base_url('admin/blogpublish') ?>" <?= urldecode(uri_string()) == 'admin/blogpublish' ? 'class="active"' : '' ?>><i class="fa fa-edit" aria-hidden="true"></i> Publish post</a></li>
													<li><a href="<?= base_url('admin/blog') ?>" <?= urldecode(uri_string()) == 'admin/blog' ? 'class="active"' : '' ?>><i class="fa fa-th" aria-hidden="true"></i> Posts</a></li>
												<?php } */ ?>
												<?php
												if (!empty($textualPages)) {
													foreach ($nonDynPages as $nonDynPage) {
														if (($key = array_search($nonDynPage, $textualPages)) !== false) {
															unset($textualPages[$key]);
														}
													}
													?>
											</ul>
										</div>
									</li>									
									
								    <li class="panel panel-default"><a data-toggle="collapse" data-parent="#accordion" class="header" href="#cms">CMS PAGES<i class="fa fa-angle-down pull-right"></i></a>
									    <div id="cms" class="panel-collapse collapse <?= ($uri2=='customer-mails'||$uri2=='aboutUsPage'||$uri2=='faq'||$uri2=='addFAQ'||$uri2=='editFAQ'||$uri2=='blog'||$uri2=='addBlog'||$uri2=='updateBlog'||$uri2=='pageedit')?'in':''?>">
									    <ul class="sidebar-menu dropdown_menu">
                                            <li><a href="<?=base_url('admin/customer-mails') ?>" <?= $uri2=='customer-mails' ? 'class="active"' : '' ?>><i class="fa fa-edit" aria-hidden="true"></i> <?=strtoupper('Customer Support') ?></a></li>
											
											<li><a href="<?=base_url('admin/aboutUsPage') ?>" <?= $uri2=='aboutUsPage' ? 'class="active"' : '' ?>><i class="fa fa-edit" aria-hidden="true"></i> <?= strtoupper('About Us') ?></a></li>

											<li><a href="<?=base_url('admin/faq') ?>" <?php if ($uri2=='faq'||$uri2=='addFAQ'||$uri2=='editFAQ') { echo 'class="active"'; } ?>><i class="fa fa-edit" aria-hidden="true"></i> <?=strtoupper('FAQ') ?></a></li>

											<li><a href="<?=base_url('admin/blog') ?>" <?php if($uri2=='blog'||$uri2=='addBlog'||$uri2=='updateBlog') { echo 'class="active"'; } ?>><i class="fa fa-edit" aria-hidden="true"></i> <?=strtoupper('BLOG') ?></a></li>
											


											<?php foreach ($textualPages as $textualPage) { ?>
												<li><a href="<?= base_url('admin/pageedit/' . $textualPage) ?>" <?= strpos(urldecode(uri_string()), $textualPage) ? 'class="active"' : '' ?>><i class="fa fa-edit" aria-hidden="true"></i> <?= strtoupper($textualPage) ?></a></li>
												<?php
											}?>

											  <?php  
											}
											?>
											<!--
											<li class="header">SETTINGS</li>
											<li><a href="<?= base_url('admin/settings') ?>" <?= urldecode(uri_string()) == 'admin/settings' ? 'class="active"' : '' ?>><i class="fa fa-wrench" aria-hidden="true"></i> Settings</a></li>
											<li><a href="<?= base_url('admin/titles') ?>" <?= urldecode(uri_string()) == 'admin/titles' ? 'class="active"' : '' ?>><i class="fa fa-font" aria-hidden="true"></i> Titles / Descriptions</a></li>
											<li><a href="<?= base_url('admin/pages') ?>" <?= urldecode(uri_string()) == 'admin/pages' ? 'class="active"' : '' ?>><i class="fa fa-file" aria-hidden="true"></i> Active Pages</a></li>
											<li><a href="<?= base_url('admin/emails') ?>" <?= urldecode(uri_string()) == 'admin/emails' ? 'class="active"' : '' ?>><i class="fa fa-envelope-o" aria-hidden="true"></i> Subscribed Emails</a></li>
											<li><a href="<?= base_url('admin/history') ?>" <?= urldecode(uri_string()) == 'admin/history' ? 'class="active"' : '' ?>><i class="fa fa-history" aria-hidden="true"></i> Activity History</a></li>
											-->
										</ul>
									  </div>
									</li>

									<li class="panel panel-default"><a data-toggle="collapse" data-parent="#accordion" class="header" href="#sliders">Sliders<i class="fa fa-angle-down pull-right"></i></a>
									    <div id="sliders" class="panel-collapse collapse <?= ($uri2 == 'sliders')?'in':'' ?>">
											<ul class="sidebar-menu dropdown_menu">
												<li><a href="<?= base_url('admin/sliders/featured') ?>" <?= ($uri3 == 'featured') ? 'class="active"' : '' ?>><i class="fa fa-sliders" aria-hidden="true"></i> Featured Page</a></li>
												<li><a href="<?= base_url('admin/sliders/express') ?>" <?= ($uri3 == 'express') ? 'class="active"' : '' ?>><i class="fa fa-sliders" aria-hidden="true"></i> Express Delivery Page</a></li>
												<li><a href="<?= base_url('admin/sliders/gadget') ?>" <?= ($uri3 == 'gadget') ? 'class="active"' : '' ?>><i class="fa fa-sliders" aria-hidden="true"></i> Gadgets Page</a></li>
												<li><a href="<?= base_url('admin/sliders/fashion') ?>" <?= ($uri3 == 'fashion') ? 'class="active"' : '' ?>><i class="fa fa-sliders" aria-hidden="true"></i> Fashion Page</a></li>
											</ul>
										</div>
									</li>

                                    <li class="panel panel-default"><a data-toggle="collapse" data-parent="#accordion" class="header" href="#sliderss">Request<i class="fa fa-angle-down pull-right"></i></a>
                                        <div id="sliderss" class="panel-collapse collapse in">
                                            <ul class="sidebar-menu dropdown_menu">
                                                <li><a href="<?= base_url('admin/express-request') ?>" class=""><i class="fa fa-sliders" aria-hidden="true"></i>Express Request</a></li>
                                            </ul>
                                        </div>
                                    </li>
									
									</div>	
                                </ul>
                            </div>
                            <div class="col-sm-9 col-md-9 col-lg-10 col-sm-offset-3 col-md-offset-3 col-lg-offset-2">
                                <?php if ($warnings != null) { ?>
                                    <div class="alert alert-danger">
                                        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                        There are some errors that you must fix!
                                        <ol>
                                            <?php foreach ($warnings as $warning) { ?>
                                                <li><?= $warning ?></li>
                                            <?php } ?>
                                        </ol>
                                    </div>
                                    <?php
                                }
                            } else {
                                ?>
                                <div>
                                <?php } ?>

