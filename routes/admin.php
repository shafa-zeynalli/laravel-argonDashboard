<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AdminController::class,'login'])->name('admin.login');
Route::post('/login', [AdminController::class,'authenticate']);


Route::group(['middleware'=>'auth'],function (){
    Route::get('/', [AdminController::class,'index'])->name('admin.dashboard');
    Route::get('/tables', [AdminController::class,'tables'])->name('admin.tables');
    Route::get('/users', [AdminController::class,'users'])->name('admin.users');
    Route::get('/profile', [AdminController::class,'profile'])->name('admin.profile');
    Route::post('/profile', [AdminController::class,'updateProfile'])->name('admin.updateProfile');
    //Route::post('/users', [AdminController::class,'filterUsers'])->name('admin.users.filter');
    Route::get('/products', [AdminController::class,'products'])->name('admin.products');
    //Route::post('/products', [AdminController::class,'filterProducts'])->name('admin.products.filter');
});


