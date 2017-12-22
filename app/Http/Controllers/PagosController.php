<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Pago;
use App\Empresa;
use App\Empleado;
use App\Asistencia;
use App\UsuarioPago;
use App\EmpresaServicio;
use DB;
use PDF;
use Excel, File;

class PagosController extends Controller
{
	/**
	 * Muestra la lista de asistencias pendientes por terminar/pagar.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		 if (auth()->check()) {
			$menu = $title = "Lista de asistencia";
			$pagos = Pago::where('status', '!=', '0')->get();

			$check = 0;
			return view('pagos.pagos', ['pagos' => $pagos, 'menu' => $menu, 'title' => $title]);
		} else {
			return redirect()->to('/');
		}
	}

	/**
	 * Muestra la lista de asistencias pagadas.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function historial()
	{
		if (auth()->check()) {
			$menu = $title = "Historial";
			$pagos = Pago::where('status', '0')->get();

			$check = 0;
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
			}

			return redirect()->action('PagosController@index')->with([ 'msg' => 'Lista de asistencia guardada', 'class' => 'alert-success' ]);
		} else {
			return redirect()->action('PagosController@index')->with([ 'msg' => 'Error al guardar la lista de asistencia, trate de nuevo', 'class' => 'alert-danger' ]);
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$title = "Lista de asistencia";
		$menu = "Lista de asistencia";
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

		return view('pagos.detalle', ['pago' => $pago, 'dias' => $days, 'menu' => $menu, 'title' => $title, 'asistencias' => $asistencias]);
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
		->select(DB::raw("usuario_pago_id, COUNT( case status when 'D' then 1 else null end OR case status when 'X' then 1 else null end OR case status when 'V' then 1 else null end ) AS total, 
			COUNT( case status when 'A' then 1 else null end ) as festivo"))
		->get();

		$pago_actualizado = DB::table('pagos')->where('id', $id)->update(['status' => 0]);//Se marca el pago como pagado

		return view('pagos.pagar', ['pago' => $pago,'menu' => $menu, 'title' => $title, 'asistencias' => $asistencias, 'pago_id' => $id]);
	}

	public function formulario() {
		$menu = "Lista de asistencia";
		$title = "Formulario de asistencia";
		$empresas = Empresa::where('status',1)->get();
		$trabajadores = Empleado::where('status',1)->get();

		return view('pagos.formulario', ['empresas' => $empresas, 'trabajadores' => $trabajadores, 'menu' => $menu, 'title' => $title]);
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
		$file = public_path()."/excel/master.xlsx";
		return response()->download($file, 'master.xlsx');
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

		$asistencias = Asistencia::leftJoin('usuario_pagos', 'usuario_pagos.id', '=', 'asistencias.usuario_pago_id')
		->leftJoin('empleados', 'empleados.id', '=', 'usuario_pagos.trabajador_id')
		->leftJoin('pagos', 'pagos.id', '=', 'usuario_pagos.pago_id')
		->leftJoin('empresa_servicio', 'empresa_servicio.id', '=', 'pagos.servicio_id')
		->leftJoin('empresas', 'empresas.id', '=', 'empresa_servicio.empresa_id')
		->whereIn('usuario_pago_id',$pago->PagoUsuarios->pluck('id'))
		->groupBy('usuario_pago_id')
		->select(DB::raw('CONCAT(empleados.nombre, " ",empleados.apellido) AS "Nombre completo", ROUND(COUNT(empresa_servicio.sueldo_diario_guardia) * sueldo_diario_guardia, 2) AS "Importe", 
			empleados.num_cuenta AS "Número de cuenta", empleados.num_empleado AS "Número de Id", CONCAT(DATE_FORMAT(pagos.fecha_inicio,  "%d %b %Y"), " - ", DATE_FORMAT(pagos.fecha_fin,  "%d %b %Y")) AS "Fecha de pagos", 
			COUNT( case asistencias.status when "D" then 1 else null end OR case asistencias.status when "X" then 1 else null end OR case asistencias.status when "V" then 1 else null end ) AS "Días",
			COUNT( case asistencias.status when "A" then 1 else null end ) as "Días festivos", empresas.nombre AS "Empresa"'))
		->get();

        Excel::create("Resumen de asistencias del $intervalo", function($excel) use($asistencias) {
            $excel->sheet('Hoja 1', function($sheet) use($asistencias) {
                $sheet->cells('A:G', function($cells) {
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                });
                
                $sheet->cells('A1:G1', function($cells) {
                    $cells->setFontWeight('bold');
                });

                $sheet->fromArray($asistencias);
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
