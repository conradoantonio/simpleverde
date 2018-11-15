<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use PDF;
use Excel, File;

use App\Pago;
use App\Empresa;
use App\Empleado;
use App\Asistencia;
use App\UsuarioPago;
use App\EmpresaServicio;

use App\Http\Requests;
use App\Http\Controllers\Controller;


class PagosController extends Controller
{
	/**
	 * Muestra la lista de asistencias pendientes por terminar/pagar.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $req)
	{
        if (auth()->user()->privilegios && auth()->user()->privilegios->asistencias == 1) {
			$menu = $title = "Lista de asistencia";
			$pagos = Pago::where('status', '!=', '0')->get();

			#dd($pagos[0]->PagoUsuarios()->delete());

			if ($req->ajax()){
				return view('pagos.tabla', ['pagos' => $pagos]);
			}
			return view('pagos.pagos', ['pagos' => $pagos, 'menu' => $menu, 'title' => $title]);
		} else {
			return view('errors.503');
		}
	}

	/**
	 * Muestra la lista de asistencias pagadas.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function historial()
	{
        if (auth()->user()->privilegios && auth()->user()->privilegios->historial_asistencias == 1) {
			$menu = $title = "Historial";
			$pagos = Pago::where('status', '0')->get();

			
			return view('pagos.pagos', ['pagos' => $pagos, 'menu' => $menu, 'title' => $title]);
		} else {
			return redirect()->to('/');
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $req)
	{
		$pago = new Pago();
		$pago->fill($req->all());
		if ( $pago->save() ){
			foreach ($req->trabajadores as $value) {
				$usuarioPago = new UsuarioPago();
				$usuarioPago->pago_id = $pago->id;
				$usuarioPago->trabajador_id = $value;
				$usuarioPago->save();

				$startTime = strtotime( $usuarioPago->pago->fecha_inicio );
				$endTime = strtotime( $usuarioPago->pago->fecha_fin );

				// Loop between timestamps, 24 hours at a time
				for ( $i = $startTime; $i <= $endTime; $i = $i + 86400 ) {
					$d = date( 'd', $i );
					$asistencia = new Asistencia();
					$asistencia->usuario_pago_id = $usuarioPago->id;
					$asistencia->dia = $d;
					$asistencia->status = '-';
					$asistencia->save();
				}
			}

			return redirect()->action('PagosController@index')->with([ 'msg' => 'Lista de asistencia guardada', 'class' => 'alert-success' ]);
		} else {
			return redirect()->action('PagosController@index')->with([ 'msg' => 'Error al guardar la lista de asistencia, trate de nuevo', 'class' => 'alert-danger' ]);
		}
	}

	/**
	 * Display the specified resource.
	 *
	 */
	public function show($id, $reload = false)
	{
		$title = "Lista de asistencia";
		$menu = "Lista de asistencia";
		$pago = Pago::with(['empresa', 'servicio'])->findOrFail($id);
		$trabajadores = Empleado::where('status',1)->get();

		$startTime = strtotime( $pago->fecha_inicio );
		$endTime = strtotime( $pago->fecha_fin );
		$days_ago = date('d', strtotime('-3 days'));
		
		$date1 = date_create(date('Y-m-d'));
		$date2 = date_create(date('Y-m-d', strtotime( "-3 days")));
		$diff = date_diff($date1,$date2);

		// Loop between timestamps, 24 hours at a time

		for ( $i = $startTime; $i <= $endTime; $i = $i + 86400 ) {
			$edit = false;
			$d = date( 'd', $i );
			/*if ( date('Y-m-d', strtotime("now")) == date('Y-m-d', $startTime) ){
				if ( $d <= date('d') ){
					$edit = true;
				}	
			} elseif ( $d >= $days_ago && $d <= date('d') ){
				$edit = true;
			}*/

			$days[] = ['dia' => date('w', $i), 'num' => $d, 'edit' => $edit];
		}


		$today = date('Y-m-d');
	    $today = date('Y-m-d', strtotime($today));
	    $inicio_d = date('Y-m-d', strtotime($pago->fecha_inicio));
	    $fin_d = date('Y-m-d', strtotime($pago->fecha_fin));

	    $c = $diff->d;
	    $dia = array();
	    while( $c > 0 ){
	    	$dia[] = date('d', strtotime(sprintf("-%d days", ($c))));
	    	$c--;
	    }

	    #if (($today >= $inicio_d) && ($today < $fin_d)){
			foreach ($days as &$day) {
				#echo $dia."<br>";
				if ( $day['num'] == $dia[0] || $day['num'] == $dia[1] || $day['num'] == $dia[2] || $day['num'] == date('d') || $day['num'] == date('d', strtotime($today . ' +1 day')) ){
		    		$day['edit'] = true;
		    	}
			}
		#}

		$asistencias = Asistencia::whereIn('usuario_pago_id',$pago->PagoUsuarios->pluck('id'))->get();
		if ($reload) {
			return view('pagos.tabla_asistencias', ['pago' => $pago, 'trabajadores' => $trabajadores, 'pago_id' => $id, 'dias' => $days, 'asistencias' => $asistencias]);
		}
		return view('pagos.detalle', ['pago' => $pago, 'trabajadores' => $trabajadores, 'pago_id' => $id, 'dias' => $days, 'menu' => $menu, 'title' => $title, 'asistencias' => $asistencias]);
	}

	/**
	 * Elimina una lista de asistencias con sus registros.
	 *
	 */
	public function eliminar_listas(Request $req)
	{
		$listas = Pago::whereIn('id', $req->checking);
		if ($listas->get()) {
			foreach ($listas->get() as $key => $lista) {
				foreach ($lista->PagoUsuarios as $pago_usuario) {
					//Desvincula las retenciones en caso de ser necesario
					if ( count ($pago_usuario->retenciones ) ) {
						foreach ($pago_usuario->retenciones as $retencion) {
							$retencion->update(['usuario_pago_id' => null, 'status' => 0]);
						}
					}

					//Desvincula las deducciones en caso de ser necesario
					if ( count ($pago_usuario->deducciones_detalles ) ) {
						foreach ($pago_usuario->deducciones_detalles as $detalle) {
							$detalle->update(['usuario_pago_id' => null, 'status' => 0]);
						}
					}
					$pago_usuario->asistencia()->delete();//Elimina las asistencias
				}
				$lista->PagoUsuarios()->delete();//Elimina los PagoUsuarios
			}
			$listas->delete();//Elimina la lista
			return response(['msg' => 'Éxito borrando la lista', 'status' => 'ok'], 200);
		} else {
			return response(['msg' => 'No se encontraron listas para borrar', 'status' => 'error'], 404);
		}
	}

	/**
	 * Agrega un trabajador a una lista de pago.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function add_worker(Request $req)
	{
		foreach ($req->trabajadores as $value) {
			$usuarioPago = new UsuarioPago();
			$usuarioPago->pago_id = $req->pago_id;
			$usuarioPago->trabajador_id = $value;
			$usuarioPago->save();

			$startTime = strtotime( $usuarioPago->pago->fecha_inicio );
			$endTime = strtotime( $usuarioPago->pago->fecha_fin );

			// Loop between timestamps, 24 hours at a time
			for ( $i = $startTime; $i <= $endTime; $i = $i + 86400 ) {
				$d = date( 'd', $i );
				$asistencia = new Asistencia();
				$asistencia->usuario_pago_id = $usuarioPago->id;
				$asistencia->dia = $d;
				$asistencia->status = '-';
				$asistencia->save();
			}
		}
	}

	/**
	 * Elimina empleados de la lista de pagos.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function eliminar_empleados_lista(Request $req)
	{
		$usuario_pagos = UsuarioPago::whereIn('id', $req->checking)->get();

		if ( count( $usuario_pagos ) ) {
			foreach ($usuario_pagos as $pago) {

				#Desvinculamos las retenciones
				if ( count ($pago->retenciones ) ) {
					foreach ($pago->retenciones as $retencion) {
						$retencion->update(['usuario_pago_id' => null, 'status' => 0]);
					}
				}

				#Desvinculamos las deducciones
				if ( count ($pago->deducciones_detalles ) ) {
					foreach ($pago->deducciones_detalles as $detalle) {
						$detalle->update(['usuario_pago_id' => null, 'status' => 0]);
					}
				}
			}

			$pago->delete();
		}
		$asistencias = Asistencia::whereIn('usuario_pago_id', $req->checking)->delete();

		if ($asistencias && $usuario_pagos){
        	return response(['msg' => 'Empleados eliminados correctamente', 'status' => 'ok'], 200);
		} else {
	        return response(['msg' => 'Error al eliminar los empleados de la lista', 'status' => 'error'], 404);
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function paid($id)
	{
		$title = "Resumen de hoja de asistencias";
		$menu = "Lista de asistencia";
		$pago = Pago::findOrFail($id);

		$asistencias = Asistencia::with(['pago.usuarios', 'pago.pago.servicio'])
		->whereIn('usuario_pago_id',$pago->PagoUsuarios->pluck('id'))
		#->whereIn('status',['D','X','V'])
		->groupBy('usuario_pago_id')
		->select(DB::raw("usuario_pago_id, COUNT( case status when 'D' then 1 else null end OR case status when 'X' then 1 else null end OR case status when 'V' then 1 else null end 
			OR case asistencias.status when 'C' then 1 else null end OR case asistencias.status when 'N' then 1 else null end) AS total,
			COUNT( case status when 'A' then 1 else null end ) as festivo, COUNT( case status when 'C' then 1 else null end ) as diurno, 
			COUNT( case status when 'N' then 1 else null end ) as nocturno"))
		->get();

		$pago_actualizado = DB::table('pagos')->where('id', $id)->update(['status' => 0]);//Se marca el pago como pagado

		return view('pagos.pagar', ['pago' => $pago, 'menu' => $menu, 'title' => $title, 'asistencias' => $asistencias, 'pago_id' => $id]);
	}

	public function formulario() 
	{
        if (auth()->user()->privilegios && auth()->user()->privilegios->asistencias == 1) {

			$menu = "Lista de asistencia";
			$title = "Formulario de asistencia";
			$empresas = Empresa::where('status',1)->get();
			$trabajadores = Empleado::where('status',1)->get();

			return view('pagos.formulario', ['empresas' => $empresas, 'trabajadores' => $trabajadores, 'menu' => $menu, 'title' => $title]);
		} else {
			return view('errors.503');
		}
	}

	public function save(Request $req) {
		$collection = json_decode($req->collection);

		foreach ($collection as $key => $value) {
			$aux = 0;
			$value = collect($value);

			Asistencia::where('usuario_pago_id', $value['pago_id'])->delete();
			$UsuarioPago = UsuarioPago::find($value['pago_id']);
			$UsuarioPago->notas = $value['notas'];

			$days = $value['days'];

			foreach ($days as $val) {
				$asistencias = collect($val);
				$asistencia = new Asistencia();
				$asistencia->usuario_pago_id = $value['pago_id'];
				$asistencia->dia = $asistencias['dia'];
				$asistencia->status = $asistencias['status'];
				$asistencia->save();
			}

			/*if ( $UsuarioPago->asistencia->where('status','')->count() > 0 && $UsuarioPago->pago->status != 3 ){
				$UsuarioPago->pago->status = 1;
			} else {
				$UsuarioPago->pago->status = 2;
			}*/

			$UsuarioPago->save();

			$aux = 1;
		}

		$asistencia = Asistencia::with('pago')->whereIn('usuario_pago_id', collect($collection[0]->pago_id))->where('status', '')->get();
		$pago = Pago::whereIn('id',collect($collection[0]->real_id_pago))->first();
		if ( !$asistencia->isEmpty() ){
			$pago->status = 1;
		} else {
			$pago->status = 2;
		}
		$pago->save();

		return [ 'save' => true, 'status' => $pago->status ];
	}

	/**
	 * Obtiene los servicios de una empresa
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function descargar_excel_master(Request $request)
	{
		$file = public_path("excel/Master_TP.xlsm");
		return response()->download($file, 'Master_TP.xlsm');
	}


	/**
     *===============================================================================================================================================================================
     *=                                                           Empiezan las funciones relacionadas a la vista de pagos                                                           =
     *===============================================================================================================================================================================
     */

	/**
	 * Obtiene los servicios de una empresa
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function servicios_empresa(Request $request)
	{
		$servicios = EmpresaServicio::where('empresa_id', $request->empresa_id)->get();
		return $servicios;
	}

	/**
	 * Exporta el excel que contiene la información de pago del guardia
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function exportar_excel_pagos($id)
    {
		$pago = Pago::findOrFail($id);
		$intervalo = date('d-M-Y', strtotime($pago->fecha_inicio)).' al '.date('d-M-Y', strtotime($pago->fecha_fin));

		$asistencias = Asistencia::with(['pago.usuarios', 'pago.pago.servicio'])
		->whereIn('usuario_pago_id',$pago->PagoUsuarios->pluck('id'))
		#->whereIn('status',['D','X','V'])
		->groupBy('usuario_pago_id')
		->select(DB::raw("usuario_pago_id, COUNT( case status when 'D' then 1 else null end OR case status when 'X' then 1 else null end OR case status when 'V' then 1 else null end 
			OR case asistencias.status when 'C' then 1 else null end OR case asistencias.status when 'N' then 1 else null end) AS total,
			COUNT( case status when 'A' then 1 else null end ) as festivo, COUNT( case status when 'C' then 1 else null end ) as diurno, 
			COUNT( case status when 'N' then 1 else null end ) as nocturno"))
		->get();

		$array = array();
		$notas_ded = '';

		foreach ($asistencias as $asistencia) {
			$notas_ded = '';
			$importe = 0;

			#Calcula el importe
			if ( count( $asistencia->pago->retenciones ) ) {
				$importe = 0;
			} elseif ( count( $asistencia->pago->deducciones_detalles ) ) {
				$importe = ($asistencia->pago->pago->servicio->sueldo_diario_guardia*$asistencia->total) - ($asistencia->pago->deducciones_detalles->sum('cantidad'));
			} else {
				$importe = $asistencia->pago->pago->servicio->sueldo_diario_guardia*$asistencia->total;
			}

			if ( count($asistencia->pago->deducciones_detalles) ) {
				foreach ( $asistencia->pago->deducciones_detalles as $detalle ) {
					$notas_ded .= $detalle->deduccion->comentarios."\n";
				}
			}

			$array[] = [
				'Nombre completo' => $asistencia->pago->usuarios->nombre.' '.$asistencia->pago->usuarios->apellido_paterno.' '.$asistencia->pago->usuarios->apellido_materno,
				'Importe ' => number_format( $importe, 2 ),
				'Número de cuenta' => $asistencia->pago->usuarios->num_cuenta,
				'Número de empleado' => $asistencia->pago->usuarios->num_empleado,
				'Fecha de pagos' => date('d M Y', strtotime($asistencia->pago->pago->fecha_inicio)).' - '.date('d M Y', strtotime($asistencia->pago->pago->fecha_fin)),
				'Días' => $asistencia->total,
				'Dias festivos' => $asistencia->festivo,
				'Turnos diurnos' => $asistencia->diurno,
				'Turnos nocturnos' => $asistencia->nocturno,
				'Empresa ' => $pago->empresa->nombre,
				'Deducciones' => number_format($asistencia->pago->deducciones_detalles->sum('cantidad'),2),
				'Retenciones' => number_format($asistencia->pago->retenciones->sum('importe'),2),
				'Notas' => $asistencia->pago->notas,
				'Notas (Deducciones)' => $notas_ded
			];
		}

        Excel::create("Resumen de asistencias del $intervalo", function($excel) use($array) {
            $excel->sheet('Hoja 1', function($sheet) use($array) {
                $sheet->cells('A:L', function($cells) {
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                });

                $sheet->cells('A1:L1', function($cells) {
                    $cells->setFontWeight('bold');
                });

                $sheet->fromArray($array);
            });
        })->export('xlsx');

        return ['msg'=>'Excel creado'];
    }

    /**
	 * Exporta la tabla de asistencias a un pdf
	 *
	 */
    public function descargar_pdf_asistencias($id) {
    	$pago = Pago::with(['empresa', 'servicio'])->findOrFail($id);

		$startTime = strtotime( $pago->fecha_inicio );
		$endTime = strtotime( $pago->fecha_fin );
		$days_ago = date('d', strtotime('-3 days'));

		// Loop between timestamps, 24 hours at a time
		for ( $i = $startTime; $i <= $endTime; $i = $i + 86400 ) {
			$edit = false;
			$d = date( 'd', $i );
			if ( $d >= $days_ago && $d <= date('d') ){
				$edit = true;
			}
			$days[] = ['dia' => date('w', $i), 'num' => $d, 'edit' => $edit];
		}

		$asistencias = Asistencia::whereIn('usuario_pago_id',$pago->PagoUsuarios->pluck('id'))->get();

		//return view('pagos.detalle', ['pago' => $pago, 'dias' => $days, 'menu' => $menu, 'title' => $title, 'asistencias' => $asistencias]);

		$pdf = PDF::loadView('pagos.detalle_asistencias_pdf', ['pago' => $pago, 'dias' => $days, 'asistencias' => $asistencias])
		->setPaper('letter', 'landscape')->setWarnings(false);
        return $pdf->stream('archivo.pdf');//Visualiza el archivo sin descargarlo
        //return $pdf->download('archivo.pdf');//Descarga directamente el archivo
    }
}
