<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
	if (Auth::check()) {
		return redirect()->action('LogController@index');
	} else {
    	return view('welcome');//login
    }
});

/*-- Rutas para el login --*/
Route::resource('log', 'LogController');
Route::post('login', 'LogController@store');
Route::get('logout', 'LogController@logout');

/*-- Rutas para el dashboard --*/
Route::get('/dashboard','LogController@index');//Carga solo el panel administrativo
Route::post('/grafica', 'LogController@get_userSesions');//Carga los datos de la gráfica

/*-- Rutas para la pestaña de usuariosSistema --*/
Route::group(['prefix' => 'usuarios/sistema', 'middleware' => 'admin'], function () {
	Route::get('/','UsersController@index');//Carga la tabla de usuarios del sistema
	Route::post('validar_usuario', 'UsersController@validar_usuario');//Checa si un usuario del sistema existe
	Route::post('guardar_usuario', 'UsersController@guardar_usuario');//Guarda un usuario del sistema
	Route::post('guardar_foto_usuario_sistema', 'UsersController@guardar_foto_usuario_sistema');//Guarda la foto de perfil de un usuario del sistema
	Route::post('eliminar_usuario', 'UsersController@eliminar_usuario');//Elimina un usuario del sistema
	Route::post('change_password', 'UsersController@change_password');//Elimina un usuario del sistema
});

/*-- Rutas para la pestaña de empresas--*/
Route::group(['prefix' => 'empresas', 'middleware' => 'supervisor'], function () {
	Route::get('/','EmpresasController@index');//Carga la tabla de empresas
	Route::post('guardar','EmpresasController@guardar');//Guarda los datos de una empresa
	Route::post('editar','EmpresasController@editar');//Edita los datos de una empresa
	Route::post('baja','EmpresasController@dar_baja');//Cambia el status de una empresa
	Route::post('baja/multiple','EmpresasController@dar_baja_multiples_empresas');//Cambia el status de una empresa

	#Prefijo para servicios
	Route::post('servicios','EmpresasController@cargar_servicios_empresa');//Carga los servicios de una empresa
	Route::post('servicios/guardar','EmpresasController@guardar_servicio');//Guarda el servicio de una empresa
	Route::post('servicios/editar','EmpresasController@editar_servicio');//Edita el servicio de una empresa
	Route::post('servicios/eliminar','EmpresasController@eliminar_servicio');//Elimina el servicio de una empresa
});

/*-- Rutas para la pestaña de empleados--*/
Route::group(['prefix' => 'empleados', 'middleware' => 'auth'], function () {
	Route::get('/','EmpleadosController@index');//Carga la tabla de empleados
	Route::get('formulario/{id?}','EmpleadosController@cargar_formulario');//Carga el formulario para editar un sólo empleado
	Route::get('detalle/{id?}','EmpleadosController@detalle_empleado');//Carga el formulario de empleados sólo para ver detalles

	Route::post('guardar','EmpleadosController@guardar');//Guarda los datos de una empleado
	Route::post('actualizar','EmpleadosController@actualizar');//Actualiza los datos de una empleado
	Route::post('baja','EmpleadosController@dar_baja');//Cambia el status de una empleado
	Route::post('baja/multiple','EmpleadosController@dar_baja_multiples_empresas');//Cambia el status de un empleado
});

/*--- Modulo pagos ---*/
Route::get('nominas/excel_master', 'PagosController@descargar_excel_master');
Route::post('pagos/servicios_empresa', 'PagosController@servicios_empresa');
Route::get('nominas', 'PagosController@index');
Route::get('historial', 'PagosController@historial');
Route::get('detalle-nomina/{id}', 'PagosController@show');
Route::get('altaNomina', 'PagosController@formulario');
Route::post('guardarPago', 'PagosController@store');
Route::post('guardarNominas', 'PagosController@save');
Route::get('pagar-nomina/{id}', 'PagosController@paid');
Route::get('pagar-nomina/exportar-excel/{id}', 'PagosController@exportar_excel_pagos');

#PDF
Route::get('nominas/pdf/{id}', 'PagosController@descargar_pdf_asistencias');
