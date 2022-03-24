<?php

use App\Http\Controllers\Admin\ForgotPasswordController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\RegisterController;
use App\Http\Controllers\Admin\ResetPasswordController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::middleware(['prevent-back-history'])->group(function(){
    
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth:web');
    
    Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin.home')->middleware('auth:admin');

});


Route::get('admin/login', [LoginController::class, 'showAdminLoginForm'])->name('admin.login');
Route::post('admin/login', [LoginController::class, 'adminLogin']);
Route::post('admin/logout', [LoginController::class, 'logout'])->name('admin.logout')->middleware('auth:admin');
Route::get('admin/register', [RegisterController::class, 'showAdminRegisterForm'])->name('admin.register');
Route::post('admin/register', [RegisterController::class, 'adminRegister']);


Route::get('admin/password/reset', [ForgotPasswordController::class, 'showAdminLinkRequestForm'])->name('admin.password.request');
Route::post('admin/password/email', [ForgotPasswordController::class, 'sendAdminResetLinkEmail'])->name('admin.password.email');
Route::get('admin/password/reset/{token}', [ResetPasswordController::class, 'showAdminResetForm'])->name('admin.password.reset');
Route::post('admin/password/reset', [ResetPasswordController::class, 'adminReset'])->name('admin.password.update');

