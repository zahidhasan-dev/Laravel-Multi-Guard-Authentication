<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\VerificationController as AdminVerificationController ;
use App\Http\Controllers\Admin\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\RegisterController as AdminRegisterController;
use App\Http\Controllers\Admin\ResetPasswordController as AdminResetPasswordController;
use App\Http\Controllers\Admin\ForgotPasswordController as AdminForgotPasswordController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::middleware(['prevent-back-history'])->group(function(){

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware(['verified']);

    Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin.home')->middleware(['verified:admin.verfication.notice']);

});

Route::controller(AdminLoginController::class)->group(function(){

    Route::get('admin/login', 'showAdminLoginForm')->name('admin.login');
    Route::post('admin/login', 'adminLogin');
    Route::post('admin/logout', 'logout')->name('admin.logout')->middleware('auth:admin');
    Route::get('admin/register', 'showAdminRegisterForm')->name('admin.register');
    Route::post('admin/register', 'adminRegister');

});

Route::controller(AdminForgotPasswordController::class)->group(function(){

    Route::get('admin/password/reset', 'showAdminLinkRequestForm')->name('admin.password.request');
    Route::post('admin/password/email', 'sendAdminResetLinkEmail')->name('admin.password.email');
    
});

Route::controller(AdminResetPasswordController::class)->group(function(){

    Route::get('admin/password/reset/{token}', 'showAdminResetForm')->name('admin.password.reset');
    Route::post('admin/password/reset', 'adminReset')->name('admin.password.update');

});

Route::controller(AdminVerificationController::class)->group(function(){
        
    Route::get('admin/email/verify', 'show')->name('admin.verfication.notice');
    Route::post('admin/email/resend', 'resend')->name('admin.verification.resend');
    Route::get('admin/email/verify/{id}/{hash}', 'verify')->name('admin.verification.verify');

});