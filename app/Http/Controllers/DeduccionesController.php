<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Excel;

use App\Empleado;
use App\Deduccion;
use App\DeduccionDetalle;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class DeduccionesController extends Controller
{
    /**
     * Guarda los registros de deducciones
     *
     * @return \Illuminate\Http\Response
     */
    public function guardar(Request $req)
    {
        $empleado = Empleado::find($req->empleado_id);
        if ( !$empleado ) { return response(['msg' => 'ID de empleado inválido, trate nuevamente', 'status' => 'error'], 404); }

        $cantidad = number_format($req->total / $req->num_pagos, 2);

        $row = New Deduccion;

        $row->empleado_id = $req->empleado_id;
        $row->total = $req->total;
        $row->comentarios = $req->comentarios;
        $row->num_pagos = $req->num_pagos;

        $row->save();

        for ($i=0; $i < $req->num_pagos; $i++) { 
            $detail = New DeduccionDetalle;

            $detail->deduccion_id = $row->id;
            $detail->cantidad = $cantidad;
            $detail->status = 0;//Not paid

            $detail->save();
        }

        $url = url($empleado->status == 1 ? 'empleados' : 'empleados/inactivos');

        return response(['msg' => 'Deducción registrada correctamente', 'status' => 'success', 'url' => $url], 200);
    }

    /**
     * Asigna uno o más detalles de retenciones a un usuario en su hoja de pago
     *
     * @return \Illuminate\Http\Response
     */
    public function asignar_pago(Request $req)
    {
        if (!is_array($req->ids)) { return response(['msg' => 'Datos erróneos, por favor, trate de nuevo', 'status' => 'error'], 400); }

        foreach ($req->ids as $id) {
            $detalle = DeduccionDetalle::find($id);
            
            if ( !$detalle ) { return response(['msg' => 'Registro no encontrado, por favor, trate nuevamente', 'status' => 'error'], 404); }

            $detalle->usuario_pago_id = $req->usuario_pago_id;
            $detalle->status = 1;//Paid

            $detalle->save();
        }

        return response(['msg' => 'Deducción asignada a hoja de pago correctamente', 'status' => 'success', 'url' => $req->redirect_to], 200);
    }

    /**
     * Muestra las retenciones de un empleado
     *
     * @return \Illuminate\Http\Response
     */
    public function mostrar_detalles(Request $req)
    {
        $empleado = Empleado::find($req->empleado_id);

        if (!$empleado) { return response(['msg' => 'ID de empleado inválido', 'status' => 'error'], 404); }

        if ( count( $empleado->deducciones ) ) {
            foreach ( $empleado->deducciones as $deduccion ) {
                $deduccion->detalles;
            }
        }

        return $empleado;
    }

    /**
     * Exporta el excel con las deducciones del empleado
     *
     * @return \Illuminate\Http\Response
     */
    public function exportar_excel($id)
    {
        $empleado = Empleado::findOrFail($id);
        $array = array();

        if (count($empleado->deducciones)) {
            foreach ($empleado->deducciones as $deduccion) {
                foreach ($deduccion->detalles as $detalle) {
                    $array[] = [
                        'Nombre completo' => $empleado->nombre.' '.$empleado->apellido_paterno.' '.$empleado->apellido_materno,
                        'Monto total de deduccion ' => number_format($deduccion->total,2),
                        'Número de pagos ' => $deduccion->num_pagos,
                        'Cantidad de pago' => $detalle->cantidad,
                        'Status ' => $detalle->status == 0 ? 'Por pagar' : 'Pagado',
                        'Notas' => $deduccion->comentarios
                    ];
                }
            }
        }

        Excel::create("Deducciones de empleado $empleado->nombre", function($excel) use($array) {
            $excel->sheet('Hoja 1', function($sheet) use($array) {
                $sheet->cells('A:F', function($cells) {
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                });

                $sheet->cells('A1:F1', function($cells) {
                    $cells->setFontWeight('bold');
                });

                $sheet->fromArray($array);
            });
        })->export('xlsx');

        return ['msg'=>'Excel creado'];
    }

    /**
     * Exporta el excel con las deducciones del empleado
     *
     * @return \Illuminate\Http\Response
     */
    public function exportar_excel_multiple($status)
    {
        $empleados = Empleado::where('status', $status)->get();
        $array = array();

        if (count($empleados)) {
            foreach ($empleados as $empleado) {
                if (count($empleado->deducciones)) {
                    foreach ($empleado->deducciones as $deduccion) {
                        foreach ($deduccion->detalles as $detalle) {
                            $array[] = [
                                'Nombre completo' => $empleado->nombre.' '.$empleado->apellido_paterno.' '.$empleado->apellido_materno,
                                'Monto total de deduccion ' => number_format($deduccion->total,2),
                                'Número de pagos ' => $deduccion->num_pagos,
                                'Cantidad de pago' => $detalle->cantidad,
                                'Status ' => $detalle->status == 0 ? 'Por pagar' : 'Pagado',
                                'Notas' => $deduccion->comentarios
                            ];
                        }
                    }
                }
            }
        }

        Excel::create("Deducciones de empleados", function($excel) use($array) {
            $excel->sheet('Hoja 1', function($sheet) use($array) {
                $sheet->cells('A:F', function($cells) {
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                });

                $sheet->cells('A1:F1', function($cells) {
                    $cells->setFontWeight('bold');
                });

                $sheet->fromArray($array);
            });
        })->export('xlsx');

        return ['msg'=>'Excel creado'];
    }
}
