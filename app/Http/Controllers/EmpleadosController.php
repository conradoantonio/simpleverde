<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Empleado;
use App\Documentacion;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class EmpleadosController extends Controller
{
    /**
     * Carga la tabla de empleados.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = $menu = "Empleados";
        $empleados = Empleado::where('status', 1)->get();
        foreach ($empleados as $empleado) { $empleado->documentacion; }
        
        if ($request->ajax()) {
            return view('empleados.tabla', ['empleados' => $empleados]);
        }
        return view('empleados.empleados', ['empleados' => $empleados, 'menu' => $menu, 'title' => $title]);
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
    public function guardar(Request $request)
    {
        $empleado = New Empleado;

        $empleado->nombre = $request->nombre;
        $empleado->apellido = $request->apellido;
        $empleado->num_empleado = $request->num_empleado;
        $empleado->num_cuenta = $request->num_cuenta;
        $empleado->domicilio = $request->domicilio;
        $empleado->ciudad = $request->ciudad;
        $empleado->telefono = $request->telefono;
        $empleado->rfc = $request->rfc;
        $empleado->curp = $request->curp;
        $empleado->nss = $request->nss;
        $empleado->telefono_emergencia = $request->telefono_emergencia;

        $empleado->save();

        $documentacion = New Documentacion;
        $documentacion->empleado_id = $empleado->id;
        $documentacion->comprobante_domicilio = $request->comprobante_domicilio ? 1 : 0;
        $documentacion->identificacion = $request->identificacion ? 1 : 0;
        $documentacion->curp = $request->curp_documento ? 1 : 0;
        $documentacion->rfc = $request->rfc_documento ? 1 : 0;
        $documentacion->hoja_imss = $request->hoja_imss ? 1 : 0;
        $documentacion->carta_no_antecedentes_penales = $request->carta_no_antecedentes_penales ? 1 : 0;
        $documentacion->acta_nacimiento = $request->acta_nacimiento ? 1 : 0;
        $documentacion->comprobante_estudios = $request->comprobante_estudios ? 1 : 0;
        $documentacion->resultado_psicometrias = $request->resultado_psicometrias ? 1 : 0;
        $documentacion->examen_socieconomico = $request->examen_socieconomico ? 1 : 0;
        $documentacion->examen_toxicologico = $request->examen_toxicologico ? 1 : 0;
        $documentacion->solicitud_frente_vuelta = $request->solicitud_frente_vuelta ? 1 : 0;
        $documentacion->deposito_uniforme = $request->deposito_uniforme ? 1 : 0;
        $documentacion->constancia_recepcion_uniforme = $request->constancia_recepcion_uniforme ? 1 : 0;
        $documentacion->comprobante_recepcion_reglamento_interno_trabajo = $request->comprobante_recepcion_reglamento_interno_trabajo ? 1 : 0;
        $documentacion->autorizacion_pago_tarjeta = $request->autorizacion_pago_tarjeta ? 1 : 0;
        $documentacion->carta_aceptacion_cambio_lugar = $request->carta_aceptacion_cambio_lugar ? 1 : 0;
        $documentacion->finiquito = $request->finiquito ? 1 : 0;
        $documentacion->calendario = $request->calendario ? 1 : 0;
        $documentacion->formato_datos_personales = $request->formato_datos_personales ? 1 : 0;
        $documentacion->solicitud_autorizacion_consulta = $request->solicitud_autorizacion_consulta ? 1 : 0;

        $documentacion->save();
        
        return redirect()->to('empleados');
        return response(['msg' => 'Empleado actualizado correctamente', 'status' => 'ok'], 200);
    }

    /**
     * Actualiza los datos de un empleado.
     *
     * @return \Illuminate\Http\Response
     */
    public function actualizar(Request $request)
    {
        $empleado = Empleado::find($request->id);
        $documentacion = Documentacion::find($request->documentacion_id);

        if ($empleado && $documentacion) {
            /*Información del empleado*/
            $empleado->nombre = $request->nombre;
            $empleado->apellido = $request->apellido;
            $empleado->num_empleado = $request->num_empleado;
            $empleado->num_cuenta = $request->num_cuenta;
            $empleado->domicilio = $request->domicilio;
            $empleado->ciudad = $request->ciudad;
            $empleado->telefono = $request->telefono;
            $empleado->rfc = $request->rfc;
            $empleado->curp = $request->curp;
            $empleado->nss = $request->nss;
            $empleado->telefono_emergencia = $request->telefono_emergencia;

            $empleado->save();

            /*Documentación del empleado*/
            $documentacion->comprobante_domicilio = $request->comprobante_domicilio ? 1 : 0;
            $documentacion->identificacion = $request->identificacion ? 1 : 0;
            $documentacion->curp = $request->curp_documento ? 1 : 0;
            $documentacion->rfc = $request->rfc_documento ? 1 : 0;
            $documentacion->hoja_imss = $request->hoja_imss ? 1 : 0;
            $documentacion->carta_no_antecedentes_penales = $request->carta_no_antecedentes_penales ? 1 : 0;
            $documentacion->acta_nacimiento = $request->acta_nacimiento ? 1 : 0;
            $documentacion->comprobante_estudios = $request->comprobante_estudios ? 1 : 0;
            $documentacion->resultado_psicometrias = $request->resultado_psicometrias ? 1 : 0;
            $documentacion->examen_socieconomico = $request->examen_socieconomico ? 1 : 0;
            $documentacion->examen_toxicologico = $request->examen_toxicologico ? 1 : 0;
            $documentacion->solicitud_frente_vuelta = $request->solicitud_frente_vuelta ? 1 : 0;
            $documentacion->deposito_uniforme = $request->deposito_uniforme ? 1 : 0;
            $documentacion->constancia_recepcion_uniforme = $request->constancia_recepcion_uniforme ? 1 : 0;
            $documentacion->comprobante_recepcion_reglamento_interno_trabajo = $request->comprobante_recepcion_reglamento_interno_trabajo ? 1 : 0;
            $documentacion->autorizacion_pago_tarjeta = $request->autorizacion_pago_tarjeta ? 1 : 0;
            $documentacion->carta_aceptacion_cambio_lugar = $request->carta_aceptacion_cambio_lugar ? 1 : 0;
            $documentacion->finiquito = $request->finiquito ? 1 : 0;
            $documentacion->calendario = $request->calendario ? 1 : 0;
            $documentacion->formato_datos_personales = $request->formato_datos_personales ? 1 : 0;
            $documentacion->solicitud_autorizacion_consulta = $request->solicitud_autorizacion_consulta ? 1 : 0;

            $documentacion->save();

            return redirect()->to('empleados');
            return response(['msg' => 'Empleado actualizado correctamente', 'status' => 'ok'], 200);
        }
        return response(['msg' => 'Error al actualizar el cliente', 'status' => 'Bad request'], 400);
    }
}
