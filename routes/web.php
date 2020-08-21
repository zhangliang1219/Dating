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
Route::get('locale/{locale}', function ($locale){
    Session::put('locale', $locale);
    return redirect()->back();
});
Route::get('/', function () {
    return view('auth.login');
});
Route::get('/login', function () {
    return view('auth.login');
});
Route::get('/home', 'HomeController@index')->name('home');

Route::post('user-register', 'UserController@register')->name('front-register');
Route::get('/confirm-account/{userId}', 'UserController@confirmAccount')->name('confirm-account');


Route::get('/redirect/{provider}', 'SocialLogInController@redirect')->name('social-redirect');
Route::get('/callback/{provider}', 'SocialLogInController@callback');


Route::get('contact-us', 'ContactUsController@contactUs')->name('contactUs');
Route::post('contact-us/store', 'ContactUsController@contactUsStore')->name('contactUsStore');

//profile route
Route::get('profile', 'ProfileController@profileInfo')->name('profileInfo');
Route::match(['get','post'],'search/profile', 'ProfileController@viewSearchProfile')->name('viewSearchProfile');
Route::get('match/profile', 'ProfileController@matchedProfile')->name('matchedProfile');
Route::post('profile/banner/upload', 'ProfileController@profileBannerUpload')->name('profileBannerUpload');
Route::post('profile/phone/verification', 'ProfileController@phoneVerification')->name('phoneVerification');
Route::post('profile/doc/verification', 'ProfileController@docVerification')->name('docVerification');
Route::post('profile/gallery/photos/upload', 'ProfileController@galleryPhotosUpload')->name('galleryPhotosUpload');
Route::post('profile/image/upload', 'ProfileController@profileImageUpload')->name('profileImageUpload');
Route::post('profile/aboutMe/store', 'ProfileController@profileAboutMeUpload')->name('profileAboutMeUpload');
Route::post('edit/profile/{id}', 'ProfileController@editProfile')->name('editProfile');
Route::get('profile/gallery/photos/delete/{id}', 'ProfileController@galleryPhotosDelete')->name('galleryPhotosDelete');
Route::get('/gallery/photos/privacy/update/{id}/{checked}', 'ProfileController@galleryPhotosPrivacyUpdate')->name('galleryPhotosPrivacyUpdate');



//My profile route
Route::get('user/profile/{id}', 'ProfileController@userProfile')->name('userProfile');
Route::get('slide/user/profile/{id}', 'ProfileController@slideUserProfile')->name('slideUserProfile');
Route::post('user/profile/like_dislike', 'ProfileController@userProfileLikeDislike')->name('userProfileLikeDislike');

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
    Route::post('user/id_verify/update/{id}','Admin\UserController@userIdVerifyUpdate')->name('userIdVerifyUpdate');
    
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
    
    //General Setting
    Route::get('setting/userInfo/privacy', 'Admin\SettingController@userInfoPrivacyView')->name('userInfoPrivacyView');
    Route::post('setting/userInfo/privacy/store', 'Admin\SettingController@storeUserInfoPrivacy')->name('storeUserInfoPrivacy');
});
Auth::routes();

