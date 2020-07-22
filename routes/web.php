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
Route::get('/home', 'HomeController@index')->name('home');

//Backend Route
Route::group(['before' => 'auth','prefix' => 'admin'], function(){
    Route::get('/', 'Admin\UserController@loginView')->name('loginView');
    Route::get('login', 'Admin\UserController@loginView')->name('loginView');
    Route::post('login', 'Admin\UserController@login')->name('adminLogin');
    Route::get('dashboard', 'Admin\DashboardController@index')->name('adminDashboard');
    Route::get('logout','Admin\UserController@logout')->name('adminLogout');
    
    //User Management
    Route::match(['get','post'],'user', 'Admin\UserController@userListing')->name('userListing');
    Route::delete('/user/delete','Admin\UserController@deleteUser')->name('deleteUser');
    Route::get('/user/edit/{id}','Admin\UserController@editUser');
    Route::post('/user/update/{id}','Admin\UserController@updateUser')->name('updateUser');
    
    //Advertise Management
    Route::match(['get','post'],'advertise', 'Admin\AdvertiseController@advertiseListing')->name('advertiseListing');
    Route::get('advertise/add', 'Admin\AdvertiseController@addAdvertise')->name('addAdvertise');
    Route::post('advertise/store', 'Admin\AdvertiseController@storeAdvertise')->name('storeAdvertise');
});
Auth::routes();

