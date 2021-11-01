<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PostImageController;
use App\Http\Controllers\ProductImageController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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

if(env('APP_ENV') == 'production') {
    \URL::forceScheme('https');
}

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){

        // admin auth middleware
        Route::middleware('AdminAuth')->group(function () {
            //home page
            Route::view('/admin', 'dashboard');

            // admins
            Route::resource('admins', AdminController::class);
            Route::post('admin/logout', [LoginController::class, 'logout'])->name('admin.logout');   

            // categories
            Route::resource('categories', CategoryController::class);
            //products
            Route::get('products', function () {
                return view('products.index');
            })->name('products');

            //posts
            Route::resource('posts', PostController::class);
            // post images
            Route::resource('post-images', PostImageController::class);
            // roles
            Route::resource('roles', RoleController::class);
            // users
            Route::resource('users', UserController::class);

        });

        // admin auth
        Route::middleware('guestAdmin')->group(function () {
            Route::get('admin/login', [LoginController::class, 'login'])->name('admin.login');    
            Route::post('admin/login', [LoginController::class, 'authenticate'])->name('admin.authenticate'); 

        });


        //user area

      Route::middleware('auth:web')->group(function () {

            Route::view('/', 'user.home')->name('home');
            Route::post('logout', [UserController::class, 'logout'])->name('logout');

            //payment
            Route::post('pay', [PaymentController::class, 'pay'])->name('pay');
            //cart
            Route::view('cart', 'user.cart')->name('cart');
        });

        Route::match(['get', 'post'], 'order-received', [PaymentController::class, 'callback']);
        Route::get('order-failed', [PaymentController::class, 'errorHandler']);
        
        //user auth
       Route::middleware('guest:web')->group(function () {
            Route::view('register', 'user.auth.register')->name('register');
            Route::view('login', 'user.auth.login')->name('login');
       });

       //test
       Route::get('test', function () {
        //    sleep(5);
        //    return Str::random(40);

        $url = ['url' => env(('PAYMENT_CALLBACK_URL'))];

        return urldecode(Arr::query($url));
       });

        Route::get('/{page}', [AdminController::class, 'page']);
    });




