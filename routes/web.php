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
//    Route::get('/user/reset/{id}', ['as' => 'permission.user.reset', 'display_name'=>'form Reset Password', 'description'=>'Melihat form User', 'uses' => 'UserController@reset']);
    
    Route::get('/role', ['as' => 'permission.role.index', 'display_name'=>'List Role', 'description'=>'Melihat Daftar Role', 'uses' => 'RoleController@index']);
    Route::post('/role', ['as' => 'permission.role.store', 'display_name'=>'Store Role', 'description'=>'Store Role', 'uses' => 'RoleController@store']);
    Route::get('/role/form', ['as' => 'permission.role.add', 'display_name'=>'form Add Role', 'description'=>'Melihat form Role', 'uses' => 'RoleController@add']);
    Route::get('/role/form/{id}', ['as' => 'permission.role.edit', 'display_name'=>'form Edit Role', 'description'=>'Melihat form Role', 'uses' => 'RoleController@edit']);
    Route::get('/role/permission/{id}', ['as' => 'permission.role.permission', 'display_name'=>'form Edit Role Permission', 'description'=>'Melihat form Role Permission', 'uses' => 'RoleController@editpermission']);
    Route::post('/role/permission', ['as' => 'permission.role.storepermission', 'display_name'=>'Store Role Permission', 'description'=>'Store Role Permission', 'uses' => 'RoleController@permission']);
    Route::get('/role/group/{id}', ['as' => 'permission.role.group', 'display_name'=>'form Edit Role Group', 'description'=>'Melihat form Role Group', 'uses' => 'RoleController@editgroup']);
    Route::post('/role/group', ['as' => 'permission.role.storegroup', 'display_name'=>'Store Role Group', 'description'=>'Store Role Group', 'uses' => 'RoleController@group']);
    
    
    Route::get('/group', ['as' => 'permission.group.index', 'display_name'=>'List Group', 'description'=>'Melihat Daftar Group', 'uses' => 'GroupController@index']);
    Route::post('/group', ['as' => 'permission.group.store', 'display_name'=>'Store Group', 'description'=>'Store Group', 'uses' => 'GroupController@store']);
    Route::get('/group/form', ['as' => 'permission.group.add', 'display_name'=>'form Add Group', 'description'=>'Melihat form Group', 'uses' => 'GroupController@add']);
    Route::get('/group/form/{id}', ['as' => 'permission.group.edit', 'display_name'=>'form Edit Group', 'description'=>'Melihat form Group', 'uses' => 'GroupController@edit']);
    Route::get('/group/permission/{id}', ['as' => 'permission.group.permission', 'display_name'=>'form Edit Group Permission', 'description'=>'Melihat form Group Permission', 'uses' => 'GroupController@editpermission']);
    Route::post('/group/permission', ['as' => 'permission.group.storepermission', 'display_name'=>'Store Group Permission', 'description'=>'Store Group Permission', 'uses' => 'GroupController@permission']);
    
});
