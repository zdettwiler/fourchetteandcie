<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

 // HOME
Route::get('', 'HomeController@index');

// ABOUT US
// Route::get('/about-us', 'HomeController@about_us');

// HANDSTAMPED SILVERWARE / CUTLERY
Route::get('/handstamped-silverware', 'CutleryController@index');
Route::get('/handstamped-silverware/item/{ref}', 'CutleryController@show_item');
Route::get('/handstamped-silverware/category/{categ}', 'CutleryController@show_categ');
Route::get('/handstamped-silverware/looking-after-your-handstamped-cutlery', 'CutleryController@look_after_cutlery');

// CAKE STANDS
Route::get('/cake-stand', 'CakeStandController@index');

// BASKET
Route::get('/basket', 'BasketController@index');
Route::get('/basket/{command}-{ref?}-{qty?}', 'BasketController@basket_command');

// CHECKOUT
Route::get('/checkout', 'CheckoutController@index');
Route::get('/checkout/shipping', 'CheckoutController@shipping');
Route::post('/checkout/{order_token}/shipping/confirm', 'CheckoutController@confirm');
Route::get('/checkout/{order_token}/shipping/confirm/place', 'CheckoutController@place');
Route::get('/checkout/{order_token}/shipping/confirm/placed/', 'CheckoutController@place');
Route::get('/checkout/{order_token}/shipping/confirm/placed/payment', 'CheckoutController@payment');
Route::get('/checkout/{order_token}/shipping/confirm/placed/payment/init', 'CheckoutController@init_payment');
Route::get('/checkout/{order_token}/shipping/confirm/placed/payment/pay', 'CheckoutController@make_payment');
Route::get('/checkout/{order_token}/shipping/confirm/placed/payment/thanks', 'CheckoutController@thanks');

// Search Engine
Route::get('/search/{query}', 'HomeController@search_query');

//
Route::get('/invoice/{order_token}', 'HomeController@invoice');

//-------------------------------------------- ADMIN --------------------------------------------//
// Login
Route::get('/admin', ['middleware' => 'auth','uses' => 'AdminController@index']);
Route::get('/admin/login', 'AdminController@login');
Route::post('/admin/login', 'AdminController@post_login');

// Items Management
Route::get('/admin/items', 'AdminItemsController@all_items');
Route::get('/admin/items/pdf', 'AdminItemsController@all_items_pdf');

Route::get('/admin/items/add', 'AdminItemsController@add_item');
Route::post('/admin/items/add', 'AdminItemsController@post_add_item');

Route::get('/admin/items/edit/{ref}', 'AdminItemsController@edit_item');
Route::post('/admin/items/edit/{ref}', 'AdminItemsController@post_edit_item');
Route::get('/admin/items/quick-edit/{command}-{ref}-{value?}', 'AdminItemsController@quick_item_edit_command');

// Orders Management
Route::get('/admin/orders', 'AdminOrdersController@all_orders');
Route::get('/admin/orders/{id}', 'AdminOrdersController@one_order');
Route::get('/admin/orders/{id}/invoice', 'AdminOrdersController@show_pdf_invoice');
Route::get('/admin/orders/{id}/validate', 'AdminOrdersController@validate_order');
Route::get('/admin/orders/{id}/validate/submit', 'AdminOrdersController@submit_validated_order');
Route::get('/admin/orders/{id}/validate/{command}-{ref?}-{value?}', 'AdminOrdersController@validate_order_command');
// Route::get('/admin/emails', 'HomeController@emails');
