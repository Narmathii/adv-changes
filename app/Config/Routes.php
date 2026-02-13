<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ***************************************************************** VIEW PAGE ************************************************************************


$routes->get('/', 'Home::index');
$routes->get('detail/(:any)', 'Home::detail/$1/$1');
$routes->get('products/(:any)/(:any)/(:any)/(:num)', 'Home::products/$1/$2/$3/$4');
$routes->get('motor-accessories/(:any)/(:any)/(:num)', 'Home::accessories/$1/$2/$3');
$routes->get('accessories-detail/(:any)', 'Home::accessoriesDetail/$1/$1');
$routes->get('riding-accessories/(:any)/(:any)/(:num)', 'Home::ridingAccessories/$1/$2/$3');

$routes->get('riding-details/(:any)', 'Home::ridingDetails/$1/$1');
$routes->get('tour-detail/(:any)', 'Home::tourDetails/$1');
$routes->get('helmet-accessories/(:any)/(:any)/(:num)', 'Home::helmetAccessories/$1/$2/$3');
$routes->get('helmet-details/(:any)', 'Home::helmetDetails/$1/$1');
$routes->get('touring-accesssories/(:any)/(:any)/(:num)', 'Home::touringAccessories/$1/$2/$3');
$routes->get('offers/(:any)', 'Home::offers/$1');

$routes->get('tracking-order/(:any)', 'Home::trackingOrder/$1', ['filter' => 'PaymentAuth']);
$routes->post('cancel-orders', 'Home::cancelOrders', ['filter' => 'AuthFilter']);

$routes->post('insert-frequent-details', 'Home::insertFrequentDetails');
$routes->post('loadmore-offer', 'Home::loadmoreOffer');
$routes->post('loadmore-newarrivals', 'Home::loadmoreNewarrivals');
$routes->post('loadmore-hotsale', 'Home::loadmoreHotsale');

$routes->post('loadmore-ridingdetails', 'Home::loadmoreRidingDetails');
$routes->post('loadmore-hdetails', 'Home::loadmoreHDetails');
$routes->post('loadmore-tourdetails', 'Home::loadmoreLugDetails');
$routes->post('loadmore-campdetails', 'Home::loadmoreCampDetails');
$routes->post('loadmore-accessdetails', 'Home::loadmoreAccessDetails');
$routes->post('loadmore-productdetails', 'Home::loadmoreProductDetails');
$routes->post('loadmore-shopbybike', 'Home::loadmoreShopbyBike');


//tally Details
$routes->post('crm-to-tally/(:any)', 'TallyController::getTallyData/$1', ['filter' => 'apiKeyAuth']);
$routes->post('update-tally', 'TallyController::updateTally', ['filter' => 'apiKeyAuth']);
$routes->post('tally-to-crm', 'TallyController::syncTallyData');

$routes->get('camping/(:any)', 'Home::camping/$1');

$routes->get('camping-products/(:any)/(:any)/(:num)', 'Home::campingProducts/$1/$2/$3');
$routes->get('camp-details/(:any)', 'Home::campingProductsDetails/$1/$1');

$routes->get('combo-products', 'Home::comboProducts');
$routes->get('combo-details/(:any)', 'Home::comboDetails/$1');

$routes->get('cartdetails', 'Home::cartdetails');
$routes->get('shopby-brand/(:any)', 'Home::shopbybrand/$1');
$routes->get('helmets', 'Home::helmets');
$routes->get('details', 'Home::details');

$routes->get('login', 'LoginControllerr::login');
$routes->post('insert-data', 'LoginControllerr::insertData');
$routes->get('reset-password(:any)', 'LoginControllerr::resetPassword/$1');
$routes->post('reset-pwd/', 'LoginControllerr::resetPwd');

//Register from mail
$routes->post('signup-mailcheck', 'LoginControllerr::signupEmailCheck');
$routes->get('verify-email-otp', 'LoginControllerr::verifyEmailOTP');
$routes->post('check-email-otp', 'LoginControllerr::checkEmailOTP');
$routes->post('resend-email-otp', 'LoginControllerr::resendEmailOTP');

// Register From SMS
$routes->post('signup-otp', 'LoginControllerr::signupOTP');
$routes->get('signup-otppage', 'LoginControllerr::signupOtppage');
$routes->post('check-sms-otp', 'LoginControllerr::checkSmsOTP');
// $routes->post('resend-sms-otp', 'LoginControllerr::resendSmsOTP');
$routes->post('resend-signup-otp', 'LoginControllerr::resendSignUpOTP');
$routes->post('verify-login-otp', 'LoginControllerr::LoginOTPVerify');


// Login From SMS
$routes->post('login-otp', 'LoginControllerr::loginOTP');
$routes->get('login-otppage', 'LoginControllerr::LoginOTPpage');
$routes->post('send-emailll', 'LoginControllerr::sendEmail');
$routes->post('check-login', 'LoginControllerr::checkLogin');
$routes->get('signup', 'LoginControllerr::signup');
$routes->get('forget-password', 'LoginControllerr::password');
$routes->post('verify-password', 'LoginControllerr::verifyPwd');
$routes->get('verify-signup-otp', 'LoginControllerr::verifyOTP');


$routes->get('cart-list', 'CartController::cartList');
$routes->post('update-cart', 'CartController::updateCart');
$routes->get('get-inital-cart', 'CartController::getInitialCart');
$routes->get('logout-view', 'LoginControllerr::Logout');


$routes->post('change-address', 'CartController::changeAddress', ['filter' => 'AuthFilter']);
$routes->post('update-cart-address', 'CartController::updateCartAddress', ['filter' => 'AuthFilter']);
$routes->post('insert-cart-address', 'CartController::insertCartAddress', ['filter' => 'AuthFilter']);

$routes->post('user-cart-details', 'CartController::userCart');
$routes->post('delete-cart', 'CartController::deleteCart');

$routes->post('update-default-addr', 'CartController::updateDefaultAddr', ['filter' => 'AuthFilter']);
$routes->post('assign-couriercharge', 'CartController::assignCharges', ['filter' => 'AuthFilter']);

//  Tested and Error handled  /////
$routes->post('getcartdist-data', 'CartController::getDistrict', ['filter' => 'AuthFilter']);
$routes->post('insert-email', 'CartController::insertEmail', ['filter' => 'AuthFilter']);
$routes->post('update-email', 'CartController::updateEmail', ['filter' => 'AuthFilter']);


$routes->get('get-email', 'CartController::getEmail', ['filter' => 'AuthFilter']);

$routes->post('get-dist', 'CartController::getDist', ['filter' => 'AuthFilter']);

$routes->get('myprofile', 'UserController::myprofile', ['filter' => 'SessionAuth']);


$routes->get('address', 'UserController::address', ['filter' => 'SessionAuth']);
$routes->post('getdist-data', 'AddressController::getDist', ['filter' => 'AuthFilter']);
$routes->post('insert-address', 'AddressController::insertAddress', ['filter' => 'AuthFilter']);

$routes->get('get-address', 'AddressController::getAddress', ['filter' => 'AuthFilter']);
$routes->post('update-address', 'AddressController::updateAddress', ['filter' => 'AuthFilter']);
$routes->post('delete-address', 'AddressController::deleteAddress', ['filter' => 'AuthFilter']);

//  ----------------------------------------------  Auth Filter  ------------------------------------------------------
$routes->get('get-profile', 'UserController::getprofile', ['filter' => 'AuthFilter']);
$routes->post('update-profile', 'UserController::updateprofile', ['filter' => 'AuthFilter']);
$routes->post('cart-checkout', 'CartCheckoutController::cartCheckout', ['filter' => 'AuthFilter']);
$routes->get('check-userlogin', 'CartCheckoutController::checkLoginRes');
$routes->get('check-address', 'CartCheckoutController::checkAddress', ['filter' => 'SessionAuth']);
$routes->get('place-order', 'CartCheckoutController::placeOrder', ['filter' => 'SessionAuth']);

// Webhook checkout controller
$routes->post('webhook-payment-status', 'WebhookController::paymentstatus');
$routes->get('payment-cancelled', 'WebhookController::paymentcancel');
$routes->get('payment-failed', 'WebhookController::paymentfail');
$routes->get('payment-success', 'WebhookController::Success');
$routes->match(['get', 'post'], 'webhook-payment-log', 'WebhookController::webhookPaymentLog');

// RazerpayController
$routes->get('payment', 'RazerpayController::payment', ['filter' => 'PaymentAuth']);
$routes->post('payment-status', 'RazerpayController::paymentstatus');
$routes->get('payment-cancelled/(:any)', 'RazerpayController::paymentcancel/$1');
$routes->get('payment-failed/(:any)', 'RazerpayController::paymentfail/$1');
$routes->get('success', 'RazerpayController::Success');
$routes->post('payment-pending', 'RazerpayController::paymentPending');


// $routes->get('success', 'RazerpayController::success');
$routes->post('add-wishlist', "WishlistController::addwishlist");
$routes->post('delete-wishlist', "WishlistController::deletewishlist");


$routes->get('wishlist', 'Home::wishlist');
$routes->get('brands-viewall', 'Home::brands_viewall');
$routes->get('brands/(:any)', 'Home::Brands/$1/$1');


$routes->get('newrrival-view/(:any)', 'Home::newArrivalViewall/$1');

$routes->get('helmet-view', 'Home::helmetView');
$routes->get('search-filter', 'Home::searchfiltrView');
$routes->get('search-data', 'SearchController::searchData');
$routes->get('get-search-suggestions', 'SearchController::searchSuggesstions');



$routes->get('privacy-policy', 'Home::policies');
$routes->get('myorders', 'Home::myorders', ['filter' => 'PaymentAuth']);

$routes->get('hotsale/(:any)', 'Home::hotsale/$1');
$routes->post('prod-filter/(:any)', 'SearchController::prodFilter/$1');
$routes->post('bike-prod-filter/(:any)', 'SearchController::BikeProdFilter/$1');

$routes->post('offers-filter/(:any)', 'SearchController::offersFilter/$1');
$routes->post('newarrival-filter/(:any)', 'SearchController::newArrivalFilter/$1');
$routes->post('hotsale-filter/(:any)', 'SearchController::hotsaleFilter/$1');
$routes->post('brand-filter', 'SearchController::brandFilter');
$routes->post('loadmore-searchdata', 'SearchController::loadmoreSearchFilter');


$routes->get('contact-us', 'Home::contactUs');
$routes->get('terms-conditions', 'Home::terms');


$routes->get('buy-now', 'BuynowController::buynowView');
$routes->get('check-loginsts', 'BuynowController::checkLogin');
$routes->post('buynow-products', 'BuynowController::buyProductsList', ['filter' => 'SessionAuth']);
$routes->post('buynow-checkout', 'BuynowController::buynowCheckout', ['filter' => 'AuthFilter']);
// $routes->post('check-email-input', 'BuynowController::checkEmailInput');

$routes->post('couriercharge-buynow', 'BuynowController::courierCharge', ['filter' => 'AuthFilter']);



// $routes->get('transaction', 'Home::transaction');
// $routes->post('insert-transaction', 'Home::inserTransaction');

// $routes->post("get-config-details", "VarientController::getConfigDetails");
$routes->get("get-sizemaster", "VarientController::getSizeMaster", ['filter' => 'SessionAuth']);

$routes->post("get-config-details", "admin\ProductController::getConfigColor", ['filter' => 'SessionAuth']);

$routes->post("get-varients", "VarientController::getVarients", ['filter' => 'SessionAuth']);


// ***************************************************************** ADMIN PAGE ************************************************************************ 

$routes->post('refund-webhook', 'admin\Refundwebhook::webhookStatus');
//*************** Wishlist ********************** */ 
$routes->get("wishlist-details", "admin\WishlistController::wishlistDetails");
$routes->post('get-wishlist-data', 'admin\WishlistController::getWishlistData');


//*************** Color master********************** */

$routes->get('color-master', 'admin\ColorMasterController::colorMaster');
$routes->post('get-color-master', 'admin\ColorMasterController::getColorMaster');
$routes->post('insert-color-master', 'admin\ColorMasterController::insertColorMaster');
$routes->post('update-color-master', 'admin\ColorMasterController::updateColorMaster');
$routes->post('delete-color-master', 'admin\ColorMasterController::deleteColorMaster');

//*************** Accessories Brand ********************** */ 
$routes->get("brand-master", "admin\BrandMaster::brands");
$routes->post('get-brand-master', 'admin\BrandMaster::getBrandData');
$routes->post('insert-brand-master', 'admin\BrandMaster::insertBrandData');
$routes->post('update-brand-master', 'admin\BrandMaster::updateBrandData');
$routes->post('delete-brand-master', 'admin\BrandMaster::deleteBrandData');


//*************** Banner Image  ********************** */ 
$routes->get("banner-image", "admin\BannerController::banner");
$routes->post("insert-banner-list", "admin\BannerController::Insertbanner");
$routes->post("get-banner", "admin\BannerController::getbanner");
$routes->post("update-banner-list", "admin\BannerController::updatebanner");
$routes->post("delete-banner", "admin\BannerController::deletebanner");

//*************** Youtube Link  ********************** */ 
$routes->get("youtube", "admin\YoutubeController::youtube");
$routes->post("insert-ytube", "admin\YoutubeController::insertYoutube");
$routes->post("get-ytube", "admin\YoutubeController::getYoutube");
$routes->post("update-ytube", "admin\YoutubeController::updateYoutube");
$routes->post("delete-ytube", "admin\YoutubeController::deleteYoutube");

//*************** Camping Start  ********************** */ 
$routes->get("camp-menu", "admin\CampMenuController::camping");
$routes->post('insert-cmenu-list', 'admin\CampMenuController::insertCampMenu');
$routes->post('get-cmenu-list', 'admin\CampMenuController::getCampMenu');
$routes->post('update-cmenu-list', 'admin\CampMenuController::updateCampMenu');
$routes->post('delete-cmenu-list', 'admin\CampMenuController::deleteCampMenu');

$routes->get("camp-submenu", "admin\CampSubmenuController::campSubmenu");
$routes->post("insert-camping-submenu", "admin\CampSubmenuController::insertCampSubmenu");
$routes->post("get-camping-submenu", "admin\CampSubmenuController::getCampSubmenu");
$routes->post("update-camping-submenu", "admin\CampSubmenuController::updateCampSubmenu");
$routes->post("del-camping-submenu", "admin\CampSubmenuController::deleteCampSubmenu");


$routes->get("camp-product-list", "admin\CampProdController::campProducts");
$routes->post("gett-camping-submenu", "admin\CampProdController::getCampSubmenu");
$routes->post("insert-camp-products", "admin\CampProdController::insertCampProducts");
$routes->post("get-cproducts", "admin\CampProdController::getCampProducts");
$routes->post("update-camp-products", "admin\CampProdController::updateCampProducts");
$routes->post("delete-cproduct", "admin\CampProdController::deleteCampProducts");
$routes->get("export-camp-stock", "admin\CampProdController::exportCampProducts");


$routes->post("insert-config", "admin\ProductController::insertConfig");
$routes->get("get-config-details", "admin\ProductController::getConfigColor");
$routes->post("get-color", "admin\RproductController::getConfigColor");
$routes->post("get-size", "admin\RproductController::getConfigSize");
$routes->get("export-riding-stock", "admin\RproductController::exportStock");

//*************** cart List Start  ********************** */ 
$routes->get("cust-list", "admin\CustListController::custList");
$routes->post("get-custlist", "admin\CustListController::getcustList");
$routes->post("delete-custlist", "admin\CustListController::deletecustList");
//*************** cart List End   ********************** */


$routes->get("order-details", "admin\OrderListController::orderList");
$routes->post("get-order-list", "admin\OrderListController::getOrderList");
$routes->post("get-order-details", "admin\OrderListController::getOrderDetails");
$routes->post("get-cancelorder-details", "admin\OrderListController::getCancelOrderDetails");

$routes->post("delete-orderlist", "admin\OrderListController::deleteOrderDetails");
$routes->post("filter-orders", "admin\OrderListController::filterOrders");
$routes->post("check-payment-status", "admin\OrderListController::checkPayment");
$routes->get("pdf-viewpage/(:any)", "admin\OrderListController::pdfViewpage/$1");
$routes->get('print/pdf/(:num)', 'admin\OrderListController::printPdf/$1');
$routes->post('process-refund', 'admin\OrderListController::processRefund');
$routes->post('check-refundstatus', 'admin\OrderListController::checkRefundStatus');



$routes->get("payment-list", "admin\PaymentListController::paymentList");
$routes->post("get-payment-list", "admin\PaymentListController::getPaymentList");
$routes->post("delete-payment-list", "admin\PaymentListController::deletePaymentList");
$routes->post("filter-payment-list", "admin\PaymentListController::filterPaymentList");


$routes->post("get-trackingdetails", "admin\OrderListController::getTrackingDetails");
$routes->post("update-trackingdetail", "admin\OrderListController::updateTrackingDetails");
$routes->post("view-trackingdetail", "admin\OrderListController::viewTrackingDetails");
$routes->post("update-delivery-status", "admin\OrderListController::updateDeliveryStatus");
$routes->post("update-cancel-reason", "admin\OrderListController::updateCancelReason");
$routes->post("update-orderpending-status", "admin\OrderListController::updateOrderPendingStatus");

//*************** User Address   ********************** */ 
$routes->get('state-list', 'admin\AddressController::stateList');
$routes->post('insert-state', 'admin\AddressController::insertState');
$routes->post('update-state', 'admin\AddressController::updateState');
$routes->post('get-state-list', 'admin\AddressController::getState');
$routes->post('delete-state', 'admin\AddressController::deleteState');


$routes->get('district-list', 'admin\AddressController::district');
$routes->post('insert-district', 'admin\AddressController::insertDistrict');
$routes->post('get-dist-list', 'admin\AddressController::getDistrict');
$routes->post('update-district', 'admin\AddressController::updateDistrict');
$routes->post('delete-dist', 'admin\AddressController::deleteDistrict');

//*************** User Address   ********************** */ 
$routes->get('admin', 'admin\LoginController::login');
$routes->get('admin-logout', 'admin\LoginController::logout');

// $routes->group('', ['filter' => 'cors'], static function (RouteCollection $routes): void {

//     $routes->post('login-check', 'admin\LoginController::checkLogin');
// });,
$routes->post('login-check', 'admin\LoginController::checkLogin', ['filter' => 'cors']);
$routes->get('logout', 'admin\LoginController::logout');
$routes->get('dashboard', 'admin\AdventureController::index');

// new order
$routes->get("new-order", "admin\NewOrderController::newOrder");
$routes->post("get-neworder", "admin\NewOrderController::getNewOrder");

// Shipping Status
$routes->get("shipping-status", "admin\DashboardController::shippingstatus");
$routes->post("get-shipping-status", "admin\DashboardController::getshippingstatus");

// delivery status 
$routes->get("delivery-status", "admin\DashboardController::deliverystatus");
$routes->post("get-delivery-list", "admin\DashboardController::getDeliverystatus");
$routes->get("notification", "admin\DashboardController::notification");
$routes->get("refund-details", "admin\DashboardController::refundDetails");
$routes->post("get-refundetails", "admin\DashboardController::getrefundDetails");


// pending order details
$routes->get("pending-order", "admin\DashboardController::pendingOrder");
$routes->post("get-pending-order", "admin\DashboardController::getPendingOrder");

// Cancelled order details
$routes->get("cancel-orders", "admin\DashboardController::canceledOrder");
$routes->post("get-cancelled-order", "admin\DashboardController::getcancelledOrder");

// payment pending order details
$routes->get("order-pending", "admin\DashboardController::paymentPendingOrder");
$routes->post("get-order-pending", "admin\DashboardController::getOrderPending");

//*************** Courier-partners   ********************** */ 
$routes->get('courier-partners', 'admin\CourierController::courierPartner');
$routes->post('insert-courier', 'admin\CourierController::insertCourier');
$routes->post('get-courier', 'admin\CourierController::getCourier');
$routes->post('update-courier', 'admin\CourierController::updateCourier');
$routes->post('delete-courier', 'admin\CourierController::deleteCourier');

//*************** Courier-Charges  ********************** */
$routes->get('courier-charges', 'admin\CourierController::courierCharges');
$routes->post('get-distfilr', 'admin\CourierController::getDistfilr');
$routes->post('insert-charges', 'admin\CourierController::insertCharges');
$routes->post('get-charges', 'admin\CourierController::getCharges');
$routes->post('update-charges', 'admin\CourierController::updateCharges');
$routes->post('delete-charge', 'admin\CourierController::deleteCharges');

// Brand Module
$routes->get('brand-list', 'admin\BrandController::brandList');
$routes->post('insert-brandList', 'admin\BrandController::insertBrandList');
$routes->post('get-brandData', 'admin\BrandController::getBrandData');
$routes->post('update-brand-list', 'admin\BrandController::updateBrandList');
$routes->post('delete-brand-list', 'admin\BrandController::deleteBrandList');

// Model Module
$routes->get('modal-list', 'admin\ModalController::modalList');
$routes->post('insert-modal-list', 'admin\ModalController::insertModalList');
$routes->post('get-modal-data', 'admin\ModalController::getModalDetails');
$routes->post('update-modal-list', 'admin\ModalController::updateModalDetails');
$routes->post('delete-modal-list', 'admin\ModalController::deleteModalDetails');

// Accessories Module
$routes->get('accessories', 'admin\AccessController::Accessories');
$routes->post('insert-access-list', 'admin\AccessController::insertAccessories');
$routes->post('get-access-data', 'admin\AccessController::getAccessories');
$routes->post('update-access-list', 'admin\AccessController::updateAccessories');
$routes->post('delete-access-title', 'admin\AccessController::deleteAccessories');

// Sub-Accessories Module
$routes->get('sub-accessories', 'admin\SubAccessController::subAccessories');
$routes->post('insert-sub-accessories', 'admin\SubAccessController::insertSubAccessories');
$routes->post('get-sub-accessories', 'admin\SubAccessController::getSubAccessories');
$routes->post('update-sub-accessories', 'admin\SubAccessController::updateSubAccessories');
$routes->post('delete-sub-accessories', 'admin\SubAccessController::deleteSubAccessories');

// Navbar
$routes->get('navbar', 'admin\NavController::navbar');
$routes->post('insert-navbar', 'admin\NavController::insertNavbar');
$routes->post('get-nav-data', 'admin\NavController::getNavbar');
$routes->post('update-navbar', 'admin\NavController::updateNavbar');
$routes->post('delete-navbar', 'admin\NavController::deleteNavbar');


//Sub Navbar
$routes->get('subnavbar', 'admin\SubnavController::subNavbar');
$routes->post('insert-subnavbar', 'admin\SubnavController::insertSubnavbar');
$routes->post('get-subnavbar', 'admin\SubnavController::getSubnavbar');
$routes->post('update-subnavbar', 'admin\SubnavController::updateSubnavbar');
$routes->post('delete-subnavbar', 'admin\SubnavController::deleteSubnavbar');

// Submenu
$routes->get('submenu', 'admin\SubmenuController::subMenu');
$routes->post('insert-submenu', 'admin\SubmenuController::insertSubmenu');
$routes->post('get-submenu', 'admin\SubmenuController::getSubmenu');
$routes->post('update-submenu', 'admin\SubmenuController::updateSubmenu');
$routes->post('delete-submenu', 'admin\SubmenuController::deleteSubmenu');

// Main Products
$routes->get('add-products', 'admin\ProductController::addProducts');
$routes->post('insert-product', 'admin\ProductController::insertProducts');
$routes->post('get-product-details', 'admin\ProductController::getProducts');
$routes->post('update-product', 'admin\ProductController::updateProducts');
$routes->post('delete-product', 'admin\ProductController::deleteProducts');
// Filter Modal names
$routes->post('get-modal', 'admin\ProductController::getModalName');



// Accessories List
$routes->get('accessories-list', 'admin\AccessListController::accessList');
$routes->post('insert-product-list', 'admin\AccessListController::insertProducts');
$routes->post('get-product-list', 'admin\AccessListController::getProductList');
$routes->post('update-product-list', 'admin\AccessListController::updateProductList');
$routes->post('delete-product-list', 'admin\AccessListController::deleteProductList');
$routes->get('export-accessory-stock', 'admin\AccessListController::exportStockList');
$routes->get('export-outof-stock', 'admin\AccessListController::exportOutofStockList');

$routes->get('get-shop-brands', 'admin\AccessListController::getShopBrands');
$routes->post('get-shop-modals', 'admin\AccessListController::getShopModals');


// Filter SubAccessories 
$routes->post('get-sub-access', 'admin\AccessListController::getSubAccess');



// Riding Gears
$routes->get('main-menu-list', 'admin\RidingMenuController::ridingMenu');
$routes->post('insert-menu-list', 'admin\RidingMenuController::insertMenu');
$routes->post('get-menu-list', 'admin\RidingMenuController::getMenu');
$routes->post('update-menu-list', 'admin\RidingMenuController::updateMenuList');
$routes->post('delete-menu-list', 'admin\RidingMenuController::deleteMenuList');


$routes->get('sub-menu-list', 'admin\RsubMenuController::rSubMenu');
$routes->post('insert-submenu-list', 'admin\RsubMenuController::insertSubMenu');
$routes->post('get-submenu-list', 'admin\RsubMenuController::getSubMenu');
$routes->post('update-submenu-list', 'admin\RsubMenuController::updateSubMenu');
$routes->post('delete-submenu-list', 'admin\RsubMenuController::deleteSubMenu');

$routes->get('riding-product-list', 'admin\RproductController::productList');
$routes->post('insert-rproduct-list', 'admin\RproductController::insertProductList');
$routes->post('update-rproduct-list', 'admin\RproductController::updateProductList');
$routes->post('get-rproduct-list', 'admin\RproductController::getProductList');
$routes->post('delete-rproduct-list', 'admin\RproductController::deleteProductList');
$routes->post('get-offerprice', 'admin\RproductController::getOfferprice');

// Filter SubMenu
$routes->post('get-rsubmenu', 'admin\RproductController::getSubmenu');


// Luggage & Touring
$routes->get('luggage_menu', 'admin\LuggageController::LuggageMenu');
$routes->post('insert-lmenu-list', 'admin\LuggageController::insertLuggageMenu');
$routes->post('get-lmenu-list', 'admin\LuggageController::getLuggageMenu');
$routes->post('update-lmenu-list', 'admin\LuggageController::updateLuggageMenu');
$routes->post('delete-Lmenu-list', 'admin\LuggageController::deleteLuggageMenu');

$routes->get('luggage_submenu', 'admin\LsubController::LuggagesubMenu');
$routes->post('insert-luggage-submenu', 'admin\LsubController::insertsubMenu');
$routes->post('get-luggage_submenu', 'admin\LsubController::getlugsubMenu');
$routes->post('update-luggage-submenu', 'admin\LsubController::updatesubMenu');
$routes->post('del-luggage-submenu', 'admin\LsubController::delsubMenu');

$routes->get('luggage_product-list', 'admin\LproductController::productList');
$routes->post('get-lug-submenu', 'admin\LproductController::getsubmenu');
$routes->post('insert-lug-product', 'admin\LproductController::insertProduct');
$routes->post('get-luggage', 'admin\LproductController::getProduct');
$routes->post('update-lug-product', 'admin\LproductController::updateProduct');
$routes->post('delete-lug-product', 'admin\LproductController::deleteProduct');
$routes->get('export-luggage-stock', 'admin\LproductController::exportLuggageStock');



// Helmet and Accessories
$routes->get('helmet_menu', 'admin\HelmetController::helmetMenu');
$routes->post('insert-hmenu-list', 'admin\HelmetController::insertMenu');
$routes->post('update-hmenu-list', 'admin\HelmetController::updateMenu');
$routes->post('get-hmenu', 'admin\HelmetController::getMenu');
$routes->post('delete-hmenu', 'admin\HelmetController::deleteMenu');

$routes->get('helmet_submenu', 'admin\HsubmenuController::subMenu');
$routes->post('insert-helmet-submenu', 'admin\HsubmenuController::insertsubMenu');
$routes->post('get-helmet-submenu', 'admin\HsubmenuController::getsubMenu');
$routes->post('update-helmet-submenu', 'admin\HsubmenuController::updatesubMenu');
$routes->post('del-helmet-submenu', 'admin\HsubmenuController::deletesubMenu');

$routes->get('helmet-product-list', 'admin\HproductController::productList');
$routes->post('get-helmet-list', 'admin\HproductController::getSubmenuList');
$routes->post('insert-helmet-products', 'admin\HproductController::insertproductList');
$routes->post('get-hproducts', 'admin\HproductController::getproductList');
$routes->post('update-helmet-products', 'admin\HproductController::updateproductList');
$routes->post('delete-hproduct', 'admin\HproductController::deleteproductList');
$routes->get('export-helmet-stock', 'admin\HproductController::exportHelmetStock');

// Combos
$routes->get('combo-products-list', 'admin\ComboProdController::productList');
$routes->post('insert-combo-products', 'admin\ComboProdController::insertProduct');
$routes->post('get-combo-products', 'admin\ComboProdController::getproduct');
$routes->post('update-combo-products', 'admin\ComboProdController::updateProduct');
$routes->post('delete-combo-product', 'admin\ComboProdController::deleteProduct');


// activation menu's & Submenu's
$routes->post('deactivate-menu', 'admin\DashboardController::deactivateMenu');
$routes->post('deactivate-submenu', 'admin\DashboardController::deactivateSubMenu');










