<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Excel;
use App\Empleado;
use App\Uniforme;
use App\Aditamento;
use App\Documentacion;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class EmpleadosController extends Controller
{
    /**
     * Carga la tabla de empleados activos.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $title = $menu = "Empleados (Activos)";
        $status = 1;
        $empleados = Empleado::where('status', $status)->get();
        
        if ($req->ajax()) {
            return view('empleados.tabla', ['empleados' => $empleados, 'status' => $status]);
        }
        return view('empleados.empleados', ['empleados' => $empleados, 'status' => $status, 'menu' => $menu, 'title' => $title]);
    }

    /**
     * Carga la tabla de empleados inactivos.
     *
     * @return \Illuminate\Http\Response
     */
    public function inactivos(Request $req)
    {
        $title = $menu = "Empleados (Inactivos)";
        $status = 0;
        $empleados = Empleado::where('status', $status)->get();
        
        if ($req->ajax()) {
            return view('empleados.tabla', ['empleados' => $empleados, 'status' => $status]);
        }
        return view('empleados.empleados', ['empleados' => $empleados, 'status' => $status, 'menu' => $menu, 'title' => $title]);
    }

    /**
     * Carga el formulario de empleados.
     *
     * @return \Illuminate\Http\Response
     */
    public function cargar_formulario($id = 0)
    {
        $title = "Formulario de empleados";
        $menu = "Empleados";
        $empleado = null;
        $editable = 1;
        if ($id) {
            $empleado = Empleado::find($id);
            $empleado->documentacion = $empleado->documentacion;
        }
        return view('empleados.formulario', ['empleado' => $empleado, 'editable' => $editable, 'menu' => $menu, 'title' => $title]);
    }

    /**
     * Carga el formulario de empleados sólo para ver detalles.
     *
     * @return \Illuminate\Http\Response
     */
    public function detalle_empleado($id)
    {
        $title = "Detalle de empleado";
        $menu = "Empleados";
        $empleado = null;
        $editable = 0;
        if ($id) {
            $empleado = Empleado::find($id);
            $empleado->documentacion = $empleado->documentacion;
        } else {
            return view('empleados.formulario', ['empleado' => $empleado, 'editable' => 1, 'menu' => $menu, 'title' => $title]);//Se regresa la vista para dar de alta un formulario
        }

        return view('empleados.formulario', ['empleado' => $empleado, 'editable' => $editable, 'menu' => $menu, 'title' => $title]);
    }

    /**
     * Guarda los datos de un empleado.
     *
     * @return \Illuminate\Http\Response
     */
    public function guardar(Request $req)
    {
        $empleado = New Empleado;

        $empleado->nombre = $req->nombre;
        $empleado->apellido_paterno = $req->apellido_paterno;
        $empleado->apellido_materno = $req->apellido_materno;
        $empleado->num_empleado = $req->num_empleado;
        $empleado->num_cuenta = $req->num_cuenta;
        $empleado->domicilio = $req->domicilio;
        $empleado->ciudad = $req->ciudad;
        $empleado->telefono = $req->telefono;
        $empleado->rfc = $req->rfc;
        $empleado->curp = $req->curp;
        $empleado->nss = $req->nss;
        $empleado->telefono_emergencia = $req->telefono_emergencia;
        $empleado->fecha_ingreso = $req->fecha_ingreso;
        $empleado->escolaridad = $req->escolaridad;
        $empleado->infonavit = $req->infonavit;
        $empleado->vacaciones = $req->vacaciones;
        $empleado->pensionado = $req->pensionado;
        $empleado->perfil_laboral = $req->perfil_laboral;
        $empleado->fecha_baja = $req->fecha_baja;
        $empleado->motivo_baja = $req->motivo_baja;
        $empleado->fecha_finiquito = $req->fecha_finiquito;
        $empleado->descripcion_finiquito = $req->descripcion_finiquito;
        $empleado->fecha_entrega_papeles = $req->fecha_entrega_papeles;
        $empleado->entrega_papeles = $req->entrega_papeles;

        $empleado->save();

        $documentacion = New Documentacion;
        $documentacion->empleado_id = $empleado->id;
        $documentacion->comprobante_domicilio = $req->comprobante_domicilio ? 1 : 0;
        $documentacion->identificacion = $req->identificacion ? 1 : 0;
        $documentacion->curp = $req->curp_documento ? 1 : 0;
        $documentacion->rfc = $req->rfc_documento ? 1 : 0;
        $documentacion->hoja_imss = $req->hoja_imss ? 1 : 0;
        $documentacion->carta_no_antecedentes_penales = $req->carta_no_antecedentes_penales ? 1 : 0;
        $documentacion->acta_nacimiento = $req->acta_nacimiento ? 1 : 0;
        $documentacion->comprobante_estudios = $req->comprobante_estudios ? 1 : 0;
        $documentacion->resultado_psicometrias = $req->resultado_psicometrias ? 1 : 0;
        $documentacion->examen_socieconomico = $req->examen_socieconomico ? 1 : 0;
        $documentacion->examen_toxicologico = $req->examen_toxicologico ? 1 : 0;
        $documentacion->solicitud_frente_vuelta = $req->solicitud_frente_vuelta ? 1 : 0;
        $documentacion->deposito_uniforme = $req->deposito_uniforme ? 1 : 0;
        $documentacion->constancia_recepcion_uniforme = $req->constancia_recepcion_uniforme ? 1 : 0;
        $documentacion->comprobante_recepcion_reglamento_interno_trabajo = $req->comprobante_recepcion_reglamento_interno_trabajo ? 1 : 0;
        $documentacion->autorizacion_pago_tarjeta = $req->autorizacion_pago_tarjeta ? 1 : 0;
        $documentacion->carta_aceptacion_cambio_lugar = $req->carta_aceptacion_cambio_lugar ? 1 : 0;
        $documentacion->finiquito = $req->finiquito ? 1 : 0;
        $documentacion->calendario = $req->calendario ? 1 : 0;
        $documentacion->formato_datos_personales = $req->formato_datos_personales ? 1 : 0;
        $documentacion->solicitud_autorizacion_consulta = $req->solicitud_autorizacion_consulta ? 1 : 0;
        $documentacion->licencia_conduccion = $req->licencia_conduccion;

        $documentacion->save();

        $uniforme = New Uniforme;
        $uniforme->empleado_id = $empleado->id;
        $uniforme->playera_polo = $req->playera_polo ? 1 : 0;
        $uniforme->camisa = $req->camisa ? 1 : 0;
        $uniforme->pantalones = $req->pantalones ? 1 : 0;
        $uniforme->chaleco = $req->chaleco ? 1 : 0;
        $uniforme->sueter = $req->sueter ? 1 : 0;
        $uniforme->chamarra = $req->chamarra ? 1 : 0;
        $uniforme->gorra = $req->gorra ? 1 : 0;
        $uniforme->botas = $req->botas ? 1 : 0;
        $uniforme->traje = $req->traje ? 1 : 0;
        $uniforme->corbata = $req->corbata ? 1 : 0;
        $uniforme->otros = $req->otros_uniformes;

        $uniforme->save();

        $aditamento = New Aditamento;
        $aditamento->empleado_id = $empleado->id;
        $aditamento->fornitura = $req->fornitura ? 1 : 0;
        $aditamento->tolete = $req->tolete ? 1 : 0;
        $aditamento->gas = $req->gas ? 1 : 0;
        $aditamento->aros_aprehensores = $req->aros_aprehensores ? 1 : 0;
        $aditamento->radio = $req->radio ? 1 : 0;
        $aditamento->celular = $req->celular ? 1 : 0;
        $aditamento->lampara = $req->lampara ? 1 : 0;
        $aditamento->otros = $req->otros_aditamentos;
        
        $aditamento->save();

        return response(['msg' => 'Empleado actualizado correctamente', 'status' => 'success', 'url' => url('empleados')], 200);
    }

    /**
     * Actualiza los datos de un empleado.
     *
     * @return \Illuminate\Http\Response
     */
    public function actualizar(Request $req)
    {
        $empleado = Empleado::find($req->id);
        $documentacion = Documentacion::find($req->documentacion_id);
        $uniforme = Uniforme::findOrCreate($req->uniforme_id);
        $aditamento = Aditamento::findOrCreate($req->aditamento_id);

        if ($empleado && $documentacion) {
            /*Información del empleado*/
            $empleado->nombre = $req->nombre;
            $empleado->apellido_paterno = $req->apellido_paterno;
            $empleado->apellido_materno = $req->apellido_materno;
            $empleado->num_empleado = $req->num_empleado;
            $empleado->num_cuenta = $req->num_cuenta;
            $empleado->domicilio = $req->domicilio;
            $empleado->ciudad = $req->ciudad;
            $empleado->telefono = $req->telefono;
            $empleado->rfc = $req->rfc;
            $empleado->curp = $req->curp;
            $empleado->nss = $req->nss;
            $empleado->telefono_emergencia = $req->telefono_emergencia;
            $empleado->fecha_ingreso = $req->fecha_ingreso;
            $empleado->escolaridad = $req->escolaridad;
            $empleado->infonavit = $req->infonavit;
            $empleado->vacaciones = $req->vacaciones;
            $empleado->pensionado = $req->pensionado;
            $empleado->perfil_laboral = $req->perfil_laboral;
            $empleado->fecha_baja = $req->fecha_baja;
            $empleado->motivo_baja = $req->motivo_baja;
            $empleado->fecha_finiquito = $req->fecha_finiquito;
            $empleado->descripcion_finiquito = $req->descripcion_finiquito;
            $empleado->fecha_entrega_papeles = $req->fecha_entrega_papeles;
            $empleado->entrega_papeles = $req->entrega_papeles;

            $empleado->save();

            /*Documentación del empleado*/
            $documentacion->comprobante_domicilio = $req->comprobante_domicilio ? 1 : 0;
            $documentacion->identificacion = $req->identificacion ? 1 : 0;
            $documentacion->curp = $req->curp_documento ? 1 : 0;
            $documentacion->rfc = $req->rfc_documento ? 1 : 0;
            $documentacion->hoja_imss = $req->hoja_imss ? 1 : 0;
            $documentacion->carta_no_antecedentes_penales = $req->carta_no_antecedentes_penales ? 1 : 0;
            $documentacion->acta_nacimiento = $req->acta_nacimiento ? 1 : 0;
            $documentacion->comprobante_estudios = $req->comprobante_estudios ? 1 : 0;
            $documentacion->resultado_psicometrias = $req->resultado_psicometrias ? 1 : 0;
            $documentacion->examen_socieconomico = $req->examen_socieconomico ? 1 : 0;
            $documentacion->examen_toxicologico = $req->examen_toxicologico ? 1 : 0;
            $documentacion->solicitud_frente_vuelta = $req->solicitud_frente_vuelta ? 1 : 0;
            $documentacion->deposito_uniforme = $req->deposito_uniforme ? 1 : 0;
            $documentacion->constancia_recepcion_uniforme = $req->constancia_recepcion_uniforme ? 1 : 0;
            $documentacion->comprobante_recepcion_reglamento_interno_trabajo = $req->comprobante_recepcion_reglamento_interno_trabajo ? 1 : 0;
            $documentacion->autorizacion_pago_tarjeta = $req->autorizacion_pago_tarjeta ? 1 : 0;
            $documentacion->carta_aceptacion_cambio_lugar = $req->carta_aceptacion_cambio_lugar ? 1 : 0;
            $documentacion->finiquito = $req->finiquito ? 1 : 0;
            $documentacion->calendario = $req->calendario ? 1 : 0;
            $documentacion->formato_datos_personales = $req->formato_datos_personales ? 1 : 0;
            $documentacion->solicitud_autorizacion_consulta = $req->solicitud_autorizacion_consulta ? 1 : 0;
            $documentacion->licencia_conduccion = $req->licencia_conduccion;

            $documentacion->save();

            /*Uniforme del empleado*/
            $uniforme->empleado_id = $empleado->id;
            $uniforme->playera_polo = $req->playera_polo ? 1 : 0;
            $uniforme->camisa = $req->camisa ? 1 : 0;
            $uniforme->pantalones = $req->pantalones ? 1 : 0;
            $uniforme->chaleco = $req->chaleco ? 1 : 0;
            $uniforme->sueter = $req->sueter ? 1 : 0;
            $uniforme->chamarra = $req->chamarra ? 1 : 0;
            $uniforme->gorra = $req->gorra ? 1 : 0;
            $uniforme->botas = $req->botas ? 1 : 0;
            $uniforme->traje = $req->traje ? 1 : 0;
            $uniforme->corbata = $req->corbata ? 1 : 0;
            $uniforme->otros = $req->otros_uniformes;

            $uniforme->save();

            /*Aditamento del empleado*/
            $aditamento->empleado_id = $empleado->id;
            $aditamento->fornitura = $req->fornitura ? 1 : 0;
            $aditamento->tolete = $req->tolete ? 1 : 0;
            $aditamento->gas = $req->gas ? 1 : 0;
            $aditamento->aros_aprehensores = $req->aros_aprehensores ? 1 : 0;
            $aditamento->radio = $req->radio ? 1 : 0;
            $aditamento->celular = $req->celular ? 1 : 0;
            $aditamento->lampara = $req->lampara ? 1 : 0;
            $aditamento->otros = $req->otros_aditamentos;

            $aditamento->save();

            $url = url($empleado->status == 1 ? 'empleados' : 'empleados/inactivas');
            return response(['msg' => 'Empleado actualizado correctamente', 'status' => 'success', 'url' => $url], 200);
        }
        return response(['msg' => 'Error al actualizar el cliente', 'status' => 'error'], 404);
    }

    /**
     * Da de baja un empleado.
     *
     * @return response
     */
    public function dar_baja(Request $req)
    {
        $empleado = Empleado::find($req->id);
        if ($empleado) {
            $empleado->update(['status' => $req->status]);
            return response(['msg' => 'Empleado dado de baja correctamente', 'status' => 'ok'], 200);
        } else {
            return response(['msg' => 'No es posible dar de baja este empleado', 'status' => 'error'], 404);
        }
    }

    /**
     * Elimina múltiples empleados al mismo tiempo.
     *
     * @return response
     */
    public function dar_baja_multiple(Request $req)
    {
        try {
            Empleado::whereIn('id', $req->checking)
            ->update(['status' => $req->status]);
            return response(['msg' => 'Los empleados seleccionados fueron dados de baja correctamente', 'status' => 'ok'], 200);
        } catch(\Illuminate\Database\QueryException $ex) {
            return $ex->getMessage();
        }
    }

    /**
     * Exporta todos los empleados a excel.
     *
     * @return response
     */
    public function exportar_excel($status, $id = false)
    {
        $nombre_excel = 'Empleado Info';
        $empleados = Empleado::select(DB::raw("empleados.*, 
            IF(documentacion.comprobante_domicilio = 1, 'Si', 'No') as 'Comprobante domicilio', 
            IF(documentacion.identificacion = 1, 'Si', 'No') as 'Identificación',
            IF(documentacion.curp = 1, 'Si', 'No') as 'CURP',
            IF(documentacion.rfc = 1, 'Si', 'No') as 'RFC',
            IF(documentacion.hoja_imss = 1, 'Si', 'No') as 'Hoja del IMSS',
            IF(documentacion.carta_no_antecedentes_penales = 1, 'Si', 'No') as 'Carta de no antecedentes penales',
            IF(documentacion.acta_nacimiento = 1, 'Si', 'No') as 'Acta de nacimiento',
            IF(documentacion.comprobante_estudios = 1, 'Si', 'No') as 'Comprobante de estudios',
            IF(documentacion.resultado_psicometrias = 1, 'Si', 'No') as 'Resultado de psicometrías',
            IF(documentacion.examen_socieconomico = 1, 'Si', 'No') as 'Examen socieconómico',
            IF(documentacion.examen_toxicologico = 1, 'Si', 'No') as 'Examen toxicológico',
            IF(documentacion.solicitud_frente_vuelta = 1, 'Si', 'No') as 'Solicitud frente y vuelta',
            IF(documentacion.deposito_uniforme = 1, 'Si', 'No') as 'Depósito de uniforme',
            IF(documentacion.constancia_recepcion_uniforme = 1, 'Si', 'No') as 'Constancia de recepción de uniforme',
            IF(documentacion.comprobante_recepcion_reglamento_interno_trabajo = 1, 'Si', 'No') as 'Comprobante de recepción del reglamento interno de trabajo',
            IF(documentacion.autorizacion_pago_tarjeta = 1, 'Si', 'No') as 'Autorización pago con tarjeta',
            IF(documentacion.carta_aceptacion_cambio_lugar = 1, 'Si', 'No') as 'Carta de aceptación por cambio de lugar',
            IF(documentacion.finiquito = 1, 'Si', 'No') as 'Finiquito',
            IF(documentacion.calendario = 1, 'Si', 'No') as 'Calendario',
            IF(documentacion.formato_datos_personales = 1, 'Si', 'No') as 'Formato de datos personales',
            IF(documentacion.solicitud_autorizacion_consulta = 1, 'Si', 'No') as 'Solicitud de autorización de consulta',
            IF(documentacion.licencia_conduccion = 1, 'Si', 'No') as 'Licencia de conducir',
            IF(uniformes.playera_polo = 1, 'Si', 'No') as 'Playera polo',
            IF(uniformes.camisa = 1, 'Si', 'No') as 'Camisa',
            IF(uniformes.pantalones = 1, 'Si', 'No') as 'Pantalones',
            IF(uniformes.chaleco = 1, 'Si', 'No') as 'Chaleco',
            IF(uniformes.sueter = 1, 'Si', 'No') as 'Sueter',
            IF(uniformes.chamarra = 1, 'Si', 'No') as 'Chamarra',
            IF(uniformes.gorra = 1, 'Si', 'No') as 'Gorra',
            IF(uniformes.botas = 1, 'Si', 'No') as 'Botas',
            IF(uniformes.traje = 1, 'Si', 'No') as 'Traje',
            IF(uniformes.corbata = 1, 'Si', 'No') as 'Corbata',
            IF(ISNULL(uniformes.otros),'',uniformes.otros) as 'Otros uniformes',
            IF(aditamentos.fornitura = 1, 'Si', 'No') as 'Fornitura',
            IF(aditamentos.tolete = 1, 'Si', 'No') as 'Tolete',
            IF(aditamentos.gas = 1, 'Si', 'No') as 'Gas',
            IF(aditamentos.aros_aprehensores = 1, 'Si', 'No') as 'Aros aprehensores',
            IF(aditamentos.radio = 1, 'Si', 'No') as 'Radio',
            IF(aditamentos.celular = 1, 'Si', 'No') as 'Celular',
            IF(aditamentos.lampara = 1, 'Si', 'No') as 'Lampara',
            IF(ISNULL(aditamentos.otros),'',aditamentos.otros) as 'Otros aditamentos'
            "
        ))
        ->leftJoin('documentacion', 'empleados.id', '=', 'documentacion.empleado_id')
        ->leftJoin('aditamentos', 'empleados.id', '=', 'aditamentos.empleado_id')
        ->leftJoin('uniformes', 'empleados.id', '=', 'uniformes.empleado_id');


        if ($id) {
            $empleados = $empleados->where('empleados.id', $id)->get();
            $nombre_excel = "Empleado ".$empleados[0]->nombre;

        } else {
            $empleados = $empleados->where('empleados.status', $status)->get();
            $nombre_excel = "Empleados";
        }

        Excel::create($nombre_excel, function($excel) use($empleados) {
            $excel->sheet('Hoja 1', function($sheet) use($empleados) {
                $sheet->cells('A:BO', function($cells) {
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                });
                
                $sheet->cells('A1:BO1', function($cells) {
                    $cells->setFontWeight('bold');
                });

                $sheet->fromArray($empleados);
            });
        })->export('xlsx');

        return ['msg'=>'Excel creado'];
    }
}
