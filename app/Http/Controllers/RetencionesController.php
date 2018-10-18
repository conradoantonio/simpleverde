<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Excel;

use App\Empleado;
use App\Retencion;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class RetencionesController extends Controller
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

        $row = New Retencion;

        $row->empleado_id = $req->empleado_id;
        $row->empresa_id = $req->empresa_id;
        $row->importe = $req->importe;
        $row->empresa_id = $req->empresa_id;
        $row->fecha_inicio = $req->fecha_inicio;
        $row->fecha_fin = $req->fecha_fin;
        $row->num_dias = $req->num_dias;
        $row->comentarios = $req->comentarios;

        $row->save();

        $url = url($empleado->status == 1 ? 'empleados' : 'empleados/inactivos');

        return response(['msg' => 'Deducción registrada correctamente', 'status' => 'success', 'url' => $url], 200);
    }

    /**
     * Exporta el excel con las retenciones del empleado
     *
     * @return \Illuminate\Http\Response
     */
    public function exportar_excel($id)
    {
        $empleado = Empleado::findOrFail($id);
        $array = array();

        if (count($empleado->retenciones)) {
            foreach ($empleado->retenciones as $retencion) {
                $array[] = [
                    'Nombre completo' => $empleado->nombre.' '.$empleado->apellido_paterno.' '.$empleado->apellido_materno,
                    'Importe ' => number_format($retencion->importe,2),
                    'Número de días ' => $retencion->num_dias,
                    'Número de cuenta' => $empleado->num_cuenta,
                    'Número de empleado' => $empleado->num_empleado,
                    'Rango de fechas' => date('d M Y', strtotime($retencion->fecha_inicio)).' - '.date('d M Y', strtotime($retencion->fecha_fin)),
                    'Empresa ' => $retencion->empresa->nombre,
                    'Notas' => $retencion->comentarios
                ];

                $retencion->status = 1;

                $retencion->save();
            }
        }

        Excel::create("Retenciones de empleado $empleado->nombre", function($excel) use($array) {
            $excel->sheet('Hoja 1', function($sheet) use($array) {
                $sheet->cells('A:H', function($cells) {
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                });

                $sheet->cells('A1:H1', function($cells) {
                    $cells->setFontWeight('bold');
                });

                $sheet->fromArray($array);
            });
        })->export('xlsx');

        return ['msg'=>'Excel creado'];
    }

    /**
     * Exporta el excel con las retenciones del empleado
     *
     * @return \Illuminate\Http\Response
     */
    public function exportar_excel_multiple($status)
    {
        $empleados = Empleado::where('status', $status)->get();
        $array = array();

        if (count($empleados)) {
            foreach ($empleados as $empleado) {
                if (count($empleado->retenciones)) {
                    foreach ($empleado->retenciones as $retencion) {
                        $array[] = [
                            'Nombre completo' => $empleado->nombre.' '.$empleado->apellido_paterno.' '.$empleado->apellido_materno,
                            'Importe ' => number_format($retencion->importe,2),
                            'Número de días ' => $retencion->num_dias,
                            'Número de cuenta' => $empleado->num_cuenta,
                            'Número de empleado' => $empleado->num_empleado,
                            'Rango de fechas' => date('d M Y', strtotime($retencion->fecha_inicio)).' - '.date('d M Y', strtotime($retencion->fecha_fin)),
                            'Empresa ' => $retencion->empresa->nombre,
                            'Notas' => $retencion->comentarios,
                            'Status ' => $retencion->status == 0 ? 'Pendiente' : 'Atendido',
                        ];

                        //$retencion->status = 1;

                        //$retencion->save();
                    }
                }
            }
        }

        Excel::create("Retenciones de empleados", function($excel) use($array) {
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
