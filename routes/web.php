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

Route::get('/home', 'HomeController@index')->name('home');

/* story routes */
Route::get('/story/{id}', 'StoryController@play');
Route::get('/story/{id}/edit', 'StoryController@edit');
Route::get('/story/create', 'StoryController@create');

