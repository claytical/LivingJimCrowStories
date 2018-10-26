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

Route::get('/', 'StoryController@welcome')->name('welcome');
Route::get ( '/redirect/{service}', 'SocialAuthController@redirect' );
Route::get ( '/callback/{service}', 'SocialAuthController@callback' );
Auth::routes();

Route::get('vault', 'VaultController@my_vault')->name('vault')->middleware('auth');


/* public story routes */
Route::get('/play/{id}', 'StoryController@show');


/* admin routes*/
Route::get('/admin/stories', 'StoryController@admin')->name('admin.stories')->middleware('auth');
Route::get('/admin/scenes', 'SceneController@index')->name('admin.stories')->middleware('auth');

//Route::put('admin/story/store', 'StoryController@store')->name('admin.stories.store')->middleware('auth');
//Route::get('/admin/story/create', 'StoryController@create')->middleware('auth');
//Route::get('/admin/story/{id}/edit', 'StoryController@edit')->middleware('auth');

Route::resource('admin/story', 'StoryController')->middleware('auth');
Route::resource('admin/vault', 'VaultController')->middleware('auth');
Route::resource('admin/scene', 'SceneController')->middleware('auth');

/* API REQUESTS */
Route::get('/get/item/{id}', 'VaultController@get_json_by_id');
Route::get('/get/category/{category}', 'VaultController@get_json_by_category');
Route::get('/get/random/item/{category}', 'VaultController@get_json_random_item_by_category');