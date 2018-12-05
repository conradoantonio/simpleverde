<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Excel;

use App\Empleado;
use App\Concepto;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ConceptosController extends Controller
{
    /**
     * Guarda los registros de conceptos
     *
     * @return \Illuminate\Http\Response
     */
    public function guardar(Request $req)
    {
        $empleado = Empleado::find($req->empleado_id);
        if ( !$empleado ) { return response(['msg' => 'ID de empleado inválido, trate nuevamente', 'status' => 'error'], 404); }

        $row = New Concepto;

        $row->empleado_id = $req->empleado_id;
        $row->importe = $req->importe;
        $row->comentarios = $req->comentarios;

        $row->save();

        $url = url($empleado->status == 1 ? 'empleados' : 'empleados/inactivos');

        return response(['msg' => 'Concepto registrado correctamente', 'status' => 'success', 'url' => $url], 200);
    }

    /**
     * Elimina los conceptos y sus detalles de un empleado
     *
     * @return \Illuminate\Http\Response
     */
    public function eliminar(Request $req)
    {
        $row = Concepto::find($req->id);

        if (! $row ) { return response(['msg' => 'Registro no encontrado, trate de nuevo', 'status' => 'error'], 404); }

        $row->delete();

        $url = url($row->empleado->status == 1 ? 'empleados' : 'empleados/inactivos');

        $empleado = Empleado::find($row->empleado->id);

        $html = view('empleados.tablas.conceptos', compact(['empleado']))->render();

        return response(['msg' => 'Concepto eliminado correctamente', 'status' => 'success', 'url' => $url, 'html' => $html], 200);
    }

    /**
     * Asigna una o más conceptos a un usuario en su hoja de pago
     *
     * @return \Illuminate\Http\Response
     */
    public function asignar_pago(Request $req)
    {
        if (!is_array($req->ids)) { return response(['msg' => 'Datos erróneos, por favor, trate de nuevo', 'status' => 'error'], 400); }

        foreach ( $req->ids as $id ) {
            $row = Concepto::find($id);
            
            if ( !$row ) { return response(['msg' => 'Registro no encontrado, por favor, trate nuevamente', 'status' => 'error'], 404); }

            $row->usuario_pago_id = $req->usuario_pago_id;
            $row->status = 1;//Pagado

            $row->save();
        }

        return response(['msg' => 'Concepto asignado a hoja de pago correctamente', 'status' => 'success', 'url' => $req->redirect_to], 200);
    }

    /**
     * Remueve la relación entre un concepto y la hoja de pago (Reinicia)
     *
     * @return \Illuminate\Http\Response
     */
    public function remover_pago(Request $req)
    {
        $detalles = Concepto::where('usuario_pago_id', $req->usuario_pago_id)->update(['usuario_pago_id' => null, 'status' => 0]);
        
        if ( !$detalles ) { return response(['msg' => 'El empleado actual no cuenta con conceptos asiganados en esta lista de asistencia', 'status' => 'error'], 404); }

        return response(['msg' => 'Conceptos removidos (reiniciados) de esta lista de asistencias', 'status' => 'success', 'url' => $req->redirect_to], 200);
    }

    /**
     * Muestra las conceptos de un empleado
     *
     * @return \Illuminate\Http\Response
     */
    public function mostrar_detalles(Request $req)
    {
        $empleado = Empleado::with('conceptos')->whereHas('conceptos', function($query) {
            $query->whereDoesntHave('usuario_pago')->where('status', 0);
        })->find($req->empleado_id);

        if (!$empleado) { return response(['msg' => 'Este empleado no cuenta con conceptos por asociar', 'status' => 'info'], 404); }

        return $empleado;
    }

    /**
     * Exporta el excel con las conceptos del empleado
     *
     * @return \Illuminate\Http\Response
     */
    public function exportar_excel($id)
    {
        $empleado = Empleado::findOrFail($id);
        $array = array();

        if (count($empleado->conceptos)) {
            foreach ($empleado->conceptos as $concepto) {
                $array[] = [
                    'Nombre completo' => $empleado->nombre.' '.$empleado->apellido_paterno.' '.$empleado->apellido_materno,
                    'Importe ' => number_format($concepto->importe,2),
                    'Número de cuenta' => $empleado->num_cuenta,
                    'Número de empleado' => $empleado->num_empleado,
                    'Notas' => $concepto->comentarios
                ];

                #$concepto->status = 1;

                #$concepto->save();
            }
        }

        Excel::create("Conceptos de empleado $empleado->nombre", function($excel) use($array) {
            $excel->sheet('Hoja 1', function($sheet) use($array) {
                $sheet->cells('A:E', function($cells) {
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                });

                $sheet->cells('A1:E1', function($cells) {
                    $cells->setFontWeight('bold');
                });

                $sheet->fromArray($array);
            });
        })->export('xlsx');

        return ['msg'=>'Excel creado'];
    }

    /**
     * Exporta el excel con las conceptos del empleado
     *
     * @return \Illuminate\Http\Response
     */
    public function exportar_excel_multiple($status)
    {
        $empleados = Empleado::where('status', $status)->get();
        $array = array();

        if (count($empleados)) {
            foreach ($empleados as $empleado) {
                if (count($empleado->conceptos)) {
                    foreach ($empleado->conceptos as $concepto) {
                        $array[] = [
                            'Nombre completo' => $empleado->nombre.' '.$empleado->apellido_paterno.' '.$empleado->apellido_materno,
                            'Importe ' => number_format($concepto->importe,2),
                            'Número de cuenta' => $empleado->num_cuenta,
                            'Número de empleado' => $empleado->num_empleado,
                            'Notas' => $concepto->comentarios,
                            'Status ' => $concepto->status == 0 ? 'Pendiente' : 'Atendido',
                        ];

                        //$concepto->status = 1;

                        //$concepto->save();
                    }
                }
            }
        }

        Excel::create("Conceptos de empleados", function($excel) use($array) {
            $excel->sheet('Hoja 1', function($sheet) use($array) {
                $sheet->cells('A:I', function($cells) {
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                });

                $sheet->cells('A1:I1', function($cells) {
                    $cells->setFontWeight('bold');
                });

                $sheet->fromArray($array);
            });
        })->export('xlsx');

        return ['msg'=>'Excel creado'];
    }
}
