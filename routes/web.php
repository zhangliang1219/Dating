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

//Frontend Route
Route::get('/', function () {
    return view('auth.login');
});
Route::get('/login', function () {
    return view('auth.login');
});
Route::get('/home', 'HomeController@index')->name('home');

Route::post('user-register', 'UserController@register')->name('front-register');
Route::get('/confirm-account/{userId}', 'UserController@confirmAccount')->name('confirm-account');
Route::get('/login/{provider}', 'UserController@redirectToProvider')->name('redirectToProvider');
Route::get('/login/{provider}/callback','UserController@handleProviderCallback');





//Backend Route
Route::group(['before' => 'auth','prefix' => 'admin'], function(){
    Route::get('/', 'Admin\UserController@loginView')->name('loginView');
    Route::get('login', 'Admin\UserController@loginView')->name('loginView');
    Route::post('login', 'Admin\UserController@login')->name('adminLogin');
    Route::get('dashboard', 'Admin\DashboardController@index')->name('adminDashboard');
    Route::get('logout','Admin\UserController@logout')->name('adminLogout');
    
    //User Management
    Route::match(['get','post'],'user', 'Admin\UserController@userListing')->name('userListing');
    Route::delete('user/delete','Admin\UserController@deleteUser')->name('deleteUser');
    Route::get('user/edit/{id}','Admin\UserController@editUser');
    Route::post('user/update/{id}','Admin\UserController@updateUser')->name('updateUser');
    
    //Advertise Management
    Route::match(['get','post'],'advertise', 'Admin\AdvertiseController@advertiseListing')->name('advertiseListing');
    Route::get('advertise/add', 'Admin\AdvertiseController@addAdvertise')->name('addAdvertise');
    Route::get('advertise/add/form/{ads_form_last_id}', 'Admin\AdvertiseController@addAdvertiseForm')->name('addAdvertiseForm');
    Route::post('advertise/store', 'Admin\AdvertiseController@storeAdvertise')->name('storeAdvertise');
    Route::get('advertise/edit/{id}', 'Admin\AdvertiseController@editAdvertise')->name('editAdvertise');
    Route::post('advertise/update/{id}', 'Admin\AdvertiseController@updateAdvertise')->name('updateAdvertise');
    Route::delete('advertise/delete','Admin\AdvertiseController@deleteAdvertise')->name('deleteAdvertise');
    
    //Subscription Management
    Route::match(['get','post'],'subscription', 'Admin\SubscriptionController@subscriptionListing')->name('subscriptionListing');
    Route::get('subscription/add', 'Admin\SubscriptionController@addSubscriptionPlan')->name('addSubscription');
    Route::post('subscription/store', 'Admin\SubscriptionController@storeSubscriptionPlan')->name('storeSubscription');
    Route::get('subscription/edit/{id}', 'Admin\SubscriptionController@editSubscriptionPlan')->name('editSubscriptionPlan');
    Route::get('subscription/price_html/{rowNumber}', 'Admin\SubscriptionController@subscriptionPriceHtml')->name('subscriptionPriceHtml');
    Route::get('subscription/add_lang_text_html/{langRowNumber}', 'Admin\SubscriptionController@subscriptionAddLangTextHtml')->name('subscriptionAddLangTextHtml');
    Route::delete('subscription/delete','Admin\SubscriptionController@subscriptionDelete')->name('subscriptionDelete');
    Route::get('subscription/period/{rowNum}/{currency_id}','Admin\SubscriptionController@subscriptionPeriod')->name('subscriptionPeriod');
    Route::post('subscription/update/{id}','Admin\SubscriptionController@updateSubscription')->name('updateSubscription');
    Route::delete('subscription/price/delete','Admin\SubscriptionController@deleteSubscriptionPrice')->name('deleteSubscriptionPrice');
});
Auth::routes();

