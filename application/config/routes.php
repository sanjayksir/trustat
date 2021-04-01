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
$route['api/complaints'] = 'Api/Consumer/Complaints';
$route['api/list_all_customers'] = 'Api/Consumer/ListAllCustomers';
$route['api/list_all_customers_brand_loyalty'] = 'Api/Consumer/ListAllCustomersBrandLoyalty';
$route['api/list_all_customers_brand_loyalty2'] = 'Api/Consumer/ListAllCustomersBrandLoyalty2';
$route['api/complaint/reply'] = 'Api/Consumer/ConsumerResponseComplaint';
$route['api/list-responses-on-complaint/(:any)'] = 'Api/Consumer/ListResponsesOnComplaint/$1';
$route['api/list-consumer-notifications'] = 'Api/Consumer/ListConsumerNotifications';

$route['api/view-consumer-notification'] = 'Api/Consumer/ViewConsumerNotification';
//$route['api/view-consumer-pushed-text-message'] = 'Api/Consumer/ViewConsumerTextMessage';
$route['api/consumer_profile_empty_field_count'] = 'Api/Consumer/ConsumerProfileEmptyFieldCount';
$route['api/loyalty-consumer-referral-product'] = 'Api/Consumer/LoyaltyConsumerReferralProduct';

$route['api/consumer_loylty_deals/(:any)/(:any)'] = 'Api/Consumer/consumerLoyltyDeals/$1/$2';

$route['api/user/consumer_profile_fields_available_update'] = 'Api/Consumer/ConsumerProfileFieldsAvailableUpdate'; 
$route['api/user/consumer_profile_fields_require_update'] = 'Api/Consumer/ConsumerProfileFieldsRequireUpdate';
$route['api/user/check_if_consumer_registered'] = 'Api/Consumer/CheckConsumerIfRegistered';
$route['api/user/check_if_consumer_if_eligible_for_reference'] = 'Api/Consumer/CheckConsumerIfEligiblForReference'; 
$route['api/user/check_if_consumer_if_eligible_for_reference_all_products'] = 'Api/Consumer/CheckConsumerIfEligiblForReferenceAllProducts'; 
$route['api/select_option_for_reason_sending_product_reference/(:any)'] = 'Api/Consumer/SelectOptionForReasonSendingProductReference/$1';

$route['api/user/check_if_consumer_received_reference'] = 'Api/Consumer/CheckIfConsumerReceivedReference'; 
$route['api/user/check_if_product_eligible_for_reference_for_consumer'] = 'Api/Consumer/CheckIfProductEligiblForReferenceForConsumer'; 

$route['api/custom_message_for_sending_product_reference/(:any)'] = 'Api/Consumer/CustomMessageforSendingProductReference/$1';
$route['api/message_for_receiver_of_reference/(:any)/(:any)'] = 'Api/Consumer/MessageForReceiverOfReference/$1/$2';
$route['api/trustat_coupon_type_name_number'] = 'Api/Consumer/TRUSTATCouponTypeNameNumber';
$route['api/user/consumer_referrals_info'] = 'Api/Consumer/ConsumerReferralsInfo'; 
$route['click_link/(:any)/(:any)/(:any)'] = 'Api/Consumer/UpdateRefSMSLinkClicked/$1/$2/$3';

//$route['api/list-responses-on-complaint/(:any)'] = 'Api/Consumer/ListResponsesOnComplaint/$1';
//$route['api/consumerpassbook'] = 'Api/Consumer/ConsumerPassBook';

//$route['api/redeem_loylty_points/(:any)/(:any)/(:any)'] = 'Api/Consumer/RedeemLoyltyPoints/$1/$2/$3';
$route['api/microsite_redeem_loylty_points/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'Api/Consumer/MicrositeRedeemLoyltyPoints/$1/$2/$3/$4/$5/$6/$7/$8/$9/$10/$11/$12/$13/$14/$15/$16/$17/$18/$19/$20/$21/$22/$23/$24/$25/$26';

$route['api/test_send_message'] = 'Api/Consumer/TestSendMessage';

// Cron Jobs
$route['api/expire_consumer_loyalty_points'] = 'Api/Consumer/ExpireConsumerLoyaltyPoints/';
$route['api/pre_loyalty_points_expiry_notifications'] = 'Api/Consumer/PreLoyaltyPointsExpiryNotifications/';
$route['api/percent_lty_pts_defined_by_customer/(:any)'] = 'Api/Consumer/PercentLoyaltyPointsDefinedByCustomer/$1';
$route['api/loyalty_point_weightage_with_compare_to_currency/(:any)'] = 'Api/Consumer/LoyaltyPointWeightageComparetoCurrency/$1';
$route['api/referral_program_auto_off'] = 'Api/Consumer/ReferralProgramAutoOff/';
//$route['api/customer/location-master'] = 'Api/Customer/location_master';
$route['api/user/list_retail_stores/(:any)'] = 'Api/Consumer/ListReltailStores/$1';

$route['api/customer/pre_purchase_scan_report_export_excel/(:any)/(:any)'] = 'Api/Customer/PrePurchaseScanReportExportExcel/$1/$2';
$route['api/customer/post_purchase_scan_report_export_excel/(:any)/(:any)'] = 'Api/Customer/PostPurchaseScanReportExportExcel/$1/$2';
$route['api/customer/auto_email_mis_customer_send'] = 'Api/Customer/AutoEmailMISCustomerSend';
$route['api/customer/auto_email_tracek_reports_send'] = 'Api/Customer/AutoEmailTracekReportsSend';

$route['api/customer/overall_global_inventory_in_hand_report_export_excel/(:any)/(:any)'] = 'Api/Customer/OverallGlobalInventoryinHandReportExportExcel/$1/$2';


$route['api/customer/auto_email_billing_mis_super_admin_send'] = 'Api/Customer/AutoEmailBillingMISSuperAdminSend';
$route['api/customer/customer_billing_report_export_excel/(:any)/(:any)'] = 'Api/Customer/CustomerBillingReportExportExcel/$1/$2';


$route['api/customer/test_email'] = 'Api/Customer/AutoEmailMIS';

$route['api/faqs_data'] = 'Api/Consumer/FaqsAndOtherData';
$route['api/terms_and_conditions'] = 'Api/Consumer/TermsAndConditions';
$route['api/TRUSTAT_app_service_agreement'] = 'Api/Consumer/TRUSTATAppServiceAgreement';
$route['api/TRUSTAT_app_version_update'] = 'Api/Consumer/TRUSTATAppVersionUpdate';
$route['api/TRUSTAT_app_server_base_url'] = 'Api/Consumer/TRUSTATAppServerBaseURL';
$route['api/tracek_app_server_base_url'] = 'Api/Consumer/TracekAppServerBaseURL';
$route['api/consumerpassbook'] = 'Api/Consumer/ConsumerPassBook';
$route['api/consumerpassbookdashboard'] = 'Api/Consumer/ConsumerPassBookDashboard';

$route['api/consumer_profile_master_data'] = 'Api/Consumer/ListConsumerProfileMasterData';

$route['api/user/add_consumer_relative'] = 'Api/Consumer/addConsumerRelative';
$route['api/user/edit_consumer_relative/(:any)'] = 'Api/Consumer/editConsumerRelative/$1';
$route['api/user/delete_consumer_relative/(:any)'] = 'Api/Consumer/DeleteConsumerRelative/$1';
$route['api/user/list_consumer_relatives'] = 'Api/Consumer/ListConsumerRelatives';

$route['api/user/save_consumer_media_view_details'] = 'Api/Consumer/SaveConsumerMediaViewDetails';
$route['api/user/save_consumer_media_view_details_auto_ref'] = 'Api/Consumer/SaveConsumerMediaViewDetailsAutoRef';

$route['api/user/add_consumer_kid'] = 'Api/Consumer/addConsumerKid';
$route['api/user/edit_consumer_kid/(:any)'] = 'Api/Consumer/editConsumerKid/$1';
$route['api/user/delete_consumer_kid/(:any)'] = 'Api/Consumer/DeleteConsumerKid/$1';
$route['api/user/list_consumer_kids'] = 'Api/Consumer/ListConsumerKids';

$route['api/products-advertisements'] = 'Api/ScannedProduct/productsAdvertisements';
$route['api/products-surveys'] = 'Api/ScannedProduct/productsSurveys';

$route['api/advertisement_read_status_update'] = 'Api/ScannedProduct/AdvertisementReadStatusUpdate';
$route['api/survey_read_status_update'] = 'Api/ScannedProduct/SurveyReadStatusUpdate';

$route['api/scan-product'] = 'Api/ScannedProduct/productScanning';
$route['api/delete-scaned-product'] = 'Api/ScannedProduct/DeleteScanedProduct';
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
//$route['api/customer/add-multipal-type-products-packaging'] = 'Api/Customer/addMultipalTypeProductsPackaging';
$route['api/customer/delete-product-parent-delink'] = 'Api/Customer/DeleteProductParentDelink';
$route['api/customer/dispatch-stock-transfer-out'] = 'Api/Customer/DispatchStockTransferOut';
$route['api/customer/receipt-stock-transfer-in'] = 'Api/Customer/ReceiptStockTransferIn';
$route['api/customer/physical-inventory-check'] = 'Api/Customer/PhysicalInventoryCheck';
$route['api/customer/add-inventory'] = 'Api/Customer/addInventory';
$route['api/customer/view-product'] = 'Api/Customer/viewProduct';
$route['api/customer/view-inventory'] = 'Api/Customer/viewInventory';
$route['api/customer/location-type-master'] = 'Api/Customer/location_type_master';
$route['api/customer/location-master'] = 'Api/Customer/location_master';
$route['api/customer/location-details-byid/(:any)'] = 'Api/Customer/location_details_byid/$1';
$route['api/customer/physical-inventory-on-hand'] = 'Api/Customer/PhysicalInventoryOnHand';
$route['api/customer/link-barcode-with-production-batch-id'] = 'Api/Customer/LinkBarcodewithProductionBatchId';
$route['api/customer/list-following-codes'] = 'Api/Customer/ListfollowingCodes';
$route['api/customer/add-shipper-box-pack-level'] = 'Api/Customer/addShipperBoxPackLevel';
$route['api/customer/ship-out-order'] = 'Api/Customer/ShipOutOrder';
$route['api/customer/tracekpassbook'] = 'Api/Customer/TracekUserPassBook';
$route['api/customer/tracekpassbookdashboard'] = 'Api/Customer/TracekUserPassBookDashboard';
$route['api/customer/tracekpassbookdashboardactivitywise'] = 'Api/Customer/TracekUserPassBookDashboardActivityWise';
$route['api/customer/tracek_loyalty_redemption'] = 'Api/Customer/TracekLoyaltyRedemptionRequest';
$route['api/customer/list_redemption_requests'] = 'Api/Consumer/redemption';
$route['api/customer/business_partner_scan_code'] = 'Api/Customer/BusinessPartnerScanCode';
$route['api/customer/scan_code_as_sold_out_direct_customer_sale'] = 'Api/Customer/ScanCodeasSoldOutDirectCustomerSale';
$route['api/customer/product_returned_from_customer'] = 'Api/Customer/ProductReturnedFromCustomer';
$route['api/product_return_type_cms_items'] = 'Api/Consumer/ProductReturnTypeCMSItems';
$route['api/product_return_type_name_value_cms_items'] = 'Api/Consumer/ProductReturnTypeNameValueCMSItems';
$route['api/customer/update_all_tracek_users_overall_global_inventory_in_hand_for_all_products'] = 'Api/Customer/UpdateAllTracekUsersOverallGlobalInventoryinHand';
$route['api/customer/all_products_list'] = 'Api/Customer/all_products_list';

//$route['api/redemption/add'] = 'Api/Consumer/redemptionAdd';
//$route['api/redemption'] = 'Api/Consumer/redemption';
//$route['api/consumerpassbook'] = 'Api/Consumer/ConsumerPassBook';
//$route['api/consumerpassbookdashboard'] = 'Api/Consumer/ConsumerPassBookDashboard';
	
$route['api/customer/tc_loyalty_redemption/add'] = 'Api/Customer/TCLoyaltyRedemptionRequest';
$route['api/customer/tc_loyalty_redemption/verifyotp'] = 'Api/Customer/TCLoyaltyRedemptionverifyOtp';
$route['api/customer/tc_loyalty_redemption/feed_invoice_number'] = 'Api/Customer/TCFeedInvoiceNumber';

$route['api/packaging_and_ship_out_order/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'Api/Consumer/addPackagingShipOutOrder/$1/$2/$3/$4/$5/$6/$7/$8/$9/$10/$11/$12/$13/$14/$15/$16';


$route['api/customer/list_packaging_and_ship_out_order_request_at_packaging_supervisor'] = 'Api/Customer/ListPackagingandShipOutOrderRequestAtPackagingSupervisor';
$route['api/customer/assign_packaging_and_ship_out_order_request_to_packer/(:any)/(:any)'] = 'Api/Customer/AssignPackagingandShipOutOrderRequestToPacker/$1/$2';
$route['api/customer/list_packers_at_packaging_supervisor'] = 'Api/Customer/ListPackersAtPackagingSupervisor';
$route['api/customer/packaging_order_for_ship_out'] = 'Api/Customer/PackagingOrderForShipOut';
$route['api/customer/initiate_short_closure_by_packer/(:any)'] = 'Api/Customer/InitiateShortClosureByPacker/$1';
$route['api/customer/response_short_closure_request_by_psupervisor/(:any)/(:any)'] = 'Api/Customer/ResponseShortClosureRequestByPSupervisor/$1/$2';


//$route['api/customer/ship-out-order'] = 'Api/Customer/ShipOutOrder';


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
$route['reports/consumer_activity_log'] = 'order_master/barcode/ConsumerActivityLog';
$route['reports/consumer_product_referral_report'] = 'order_master/barcode/ConsumerProductReferralReport';

$route['reports/tracek_user_activity_log'] = 'order_master/barcode/TracekUserActivityLog';

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
$route['reports/barcode/basic_customer_report_level0'] = 'order_master/barcode/BasicCustomerReportLevel0';
$route['reports/barcode/basic_customer_report_level0_download'] = 'order_master/barcode/BasicCustomerReportLevel0Download';
$route['reports/barcode/basic_customer_report_level1'] = 'order_master/barcode/BasicCustomerReportLevel1';
$route['reports/barcode/basic_customer_report_level1_download'] = 'order_master/barcode/BasicCustomerReportLevel1Download';
$route['reports/barcode/basic_customer_report_level0_product/(:any)'] = 'order_master/barcode/BasicCustomerReportLevel0Product/$1';
$route['reports/barcode/basic_customer_report_level1_product/(:any)'] = 'order_master/barcode/BasicCustomerReportLevel1Product/$1';
$route['reports/overall_global_inventory_product_stock_transfer_out_details/(:any)'] = 'order_master/barcode/list_overall_global_inventory_stock_transfer_out_invoice_details/$1';
$route['reports/overall_global_inventory_product_stock_transfer_in_details/(:any)'] = 'order_master/barcode/list_overall_global_inventory_stock_transfer_in_invoice_details/$1';
$route['reports/overall_global_inventory_product_sale_details/(:any)'] = 'order_master/barcode/list_overall_global_inventory_product_sale_details/$1';
$route['reports/overall_global_inventory_product_returned_details/(:any)'] = 'order_master/barcode/list_overall_global_inventory_product_returned_details/$1';
$route['reports/overall_global_inventory_closing_details/(:any)'] = 'order_master/barcode/list_overall_global_inventory_closing_details/$1';
$route['reports/overall_global_inventory_opening_details/(:any)'] = 'order_master/barcode/list_overall_global_inventory_opening_details/$1';

$route['surveys/view_survey_details/(:any)'] = 'surveys/view_survey_details/$1';
$route['advertisements/view_advertisement_details/(:any)'] = 'advertisements/view_advertisement_details/$1';


$route['reports/ship_out_order_report_list'] = 'order_master/barcode/ship_out_order_report_list';
$route['reports/ship_out_order_details/(:any)'] = 'order_master/barcode/ship_out_order_details/$1';

$route['reports/overall_global_inventory_in_hand'] = 'order_master/barcode/overall_global_inventory_in_hand';
$route['reports/overall_global_inventory_in_hand_download'] = 'order_master/barcode/overall_global_inventory_in_hand_download';

$route['reports/overall_global_inventory_in_hand_all_records'] = 'order_master/barcode/overall_global_inventory_in_hand_all_records';
$route['reports/overall_global_inventory_in_hand_all_records_download'] = 'order_master/barcode/overall_global_inventory_in_hand_all_records_download';

$route['reports/overall_global_inventory_in_hand_tr_records'] = 'order_master/barcode/overall_global_inventory_in_hand_tr_records';
$route['reports/overall_global_inventory_in_hand_tr_records_download'] = 'order_master/barcode/overall_global_inventory_in_hand_tr_records_download';

$route['reports/overall_global_inventory_in_hand_tr_all_records'] = 'order_master/barcode/overall_global_inventory_in_hand_tr_all_records';
$route['reports/overall_global_inventory_in_hand_tr_all_records_download'] = 'order_master/barcode/overall_global_inventory_in_hand_tr_all_records_download';


$route['reports/unpacked_inventory_in_hand'] = 'order_master/barcode/unpacked_inventory_in_hand';
$route['reports/unpacked_inventory_in_hand_download'] = 'order_master/barcode/unpacked_inventory_in_hand_download';

$route['reports/inventory/unpacked_inventory_in_hand_list_codes/(:any)/(:any)'] = 'order_master/barcode/unpacked_inventory_in_hand_list_codes/$1/$1';
$route['reports/inventory/unpacked_inventory_in_hand_list_codes_download/(:any)/(:any)'] = 'order_master/barcode/unpacked_inventory_in_hand_list_codes_download/$1/$1';

$route['reports/product_code_history'] = 'order_master/barcode/list_product_code_history';
$route['reports/product_barcode_batch_id_mapping'] = 'barcode_inventory/link_code_with_batchid';
$route['reports/tracek_loyalty_management'] = 'product/list_tracek_users_loyalty_summary';
$route['reports/packaging_and_ship_out_order_report'] = 'product/list_packaging_and_ship_out_order_report';
$route['reports/packaging_and_ship_out_order_report_details/(:any)'] = 'product/list_packaging_and_ship_out_order_report_details/$1';
$route['reports/products_packaging_and_ship_out_report'] = 'product/list_products_packaging_and_ship_out_report';
$route['reports/products_packaging_and_ship_out_report_by_packaging_id/(:any)'] = 'product/list_products_packaging_and_ship_out_report_packaging_id/$1';




