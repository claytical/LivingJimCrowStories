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

Route::get ( '/redirect/{service}', 'SocialAuthController@redirect' );
Route::get ( '/callback/{service}', 'SocialAuthController@callback' );
Auth::routes();



/* public story routes */
Route::get('/story/{id}', 'StoryController@play');


/* admin routes*/
Route::get('/admin/stories', 'StoryController@admin')->name('admin.stories')->middleware('auth');
//Route::put('admin/story/store', 'StoryController@store')->name('admin.stories.store')->middleware('auth');
//Route::get('/admin/story/create', 'StoryController@create')->middleware('auth');
//Route::get('/admin/story/{id}/edit', 'StoryController@edit')->middleware('auth');

Route::resource('story', 'StoryController');
