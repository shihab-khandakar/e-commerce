<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\ProductController;
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

        // This route for Brand Panel

        Route::get('/brands',[BrandController::class, 'brands']);
        Route::post('/update-brand-status',[BrandController::class, 'updateBrandStatus']);
        Route::match(['get', 'post'],'add-edit-brand/{id?}',[BrandController::class, 'addEditBrand']);
        Route::get('/delete-brand/{id}',[BrandController::class, 'deleteBrand']);


        // This route for Categories Panel

        Route::get('/categories',[CategoryController::class, 'categories'])->name('admin.categories');
        Route::post('/update-category-status',[CategoryController::class, 'updateCategoryStatus']);
        Route::match(['get', 'post'],'add-edit-category/{id?}',[CategoryController::class, 'addEditCategory']);
        Route::post('/append-category-level',[CategoryController::class, 'appendCategoryLavel']);
        Route::get('/delete-category-image/{id}',[CategoryController::class, 'deleteCategoryImage']);
        Route::get('/delete-category/{id}',[CategoryController::class, 'deleteCategory']);


        // This Route for Products Panel

        Route::get('/products',[ProductController::class, 'products'])->name('admin.products');
        Route::post('/update-product-status',[ProductController::class, 'updateProductStatus']);
        Route::match(['get', 'post'],'add-edit-product/{id?}',[ProductController::class, 'addEditProduct']);
        Route::get('/delete-product-image/{id}',[ProductController::class, 'deleteProductImage']);
        Route::get('/delete-product-video/{id}',[ProductController::class, 'deleteProductVideo']);
        Route::get('/delete-product/{id}',[ProductController::class, 'deleteProduct']);

        // This Route for Products Attributes Panel
        Route::match(['get', 'post'],'add-attributes/{id?}',[ProductController::class, 'addAttributes']);
        Route::post('edit-attributes/{id}',[ProductController::class, 'editAttributes']);
        Route::post('/update-attribute-status',[ProductController::class, 'updateAttributeStatus']);
        Route::get('/delete-attribute/{id}',[ProductController::class, 'deleteAttribute']);

        // This Route for Products Images Panel
        Route::match(['get', 'post'],'add-images/{id?}',[ProductController::class, 'addImages']);
        Route::post('/update-image-status',[ProductController::class, 'updateImageStatus']);
        Route::get('/delete-image/{id}',[ProductController::class, 'deleteImage']);


    });

});
