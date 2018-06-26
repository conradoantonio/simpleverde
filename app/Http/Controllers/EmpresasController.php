<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Empresa;
use App\EmpresaServicio;
use Image;
use Excel;
use DB;

class EmpresasController extends Controller
{
    function __construct() {
        date_default_timezone_set('America/Mexico_City');
        $this->actual_datetime = date('Y-m-d H:i:s');
    }

    /**
     *===============================================================================================================================================================================
     *=                                                         Empiezan las funciones relacionadas al CRUD de las empresas                                                         =
     *===============================================================================================================================================================================
     */

    /**
     * Carga la tabla de productos.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (auth()->user()->privilegios && auth()->user()->privilegios->cli_act == 1) {
            $title = $menu ="Clientes (Activos)";
            $modify = auth()->user()->privilegios->cli_act_mod == 1 ? 1 : 0;
            $status = 1;
            $empresas = Empresa::where('status', $status)->get();
            if ($request->ajax()) {
                return view('empresas.tabla', ['empresas' => $empresas, 'status' => $status, 'modify' => $modify]);
            }
            return view('empresas.empresas', ['empresas' => $empresas, 'status' => $status, 'modify' => $modify, 'menu' => $menu, 'title' => $title]);
        } else {
            return view('errors.503');
        }
    }

    /**
     * Carga la tabla de productos.
     *
     * @return \Illuminate\Http\Response
     */
    public function inactivas(Request $request)
    {
        if (auth()->user()->privilegios && auth()->user()->privilegios->cli_baj == 1) {
            $modify = auth()->user()->privilegios->cli_baj_mod == 1 ? 1 : 0;
            $title = $menu ="Clientes (Inactivos)";
            $status = 0;
            $empresas = Empresa::where('status', $status)->get();
            if ($request->ajax()) {
                return view('empresas.tabla', ['empresas' => $empresas, 'status' => $status, 'modify' => $modify]);
            }
            return view('empresas.empresas', ['empresas' => $empresas, 'status' => $status, 'modify' => $modify, 'menu' => $menu, 'title' => $title]);
        } else {
            return view('errors.503');
        }
    }

    /**
     * Guarda una empresa
     *
     * @param  \Illuminate\Http\Request  $request
     * @return json($msg)
     */
    public function guardar(Request $request)
    {
        $empresa = new Empresa;

        $empresa->nombre = $request->nombre;
        $empresa->oficina_cargo = $request->oficina_cargo;
        $empresa->direccion = $request->direccion;
        $empresa->contacto = $request->contacto;
        $empresa->telefono = $request->telefono;
        $empresa->marcacion_corta = $request->marcacion_corta;
        $empresa->contrato = $request->contrato;
        $empresa->numero_elementos = $request->numero_elementos;
        $request->fecha_inicio ?  $empresa->fecha_inicio = $request->fecha_inicio : '';
        $request->fecha_termino ?  $empresa->fecha_termino = $request->fecha_termino : '';
        $empresa->observaciones = $request->observaciones;
        $empresa->rfc = $request->rfc;
        $empresa->tipo_pago = $request->tipo_pago;
        $empresa->status = 1;
        $empresa->created_at = $this->actual_datetime;

        $empresa->save();

        return response(['msg' => 'Cliente guardado exitosamente', 'status' => 'success', 'url' => url('empresas')], 200);
    }

    /**
     * Guarda una empresa
     *
     * @param  \Illuminate\Http\Request  $request
     * @return json($msg)
     */
    public function editar(Request $request)
    {
        $empresa = Empresa::find($request->id);

        if ($empresa) {
            $empresa->nombre = $request->nombre;
            $empresa->oficina_cargo = $request->oficina_cargo;
            $empresa->direccion = $request->direccion;
            $empresa->contacto = $request->contacto;
            $empresa->telefono = $request->telefono;
            $empresa->marcacion_corta = $request->marcacion_corta;
            $empresa->contrato = $request->contrato;
            $empresa->numero_elementos = $request->numero_elementos;
            $empresa->fecha_inicio = $request->fecha_inicio;
            $empresa->fecha_termino = $request->fecha_termino;
            $empresa->observaciones = $request->observaciones;
            $empresa->rfc = $request->rfc;
            $empresa->tipo_pago = $request->tipo_pago;

            $empresa->save();

            $url = url($empresa->status == 1 ? 'empresas' : 'empresas/inactivas');

            return response(['msg' => 'Cliente editado exitosamente', 'status' => 'success', 'url' => $url], 200);
        }
        return response(['msg' => 'Error al editar el cliente, por favor, trate nuevamente', 'status' => 'success'], 404);
    }

    /**
     * Elimina una o más empresas.
     *
     */
    public function dar_baja(Request $req)
    {
        $rows = Empresa::whereIn('id', $req->ids)
        ->update(['status' => $req->status]);

        $url = url($req->status == 0 ? 'empresas' : 'empresas/inactivas');

        if ($rows) {
            return response(['url' => $url, 'status' => 'success', 'msg' => 'Éxito cambiando el status de las empresas seleccionadas'], 200);
        } else {
            return response(['msg' => 'Ha ocurrido un error, trate nuevamente', 'status' => 'error'], 404);
        }
    }

    /**
     * Exporta todos los empleados a excel.
     *
     * @return response
     */
    public function exportar_excel($status, $id = false)
    {
        $nombre_excel = 'Empresa info';
        $empresas = Empresa::select(DB::raw("empresas.id, empresas.nombre, empresas.oficina_cargo AS 'oficina a cargo',
            empresas.direccion, empresas.contacto, empresas.telefono, empresas.marcacion_corta AS 'marcación corta',
            empresas.contrato, empresas.numero_elementos AS 'número de elementos', empresas.fecha_inicio AS 'fecha de inicio',
            empresas.fecha_termino AS 'fecha de término', empresas.rfc, empresas.tipo_pago AS 'Tipo de pago', empresas.observaciones, 
            IF(empresas.status = 1, 'Activa', 'inactiva') as 'status'"));
        

        if ($id) {
            $empresas = $empresas->where('empresas.id', $id)->get();
            $nombre_excel = "Empresa (Cliente) ".$empresas[0]->nombre;

        } else {
            $empresas = $empresas->where('empresas.status', $status)->get();
            $nombre_excel = "Empleados";
        }

        Excel::create($nombre_excel, function($excel) use($empresas) {
            $excel->sheet('Hoja 1', function($sheet) use($empresas) {
                $sheet->cells('A:O', function($cells) {
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                });
                
                $sheet->cells('A1:O1', function($cells) {
                    $cells->setFontWeight('bold');
                });

                $sheet->fromArray($empresas);
            });
        })->export('xlsx');

        return ['msg'=>'Excel creado'];
    }

    /**
     *===============================================================================================================================================================================
     *=                                                     Empiezan las funciones relacionadas a los servicios de las empresas                                                     =
     *===============================================================================================================================================================================
     */

    /**
     * Guarda un servicio de una empresa
     *
     * @param  \Illuminate\Http\Request  $request
     * @return json($msg)
     */
    public function cargar_servicios_empresa(Request $request)
    {
        return $this->servicios_empresa($request->empresa_id);
    }

    /**
     * Guarda un servicio de una empresa
     *
     * @param  \Illuminate\Http\Request  $request
     * @return json($msg)
     */
    public function servicios_empresa($empresa_id)
    {
        $servicios = EmpresaServicio::where('empresa_id', $empresa_id)->where('status', 1)->get();
        return view('empresas.tabla_servicio', ['servicios' => $servicios]);
    }

    /**
     * Guarda un servicio de una empresa
     *
     * @param  \Illuminate\Http\Request  $request
     * @return json($msg)
     */
    public function guardar_servicio(Request $request)
    {
        $servicio = new EmpresaServicio;

        $servicio->empresa_id = $request->empresa_id;
        $servicio->servicio = $request->servicio;
        $servicio->horario = $request->horario;
        $servicio->sueldo = $request->sueldo;
        $servicio->sueldo_diario_guardia = $request->sueldo_diario_guardia;
        $servicio->created_at = $this->actual_datetime;

        $servicio->save();
        
        return $this->servicios_empresa($request->empresa_id);
    }

    /**
     * Edita un servicio de una empresa
     *
     * @param  \Illuminate\Http\Request  $request
     * @return json($msg)
     */
    public function editar_servicio(Request $request)
    {
        $servicio = EmpresaServicio::find($request->servicio_id);

        if ($servicio) {
            $servicio->servicio = $request->servicio;
            $servicio->horario = $request->horario;
            $servicio->sueldo = $request->sueldo;
            $servicio->sueldo_diario_guardia = $request->sueldo_diario_guardia;

            $servicio->save();

            return $this->servicios_empresa($request->empresa_id);
        }
        return response(['msg' => 'Record not found'], 404);
    }

    /**
     * Elimina un servicio de una empresa.
     *
     * @param  \Illuminate\Http\Request $request
     * @return json($msg)
     */
    public function eliminar_servicio(Request $request)
    {
        $servicio = EmpresaServicio::find($request->servicio_id);
        if ($servicio) {
            $servicio->status = 0;
            $servicio->save();
            return $this->servicios_empresa($request->empresa_id);
        } else {
            return response(["msg" => 'Record not found'], 404);
        }
    }
}
