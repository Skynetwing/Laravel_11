<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
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

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    route::post('groups-position', [RoleController::class, 'groupsPosition']);
    route::post('permissions-position', [RoleController::class, 'permissionsPosition']);
    route::get('settings', [SettingsController::class, 'index'])->name('settings');
});
