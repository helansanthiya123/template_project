<?php

use App\Http\Controllers\AdminOrder;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MyProduct;
use App\Http\Controllers\FruitController;

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
Route::group(['middleware' => 'prevent-back-history'],function(){

	Auth::routes();

	Route::get('index',[MyProduct::class,'dashboard']);
	Route::get('adminprofile',[MyProduct::class,'adminprofile'])->name('adminprofile');
	Route::get('showfruit',[MyProduct::class,'showfruit'])->name('showfruit');
	Route::get('managefruit',[FruitController::class,'managefruit'])->name('managefruit');
	Route::get('editfruit/{id}',[FruitController::class,'editfruit']);
	Route::get('admin_order',[AdminOrder::class,'order'])->name('admin_order');
	Route::get('admin_view_order/{id}',[AdminOrder::class,'viewOrder']);
	Route::put('update-order/{id}',[AdminOrder::class,'update']);
	Route::get('order-history',[AdminOrder::class,'order_history']);

});
// Route::get('/', function () {
//     return view('template_folder.index');
// });
Route::get('/',[MyProduct::class,'showIndex']);

// Route::get('/homepage', function () {
//     return view('template_folder.index'); 
// });
Route::view('about','template_folder/about');
Route::view('news','template_folder/news');
Route::view('shop','template_folder/shop');
Route::view('checkout','template_folder/checkout');
Route::view('single-product','template_folder/single-product');
Route::view('cart','template_folder/cart');
Route::view('single-news','template_folder/single-news');
Route::view('contact','template_folder/contact');
Route::view('sign-up', 'template_folder/signup');
Route::view('sign-in/{action?}', 'template_folder/signin');

// Route::get('sign-in/{action}',function(){
// 	return view('template_folder.signin');
// });
Route::post('postlogin',[MyProduct::class,'login'])->name('postlogin');

Route::post('postsignup',[MyProduct::class,'register'])->name('postsignup');
Route::post('addfruit',[MyProduct::class,'addfruit']);
Route::post('updatefruit',[FruitController::class,'updatefruit']);
Route::get('deletefruit/{id}',[FruitController::class,'deletefruit']);
Route::get('add_to_cart/{id}',[FruitController::class,'add_to_cart']);
Route::get('cartlisting',[FruitController::class,'cartListing']);
Route::get('checkout',[FruitController::class,'checkout']);
Route::post('add_cart_login',[MyProduct::class,'add_cart_login'])->name('add_cart_login');
Route::get('removecart/{product_id}',[FruitController::class,'removeCart']);
Route::post('increasequantity/{product_id}',[FruitController::class,'increaseQuantity']);
Route::post('decreasequantity/{cart_id}',[FruitController::class,'decreaseQuantity']);
Route::get('signout',[MyProduct::class,'signout'])->name('signout');
Route::get('front_signout',[MyProduct::class,'front_signout'])->name('front_signout');
Route::post('place_order',[FruitController::class,'placeOrder']);
Route::get('order',[FruitController::class,'order']);
Route::post('orderlogin',[FruitController::class,'orderLogin']);
Route::get('view_order/{order_id}',[FruitController::class,'view_order']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
