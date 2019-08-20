<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/backend', function () {
    return redirect('backend/login');
});

//Route::any('/', 'IndexController@index');


Route::get('home', 'HomeController@index');
// - under development
//Route::match(array('get', 'post'),DIR_API.'user/reportdp', rtrim(ucfirst(DIR_API), '/').'\Index@ud');

// Index routes
Route::get('confirm_signup', 'IndexController@confirm_signup');
Route::any('confirm_forgot', 'IndexController@confirm_forgot');
// page
Route::any('page/terms', 'PageController@terms');
Route::any('page/privacy', 'PageController@privacy');
Route::any('page/faq', 'PageController@faq');
Route::any('page/about', 'PageController@about');
// user
Route::any('/@{username}', 'UserController@webProfile');
Route::get('user/removeWebUsername', 'IndexController@removeWebUsername');
// Check (CSRF protected)
Route::get('check/admin_auth', 'CheckController@adminAuth');


// Test
Route::get('test/', 'IndexController@test');
Route::post('test/background_task', 'IndexController@testBackgroundTask');

// Cache
Route::get('cache/clear', 'IndexController@clearCache');
// multi uploader
Route::any('ajax/multi_uploader', 'IndexController@multiUploader');

// Open Graph
Route::any('og/share', 'OpenGraphController@share');

// Flurry
Route::any('flurry/pull_analytics', 'FlurryController@pullAnalyticsData');

// Administrator : Q&A : Content
Route::any(DIR_ADMIN . 'qa_content/', rtrim(ucfirst(DIR_ADMIN), '/') . '\QAContentController@index');
Route::any(DIR_ADMIN . 'qa_content/ajax/listing', rtrim(ucfirst(DIR_ADMIN), '/') . '\QAContentController@ajaxListing');
Route::any(DIR_ADMIN . 'qa_content/add', rtrim(ucfirst(DIR_ADMIN), '/') . '\QAContentController@add');
Route::any(DIR_ADMIN . 'qa_content/update/{id}', rtrim(ucfirst(DIR_ADMIN), '/') . '\QAContentController@update');
Route::any(DIR_ADMIN . 'qa_content/image_browser', rtrim(ucfirst(DIR_ADMIN), '/') . '\QAContentController@imageBrowser');
// Administrator : Queue Upload
Route::any(DIR_ADMIN . 'qa_content/queue_upload', rtrim(ucfirst(DIR_ADMIN), '/') . '\QAContentController@queueUpload');

// Administrator : Q&A : Tag
Route::any(DIR_ADMIN . 'tag/', rtrim(ucfirst(DIR_ADMIN), '/') . '\TagController@index');
Route::any(DIR_ADMIN . 'tag/ajax/listing', rtrim(ucfirst(DIR_ADMIN), '/') . '\TagController@ajaxListing');
Route::any(DIR_ADMIN . 'tag/add', rtrim(ucfirst(DIR_ADMIN), '/') . '\TagController@add');
Route::any(DIR_ADMIN . 'tag/update/{id}', rtrim(ucfirst(DIR_ADMIN), '/') . '\TagController@update');
Route::any(DIR_ADMIN . 'tag/image_browser', rtrim(ucfirst(DIR_ADMIN), '/') . '\TagController@imageBrowser');
// Administrator : Queue UploadTagController@imageBrowser
Route::any(DIR_ADMIN . 'tag/queue_upload', rtrim(ucfirst(DIR_ADMIN), '/') . '\TagController@queueUpload');

// Administrator : Q&A : Bag
Route::any(DIR_ADMIN . 'bag/', rtrim(ucfirst(DIR_ADMIN), '/') . '\BagController@index');
Route::any(DIR_ADMIN . 'bag/ajax/listing', rtrim(ucfirst(DIR_ADMIN), '/') . '\BagController@ajaxListing');
Route::any(DIR_ADMIN . 'bag/add', rtrim(ucfirst(DIR_ADMIN), '/') . '\BagController@add');
Route::any(DIR_ADMIN . 'bag/update/{id}', rtrim(ucfirst(DIR_ADMIN), '/') . '\BagController@update');
Route::any(DIR_ADMIN . 'bag/image_browser', rtrim(ucfirst(DIR_ADMIN), '/') . '\BagController@imageBrowser');
// Administrator : Queue Upload
Route::any(DIR_ADMIN . 'bag/queue_upload', rtrim(ucfirst(DIR_ADMIN), '/') . '\BagController@queueUpload');

//General Routes
$general_panel_dir = str_replace("/", '\\',ucwords(config("panel.DIR")));
Route::any('getoptions', $general_panel_dir . 'EntityAjaxController@getoptions');
Route::any('getItemData', $general_panel_dir . 'EntityAjaxController@getItemData');
Route::any('getRoleOptions', $general_panel_dir . 'EntityAjaxController@getRoleOptions');

Route::any('getOrderCart', $general_panel_dir . 'EntityAjaxController@getOrderCart');

//Dashboard Widgets routes
Route::any('totalCountStats', $general_panel_dir . 'EntityAjaxController@totalCountStats');
Route::any('totalSalesChart', $general_panel_dir . 'EntityAjaxController@totalSalesChart');
Route::any('topProductChart', $general_panel_dir . 'EntityAjaxController@topProductChart');
Route::any('orderByProductType', $general_panel_dir . 'EntityAjaxController@totalOrderByProductType');
Route::any('getListWidgets', $general_panel_dir . 'EntityAjaxController@getListWidgets');
Route::any('topDriver', $general_panel_dir . 'EntityAjaxController@topDriverChart');
Route::any('topCustomerChart', $general_panel_dir . 'EntityAjaxController@topCustomerChart');
Route::any('topCustomerList', $general_panel_dir . 'EntityAjaxController@topCustomerList');
Route::any('topDriverList', $general_panel_dir . 'EntityAjaxController@topDriverList');
Route::any('activePromotion', $general_panel_dir . 'EntityAjaxController@activePromotion');
Route::any('activeCoupon', $general_panel_dir . 'EntityAjaxController@activeCoupon');
Route::any('topDeliverySlot', $general_panel_dir . 'EntityAjaxController@topDeliverySlots');
Route::any('topCity', $general_panel_dir . 'EntityAjaxController@topCity');
Route::any('peakOrderTime', $general_panel_dir . 'EntityAjaxController@peakOrderTime');
Route::any('getProductsByType', $general_panel_dir . 'EntityAjaxController@getProductsByType');
Route::any('getTopProducts', $general_panel_dir . 'EntityAjaxController@getTopProducts');

Route::get('getDeliverySlot', $general_panel_dir . 'EntityAjaxController@getDeliverySlot');

//Syetem Notification routes
Route::any('countNotification', $general_panel_dir . 'EntityNotificationController@countNotification');
Route::any('listNotification', $general_panel_dir . 'EntityNotificationController@listNotification');

//cron services routes
$cron_dir = str_replace("/", '\\',ucwords(DIR_CRON));
Route::any('applyPromotion', $cron_dir . 'PromotionController@apply');
Route::any('clearCoupon', $cron_dir . 'CouponController@clearCoupon');

$data_cron_dir = str_replace("/", '\\',ucwords('DataScript/'));
Route::any('clearData', $data_cron_dir . 'DataScriptController@clearData');
Route::any('updateProductCount', $data_cron_dir . 'DataScriptController@updateProductCount');
Route::any('compressImages', $data_cron_dir . 'DataScriptController@compressImages');
Route::any('update_data', $data_cron_dir . 'DataScriptController@updateDate');
Route::any('clearSystemEntity', $data_cron_dir . 'DataScriptController@clearSystemEntity');
Route::any('assign_order', $cron_dir . 'OrderController@assignOrder');
Route::any('auto_decline', $cron_dir . 'OrderController@autoDecline');
Route::any('order_process', $cron_dir . 'OrderController@processOrder');

//Rite Hauler Routes
Route::get('getCityByState', $general_panel_dir . 'EntityAjaxController@getCityByState');
Route::any('getDeliveryProfessional', $general_panel_dir . 'EntityAjaxController@getDeliveryProfessional');
Route::any('getTruckInfo', $general_panel_dir . 'EntityAjaxController@getTrucksById');
Route::any('getTruckList', $general_panel_dir . 'EntityAjaxController@getTruckListByVol');
Route::any('getOrderStatus', $general_panel_dir . 'EntityAjaxController@getOrderStatus');
Route::any('updateOrderStatus', $general_panel_dir . 'EntityAjaxController@updateOrderStatus');
Route::get('getDriverVehicle', $general_panel_dir . 'EntityAjaxController@getVehicleInfo');
Route::get('getDriverLocation', $general_panel_dir . 'EntityAjaxController@getDriverLocation');
Route::get('order_calendar', $general_panel_dir . 'EntityAjaxController@getOrderCalendar');
Route::get('order_calendar_content', $general_panel_dir . 'EntityAjaxController@getOrderCalendarContent');

//Share url
Route::get('share/{slug}/{id}','OpenGraphController@shareView');

/////////////Website Routes///////////////////////////

Route::group(['middleware' => ['web']], function () {
Route::get('/webpay/bridge', "Web\PaymentController@bridgepage")->name('bridgepage');
Route::post('/webpay/response', "Web\PaymentController@webpayResponse")->name('webpay_response');
Route::get('/process', "Web\PaymentController@processPaymentData")->name('process_payment');


//Route::group(['middleware' => ['fb.auth']], function () {


Route::get('/aboutBusiness', "Web\AboutBusinessController@aboutBusiness")->name('aboutBusiness');
Route::post('/forgotPassword', "Web\AuthenticationController@forgotPassword")->name('forgotPassword');
Route::get('/signin', "Web\AuthenticationController@signin")->name('signin');
Route::get('/signin_step1', "Web\AuthenticationController@signin_step1")->name('signin_step1');
Route::get('/signout', "Web\AuthenticationController@signout")->name('signout');
Route::post('/signup', "Web\AuthenticationController@signup")->name('signup');
Route::post('/verification', "Web\AuthenticationController@phoneVerfication")->name('phoneVerification');
Route::post('/resend', "Web\AuthenticationController@resendCode")->name('resendCode');
Route::get('/send', "Web\AuthenticationController@sendCode")->name('sendCode');
Route::get('/social/verification', "Web\AuthenticationController@socialPhoneVerfication")->name('socialPhoneVerfication');

Route::get('/fsignup', "Web\AuthenticationController@facebookSignup")->name('fsignup');
Route::get('/fbSignout', "Web\AuthenticationController@facebookSignOut")->name('fbSignout');
Route::post('/validateSignUp', "Web\AuthenticationController@validateBasicAuth")->name('validateSignUp');



Route::get('/guest/deal', "Web\ChefController@getGuestChefDeals")->name('guest_chef_deals_list');
Route::get('/top/deal', "Web\ChefController@getTopChefDeals")->name('top_chef_deals_list');
Route::get('/chef/list', "Web\ChefController@getGuestChefDeals")->name('recipe_list');
Route::get('/chef', "Web\ChefController@getRecipeByChef")->name('chef');
Route::get('/recipe/list', "Web\ChefController@getAllRecipes")->name('recipe_list');
Route::get('/recipe_detail', "Web\ChefController@getRecipeByCode")->name('recipe_detail');
Route::get('/review/save', "Web\ChefController@saveReview")->name('review');

Route::get('/cron', "Web\CronController@cron")->name('cron1');

Route::get('/frequentAskedQuestions', "Web\FaqController@frequentAskedQuestions")->name('frequentAskedQuestions');
Route::get('/termAndCondition', "Web\FaqController@termAndCondition")->name('termAndCondition');

Route::get('/saveorder', "Web\OrderController@saveOrder")->name('saveorder');
Route::post('/confirmation', "Web\OrderController@confirmation")->name('confirmation');
Route::post('/checkout_order', "Web\OrderController@checkoutOrder")->name('checkout_order');

    Route::get('/cart/get', "Web\ProductController@getCart")->name('get_cart');
Route::get('/cart/add', "Web\ProductController@addToCart")->name('add_to_cart');
Route::any('/wishlist/add', "Web\ProductController@addToWishlist")->name('add_to_wishlist');
Route::get('/wishlist/delete', "Web\ProductController@DeleteToWishlist")->name('delete_to_wishlist');
Route::get('/cart/show', "Web\ProductController@showCart")->name('show_cart');
Route::get('/total_price', "Web\ProductController@totalPrice")->name('total_price');
Route::get('/order/save', "Web\ProductController@saveOrder")->name('save_order');
Route::get('/product/list', "Web\ProductController@getAllProducts")->name('product_list');
Route::get('/essentials', "Web\ProductController@todayTodayEssentials")->name('essentials');
Route::get('/news/Seasons', "Web\ProductController@newsAndPeakSeasons")->name('newsAndPeakSeasons');
    Route::get('/get_brands', "Web\ProductController@getBrands")->name('getBrands');
Route::get('/product/title', "Web\ProductController@getAllProductsByTitle")->name('product_title');
Route::get('/product_detail', "Web\ProductController@getProductByCode")->name('product_detail');
Route::get('/product_categories', "Web\ProductController@getAllProduct")->name('product_categories');
Route::get('/popular/categories', "Web\ProductController@popularCategories")->name('popularCategories');
Route::get('/menus', "Web\ProductController@menus")->name('menus');
Route::get('/categories', "Web\ProductController@categories")->name('categories');
Route::get('/product', "Web\ProductController@getAllProduct")->name('product');
Route::get('/product/promotion', "Web\ProductController@getAllPromotionProducts")->name('product_promotion');
Route::get('/product/feature', "Web\ProductController@getAllFeatureProducts")->name('featured_type');
    Route::get('/product/brand', "Web\ProductController@getBrandProducts")->name('brand_products');


/*    Topup Web*/

    Route::any('/topup/du', "Web\TopupsController@du")->name('du');
    Route::any('/topup/etisalat', "Web\TopupsController@etisalat")->name('etisalat');
    Route::any('/fly_dubai', "Web\TopupsController@flyDubai")->name('fly_dubai');
    Route::any('/addc', "Web\TopupsController@addc")->name('addc');
    Route::any('/topup/checkout', "Web\TopupsController@checkout")->name('topup_checkout');
    Route::any('/topup/send', "Web\TopupsController@sendTopup")->name('send_topup');
    Route::any('/service_topup/send', "Web\TopupsController@sendServiceTopup")->name('send_service_topup');



Route::get('/recipe/list', "Web\RecipeController@getAllRecipes")->name('recipe_all_list');
Route::get('/recipe', "Web\RecipeController@showAllRecipe")->name('recipe');

Route::get('/testimonial', "Web\TestimonialController@getTestimonial")->name('testimonial');
    Route::get('/main_category', "Web\ProductController@getMainCategory")->name('main_category');
Route::get('/promotion', "Web\PromotionAndDiscountController@getPromotionAndDiscount")->name('promotionAndDiscount');
    Route::get('/top_category_products', "Web\ProductController@topCategotyProducts")->name('top_category_products');

    Route::get('/brand', "Web\ProductController@getAllBrands")->name('brand');
    Route::get('/product/all_brand', "Web\ProductController@getBrandsAll")->name('all_brand');


Route::get('dashboard', function () {
    return View::make('web/dashboard');
});
/*
Route::get('/', function () {
    return View::make('web/main');
})->name('main');
*/
Route::get('/', "Web\AuthenticationController@main")->name('main');


/* Route::get('/logout', function () {
     return View::make('web/logout');
 })->name('logout');*/

Route::get('/logout', "Web\AuthenticationController@signout")->name('logout');

Route::get('/mobileapp', "Web\FaqController@mobileapp")->name('mobileapp');
/*   Route::get('/mobileapp', function () {
       return View::make('web/mobileapp');
   })->name('mobileapp');*/

/*  Route::get('/faq', function () {
      return View::make('web/faq');
  })->name('faq');*/

//Route::get('/faq', "Web\FaqController@index")->name('faq');

/*    Route::get('/term_and_condition', function () {
        return View::make('web/term_and_condition');
    })->name('term_and_condition');*/


//});


Route::post('/facebookLogin', "Web\AuthenticationController@facebookLogin")->name('facebookLogin');
    Route::post('/gmailLogin', "Web\AuthenticationController@gmailLogin")->name('gmailLogin');
Route::get('/faq', "Web\FaqController@index")->name('faq');
Route::get('/cms/{slug}', "Web\FaqController@cms")->name('cms');
});
Route::group(['middleware' => ['web.auth']], function () {


    Route::get('/address_book', "Web\AccountController@getAddressBook")->name('address_book');
    Route::get('/getOrderDetail', "Web\AccountController@getOrderDetail")->name('get_order_detail');
    Route::get('/getOrderReview', "Web\AccountController@getOrderReview")->name('get_order_review_detail');
    Route::get('/order_history', "Web\AccountController@orderHistory")->name('order_history');
    /*    Route::get('/order_history', function () {
            return View::make('web/order_history');
        })->name('order_history');*/

    Route::get('/order_history_list', "Web\AccountController@getOrderHistory")->name('order_history_list');


    Route::get('/your_account', "Web\AccountController@getAccountDetail")->name('account_detail');
    Route::get('/account/update', "Web\AccountController@changeAccountDetail")->name('change_your_account_detail');
    Route::get('/account/change', "Web\AccountController@changeAccountPassword")->name('change_your_account_password');
    Route::get('/account/payment_method', "Web\AccountController@changePaymentMethodType")->name('change_your_account_payment_method');
    Route::get('/payment', "Web\AccountController@getPaymentDetail")->name('payment');
    Route::post('/address/save', "Web\AccountController@saveAddress")->name('save_address');
    Route::get('/account/wallet_default', "Web\AccountController@updateWalletDefault")->name('wallet_default');

    Route::get('/refer', "Web\ReferAFriendController@referAFriend")->name('refer_a_friend');


    Route::get('/checkout1', "Web\CheckOutController@checkout1")->name('checkout1');
    Route::get('/checkout2', "Web\CheckOutController@checkout2")->name('checkout2');



    Route::get('/discount', "Web\CheckOutController@discountCalculation")->name('discount');
    Route::get('/checkout', "Web\CheckOutController@checkout")->name('checkout');
    Route::get('/time', "Web\CheckOutController@getAllTimeSlots")->name('delivery_slot');
    Route::get('/checkout3', "Web\CheckOutController@checkoutCart");
    Route::get('/checkout4', "Web\CheckOutController@checkoutOrder")->name('checkout4');

    /*    Route::get('/checkout3', function () {
            return View::make('web/checkout3');
        })->name('checkout3');
        Route::get('/checkout4', function () {
            return View::make('web/checkout4');
        })->name('checkout4');*/


    Route::get('/wallet', "Web\WalletController@ShowWallet")->name('customer_wallet');//customer_transactions
    Route::get('/gift_card', "Web\WalletController@redeemGift")->name('gift_card');//customer_transactions
    Route::get('/wallet_list', "Web\WalletController@getAllCustomerTransactions")->name('customer_wallet_list');//customer_transactions
    Route::post('/redeem_card', "Web\WalletController@redeemCard")->name('redeem_card');//customer_transactions
    Route::post('/updateCart', "Web\CheckOutController@updateCart")->name('updateCart');
   // Route::post('/get_session', "Web\PaymentController@getSessionID")->name('get_session');
    Route::get('/payment_page', "Web\PaymentController@paymentPage")->name('payment_page');
});

Route::get('/chat', "Web\AboutBusinessController@chat")->name('zendesk_chat');
///

// - thumbnail
Route::get('/thumb/{path}/{size}/{name}/{thumb}', function ($path = NULL, $size = NULL, $name = NULL, $thumb = null) {
    if (!is_null($path) && !is_null($size) && !is_null($name)) {
        $path = base64_decode($path);
        $size = explode('x', $size);
        $cache_image = Image::cache(function ($image) use ($path, $size, $name, $thumb) {
            $thumb = !$thumb ? $name : $thumb;
            //return $image->make(url("/".$path.$name))->resize($size[0], $size[1]);
            return $image->make(\URL::to($path .$name))->fit($size[0])->save($path.$thumb);
        }, 10); // cache for 10 minutes
        return Response::make($cache_image, 200, array('Content-Type' => 'image'));
    } else {
        abort(404);
    }
});

// - mask
Route::get('/mask/{entity}/{type}/{name}', function ($entity = NULL, $type = NULL, $name = NULL) {
    if (!is_null($entity) && !is_null($type) && !is_null($name)) {

        /*
        * PHP GD
        * adding watermark to an image with GD library
        */
        //$path = $entity == "user" ? getcwd()."/".DIR_USER_IMG : $_SERVER['DOCUMENT_ROOT']."/".DIR_DISH;
        $path = getcwd() . "/" . DIR_RAW_FILES;
        //$path = $entity == "user" ? $_SERVER['DOCUMENT_ROOT']."/".DIR_USER_IMG : $_SERVER['DOCUMENT_ROOT']."/".DIR_DISH;
        if (file_exists($path . "wm-" . $name)) {
            header('Content-type: image/png');
            $img_data = file_get_contents($path . "wm-" . $name);
            echo $img_data;
            return;
        } else {
            $watermark_img = $type . ".png";

            // Load the watermark and the photo to apply the watermark to
            $stamp = imagecreatefrompng(getcwd() . "/" . DIR_WATERMARK . $watermark_img);
            //$stamp = imagecreatefrompng($_SERVER['DOCUMENT_ROOT']."/".DIR_WATERMARK.$watermark_img);
            $im = imagecreatefromjpeg($path . $name);

            // Set the margins for the stamp and get the height/width of the stamp image
            $wm_img = getimagesize(getcwd() . "/" . DIR_WATERMARK . $watermark_img);
            //$wm_img = getimagesize($_SERVER['DOCUMENT_ROOT']."/".DIR_WATERMARK.$watermark_img);
            $main_img = getimagesize($path . $name);
            //var_dump($wm_img); exit;
            //$marge_right = 10;
            //$marge_bottom = 10;
            $marge_right = ($main_img[0] / 2) - ($wm_img[0] / 2);
            $marge_bottom = ($main_img[1] / 2) - ($wm_img[1] / 2);
            $sx = imagesx($stamp);
            $sy = imagesy($stamp);

            // Copy the stamp image onto our photo using the margin offsets and the photo
            // width to calculate positioning of the stamp.
            imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));

            // Output and free memory
            ob_start();
            header('Content-type: image/png');
            imagejpeg($im);
            $img_data = ob_get_clean();
            imagedestroy($im);
            // save into file
            echo $img_data;
            @file_put_contents($path . "wm-" . $name, $img_data);
            return;
        }
    } else {
        abort(404);
    }
});


/*
|--------------------------------------------------------------------------
| Include all Routes
|--------------------------------------------------------------------------
|
| Here we include all php files that exists in Routes directory
|
*/
$dir = __DIR__ . "/";
$files = scandir($dir);
if ($files) {
    foreach ($files as $file) {
        if (preg_match("@(\.php)$@", $file)) {
            include_once($dir . $file);
        }
    }
}

//Route::any('entities/other_item/updateOtherItem', $ctrl_dir . 'EntityBackController@updateOtherItemStatus');

