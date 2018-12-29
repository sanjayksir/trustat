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

|	http://codeigniter.com/user_guide/general/routing.html

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

//echo '<pre>';print_r($_SERVER);exit;

$route['default_controller'] = 'backend';


/* API routing */
$route['api/register'] = 'Api/Consumer/register';
$route['api/login'] = 'Api/Consumer/login';
$route['api/upload-avatar'] = 'Api/Consumer/uploadAvatar';
$route['api/logout'] = 'Api/Consumer/logout';
$route['api/user/view'] = 'Api/Consumer/viewProfile';
$route['api/user/edit'] = 'Api/Consumer/editProfile';
$route['api/change-password'] = 'Api/Consumer/changePassword';
$route['api/resendotp/(:any)'] = 'Api/Consumer/resendOtp/$1';
$route['api/resendmail'] = 'Api/Consumer/resendMail';
$route['api/verifyotp'] = 'Api/Consumer/verifyOtp';
$route['api/logout'] = 'Api/Consumer/logout';
$route['emailverify/(:any)/(:any)'] = 'Api/Consumer/mailVerification/$1/$2';
$route['api/forgot-password/(:any)'] = 'Api/Consumer/forgotPassword/$1';
$route['api/feedback-question/(:num)'] = 'Api/Consumer/feedbackQuestion/$1';
$route['api/feedback-answer'] = 'Api/Consumer/feedbackAnswer';
$route['api/loylties'] = 'Api/Consumer/loylty';
$route['api/consumer-loylty'] = 'Api/Consumer/consumerLoylty';
$route['api/redemption/add'] = 'Api/Consumer/redemptionAdd';
$route['api/redemption'] = 'Api/Consumer/redemption';
$route['api/faqs_otherafterlogindata'] = 'Api/Consumer/FaqsAndOtherData';
$route['api/terms_and_conditions'] = 'Api/Consumer/TermsAndConditions';

$route['api/consumerpassbook'] = 'Api/Consumer/ConsumerPassBook';

$route['api/user/add_consumer_relative'] = 'Api/Consumer/addConsumerRelative';
$route['api/user/edit_consumer_relative/(:any)'] = 'Api/Consumer/editConsumerRelative/$1';
$route['api/user/delete_consumer_relative/(:any)'] = 'Api/Consumer/DeleteConsumerRelative/$1';
$route['api/user/list_consumer_relatives'] = 'Api/Consumer/ListConsumerRelatives';
$route['api/products-advertisements'] = 'Api/ScannedProduct/productsAdvertisements';
$route['api/products-surveys'] = 'Api/ScannedProduct/productsSurveys';


$route['api/scan-product'] = 'Api/ScannedProduct/productScanning';
$route['api/view-scanned-product'] = 'Api/ScannedProduct/viewScannedProduct';
$route['api/register-product'] = 'Api/ScannedProduct/registerProduct';
$route['api/purchased-product'] = 'Api/ScannedProduct/purchasedProduct';
$route['api/product-details/(:any)'] = 'Api/ScannedProduct/purchasedProductDetails/$1';
$route['api/complaint'] = 'Api/ScannedProduct/complaint';
$route['api/feedback-on-product'] = 'Api/ScannedProduct/FeedbackOnProduct';

$route['api/customer/login'] = 'Api/Customer/login';
$route['api/customer/logout'] = 'Api/Customer/logout';
$route['api/customer/add-product-level'] = 'Api/Customer/addProductLevel';
$route['api/customer/view-product-level'] = 'Api/Customer/viewProductLevel';
$route['api/customer/add-product-level-parent-activate'] = 'Api/Customer/addProductLevelParentActivate';
$route['api/customer/delete-product-parent-delink'] = 'Api/Customer/DeleteProductParentDelink';
$route['api/customer/dispatch-stock-transfer-out'] = 'Api/Customer/DispatchStockTransferOut';
$route['api/customer/receipt-stock-transfer-in'] = 'Api/Customer/ReceiptStockTransferIn';
$route['api/customer/physical-inventory-check'] = 'Api/Customer/PhysicalInventoryCheck';
$route['api/customer/add-inventory'] = 'Api/Customer/addInventory';
$route['api/customer/view-product'] = 'Api/Customer/viewProduct';
$route['api/customer/view-inventory'] = 'Api/Customer/viewInventory';
$route['api/customer/location-type-master'] = 'Api/Customer/location_type_master';
$route['api/customer/location-master'] = 'Api/Customer/location_master';
$route['api/customer/physical-inventory-on-hand'] = 'Api/Customer/PhysicalInventoryOnHand';


$route['api/customer/forgot-password/(:any)'] = 'Api/Customer/forgotPassword/$1';

/* End of API */


$route['login'] = 'backend/getLoggedIn';
$route['admin'] = 'backend/getAdminLoggedIn';
$route['dashboard'] = 'backend/dashboard';
## For News Dtail Url

//$route['detail/story/(num)'] = 'news/detail/$1';

//$route['news-(:num)/(:num)/(:num)/(:any)'] = "news/detail/story/$1";

$route['(:num)/(:num)/(:num)/(:any)'] = "news/detail/story/$1";

## For News Dtail Url

$route['backend/login'] = 'backend/getLoggedIn';
$route['user-post-news'] = 'home/buzzpeople';
$route['user-saved-news'] = 'home/buzzpeople/saved_stories';
$route['user-submit-news'] = 'home/buzzpeople/submitted_stories';

 

//$route['backend/login'] = 'backend/getLoggedIn';

$route['404_override'] = '';

$route['translate_uri_dashes'] = FALSE;



// CMS Pages Routes

$route['cms/about-spidey-buzz'] = 'cms/about_spidey_buzz';

$route['cms/become-citizen-journalist'] = 'cms/become_citizen_journalist';

$route['cms/advertise-with-us'] = 'cms/advertise';



$route['cms/contact'] = 'cms/contact';

$route['cms/feedback'] = 'cms/feedback';

$route['cms/terms-conditions'] = 'cms/terms_conditions';

$route['cms/privacy-policy'] = 'cms/privacy_policy';



$route['tag/(:any)'] = 'category/tags/$1';

$route['forgot-password'] = 'register/forgot_password';

$route['change-password'] = 'register/change_password';

$route['crime'] = 'category/posts/crime';

$route['trending/(:any)'] = 'category/trending/$1';

$route['mcd-election-special'] = 'category/posts/MCD Election Special';

$route['water'] = 'category/posts/Water';

$route['power'] = 'category/posts/Power';

$route['trafic-transportation'] = 'category/posts/Trafic & Transportation';

$route['health-sanitation'] = 'category/posts/Health & Sanitation';

$route['last-week'] = 'category/last_week';

$route['missing-people/(:num)'] = 'missing_people/index/$1';

$route['city-news/(:any)'] = 'home/citywise_stories_view/$1';



$route['reports/barcode_printed_reports'] = 'order_master/barcode/list_printed_report';
$route['reports/barcode_scanned_reports'] = 'order_master/barcode/list_scanned_report';
$route['reports/product_physical_packaging_reports'] = 'order_master/barcode/list_physical_packaging_report';
$route['reports/product_physical_unpackaging_reports'] = 'order_master/barcode/list_physical_unpackaging_report';
$route['reports/product_stock_transfer_out_reports'] = 'order_master/barcode/list_stock_transfer_out_report';
$route['reports/product_stock_transfer_out_invoice_details/(:any)'] = 'order_master/barcode/list_stock_transfer_out_invoice_details/$1';
$route['reports/product_stock_transfer_in_invoice_details/(:any)'] = 'order_master/barcode/list_stock_transfer_in_invoice_details/$1';
$route['reports/product_stock_physical_inventory_details/(:any)'] = 'order_master/barcode/list_physical_inventory_details/$1';
$route['reports/product_stock_physical_inventory_summary/(:any)'] = 'order_master/barcode/list_physical_inventory_summary/$1';
//$route['reports/view_product_code_details/(:any)'] = 'order_master/barcode/view_product_code_details/$1';
$route['reports/product_stock_transfer_in_reports'] = 'order_master/barcode/list_stock_transfer_in_report';
$route['reports/product_physical_inventory_check_report'] = 'order_master/barcode/list_physical_inventory_check_report';
$route['reports/inventory_on_hand_report'] = 'order_master/barcode/inventory_on_hand_report';
$route['reports/list_purchased_products'] = 'order_master/barcode/list_purchased_products';
$route['reports/list_complaint_log'] = 'order_master/barcode/list_complaint_log';
$route['reports/list_feedback_on_product'] = 'order_master/barcode/list_feedback_on_product';
$route['reports/list_warranty_claims'] = 'order_master/barcode/list_warranty_claims';




