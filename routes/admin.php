<?php

use App\Http\Controllers\Backend\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Backend\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Backend\Admin\AdminManage\AdminController;
use App\Http\Controllers\Backend\Admin\AdminManage\PermissionController;
use App\Http\Controllers\Backend\Admin\AdminManage\RoleController;
use App\Http\Controllers\Backend\Admin\MaterialManagement\MaterialAttributeController;
use App\Http\Controllers\Backend\Admin\MaterialManagement\MaterialAttributeValueController;
use App\Http\Controllers\Backend\Admin\MaterialManagement\MaterialController;
use App\Http\Controllers\Backend\Admin\MaterialManagement\StickerTypeMaterialController;
use App\Http\Controllers\Backend\Admin\StickerMangement\QuantityTierController;
use App\Http\Controllers\Backend\Admin\StickerMangement\StickerCategoryController;
use App\Http\Controllers\Backend\Admin\StickerMangement\StickerShapeController;
use App\Http\Controllers\Backend\Admin\StickerMangement\StickerTypeContoller;
use App\Http\Controllers\Backend\Admin\TemplateManagement\TemplateCategoryController;
use App\Http\Controllers\Backend\Admin\StickerMangement\TypeShapeController;
use Illuminate\Support\Facades\Route;

// Admin Auth Routes
Route::controller(AdminLoginController::class)->prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', 'showLoginForm')->name('login'); // Admin Login Form
    Route::post('/login', 'login')->name('login.submit'); // Admin Login Submit (Handled by AuthenticatesUsers)
    Route::post('/logout', 'logout')->name('logout'); // Admin Logout
});

// Admin Dashboard Routes (Requires Admin Authentication)

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth:admin'], function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'dashboard'])->name('dashboard');
});

Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function () {

    // Admin & Role - Permission Management
    Route::group(['prefix' => 'admin-management', 'as' => 'am.'], function () {

        // Admins Management
        Route::resource('admin', AdminController::class);
        Route::group(['as' => 'admin.', 'prefix' => 'admin-restore'], function () {
            Route::get('/trash', [AdminController::class, 'trash'])->name('trash');
            Route::get('/restore/{id}', [AdminController::class, 'restore'])->name('restore');
            Route::get('/force-delete/{id}', [AdminController::class, 'forceDelete'])->name('force-delete');
            Route::get('/status/{id}/{status}', [AdminController::class, 'status'])->name('status');
        });

        // Role Management
        Route::resource('role', RoleController::class);
        Route::group(['as' => 'role.', 'prefix' => 'role-restore'], function () {
            Route::get('/trash', [RoleController::class, 'trash'])->name('trash');
            Route::get('/restore/{id}', [RoleController::class, 'restore'])->name('restore');
            Route::get('/force-delete/{id}', [RoleController::class, 'forceDelete'])->name('force-delete');
        });

        // Permission Management
        Route::resource('permission', PermissionController::class);
        Route::group(['as' => 'permission.', 'prefix' => 'permission-restore'], function () {
            Route::get('/trash', [PermissionController::class, 'trash'])->name('trash');
            Route::get('/restore/{id}', [PermissionController::class, 'restore'])->name('restore');
            Route::get('/force-delete/{id}', [PermissionController::class, 'forceDelete'])->name('force-delete');
        });

        //Material Management
        Route::resource('/material', MaterialController::class);
        Route::group(['as' => 'material.', 'prefix' => 'material-restore'], function () {
            Route::get('/status/{id}/{status}', [MaterialController::class, 'status'])->name('status');
            Route::get('/trash', [MaterialController::class, 'trash'])->name('trash');
            Route::get('/restore/{id}', [MaterialController::class, 'restore'])->name('restore');
            Route::get('/force-delete/{id}', [MaterialController::class, 'forceDelete'])->name('force-delete');
        });

        //Material Attribute Management
        Route::resource('/material-attribute', MaterialAttributeController::class);
        Route::group(['as' => 'material-attribute.', 'prefix' => 'material-attribute-restore'], function () {
            Route::get('/status/{id}/{status}', [MaterialAttributeController::class, 'status'])->name('status');
            Route::get('/trash', [MaterialAttributeController::class, 'trash'])->name('trash');
            Route::get('/restore/{id}', [MaterialAttributeController::class, 'restore'])->name('restore');
            Route::get('/force-delete/{id}', [MaterialAttributeController::class, 'forceDelete'])->name('force-delete');
        });

        //Material Attribute Value Management
        Route::resource('/material-attribute-value', MaterialAttributeValueController::class);
        Route::group(['as' => 'material-attribute-value.', 'prefix' => 'material-attribute-value-restore'], function () {
            Route::get('/status/{id}/{status}', [MaterialAttributeValueController::class, 'status'])->name('status');
            Route::get('/trash', [MaterialAttributeValueController::class, 'trash'])->name('trash');
            Route::get('/restore/{id}', [MaterialAttributeValueController::class, 'restore'])->name('restore');
            Route::get('/force-delete/{id}', [MaterialAttributeValueController::class, 'forceDelete'])->name('force-delete');
        });
        // Sticker Management
        Route::resource('sticker-category',StickerCategoryController::class);
        Route::get('sticker-types/{id}/status/{status}', [StickerTypeContoller::class, 'status'])->name('sticker-types.status');
        Route::resource('sticker-types', StickerTypeContoller::class);
        Route::resource('sticker-shapes', StickerShapesController::class);

        // Sticker Type Material Management
        Route::resource('sticker-type-material', StickerTypeMaterialController::class);
        Route::group(['as' => 'sticker-type-material.', 'prefix' => 'sticker-type-material-restore'], function () {
            Route::get('/status/{id}/{status}', [StickerTypeMaterialController::class, 'status'])->name('status');
            Route::get('/trash', [StickerTypeMaterialController::class, 'trash'])->name('trash');
            Route::get('/restore/{id}', [StickerTypeMaterialController::class, 'restore'])->name('restore');
            Route::get('/force-delete/{id}', [StickerTypeMaterialController::class, 'forceDelete'])->name('force-delete');
        });

        //Template Category Management
        Route::resource('template-category', TemplateCategoryController::class);
        Route::group(['as' => 'template-category.', 'prefix' => 'template-category-restore'], function () {
            Route::get('/status/{id}/{status}', [TemplateCategoryController::class, 'status'])->name('status');
            Route::get('/trash', [TemplateCategoryController::class, 'trash'])->name('trash');
            Route::get('/restore/{id}', [TemplateCategoryController::class, 'restore'])->name('restore');
            Route::get('/force-delete/{id}', [TemplateCategoryController::class, 'forceDelete'])->name('force-delete');
        });
       
        Route::resource('type-shape', TypeShapeController::class);
        Route::resource('quantity-tier', QuantityTierController::class);
    });
});
