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
    return redirect('admin');
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
     
    Route::get('/permission', ['as' => 'permission.permission.index', 'display_name'=>'List Group', 'description'=>'Melihat Daftar Permission', 'uses' => 'PermissionController@index']);
    Route::post('/permission', ['as' => 'permission.permission.store', 'display_name'=>'Store Group', 'description'=>'Store Permission', 'uses' => 'PermissionController@store']);
    Route::get('/permission/form/{id}', ['as' => 'permission.permission.edit', 'display_name'=>'form Edit Group', 'description'=>'Melihat form Permission', 'uses' => 'PermissionController@edit']);
    
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
    
    Route::get('/sarpras', ['as' => 'permission.sarpras.index', 'display_name'=>'List Sarpras', 'description'=>'Melihat Daftar Sarpras', 'uses' => 'Master\SarprasController@index']);
    Route::post('/sarpras', ['as' => 'permission.sarpras.store', 'display_name'=>'Store Sarpras', 'description'=>'Store Sarpras', 'uses' => 'Master\SarprasController@store']);
    Route::get('/sarpras/form', ['as' => 'permission.sarpras.add', 'display_name'=>'form Add Sarpras', 'description'=>'Melihat form Sarpras', 'uses' => 'Master\SarprasController@add']);
    Route::get('/sarpras/form/{id}', ['as' => 'permission.sarpras.edit', 'display_name'=>'form Edit Sarpras', 'description'=>'Melihat form Sarpras', 'uses' => 'Master\SarprasController@edit']);
    
    Route::get('/mrombel', ['as' => 'permission.mrombel.index', 'display_name'=>'List Rombel', 'description'=>'Melihat Daftar Rombel', 'uses' => 'Master\RombelController@index']);
    Route::post('/mrombel', ['as' => 'permission.mrombel.store', 'display_name'=>'Store Rombel', 'description'=>'Store Rombel', 'uses' => 'Master\RombelController@store']);
    Route::get('/mrombel/form', ['as' => 'permission.mrombel.add', 'display_name'=>'form Add Rombel', 'description'=>'Melihat form Rombel', 'uses' => 'Master\RombelController@add']);
    Route::get('/mrombel/form/{id}', ['as' => 'permission.mrombel.edit', 'display_name'=>'form Edit Rombel', 'description'=>'Melihat form Rombel', 'uses' => 'Master\RombelController@edit']);
    
    Route::get('/tahun_ajaran', ['as' => 'permission.tahun_ajaran.index', 'display_name'=>'List TahunAjaran', 'description'=>'Melihat Daftar TahunAjaran', 'uses' => 'Master\TahunAjaranController@index']);
    Route::post('/tahun_ajaran', ['as' => 'permission.tahun_ajaran.store', 'display_name'=>'Store TahunAjaran', 'description'=>'Store TahunAjaran', 'uses' => 'Master\TahunAjaranController@store']);
    Route::get('/tahun_ajaran/form', ['as' => 'permission.tahun_ajaran.add', 'display_name'=>'form Add TahunAjaran', 'description'=>'Melihat form TahunAjaran', 'uses' => 'Master\TahunAjaranController@add']);
    Route::get('/tahun_ajaran/form/{id}', ['as' => 'permission.tahun_ajaran.edit', 'display_name'=>'form Edit TahunAjaran', 'description'=>'Melihat form TahunAjaran', 'uses' => 'Master\TahunAjaranController@edit']);
    
    Route::get('/m_tingkat_mapel', ['as' => 'permission.m_tingkat_mapel.index', 'display_name'=>'List Master Tingkat Mapel', 'description'=>'Melihat Daftar Master Tingkat Mapel', 'uses' => 'MTingkatMapelController@index']);
    Route::post('/m_tingkat_mapel', ['as' => 'permission.m_tingkat_mapel.store', 'display_name'=>'Store Master Tingkat Mapel', 'description'=>'Store Master Tingkat Mapel', 'uses' => 'MTingkatMapelController@store']);
    Route::delete('/m_tingkat_mapel', ['as' => 'permission.m_tingkat_mapel.delete', 'display_name'=>'Delete Master Tingkat Mapel', 'description'=>'Delete Master Tingkat Mapel', 'uses' => 'MTingkatMapelController@delete']);
    
    Route::get('/rombel', ['as' => 'permission.rombel.pilih', 'display_name'=>'Pilih tahun', 'description'=>'Pilih tahun', 'uses' => 'RombelController@pilih']);
    Route::post('/rombel', ['as' => 'permission.rombel.pilihstore', 'display_name'=>'Store Pilih tahun', 'description'=>'Store Pilih tahun', 'uses' => 'RombelController@storepilih']);
    Route::get('/rombel/{tahun}', ['as' => 'permission.rombel.index', 'display_name'=>'List Rombel', 'description'=>'Melihat Daftar Rombel', 'uses' => 'RombelController@index']);
    Route::post('/rombel/{tahun}', ['as' => 'permission.rombel.store', 'display_name'=>'Store Rombel', 'description'=>'Store Rombel', 'uses' => 'RombelController@store']);
    Route::get('/rombel/{tahun}/form', ['as' => 'permission.rombel.add', 'display_name'=>'form Add Rombel', 'description'=>'Melihat form Rombel', 'uses' => 'RombelController@add']);
    Route::get('/rombel/{tahun}/form/{id}', ['as' => 'permission.rombel.edit', 'display_name'=>'form Edit Rombel', 'description'=>'Melihat form Rombel', 'uses' => 'RombelController@edit']);
    
});
