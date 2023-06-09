<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('login', 'login');
        Route::post('login', '_login')->name('login');
        Route::get('logout', 'logout')->name('logout');
        Route::group(['middleware' => 'auth.web'], function () {
            Route::get('change-password', [AuthController::class, 'changePassword']);
            Route::post('change-password', [AuthController::class, '_changePassword'])->name('change_password');
        });
    });
    Route::group(['middleware' => 'auth.web'], function () {
        view()->composer(['*'], function ($view) {
            $user = session()->get('user');
            $categories = Category::whereParentId(null)->get();
            $view->with('user', $user);
            $view->with('categories', $categories);
        });
        Route::get('/', [HomeController::class, 'index']);
        Route::resource('items', ItemController::class);
        Route::post('item-update', [ItemController::class, 'update'])->name('item.update');
        Route::get('items/{id}/delete', [ItemController::class, 'destroy'])->name('item.delete');
        Route::resource('categories', CategoryController::class);
        Route::post('category-update', [CategoryController::class, 'update'])->name('category.update');
        Route::get('sub_categories/{id}', [CategoryController::class, 'subCategories']);
        Route::get('categories/{id}/delete', [CategoryController::class, 'destroy'])->name('category.delete');
        Route::get('register', [AuthController::class, 'register']);
        Route::post('register', [AuthController::class, '_register'])->name('register');
    });
});
