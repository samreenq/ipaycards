<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Services API Routes
Route::group([
	'middleware' => 'api.auth',
	'namespace' => 'Api\Service',
	'prefix' => 'api/service/'
], function () {
	/**
	 * Topup
	 */
	Route::get('topup/balance', 'TopupController@balance');
	Route::get('topup/send', 'TopupController@send');
	Route::get('topup/products', 'TopupController@products');
	
	
	/**
	 * Card
	 */
	Route::get('card/categories', 'CardController@categories');
	Route::get('card/brands', 'CardController@brands');
	Route::get('card/denominations', 'CardController@denominations');
	Route::get('card/balance', 'CardController@balance');
	Route::get('card/orders', 'CardController@orders');
	Route::post('card/order', 'CardController@postOrder');
	Route::get('card/check_availability', 'CardController@checkAvailability');
	Route::post('card/reserve', 'CardController@reserve');
	Route::post('card/purchase', 'CardController@purchase');
	Route::get('card/get_order', 'CardController@getOrder');
	
	/**
	 * Payment
	 */
	Route::get('payment/balance', 'PaymentController@balance');
	Route::post('payment/customer', 'PaymentController@postCustomer');
	Route::get('payment/customer', 'PaymentController@getCustomer');
	Route::post('payment/card_token', 'PaymentController@postCardToken');
	Route::post('payment/bank_token', 'PaymentController@postBankToken');
	Route::get('payment/token', 'PaymentController@getToken');
	Route::post('payment/charge', 'PaymentController@postCharge');
	Route::get('payment/charge', 'PaymentController@getCharge');
	Route::post('payment/reserve', 'PaymentController@postReserve');
	
	
});