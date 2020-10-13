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
use App\Mail\WelcomeMail;
Route::get('/email', function () {
    return new WelcomeMail();
});
use App\Mail\registrationemail;

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('/admin')->namespace('Admin')->group(function () {
    Route::match(['get', 'post'], '/', 'AdminController@login');
    Route::group(['middleware'=>['adminlogin']], function () {
        Route::get('dashboard','AdminController@dashboard');
        Route::get('settings', 'AdminController@settings');
        Route::get('logout', 'AdminController@logout');
        Route::post('check-current-pwd','AdminController@chkCurrentPassword');
        Route::post('update-current-pwd','AdminController@updateCurrentPassword');
        Route::match(['get','post'],'update-admin-details','AdminController@updateAdminDetails');
        //sections
        Route::get('sections','SectionController@sections');
        Route::post('update-section-status','SectionController@updateSectionStatus');
         //Brands
         Route::get('brands','BrandController@brands');
         Route::post('update-brand-status','BrandController@updateBrandStatus');
         Route::match(['get', 'post'], 'add-edit-brand/{id?}','BrandController@addEditBrand');
         Route::get('delete-brand/{id}','BrandController@deleteBrand');
         // Categories
        Route::get('categories','CategoryController@categories');
        Route::post('update-category-status','CategoryController@updateCategoryStatus');
        Route::match(['get', 'post'], 'add-edit-category/{id?}','CategoryController@addEditCategory');
        Route::post('append-categories-level','CategoryController@appendCategoryLevel');
        Route::get('delete-category-image/{id}','CategoryController@deleteCategoryImage');
        Route::get('delete-category/{id}','CategoryController@deleteCategory');
        //Products
        Route::get('products','ProductsController@products');
        Route::post('update-product-status','ProductsController@updateProductStatus');
        Route::get('delete-product/{id}','ProductsController@deleteProduct');
        Route::match(['get', 'post'], 'add-edit-product/{id?}','ProductsController@addEditProduct');
        Route::get('delete-product-image/{id}','ProductsController@deleteProductImage');
        Route::get('delete-product-video/{id}','ProductsController@deleteProductVideo');
        //Attributes
        Route::match(['get', 'post'], 'add-attributes/{id}','ProductsController@addAttributes');
        Route::post('edit-attributes/{id}','ProductsController@editAttributes');
        Route::post('update-attribute-status','ProductsController@updateAttributeStatus');
        Route::get('delete-attribute/{id}','ProductsController@deleteAttribute');
        //Images
        Route::match(['get', 'post'], 'add-images/{id}','ProductsController@addImages');
        Route::post('update-image-status','ProductsController@updateImageStatus');
        Route::get('delete-image/{id}','ProductsController@deleteImage');
        //Banners
        Route::get('banners','BannersController@banners');
        Route::match(['get','post'],'add-edit-banner/{id?}','BannersController@addeditBanner');
        Route::post('update-banner-status','BannersController@updateBannerStatus');
        Route::get('delete-banner/{id}','BannersController@deleteBanner');
        //Coupons
        Route::match(['get', 'post'], 'add-coupon/{id?}', 'CouponsController@addCoupon');
        Route::get('coupons','CouponsController@coupons');
        Route::post('update-coupon-status','CouponsController@updateCouponStatus');
        Route::get('delete-coupon/{id}','CouponsController@deleteCoupon');
        //orders
        Route::get('view-orders','ProductsController@viewOrders');
        //Admin Order Details Route
        Route::get('view-order/{id}','ProductsController@viewOrderDetails');
        //Update Order Status
        Route::post('update-order-status','ProductsController@updateOrderStatus');
        //Admin User Route
        Route::get('view-user','AdminController@viewUsers');
        //Order Invoice
        Route::get('view-order-invoice/{id}','ProductsController@viewOrderInvoice');
        //Add CMS Route
        Route::match(['get', 'post'],'add-cms-page/{id?}','CmsController@addCmsPage');
        //View CMS Pages Route
        Route::get('view-cms-page','CmsController@viewCmsPages');
        //Update Cms status
        Route::post('update-cms-status','CmsController@updateCmsStatus');
        Route::get('delete-cms/{id}','CmsController@deleteCms');
    });
   
}); 

Route::match(['get', 'post'],'/page/contact','Admin\CmsController@contact');
Route::match(['get', 'post'],'/page/{url}','Admin\CmsController@cmsPage');

Route::namespace('Front')->group(function (){
    Route::get('/','IndexController@index');
    //Route::get('/{url}','ProductsController@listing');

    

    Route::get('/products/{url}','ProductsController@products');
    Route::get('/product/{id}','ProductsController@product');
    Route::get('/get-product-price','ProductsController@getProductPrice');
    Route::match(['get','post'],'/add-cart','ProductsController@addtocart');
    Route::match(['get','post'],'/cart','ProductsController@cart');
    Route::get('/cart/delete-product/{id}', 'ProductsController@deleteCartProduct');
    Route::get('/cart/update-quantity/{id}/{quantity}', 'ProductsController@updateCartQuantity');
    Route::post('/cart/apply-coupon', 'ProductsController@applyCoupon');
   // Route::match(['get', 'post'],'login-register','UsersController@register');
    Route::get('/login-register', 'UsersController@userLoginRegister');
    Route::match(['get', 'post'],'forgot-password','UsersController@forgotPassword');
    Route::post('/user-register', 'UsersController@register');
    Route::match(['get', 'post'],'/check-email', 'UsersController@checkEmail');
    Route::get('/user-logout','UsersController@logout');
    Route::post('user-login','UsersController@login');
    Route::post('/search-products','ProductsController@searchProducts');
    Route::group(['middleware' => ['frontlogin']], function () {
         Route::match(['get', 'post'],'account','UsersController@account');
         Route::post('/check-user-pwd','UsersController@chkUserPassword');
        // Route::get('confirm/{code}','UsersController@confirmAccount');
        
         Route::post('/update-user-pwd','UsersController@updatePassword');
         Route::match(['get', 'post'], 'checkout','ProductsController@checkout');
         Route::match(['get', 'post'], '/order-review','ProductsController@orderReview');
         Route::match(['get', 'post'],'/place-order','ProductsController@placeOrder');
         Route::get('/thanks','ProductsController@thanks');
         Route::get('/orders','ProductsController@userOrders');
         Route::get('/orders/{id}','ProductsController@userOrderDetails');
         Route::get('/paypal','ProductsController@paypal');
    });
   
});

Route::get('confirm/{code}','Front\UsersController@confirmAccount');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/send-mail', function () {
    $details=[
        'title'=>'Mail From Sujan'
    ];
    \Mail::to('sujanbag58@gmail.com')->send(new \App\Mail\registrationemail($details));
    echo "Email has been sent";
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
