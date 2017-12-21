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

//Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix'=> 'admin','middleware' => []], function () {
    Route::get('/', ['as' => 'dashboard', 'display_name'=>'Lihat Dashboard', 'description'=>'Melihat Dashboard', 'uses' => 'HomeController@index']);
    
    Route::get('/user', ['as' => 'permission.user.index', 'display_name'=>'List User', 'description'=>'Melihat Daftar User', 'uses' => 'UserController@index']);
    Route::post('/user', ['as' => 'permission.user.store', 'display_name'=>'Store User', 'description'=>'Store User', 'uses' => 'UserController@store']);
    Route::get('/user/form', ['as' => 'permission.user.add', 'display_name'=>'form Add User', 'description'=>'Melihat form User', 'uses' => 'UserController@add']);
    Route::get('/user/form/{id}', ['as' => 'permission.user.edit', 'display_name'=>'form Edit User', 'description'=>'Melihat form User', 'uses' => 'UserController@edit']);
    Route::get('/user/reset/{id}', ['as' => 'permission.user.reset', 'display_name'=>'form Reset Password', 'description'=>'Melihat form User', 'uses' => 'UserController@reset']);
    
});
