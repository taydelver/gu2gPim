<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/test', 'Admin\SyncController@test');

Route::post('/login', 'Admin\ApiController@login');

// ADMIN

Route::post('/sync', 'Admin\SyncController@getProducts');
Route::get('/bc/fetch/products', 'Admin\SyncController@apiProducts');
// Route::get('/bc/fetch/categories', 'Admin\SyncController@getCategories');
Route::get('/bc/categories', 'Admin\ApiController@bcCategories');

Route::post('/bc/sync/products', 'Admin\SyncController@syncCategories');
Route::post('/bc/sync/products', 'Admin\SyncController@syncProducts');

Route::post('/bc/sync/all', 'Admin\SyncController@runSync');


// FOR PIM
Route::get('/products', 'Admin\ApiController@products');

Route::post('/products/option-group/create', 'Admin\ProductOptionsController@createOptionGroup');
Route::post('/products/option-group/update', 'Admin\ProductOptionsController@updateOptionGroup');
Route::post('/products/option-values/create', 'Admin\ProductOptionsController@createOptionValues');

Route::post('/create/product', 'Admin\BigCommerceController@createProduct');
Route::post('/create/product/options', 'Admin\BigCommerceController@createProductOptions');
Route::post('/create/product/variants', 'Admin\BigCommerceController@createProductVariants');
Route::post('/create/product/custom-fields', 'Admin\BigCommerceController@createProductCustomFields');
Route::post('/create/product/images', 'Admin\BigCommerceController@saveProductImage');

Route::get('/products/option-groups', 'Admin\ProductOptionsController@getOptionGroups');
Route::get('/products/option-values', 'Admin\ProductOptionsController@getOptionValues');
Route::get('/products/option-group/{group}/values', 'Admin\ProductOptionsController@getOptionGroupValues');

Route::get('/fitments', 'Admin\FitmentsController@getFitments');
Route::get('/fitments/all', 'Admin\FitmentsController@getFitmentsAll');
Route::get('/fitment-models', 'Admin\FitmentsController@getFitmentModels');
Route::post('/fitment/group/create', 'Admin\FitmentsController@createFitmentGroup');
Route::post('/fitment/model/create', 'Admin\FitmentsController@createFitmentModel');
Route::post('/fitment/group/update', 'Admin\FitmentsController@updateFitmentGroup');

Route::get('/attribute-groups', 'Admin\AttributesController@all');
Route::post('/attribute/group/create', 'Admin\AttributesController@createGroup');
Route::post('/attribute/group/update', 'Admin\AttributesController@updateGroup');



Route::get('/category/tree', 'Admin\ApiController@categoryTree');
Route::get('/product/{id}', 'Admin\ApiController@product');


// IMAGES
Route::post('/products/images/save', 'Admin\ProductsController@saveProductImage');


// SEARCH
Route::get('/bc/search/name', 'Admin\SearchController@productName');


Route::get('/combos', 'Admin\ProductsController@test');