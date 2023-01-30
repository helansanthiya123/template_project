<?php

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
});
// Route::get('/', function () {
//     return view('template_folder.index');
// });
Route::get('/',[MyProduct::class,'showIndex']);

Route::get('/homepage', function () {
    return view('template_folder.index'); 
});
Route::view('about','template_folder/about');
Route::view('news','template_folder/news');
Route::view('shop','template_folder/shop');
Route::view('checkout','template_folder/checkout');
Route::view('single-product','template_folder/single-product');
Route::view('cart','template_folder/cart');
Route::view('single-news','template_folder/single-news');
Route::view('contact','template_folder/contact');
Route::view('sign-up', 'template_folder/signup');
Route::view('sign-in', 'template_folder/signin');
Route::post('postlogin',[MyProduct::class,'login'])->name('postlogin');
Route::post('postsignup',[MyProduct::class,'register'])->name('postsignup');
Route::post('addfruit',[MyProduct::class,'addfruit']);
Route::post('updatefruit',[FruitController::class,'updatefruit']);
Route::get('deletefruit/{id}',[FruitController::class,'deletefruit']);
Route::get('add_to_cart/{id}',[FruitController::class,'add_to_cart']);


Route::get('signout',[MyProduct::class,'signout'])->name('signout');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
