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

Route::get('/401', function () {
    return view('401');
});

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix'=> 'admin','middleware' => ['auth','auth.route']], function () {
    Route::get('/', ['as' => 'dashboard', 'display_name'=>'Lihat Dashboard', 'description'=>'Melihat Dashboard', 'uses' => 'HomeController@index']);
    
    Route::get('/user', ['as' => 'permission.user.index', 'display_name'=>'List User', 'description'=>'Melihat Daftar User', 'uses' => 'UserController@index']);
    Route::post('/user', ['as' => 'permission.user.store', 'display_name'=>'Store User', 'description'=>'Store User', 'uses' => 'UserController@store']);
    Route::get('/user/form', ['as' => 'permission.user.add', 'display_name'=>'form Add User', 'description'=>'Melihat form User', 'uses' => 'UserController@add']);
    Route::get('/user/form/{id}', ['as' => 'permission.user.edit', 'display_name'=>'form Edit User', 'description'=>'Melihat form User', 'uses' => 'UserController@edit']);
    Route::get('/user/cetak/{id}', ['as' => 'permission.user.cetak', 'display_name'=>'Cetak User', 'description'=>'Cetak pdf User', 'uses' => 'UserController@cetak']);
    Route::get('/user/preview/{id}', ['as' => 'permission.user.preview', 'display_name'=>'Cetak User', 'description'=>'Cetak pdf User', 'uses' => 'UserController@preview']);
//    Route::post('/user/upload', ['as' => 'permission.user.upload', 'display_name'=>'Upload User', 'description'=>'Upload User', 'uses' => 'UserController@upload']);
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
    
//    Route::get('/agama', ['as' => 'permission.agama.index', 'display_name'=>'List Agama', 'description'=>'Melihat Daftar Agama', 'uses' => 'Master\AgamaController@index']);
//    Route::post('/agama', ['as' => 'permission.agama.store', 'display_name'=>'Store Agama', 'description'=>'Store Agama', 'uses' => 'Master\AgamaController@store']);
//    Route::get('/agama/form', ['as' => 'permission.agama.add', 'display_name'=>'form Add Agama', 'description'=>'Melihat form Agama', 'uses' => 'Master\AgamaController@add']);
//    Route::get('/agama/form/{id}', ['as' => 'permission.agama.edit', 'display_name'=>'form Edit Agama', 'description'=>'Melihat form Agama', 'uses' => 'Master\AgamaController@edit']);
//    
    Route::get('/siswa', ['as' => 'permission.siswa.index', 'display_name'=>'List Siswa', 'description'=>'Melihat Daftar Siswa', 'uses' => 'SiswaController@index']);
    Route::post('/siswa', ['as' => 'permission.siswa.store', 'display_name'=>'Store Siswa', 'description'=>'Store Siswa', 'uses' => 'SiswaController@store']);
    Route::post('/siswa/uploadexcel', ['as' => 'permission.siswa.uploadexcel', 'display_name'=>'uploadexcel Siswa', 'description'=>'uploadexcel Siswa', 'uses' => 'SiswaController@uploadexcel']);
    Route::post('/siswa/storeupload', ['as' => 'permission.siswa.storeupload', 'display_name'=>'storeupload Siswa', 'description'=>'storeupload Siswa', 'uses' => 'SiswaController@storeupload']);
    Route::get('/siswa/formupload', ['as' => 'permission.siswa.formupload', 'display_name'=>'formupload Siswa', 'description'=>'formupload Siswa', 'uses' => 'SiswaController@formupload']);
    Route::get('/siswa/form', ['as' => 'permission.siswa.add', 'display_name'=>'form Add Siswa', 'description'=>'Melihat form Siswa', 'uses' => 'SiswaController@add']);
    Route::get('/siswa/form/{id}', ['as' => 'permission.siswa.edit', 'display_name'=>'form Edit Siswa', 'description'=>'Melihat form Siswa', 'uses' => 'SiswaController@edit']);
    
    Route::get('/mapel', ['as' => 'permission.mapel.index', 'display_name'=>'List Mapel', 'description'=>'Melihat Daftar Mapel', 'uses' => 'Master\MapelController@index']);
    Route::post('/mapel', ['as' => 'permission.mapel.store', 'display_name'=>'Store Mapel', 'description'=>'Store Mapel', 'uses' => 'Master\MapelController@store']);
    Route::get('/mapel/form', ['as' => 'permission.mapel.add', 'display_name'=>'form Add Mapel', 'description'=>'Melihat form Mapel', 'uses' => 'Master\MapelController@add']);
    Route::get('/mapel/form/{id}', ['as' => 'permission.mapel.edit', 'display_name'=>'form Edit Mapel', 'description'=>'Melihat form Mapel', 'uses' => 'Master\MapelController@edit']);
    
    Route::get('/tingkat', ['as' => 'permission.tingkat.index', 'display_name'=>'List Tingkat', 'description'=>'Melihat Daftar Tingkat', 'uses' => 'Master\TingkatController@index']);
    Route::post('/tingkat', ['as' => 'permission.tingkat.store', 'display_name'=>'Store Tingkat', 'description'=>'Store Tingkat', 'uses' => 'Master\TingkatController@store']);
    Route::get('/tingkat/form', ['as' => 'permission.tingkat.add', 'display_name'=>'form Add Tingkat', 'description'=>'Melihat form Tingkat', 'uses' => 'Master\TingkatController@add']);
    Route::get('/tingkat/form/{id}', ['as' => 'permission.tingkat.edit', 'display_name'=>'form Edit Tingkat', 'description'=>'Melihat form Tingkat', 'uses' => 'Master\TingkatController@edit']);
    
    Route::get('/kelas', ['as' => 'permission.kelas.index', 'display_name'=>'List Kelas', 'description'=>'Melihat Daftar Kelas', 'uses' => 'Master\KelasController@index']);
    Route::post('/kelas', ['as' => 'permission.kelas.store', 'display_name'=>'Store Kelas', 'description'=>'Store Kelas', 'uses' => 'Master\KelasController@store']);
    Route::get('/kelas/form', ['as' => 'permission.kelas.add', 'display_name'=>'form Add Kelas', 'description'=>'Melihat form Kelas', 'uses' => 'Master\KelasController@add']);
    Route::get('/kelas/form/{id}', ['as' => 'permission.kelas.edit', 'display_name'=>'form Edit Kelas', 'description'=>'Melihat form Kelas', 'uses' => 'Master\KelasController@edit']);
    
});
