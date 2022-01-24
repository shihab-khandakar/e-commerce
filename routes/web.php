<?php

use App\Http\Controllers\admin\AdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;



Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::prefix('admin')->group( function(){
// All the admin dashboard defain here

    Route::match(['get', 'post'],'/',[AdminController::class, 'login'])->name('admin.login');

    Route::group(['middleware'=>['admin']], function(){

        Route::get('/dashboard',[AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/settings',[AdminController::class, 'settings'])->name('admin.settings');
        Route::match(['get', 'post'],'/check-current-pwd',[AdminController::class, 'CurrentPwd']);
        Route::post('/update-current-pwd',[AdminController::class, 'UpdateCurrentPwd'])->name('admin.updateChkPwd');
        Route::match(['get', 'post'],'/update-details',[AdminController::class, 'UpdateAdminDetails'])->name('admin.updateAdminDetails');
        Route::get('/logout',[AdminController::class, 'logout'])->name('admin.logout');
        

    });

});
