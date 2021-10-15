<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Admin\Auth\LoginController;
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

// todo: group routes under auth middelware

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){

        // admin auth middleware
        Route::middleware('AdminAuth')->group(function () {
            //home page
            Route::view('/', 'dashboard');

            // admins
            Route::resource('admins', AdminController::class);
            Route::post('admin/logout', [LoginController::class, 'logout'])->name('admin.logout');   

            // categories
            Route::resource('categories', CategoryController::class);
            // roles
            Route::resource('roles', RoleController::class);
            // users
            Route::resource('users', UserController::class);

        });

        // admin auth
        Route::middleware('guest')->group(function () {
            Route::get('admin/login', [LoginController::class, 'login'])->name('admin.login');    
            Route::post('admin/login', [LoginController::class, 'authenticate'])->name('admin.authenticate'); 

        });

        Route::get('/{page}', [AdminController::class, 'page']);

        
    });

   
