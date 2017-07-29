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
    return view('auth.login');
});


Auth::routes();
Route::get('/home', 'HomeController@index');
//Route::get('/test_order','Admin\OrderController@newOrder');

Route::group(['namespace' => 'Admin'], function () {
    Route::get('/dashboard','AdminController@index');
    Route::get('/about-us','AdminController@aboutUs');
    Route::get('/get-order/{id}','OrderController@getOrder');

    /********** Opening Closing time **********/
    Route::post('/about-us-timing','AdminController@updateTiming');

    /************** Contact Us ****************/
    Route::post('/about-us-contact','AdminController@updateContact');

    /********** Delivery Information **********/
    Route::post('/about-us-delivery-information','AdminController@addDeliveryInformation');
    Route::get('/edit-delivery-information/{id}','AdminController@editDeliveryInfo');
    Route::post('/update-delivery-information','AdminController@postUpdateDeliveryInfo');
    Route::get('/delete-delivery-detail/{id}','AdminController@deleteDeliveryInfo');

    /********** Transcation Fees **********/
    Route::post('/about-us-transcation','AdminController@updateTranscationFees');

    /********** Discounts **********/
    Route::get('/add-discount','AdminController@discount');
    Route::post('/add-new-discount','AdminController@addNewDiscount');

    /********** Coupons **********/
    Route::get('/add-coupon','AdminController@coupon');
    Route::post('/add-new-coupon','AdminController@addNewCoupon');
    Route::get('/delete-coupon/{id}','AdminController@deleteCoupon');
    Route::get('/change-coupon-status/{id}/{status}','AdminController@changeCouponStatus');


    /********** Customer **********/
    Route::get('/customer','AdminController@viewCustomer');
    Route::get('/view-customer-order/{id}','AdminController@viewCustomerOrder');
});


Route::group(['prefix' => 'category','namespace' => 'Admin'], function () {
    Route::get('/','AdminController@categoryIndex');
    Route::post('add-category','AdminController@categoryAdd');
    Route::get('/view-all-category','AdminController@viewCategory');
    Route::get('/edit-category/{cat_id}','AdminController@editCategoryView');
    Route::post('/edit-category-post','AdminController@editedCategoryPost');
    Route::get('view-category-items/{buk_id}/{cat_id}','AdminController@viewCategoryProducts');
});


Route::group(['prefix' => 'product','namespace' => 'Admin'], function () {

    /************* Product Routes ************/
    Route::get('/add-product','ProductController@productIndex');
    Route::get('/get-category-attr/{id}','ProductController@getCategoryAttribute');
    Route::post('/add-new-product','ProductController@productAdd');
    Route::get('/view-all-product','ProductController@viewProducts');
    Route::get('/edit-product/pro_id/{pro_id}/attribute/{attr_id}','ProductController@editProduct');
    Route::post('/update-product','ProductController@updateProduct');
    Route::get('/delete-product-extra-item/{id}','ProductController@deleteproductExtra');
    Route::get('/delete-item/{id}','ProductController@deleteProduct');


    /************* Bucket Product Routes ************/
    Route::get('/add-bucket-product','ProductController@bucketProductIndex');
    Route::post('/add-new-bucket-product','ProductController@bucketProductAdd');
    Route::get('/view-bucket-product','ProductController@viewBucketProducts');
    Route::get('/delete-bucket/{id}','ProductController@deleteBucket');
    Route::get('/edit-bucket-product/{id}','ProductController@editBucketProducts');
    Route::post('/update-bucket-product','ProductController@updateBucketProduct');
    Route::get('/delete-bucket-item/{id}','ProductController@deleteBucketItemById');
    Route::get('/delete-bucket-related-item/{id}','ProductController@deleteBucketRelatedItemById');

});

Route::group(['prefix' => 'order','namespace' => 'Admin'], function () {
    Route::get('/pending-order','OrderController@getPendingOrder');
    Route::get('/order-history','OrderController@orderHistory');
    Route::post('/confirm-order','OrderController@confirmOrder');
    Route::post('/reject-order','OrderController@rejectOrder');
    Route::get('/search-order{start_date?}{end_date?}','OrderController@searchOrder');
});
