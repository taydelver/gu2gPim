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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');


Route::prefix('admin')->group(function () {
    Route::get('dashboard', 'AdminController@index')->name('admin.dashboard');
    Route::get('attributes', 'AdminController@attributes')->name('admin.attributes');
    Route::get('products', 'AdminController@products')->name('admin.products');
    Route::get('products/add', 'AdminController@productsAdd')->name('admin.products.view.add');
    Route::get('product-options', 'AdminController@productOptions')->name('admin.product.options');
    Route::get('brands', 'AdminController@brands')->name('admin.brands');
    Route::get('categories', 'AdminController@categories')->name('admin.categories');
    Route::get('fitments', 'AdminController@fitments')->name('admin.fitments');
    Route::get('syncdata', 'AdminController@syncData');

    // POST
    Route::post('syncdata', 'Admin\SyncController@runSync')->name('sync.data.all');
});

// Route::get('/admin/{any}', function () {
//     return view('base');
// })->where('any', '.*');