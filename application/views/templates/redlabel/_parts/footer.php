<div class="clearfix"></div>
<div class="prd_shadwo"></div>
<div class="clearfix"></div>

<footer class="main_footer">
    <div class="container-fluid">
    <div class="row">
        <div class="col-md-10 col-sm-12 ft_left">
            <ul class="ft_ul">
                <li><a href="<?= LANG_URL . '/customer-support' ?>">Customer support</a></li>
                <li><a href="<?= LANG_URL . '/about-us' ?>">About us</a></li>
                <li><a href="<?= LANG_URL . '/FAQ' ?>">Help/FAQ</a></li>  
                <li><a href="<?= LANG_URL . '' ?>">Featured Products</a></li>  
                <li><a href="<?= LANG_URL . '/blog' ?>">Blog</a></li>
                <li><a href="<?= LANG_URL . '/careers' ?>">Careers</a></li>    
                <li><a href="<?= LANG_URL . '/privacy-policy' ?>">Privacy Policy</a></li>  
                <!--<li><a href="<?= LANG_URL . '/term-of-services' ?>">Term of services</a></li>-->
                <li><a href="<?= LANG_URL . '/return-policy' ?>">Return Policy</a></li>  
                <!--<li><a href="<?= LANG_URL . '/trademark-protection' ?>">Trademark Protection</a></li>  -->
            </ul>			
		</div>
		<div class="col-md-2 col-sm-12 ft_right">
		    <a href="#"><img src="<?=base_url('assets/web/images/ft_logo.png');?>" /></a>   
		</div>
    </div> 	
    </div> 	
</footer>

</body>
</html>	

<!--<script src="<?= base_url('assets/web/js/jquery.zoom.js') ?>"></script>-->
<!--<script src="<?= base_url('assets/web/js/popper.min.js') ?>"></script>-->
<!--<script src="<?= base_url('assets/web/bootstrap-4.1.3-dist/js/bootstrap.min.js') ?>"></script>-->
<!--<script src="<?= base_url('assets/web/js/owl.carousel.js') ?>"></script>-->
<!-- <script src="<?= base_url('assets/js/lozad.min.js') ?>"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-zoom/1.7.21/jquery.zoom.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.5/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js"></script>
<script src="<?= base_url('assets/web/js/wow.js') ?>"></script>
<?php if($title != lang('user_login') && $title != lang('user_register')) { ?>
<script src="<?= base_url('assets/web/js/style.js') ?>"></script>
<?php } ?>

<script>	
$(document).ready(function(){
$('.zoom').zoom();  
});
</script>
<script>
  <?php 
  if($this->uri->segment(2) == 'searchfilter') $page = 'search'; else $page = $this->uri->segment(1);
  if(isset($view_search) && $view_search) $page = 'search';
  ?>
var page = '<?=$page?>';
var search_mode = "<?php if(isset($search_mode)) echo $search_mode; else echo 'product';?>";
var variable = {
    clearShoppingCartUrl: "<?= base_url('clearShoppingCart') ?>",
    manageShoppingCartUrl: "<?= base_url('manageShoppingCart') ?>",
    discountCodeChecker: "<?= base_url('discountCodeChecker') ?>",
    searchProductHeaderURL: "<?= base_url('home/searchProductHeader') ?>",
    searchProductHeaderHintURL: "<?= base_url('home/searchProductHeaderHint') ?>",
    filterProductsURL: "<?=base_url('home/filterProducts/'.$page)?>",
    filterProductBundlesURL: "<?=base_url('home/filterProductBundles/'.$page)?>"
};
var product_limit = '<?=FILTER_PRODUCT_LIMIT?>';


var addToWishlistURL = '<?=base_url('home/addToWishlist/');?>';
if(typeof getColorSizeURL == 'undefined'){
  var getColorSizeURL = '';
}
var loginCheck = false;
<?php if($this->session->userdata('logged_user') && !empty($this->session->userdata('logged_user'))){ ?>
	loginCheck = true;
<?php } ?>
var login_url = '<?=base_url('login')?>';
var category_id = '';
<?php if($this->uri->segment('2')!=''){ ?>
	category_id = '<?=escape_product_name($this->uri->segment('2'))?>';
<?php } ?>
</script>
<script src="<?= base_url('assets/js/system.js') ?>"></script>
<script src="<?= base_url('assets/web/js/filter.js') ?>"></script>

<script>
$('.dropdown-menu a.dropdown-toggle').on('click', function(e) {
  if (!$(this).next().hasClass('show')) {
    $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
  }
  var $subMenu = $(this).next(".dropdown-menu");
  $subMenu.toggleClass('show');


  $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
    $('.dropdown-submenu .show').removeClass("show");
  });
  return false;
});
</script>

<script>
$(window).scroll(function() {
	$('#ak_menu').removeClass('show');
});
</script>
