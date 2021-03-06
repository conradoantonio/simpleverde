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

Route::group(['middleware' => 'auth'], function () {
	/*-- Rutas para la pestaña de usuariosSistema --*/
	Route::group(['prefix' => 'usuarios/sistema'], function () {
		Route::get('/','UsersController@index');//Carga la tabla de usuarios del sistema
		Route::get('formulario/{id?}','UsersController@cargar_formulario');//Carga el formulario para editar un sólo usuario
		Route::post('validar_usuario', 'UsersController@validar_usuario');//Checa si un usuario del sistema existe
		Route::post('guardar', 'UsersController@guardar');//Guarda un usuario del sistema
		Route::post('editar', 'UsersController@editar');//Guarda un usuario del sistema
		Route::post('guardar_foto_usuario_sistema', 'UsersController@guardar_foto_usuario_sistema');//Guarda la foto de perfil de un usuario del sistema
		Route::post('eliminar_usuario', 'UsersController@eliminar_usuario');//Elimina un usuario del sistema
		Route::post('change_password', 'UsersController@change_password');//Elimina un usuario del sistema
	});

	/*-- Rutas para la pestaña de empresas--*/
	Route::group(['prefix' => 'empresas'], function () {
		Route::get('/','EmpresasController@index');//Carga la tabla de empresas
		Route::get('/inactivas','EmpresasController@inactivas');//Carga la tabla de empresas inactivas
		Route::post('guardar','EmpresasController@guardar');//Guarda los datos de una empresa
		Route::post('editar','EmpresasController@editar');//Edita los datos de una empresa
		Route::post('baja','EmpresasController@dar_baja');//Cambia el status de una empresa
		Route::get('exportar/individual/{status}/{id}','EmpresasController@exportar_excel');//Exporta una empresa a excel
		Route::get('exportar/general/{status}','EmpresasController@exportar_excel');//Exporta las empresas a excel con cierto status

		#Prefijo para servicios
		Route::post('servicios','EmpresasController@cargar_servicios_empresa');//Carga los servicios de una empresa
		Route::post('servicios/guardar','EmpresasController@guardar_servicio');//Guarda el servicio de una empresa
		Route::post('servicios/editar','EmpresasController@editar_servicio');//Edita el servicio de una empresa
		Route::post('servicios/eliminar','EmpresasController@eliminar_servicio');//Elimina el servicio de una empresa
	});

	/*-- Rutas para la pestaña de empleados--*/
	Route::group(['prefix' => 'empleados'], function () {
		Route::get('/','EmpleadosController@index');//Carga la tabla de empleados con status activo
		Route::get('/inactivos','EmpleadosController@inactivos');//Carga la tabla de empleados con status inactivo
		Route::get('formulario/{id?}','EmpleadosController@cargar_formulario');//Carga el formulario para editar un sólo empleado
		Route::get('detalle/{id?}','EmpleadosController@detalle_empleado');//Carga el formulario de empleados sólo para ver detalles

		Route::post('guardar','EmpleadosController@guardar');//Guarda los datos de una empleado
		Route::post('actualizar','EmpleadosController@actualizar');//Actualiza los datos de una empleado
		Route::post('baja','EmpleadosController@dar_baja');//Cambia el status de una empleado
		Route::post('baja/multiple','EmpleadosController@dar_baja_multiple');//Cambia el status de un empleado
		Route::get('exportar/individual/{status}/{id}','EmpleadosController@exportar_excel');//Exporta un empleado a excel
		Route::get('exportar/general/{status}','EmpleadosController@exportar_excel');//Exporta los empleados a excel con cierto status
	});

	/*Rutas para deducciones*/
	Route::group(['prefix' => 'deducciones'], function () {
		Route::post('guardar','DeduccionesController@guardar');//Guarda los datos de una deducción
		Route::post('eliminar','DeduccionesController@eliminar');//Elimina los datos de una deducción
		Route::post('pagar','DeduccionesController@asignar_pago');//Adjunta los pagos de deducción a una hoja de pago
		Route::post('reiniciar','DeduccionesController@remover_pago');//Remueve la relación entre una deducción y la hoja de pago (Reinicia)
		Route::post('mostrar-detalles','DeduccionesController@mostrar_detalles');//Muestra las deducciones de un empleado
		Route::get('excel/export/{empleado_id}','DeduccionesController@exportar_excel');//Exporta las deducciones del empleado
		Route::get('excel/export/general/{status}','DeduccionesController@exportar_excel_multiple');//Exporta las deducciones de los empleados dependiendo de su status
	});

	/*Rutas para retenciones*/
	Route::group(['prefix' => 'retenciones'], function () {
		Route::post('guardar','RetencionesController@guardar');//Guarda los datos de una retención
		Route::post('eliminar','RetencionesController@eliminar');//Elimina los datos de una retención
		Route::post('pagar','RetencionesController@asignar_pago');//Adjunta los pagos de retención a una hoja de pago
		Route::post('reiniciar','RetencionesController@remover_pago');//Remueve la relación entre una retención y la hoja de pago (Reinicia)
		Route::post('mostrar-detalles','RetencionesController@mostrar_detalles');//Muestra las retenciones de un empleado
		Route::get('excel/export/{empleado_id}','RetencionesController@exportar_excel');//Exporta las retenciones del empleado y cambia su status
		Route::get('excel/export/general/{status}','RetencionesController@exportar_excel_multiple');//Exporta las retenciones de los empleados dependiendo de su status
	});

	/*Rutas para conceptos*/
	Route::group(['prefix' => 'conceptos'], function () {
		Route::post('guardar','ConceptosController@guardar');//Guarda los datos de un concepto
		Route::post('eliminar','ConceptosController@eliminar');//Elimina los datos de un concepto
		Route::post('pagar','ConceptosController@asignar_pago');//Adjunta los pagos de un concepto a una hoja de pago
		Route::post('reiniciar','ConceptosController@remover_pago');//Remueve la relación entre un concepto y la hoja de pago (Reinicia)
		Route::post('mostrar-detalles','ConceptosController@mostrar_detalles');//Muestra las conceptos de un empleado
		Route::get('excel/export/{empleado_id}','ConceptosController@exportar_excel');//Exporta las conceptos del empleado y cambia su status
		Route::get('excel/export/general/{status}','ConceptosController@exportar_excel_multiple');//Exporta las conceptos de los empleados dependiendo de su status
	});


	/*--- Modulo pagos ---*/
	/*Route::group(['middleware' => 'role:Administrador,Nóminas,Recepción'], function () {*/
		Route::get('nominas/excel_master', 'PagosController@descargar_excel_master');
		Route::post('nominas/eliminar_listas', 'PagosController@eliminar_listas');

		Route::post('pagos/servicios_empresa', 'PagosController@servicios_empresa');
		Route::post('pagos/agregar_empleado', 'PagosController@add_worker');
		Route::post('pagos/eliminar_empleados', 'PagosController@eliminar_empleados_lista');
		Route::get('nominas', 'PagosController@index');
		Route::get('historial', 'PagosController@historial');
		Route::get('detalle-nomina/{id}/{reload?}', 'PagosController@show');
		Route::get('altaNomina', 'PagosController@formulario');
		Route::post('guardarPago', 'PagosController@store');
		Route::post('guardarNominas', 'PagosController@save');
		Route::get('pagar-nomina/{id}', 'PagosController@paid');
		Route::get('pagar-nomina/exportar-excel/{id}', 'PagosController@exportar_excel_pagos');

		#PDF
		Route::get('nominas/pdf/{id}', 'PagosController@descargar_pdf_asistencias');
	/*});*/
});