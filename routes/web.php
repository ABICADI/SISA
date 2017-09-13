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
    return view('dashboard');
})->middleware('auth');

Auth::routes();

//Nuestras Rutas
Route::get('/dashboard', 'DashboardController@index');
Route::get('/error', 'ErrorController@index');
Route::get('/profile', 'ProfileController@index');

Route::post('system-management/bitacora/search', 'BitacoraController@search')->name('bitacora.search');
Route::resource('system-management/bitacora', 'BitacoraController');

Route::post('user-management/search', 'UserManagementController@search')->name('user-management.search');
Route::resource('user-management', 'UserManagementController');

Route::resource('diasemanausuario-management', 'DiaSemanaUsuarioController');
Route::resource('user-management/terapia-usuario', 'TerapiaUsuarioController');

Route::post('actividad-management/search', 'ActividadController@search')->name('actividad-management.search');
Route::resource('actividad-management', 'ActividadController');

Route::post('system-management/terapia/search', 'TerapiaController@search')->name('terapia.search');
Route::resource('system-management/terapia', 'TerapiaController');


//Route::get('system-management/report', 'ReportController@index');
//Route::post('system-management/report/search', 'ReportController@search')->name('report.search');
//Route::post('system-management/report/excel', 'ReportController@exportExcel')->name('report.excel');
//Route::post('system-management/report/pdf', 'ReportController@exportPDF')->name('report.pdf');

//Route::get('avatars/{name}', 'EmployeeManagementController@load');



