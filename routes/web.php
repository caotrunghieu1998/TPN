<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [
    'as' => 'admin.login',
    'uses' => 'AdminController@loginAdmin'
]);

Route::post('/', [
    'as' => 'admin.post-login',
    'uses' => 'AdminController@postLoginAdmin'
]);
Route::get('/logout', [
    'as' => 'admin.logout',
    'uses' => 'AdminController@logout'
]);

Route::get('/home', function () {
    if(!auth()->check()){
        return redirect()->route('admin.login');
    }
    return view('home');
});

Route::prefix('admin')->group(function () {
    // prefix categories
    Route::prefix('categories')->group(function () {
        // Get View index
        Route::get('/', [
            'as' => 'categories.index',
            'uses' => 'CategoryController@index'
        ]);
        // Get view create
        Route::get('/create', [
            'as' => 'categories.create',
            'uses' => 'CategoryController@create'
        ]);
        // Create function
        Route::post('/store', [
            'as' => 'categories.store',
            'uses' => 'CategoryController@store'
        ]);
        // Get view edit
        Route::get('/edit/{id}', [
            'as' => 'categories.edit',
            'uses' => 'CategoryController@edit'
        ]);
        // Update function
        Route::post('/update/{id}', [
            'as' => 'categories.update',
            'uses' => 'CategoryController@update'
        ]);
        // Delete function
        Route::get('/delete/{id}', [
            'as' => 'categories.delete',
            'uses' => 'CategoryController@delete'
        ]);
    });

    // prefix menus
    Route::prefix('menus')->group(function () {
        // Get View index
        Route::get('/', [
            'as' => 'menus.index',
            'uses' => 'MenuController@index'
        ]);
        // Get view create
        Route::get('/create', [
            'as' => 'menus.create',
            'uses' => 'MenuController@create'
        ]);
        // Create function
        Route::post('/store', [
            'as' => 'menus.store',
            'uses' => 'MenuController@store'
        ]);
        // Get view edit
        Route::get('/edit/{id}', [
            'as' => 'menus.edit',
            'uses' => 'MenuController@edit'
        ]);
        // Update function
        Route::post('/update/{id}', [
            'as' => 'menus.update',
            'uses' => 'MenuController@update'
        ]);
        // Delete function
        Route::get('/delete/{id}', [
            'as' => 'menus.delete',
            'uses' => 'MenuController@delete'
        ]);
    });

     // prefix products
     Route::prefix('products')->group(function () {
        // Get View index
        Route::get('/', [
            'as' => 'product.index',
            'uses' => 'AdminProductController@index'
        ]);
        // Get view create
        Route::get('/create', [
            'as' => 'product.create',
            'uses' => 'AdminProductController@create'
        ]);
        // Create function
        Route::post('/store', [
            'as' => 'product.store',
            'uses' => 'AdminProductController@store'
        ]);
        // Get view edit
        Route::get('/edit/{id}', [
            'as' => 'product.edit',
            'uses' => 'AdminProductController@edit'
        ]);
        // Update function
        Route::post('/update/{id}', [
            'as' => 'product.update',
            'uses' => 'AdminProductController@update'
        ]);
        // Delete function
        Route::get('/delete/{id}', [
            'as' => 'product.delete',
            'uses' => 'AdminProductController@delete'
        ]);
    });
});
