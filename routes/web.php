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
    return view('error');
})->middleware('auth');

Auth::routes();

//Nuestras Rutas
Route::get('/dashboard', 'DashboardController@index');
Route::get('/error', 'ErrorController@index');
Route::resource('profile', 'ProfileController');

//Rutas de CRUD de todo el Sistema
Route::post('system-management/bitacora/search', 'BitacoraController@search')->name('bitacora.search');
Route::resource('system-management/bitacora', 'BitacoraController');

Route::post('user-management/search', 'UserManagementController@search')->name('user-management.search');
Route::resource('user-management', 'UserManagementController');

Route::post('paciente-management/search', 'PacienteController@search')->name('paciente-management.search');
Route::resource('paciente-management', 'PacienteController');

Route::post('tratamiento-management/search', 'TratamientoController@search')->name('tratamiento-management.search');
Route::resource('tratamiento-management', 'TratamientoController');

Route::post('medico-management/search', 'MedicoController@search')->name('medico-management.search');
Route::resource('medico-management', 'MedicoController');

Route::resource('dia-terapia-user-management', 'DiaTerapiaUsuarioController');

Route::resource('diasemanausuario-management', 'DiaSemanaUsuarioController');
Route::resource('terapiausuario-management', 'TerapiaUsuarioController');

Route::post('actividad-management/search', 'ActividadController@search')->name('actividad-management.search');
Route::resource('actividad-management', 'ActividadController');
Route::resource('actividad-descripcion-management', 'ActividadDescripcionController');

Route::post('system-management/terapia/search', 'TerapiaController@search')->name('terapia.search');
Route::resource('system-management/terapia', 'TerapiaController');

//Rutas de Reporteria de todo el Sistema
Route::get('system-management/report-actividad', 'ReportController@index');
Route::post('system-management/report-actividad/search', 'ReportController@search')->name('report-actividad.search');
Route::post('system-management/report-actividad/excel', 'ReportController@exportExcel')->name('report-actividad.excel');
Route::post('system-management/report-actividad/pdf', 'ReportController@exportPDF')->name('report-actividad.pdf');

Route::get('system-management/report-paciente', 'ReportPacienteController@index');
Route::post('system-management/report-paciente/search', 'ReportPacienteController@search')->name('report-paciente.search');
Route::post('system-management/report-paciente/excel', 'ReportPacienteController@exportExcel')->name('report-paciente.excel');
Route::post('system-management/report-paciente/pdf', 'ReportPacienteController@exportPDF')->name('report-paciente.pdf');

Route::get('system-management/report-tratamiento', 'ReportTratamientoController@index');
Route::post('system-management/report-tratamiento/search', 'ReportTratamientoController@search')->name('report-tratamiento.search');
Route::post('system-management/report-tratamiento/excel', 'ReportTratamientoController@exportExcel')->name('report-tratamiento.excel');
Route::post('system-management/report-tratamiento/pdf', 'ReportTratamientoController@exportPDF')->name('report-tratamiento.pdf');

//Rutas de Graficas
Route::get('grafica-management/cita', 'GraficaCitaController@index');
Route::get('grafica-management/empleado', 'GraficaEmpleadoController@index');
Route::get('grafica-management/medico', 'GraficaMedicoController@index');
Route::get('grafica-management/paciente', 'GraficaPacienteController@index');
Route::get('grafica-management/tratamiento', 'GraficaTratamientoController@index');

Route::resource('calendario', 'CalendarioController');
Route::resource('agregar-cita', 'CitaController');

//Route::get('avatars/{name}', 'EmployeeManagementController@load');
