<?php

use App\Http\Controllers\Admin\ServicesController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Route::get('/get-subservice', [ServicesController::class, 'getSubservice'])->name('getSubservice');
Route::get('/get-userby', [ServicesController::class, 'getuserby'])->name('getuserby');

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');


    // Img
    Route::delete('imgs/destroy', 'ImgController@massDestroy')->name('imgs.massDestroy');
    Route::post('imgs/media', 'ImgController@storeMedia')->name('imgs.storeMedia');
    Route::post('imgs/ckmedia', 'ImgController@storeCKEditorImages')->name('imgs.storeCKEditorImages');
    Route::resource('imgs', 'ImgController');

    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Services
    Route::delete('services/destroy', 'ServicesController@massDestroy')->name('services.massDestroy');
    Route::resource('services', 'ServicesController');

    // Services Attribute
    Route::delete('services-attributes/destroy', 'ServicesAttributeController@massDestroy')->name('services-attributes.massDestroy');
    Route::resource('services-attributes', 'ServicesAttributeController');

    // View Service
    Route::resource('view-services', 'ViewServiceController', ['except' => ['destroy']]);
    Route::get('service/{id}', 'ServicesController@viewservice')->name('service.view');
    Route::get('service/create/{id}', 'ServicesController@create_parent_service')->name('parent.service.create');
    Route::post('service/save', 'ServicesController@save_parent_service')->name('parent.service.save');

    // Accounts
    Route::delete('accounts/destroy', 'AccountsController@massDestroy')->name('accounts.massDestroy');
    Route::resource('accounts', 'AccountsController');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
