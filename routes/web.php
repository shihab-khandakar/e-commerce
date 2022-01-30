<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\SectionController;
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
        Route::get('/update-admin-password',[AdminController::class, 'settings'])->name('admin.settings');
        Route::match(['get', 'post'],'/check-current-pwd',[AdminController::class, 'CurrentPwd']);
        Route::post('/update-current-pwd',[AdminController::class, 'UpdateCurrentPwd'])->name('admin.updateChkPwd');
        Route::match(['get', 'post'],'/update-admin-details',[AdminController::class, 'UpdateAdminDetails'])->name('admin.updateAdminDetails');
        Route::get('/logout',[AdminController::class, 'logout'])->name('admin.logout');

        // This route for Section Panel

        Route::get('/sections',[SectionController::class, 'section'])->name('admin.section');
        Route::post('/update-section-status',[SectionController::class, 'updateSectionStatus']);

        // This route for Categories Panel

        Route::get('/categories',[CategoryController::class, 'categories'])->name('admin.categories');
        Route::post('/update-category-status',[CategoryController::class, 'updateCategoryStatus']);
        Route::match(['get', 'post'],'add-edit-category/{id?}',[CategoryController::class, 'addEditCategory']);
        Route::post('/append-category-level',[CategoryController::class, 'appendCategoryLavel']);
        Route::get('/delete-category-image/{id}',[CategoryController::class, 'deleteCategoryImage']);
        Route::get('/delete-category/{id}',[CategoryController::class, 'deleteCategory']);

    });

});
