<?php

use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RazorpayController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/dashboard');
});

Auth::routes();

Route::get('/dashboard', [HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::resource('roles', RoleController::class);
    route::post('groups-position', [RoleController::class, 'groupsPosition']);
    route::post('permissions-position', [RoleController::class, 'permissionsPosition']);
    Route::resource('users', UserController::class);
    route::get('settings', [SettingsController::class, 'index'])->name('settings');

    // Razorpay
    Route::get('razorpay', [RazorpayController::class, 'index'])->name('razorpay.index');
    Route::post('razorpay/payment', [RazorpayController::class, 'payment'])->name('razorpay.payment');
    Route::get('razorpay/callback', [RazorpayController::class, 'callback'])->name('razorpay.callback');

    // File Upload with Progress Bar
    Route::get('file', [FileUploadController::class, 'index'])->name('file.index');
    Route::post('upload', [FileUploadController::class, 'upload'])->name('file.upload');

    // Send Mail
    Route::get('send', [MailController::class, 'index'])->name('mail.index');
});
