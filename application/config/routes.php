<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
  | -------------------------------------------------------------------------
  | URI ROUTING
  | -------------------------------------------------------------------------
  | This file lets you re-map URI requests to specific controller functions.
  |
  | Typically there is a one-to-one relationship between a URL string
  | and its corresponding controller class/method. The segments in a
  | URL normally follow this pattern:
  |
  |	example.com/class/method/id/
  |
  | In some instances, however, you may want to remap this relationship
  | so that a different class/function is called than the one
  | corresponding to the URL.
  |
  | Please see the user guide for complete details:
  |
  |	https://codeigniter.com/user_guide/general/routing.html
  |
  | -------------------------------------------------------------------------
  | RESERVED ROUTES
  | -------------------------------------------------------------------------
  |
  | There are three reserved routes:
  |
  |	$route['default_controller'] = 'welcome';
  |
  | This route indicates which controller class should be loaded if the
  | URI contains no data. In the above example, the "welcome" class
  | would be loaded.
  |
  |	$route['404_override'] = 'errors/page_missing';
  |
  | This route will tell the Router which controller/method to use if those
  | provided in the URL cannot be matched to a valid route.
  |
  |	$route['translate_uri_dashes'] = FALSE;
  |
  | This is not exactly a route, but allows you to automatically route
  | controller and method names that contain dashes. '-' isn't a valid
  | class or method name character, so it requires translation.
  | When you set this option to TRUE, it will replace ALL dashes in the
  | controller and method URI segments.
  |
  | Examples:	my-controller/index	-> my_controller/index
  |		my-controller/my-method	-> my_controller/my_method
 */
$route['default_controller'] = 'home';

// Load default conrtoller when have only currency from multilanguage
$route['^(\w{2})$'] = $route['default_controller'];

$route['change-theme/(:any)']='home/change_theme/$1';
$route['vendor/change-theme/(:any)']='vendor/VendorProfile/change_theme/$1';
$route['vendor/auth/change-theme/(:any)']='vendor/auth/change_theme/$1';

$route['home/searchdetails']='home/search';
$route['home/searchfilter']='home/searchfilter';
$route['product/search']='home/view_search';

$route['featured']='home/featured';
$route['get_product/(:any)'] = 'home/get_product/$1';
$route['get_product_bundle'] = 'home/get_product_bundle';
$route['products-details/(:any)/(:any)']='home/product_details/$1/$2';
$route['product_bundle-details/(:any)/(:any)/(:any)']='home/product_bundle_details/$1/$2/$3';
$route['products-filter']='home/products_filter';
$route['products-filter/(:any)']='home/products_filter/$1';
$route['seller/(:any)']='home/seller/$1';
$route['write-vendor-review/(:any)']='home/write_vendor_review/$1';
$route['write-product-review/(:any)']='home/write_product_review/$1';

//Checkout
$route['(\w{2})?/?checkout/successcash'] = 'checkout/successPaymentCashOnD';
$route['(\w{2})?/?checkout/successbank'] = 'checkout/successPaymentBank';
$route['(\w{2})?/?checkout/paypalpayment'] = 'checkout/paypalPayment';
$route['(\w{2})?/?checkout/order-error'] = 'checkout/orderError';

// Ajax called. Functions for managing shopping cart
$route['(\w{2})?/?manageShoppingCart'] = 'home/manageShoppingCart';
$route['(\w{2})?/?clearShoppingCart'] = 'home/clearShoppingCart';
$route['(\w{2})?/?discountCodeChecker'] = 'home/discountCodeChecker';

// home page pagination
$route[rawurlencode('home') . '/(:num)'] = "home/index/$1";
// load javascript language file
$route['loadlanguage/(:any)'] = "Loader/jsFile/$1";
// load default-gradient css
$route['cssloader/(:any)'] = "Loader/cssStyle";

// Template Routes
$route['template/imgs/(:any)'] = "Loader/templateCssImage/$1";
$route['templatecss/imgs/(:any)'] = "Loader/templateCssImage/$1";
$route['templatecss/(:any)'] = "Loader/templateCss/$1";
$route['templatejs/(:any)'] = "Loader/templateJs/$1";

// Products urls style
$route['(:any)_(:num)'] = "home/viewProduct/$2";
$route['(\w{2})/(:any)_(:num)'] = "home/viewProduct/$3";
$route['shop-product_(:num)'] = "home/viewProduct/$3";

// blog urls style and pagination
$route['blog/(:num)'] = "blog/index/$1";
$route['blog/(:any)_(:num)'] = "blog/viewPost/$2";
$route['(\w{2})/blog/(:any)_(:num)'] = "blog/viewPost/$3";
$route['blog-detail/(:any)'] = "blog/blogDetail/$1";
// Shopping cart page
$route['shopping-cart'] = "ShoppingCartPage";
$route['(\w{2})/shopping-cart'] = "ShoppingCartPage";

// Shop page (greenlabel template)
$route['shop'] = "home/shop";
$route['(\w{2})/shop'] = "home/shop";

// Textual Pages links
$route['page/(:any)'] = "page/index/$1";
$route['(\w{2})/page/(:any)'] = "page/index/$2";

// Login Public Users Page
$route['login'] = "Users/login";
$route['(\w{2})/login'] = "Users/login";
$route['forgotten-password'] = "Users/forgotten";
$route['forgot-password-vefication/(:any)/(:any)'] = 'Users/verify_forgot_password/$1/$2';

$route['verify-account/(:any)/(:any)'] = "Users/verifyUserAccount/$1/$2";

// Register Public Users Page
$route['register'] = "Users/register";
$route['(\w{2})/register'] = "Users/register";

// Users Profiles Public Users Page
//$route['myaccount'] = "Users/myaccount";
$route['update-profile'] = "Home/update_profile";
$route['(\w{2})/myaccount'] = "Users/myaccount";

$route['changeProfileImage'] = "home/changeProfileImage";

$route['payment-setting'] = "home/payment_setting";
$route['change-password'] = "home/changePassword";
$route['check-user-password'] = "home/checkUserPassword";
$route['checkUseremail'] = "home/check_useremail";

$route['express-delivery'] = "Home/expressDelivery";
$route['gadgets'] = "Home/gadgets";
$route['fashion'] = "Home/fashion";
$route['notifications'] = "Home/notifications";
$route['inbox'] = "Home/inbox";
$route['inbox/(:any)'] = "Home/inbox/$1";
$route['send-message/(:any)'] = "Home/send_message/$1";
$route['wishlist'] = "Home/wishlist";
$route['check-order'] = "Home/checkOrder";
$route['order-history'] = "Home/orderHistory";
$route['order-track/(:any)'] = "Home/orderTrack/$1";
$route['write-review/(:any)'] = "Home/writeReview/$1";
$route['about-us'] = "Home/aboutUs";
$route['privacy-policy'] = "Home/privacyPolicy";
$route['return-policy'] = "Home/returnPolicy";
$route['customer-support'] = "Home/customerSupport";
$route['careers'] = "Home/careers";
$route['FAQ'] = "Home/FAQ";

// Logout Profiles Public Users Page
$route['logout'] = "home/logout";
$route['(\w{2})/logout'] = "home/logout";

$route['sitemap.xml'] = "home/sitemap";

// Confirm link
$route['confirm/(:any)'] = "home/confirmLink/$1";

/*
 * Vendor Controllers Routes
 */ 
$route['vendor/login'] = "vendor/auth/login";
$route['vendor'] = "vendor/auth/login";
$route['(\w{2})/vendor/login'] = "vendor/auth/login";
$route['vendor/payment'] = "vendor/vendorProfile/provider_payment";
$route['payment-success'] = "payment/payment_success";
$route['payment-failed'] = "payment/payment_failed";
$route['payment-thirdparty'] = 'payment/thirdparty_payment';
$route['user-payment'] = "payment/userPayment";
$route['payment-form'] = "payment/payment_form";

$route['vendor/getStates'] = "vendor/auth/getStates";
$route['vendor/getCities'] = "vendor/auth/getCities";
$route['vendor/shopping-approach'] = "vendor/auth/shoppingApproach";
$route['vendor/success-story'] = "vendor/auth/successstory";
$route['vendor/register'] = "vendor/auth/register";
$route['(\w{2})/vendor/register'] = "vendor/auth/register";
$route['vendor/verify-account/(:any)/(:any)'] = "vendor/auth/verifyAccount/$1/$2";
$route['vendor/forgotten-password'] = "vendor/auth/forgotten";
$route['vendor/forgot-password-vefication/(:any)/(:any)'] = 'vendor/auth/verify_forgot_password/$1/$2';
$route['(\w{2})/vendor/forgotten-password'] = "vendor/auth/forgotten";
$route['vendor/checkUseremail'] = "vendor/auth/check_useremail";
$route['vendor/me'] = "vendor/VendorProfile";
$route['(\w{2})/vendor/me'] = "vendor/VendorProfile";
$route['changeVendorImage'] = "vendor/VendorProfile/changeVendorImage";
$route['vendor/change-password'] = "vendor/VendorProfile/changePassword";
$route['vendor/check-vendor-password'] = "vendor/VendorProfile/checkVendorPassword";

$route['vendor/sales-merchant'] = "vendor/VendorProfile";
//$route['vendor/shippingstatus/shipping/(:any)'] = "vendor/VendorProfile/changeshippingstatus/$1";
$route['(\w{2})/vendor/sales-merchant'] = "vendor/VendorProfile";
$route['vendor/notifications'] = "vendor/VendorProfile/notifications";
$route['(\w{2})/vendor/notifications'] = "vendor/VendorProfile/notifications";
$route['vendor/inbox'] = "vendor/VendorProfile/inbox";
$route['vendor/inbox/(:any)/(:any)'] = "vendor/VendorProfile/inbox/$1/$2";
$route['vendor/getChatMessages'] = "vendor/VendorProfile/getChatMessages";
$route['vendor/send_message_by_ajax'] = "vendor/VendorProfile/send_message_by_ajax";
$route['vendor/review-rating'] = "vendor/ReviewRating";
$route['(\w{2})/vendor/salesreview-rating'] = "vendor/ReviewRating";
$route['vendor/init_payment'] = 'vendor/VendorProfile/init_payment';
$route['vendor/user-account'] = "vendor/VendorProfile/user_account";
$route['vendor/payment-setting'] = "vendor/VendorProfile/payment_setting";

$route['vendor/logout'] = "vendor/VendorProfile/logout";
$route['(\w{2})/vendor/logout'] = "vendor/VendorProfile/logout";
$route['vendor/deleteVendorProduct'] = "vendor/Products/deleteVendorProduct";
$route['vendor/products'] = "vendor/Products";
$route['(\w{2})/vendor/products'] = "vendor/Products";

$route['vendor/products/(:any)'] = "vendor/Products/index/$1";
$route['(\w{2})/vendor/products/(:any)'] = "vendor/Products/index/$2";

$route['addProductImage'] = "vendor/AddProduct/addProductImage";
$route['getTags'] = "vendor/AddProduct/getTags";

$route['vendor/add/product'] = "vendor/AddProduct";
$route['(\w{2})/vendor/add/product'] = "vendor/AddProduct";

$route['vendor/add/product/(:any)'] = "vendor/AddProduct/index/$1";
$route['(\w{2})/vendor/add/product/(:any)'] = "vendor/AddProduct/index/$2";
//addbulk product
$route['vendor/add/bulk/(:any)'] = "vendor/AddProduct/bulk/$1";
$route['vendor/express'] = "vendor/Products/express";
$route['vendor/express-join'] = "vendor/Products/expressJoin";
$route['vendor/express-success'] = "vendor/Products/expressSuccess";
$route['vendor/express-request'] = "vendor/Products/sendExpressRequest";
$route['vendor/edit/product/(:any)'] = "vendor/AddProduct/edit_product/$1";
$route['(\w{2})/vendor/edit/product/(:num)'] = "vendor/AddProduct/edit_product/$1";
$route['vendor/orders'] = "vendor/Orders";
$route['(\w{2})/vendor/orders'] = "vendor/Orders";
$route['vendor/uploadOthersImages'] = "vendor/AddProduct/do_upload_others_images";
$route['vendor/loadOthersImages'] = "vendor/AddProduct/loadOthersImages";
$route['vendor/removeSecondaryImage'] = "vendor/AddProduct/removeSecondaryImage";
$route['vendor/delete/product/(:num)'] = "vendor/products/deleteProduct/$1";
$route['(\w{2})/vendor/delete/product/(:num)'] = "vendor/products/deleteProduct/$1";
$route['vendor/view/(:any)'] = "Vendor/index/0/$1";
$route['(\w{2})/vendor/view/(:any)'] = "Vendor/index/0/$2";
$route['vendor/view/(:any)/(:num)'] = "Vendor/index/$2/$1";
$route['(\w{2})/vendor/view/(:any)/(:num)'] = "Vendor/index/$3/$2";
$route['(:any)/(:any)_(:num)'] = "Vendor/viewProduct/$1/$3";
$route['(\w{2})/(:any)/(:any)_(:num)'] = "Vendor/viewProduct/$2/$4";
$route['vendor/temporary_vendor'] = "vendor/auth/temporaryVendorInfo";
$route['vendor/changeOrderStatus'] = "vendor/orders/changeOrdersOrderStatus";
$route['vendor/uploadImage'] = "vendor/AddProduct/uploadImage";

$route['vendor/promote'] = "vendor/Promote";
$route['vendor/promoteProducts'] = "vendor/Promote/products";
$route['vendor/promoteNow/(:any)'] = "vendor/Promote/promote_now/$1";
$route['vendor/promoteNowSubmit/(:any)'] = "vendor/Promote/promote_now_submit/$1";
$route['vendor/promoteTotalSpend/(:any)'] = "vendor/Promote/promote_total_spend/$1";
$route['vendor/promotePreview/(:any)'] = "vendor/Promote/promote_preview/$1";

$route['vendor/product_bundles'] = "vendor/Products/product_bundle_list";
$route['vendor/update_product_bundle'] = "vendor/Products/update_product_bundle";
$route['vendor/delete_product_bundle'] = "vendor/Products/delete_product_bundle";
$route['vendor/create_product_bundle'] = "vendor/Products/create_product_bundle";
$route['vendor/get_products_by_category'] = "vendor/Products/get_products_by_category";


//$route['vendor/payment'] = "Vendor/provider_payment";

// Site Multilanguage
$route['^(\w{2})/(.*)$'] = '$2';

/*
 * Admin Controllers Routes
 */
// HOME / LOGIN
$route['admin'] = "admin/home/login";
$route['admin/forgotten-password'] = "admin/home/login/forgotten";
$route['admin/forgot-password-vefication/(:any)/(:any)'] = 'admin/home/login/verify_forgot_password/$1/$2';

// ECOMMERCE GROUP
$route['admin/publish'] = "admin/ecommerce/publish";
$route['admin/publish/(:num)'] = "admin/ecommerce/publish/index/$1";
$route['admin/removeSecondaryImage'] = "admin/ecommerce/publish/removeSecondaryImage";
$route['admin/products'] = "admin/ecommerce/products";
$route['admin/products/(:num)'] = "admin/ecommerce/products/index/$1";
$route['admin/productRequests'] = "admin/ecommerce/products/productRequests";
$route['admin/productRequests/(:num)'] = "admin/ecommerce/products/productRequests/$1";
$route['admin/rejectedProducts'] = "admin/ecommerce/products/rejectedProducts";
$route['admin/rejectedProducts/(:num)'] = "admin/ecommerce/products/rejectedProducts/$1";
$route['admin/acceptedProducts'] = "admin/ecommerce/products/acceptedProducts";
$route['admin/acceptedProducts/(:num)'] = "admin/ecommerce/products/acceptedProducts/$1";
$route['admin/verifyProduct/(:any)'] = "admin/ecommerce/products/verifyProduct/$1";
$route['admin/unverifyProduct/(:any)'] = "admin/ecommerce/products/unverifyProduct/$1";
$route['admin/productStatusChange'] = "admin/ecommerce/products/productStatusChange";
$route['admin/productAttribute'] = 'admin/ecommerce/products/product_attribute';
$route['admin/review/(:any)'] = "admin/ecommerce/products/review/$1";
$route['admin/productReview'] = "admin/ecommerce/products/reviewStatus";
$route['admin/productReviewDelete'] = "admin/ecommerce/products/reviewDelete";
$route['admin/addReview/(:any)'] = "admin/ecommerce/products/addReview/$1";
$route['admin/product/update_label'] = 'admin/ecommerce/products/updateLabel';

$route['admin/shopcategories'] = "admin/ecommerce/ShopCategories";
$route['admin/shoporder'] = "admin/ecommerce/ShopOrder";
$route['admin/shoporder/editorder/(:num)'] = "admin/ecommerce/ShopOrder/editorder/$1";
$route['admin/shoporder/editorderdetails'] = "admin/ecommerce/ShopOrder/editorderdetails";
$route['admin/shoporder/delete/(:num)'] = "admin/ecommerce/ShopOrder/delete/$1";

$route['admin/changeCategoryImage'] = "admin/ecommerce/ShopCategories/changeCategoryImage";
$route['admin/shopcategories/(:num)'] = "admin/ecommerce/ShopCategories/index/$1";
$route['admin/editshopcategorie'] = "admin/ecommerce/ShopCategories/editShopCategorie";
$route['admin/orders'] = "admin/ecommerce/orders";
$route['admin/orders/(:num)'] = "admin/ecommerce/orders/index/$1";
$route['admin/changeOrdersOrderStatus'] = "admin/ecommerce/orders/changeOrdersOrderStatus";
$route['admin/brands'] = "admin/ecommerce/brands";
$route['admin/changePosition'] = "admin/ecommerce/ShopCategories/changePosition";
$route['admin/discounts'] = "admin/ecommerce/discounts";
$route['admin/discounts/(:num)'] = "admin/ecommerce/discounts/index/$1";
// BLOG GROUP
$route['admin/blogpublish'] = "admin/blog/BlogPublish";
$route['admin/blogpublish/(:num)'] = "admin/blog/BlogPublish/index/$1";
//$route['admin/blog'] = "admin/blog/Blog";
$route['admin/blog/(:num)'] = "admin/blog/blog/index/$1";

// NEW  BLOG GROUP 
$route['admin/addBlog'] = "admin/blog/Blog/addBlog";
$route['admin/blog'] = "admin/blog/Blog/getListing";
$route['admin/blog/(:num)'] = "admin/blog/Blog/getListing/$1";
$route['admin/delBlog/(:any)'] = "admin/blog/Blog/removeBlog/$1";
$route['admin/updateBlog/(:any)'] = "admin/blog/Blog/updateBlog/$1";

// SETTINGS GROUP
$route['admin/settings'] = "admin/settings/settings";
$route['admin/styling'] = "admin/settings/styling";
$route['admin/files'] = 'admin/settings/settings/file_settings';
$route['admin/templates'] = "admin/settings/templates";
$route['admin/titles'] = "admin/settings/titles";
$route['admin/pages'] = "admin/settings/pages";
$route['admin/emails'] = "admin/settings/emails";
$route['admin/emails/(:num)'] = "admin/settings/emails/index/$1";
$route['admin/history'] = "admin/settings/history";
$route['admin/history/(:num)'] = "admin/settings/history/index/$1";
// ADVANCED SETTINGS
$route['admin/languages'] = "admin/advanced_settings/languages";
$route['admin/lang_settings'] = 'admin/advanced_settings/languages/lang_settings';
$route['admin/filemanager'] = "admin/advanced_settings/filemanager";
$route['admin/vendors'] = "admin/advanced_settings/vendors";

$route['admin/vendors/venderpayment/(:num)'] = "admin/advanced_settings/vendors/venderpayment/$1";
$route['admin/vendors/paymentstatus/(:num)'] = "admin/advanced_settings/vendors/paymentstatus/$1";

$route['admin/vendors/(:num)'] = "admin/advanced_settings/vendors/index/$1";
$route['admin/vendor/change-status/(:any)/(:any)'] = "admin/advanced_settings/vendors/change_activation_status/$1/$2";
$route['admin/vendor/deleteVendor/(:any)'] = "admin/advanced_settings/vendors/deleteVendor/$1";
$route['admin/users'] = "admin/advanced_settings/users";
$route['admin/users/(:num)'] = "admin/advanced_settings/users/index/$1";
$route['admin/user/change-status/(:any)/(:any)'] = "admin/advanced_settings/users/change_activation_status/$1/$2";
$route['admin/user/change-spam-status/(:any)/(:any)'] = "admin/advanced_settings/users/change_spam_status/$1/$2";
$route['admin/user/deleteUser/(:any)'] = "admin/advanced_settings/users/deleteUser/$1";
$route['admin/adminusers'] = "admin/advanced_settings/adminusers";
// ATTRIBUTES
$route['admin/attributes'] = "admin/attribute/Attributes/index";
$route['admin/colors'] = "admin/attribute/Attributes/colors";
$route['admin/changeAttrColor'] = "admin/attribute/Attributes/changeAttrColor";
$route['admin/attributes/(:num)'] = "admin/attribute/Attributes/index/$1";
$route['admin/attributeSubCategories/(:any)/?(:any)'] = "admin/attribute/Attributes/attributeSubCategories/$1/$2";
$route['admin/editAttrCategory'] = "admin/attribute/Attributes/editAttrCategory";
$route['admin/editAttrSubCategory'] = "admin/attribute/Attributes/editAttrSubCategory";
$route['admin/changeAttrPosition'] = "admin/attribute/Attributes/changeAttrPosition";
// TEXTUAL PAGES
$route['admin/pageedit/(:any)'] = "admin/textual_pages/TextualPages/pageEdit/$1";
$route['admin/changePageStatus'] = "admin/textual_pages/TextualPages/changePageStatus";

// ABOUT PAGE
$route['admin/aboutUsPage'] = "admin/textual_pages/aboutUs/aboutUsPage";
$route['admin/editContent/(:any)'] = "admin/textual_pages/aboutUs/editAboutMultiContent/$1";
$route['admin/removeContent/(:any)'] = "admin/textual_pages/aboutUs/removeAboutContent/$1";
$route['admin/addPage'] = "admin/textual_pages/aboutUs/addAboutPage";

// FAQ PAGE addFAQ
$route['admin/faq'] = "admin/textual_pages/FAQ";
$route['admin/addFAQ'] = "admin/textual_pages/FAQ/addFAQ";
$route['admin/delFAQ/(:any)'] = "admin/textual_pages/FAQ/removeFAQcontent/$1";
$route['admin/editFAQ/(:any)'] = "admin/textual_pages/FAQ/updateFAQ/$1";

// SEND CUSTOMER MAIL
$route['admin/customer-mails'] = "admin/textual_pages/CustomerSupport/paginations";
$route['admin/customer-mails/(:num)'] = "admin/textual_pages/CustomerSupport/paginations/$1";
$route['admin/removeData/(:any)'] = "admin/textual_pages/CustomerSupport/removeData/$1";

// SLIDERS
$route['admin/sliders'] = "admin/sliders/sliders/index";
$route['admin/sliders/(:any)'] = "admin/sliders/sliders/index/$1";
$route['admin/sliders/(:any)/?(:any)'] = "admin/sliders/sliders/index/$1/$2";
$route['admin/updateSliderText'] = "admin/sliders/sliders/updateSliderText";
$route['admin/updateSliderPosition'] = "admin/sliders/sliders/updateSliderPosition";
$route['admin/changeSliderImage'] = "admin/sliders/sliders/changeSliderImage";

// EXPRESS REQUEST
$route['admin/express-request'] = "admin/textual_pages/ExpressRequest/requestList";
$route['admin/accept-request/(:any)'] = "admin/textual_pages/ExpressRequest/acceptRequest/$1";
$route['admin/allow-request'] = "admin/textual_pages/ExpressRequest/allowRequest";
$route['admin/accept-request/(:any)/(:any)'] = "admin/textual_pages/ExpressRequest/acceptRequest/$1/$2";
$route['admin/reject-request/(:any)'] = "admin/textual_pages/ExpressRequest/rejectRequest/$1";
$route['admin/reject-request/(:any)/(:any)'] = "admin/textual_pages/ExpressRequest/rejectRequest/$1/$2";
$route['admin/view-countries'] = "admin/textual_pages/ExpressRequest/getCountries";


// LOGOUT
$route['admin/logout'] = "admin/home/home/logout";
// Admin pass change ajax
$route['admin/changePass'] = "admin/home/home/changePass";
$route['admin/uploadOthersImages'] = "admin/ecommerce/publish/do_upload_others_images";
$route['admin/loadOthersImages'] = "admin/ecommerce/publish/loadOthersImages";

/*
  | -------------------------------------------------------------------------
  | Sample REST API Routes
  | -------------------------------------------------------------------------
 */
$route['api/products/(\w{2})/get'] = 'Api/Products/all/$1';
$route['api/product/(\w{2})/(:num)/get'] = 'Api/Products/one/$1/$2';
$route['api/product/set'] = 'Api/Products/set';
$route['api/product/(\w{2})/delete'] = 'Api/Products/productDel/$1';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
