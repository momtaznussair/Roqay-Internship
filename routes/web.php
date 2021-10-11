<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
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
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){
        
        Route::get('/', function () {
            return view('dashboard');
        })->middleware('AdminAuth');

        // admins
        Route::resource('admins', AdminController::class);
        // admin auth
        Route::get('admin/login', [LoginController::class, 'login'])->name('admin.login');    
        Route::post('admin/login', [LoginController::class, 'authenticate'])->name('admin.authenticate');    
        Route::post('admin/logout', [LoginController::class, 'logout'])->name('admin.logout');    

        // categories
        Route::resource('categories', CategoryController::class);

        Route::get('/{page}', [AdminController::class, 'page']);
    });
