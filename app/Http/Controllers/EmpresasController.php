<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Empresa;
use App\EmpresaServicio;
use Image;

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
        if (auth()->check()) {
            $title = "Clientes";
            $menu = "Clientes";
            $empresas = Empresa::where('status', 1)->get();
            if ($request->ajax()) {
                return view('empresas.tabla', ['empresas' => $empresas]);
            }
            return view('empresas.empresas', ['empresas' => $empresas, 'menu' => $menu, 'title' => $title]);
        } else {
            return redirect()->to('/');
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
        $empresa->status = 1;
        $empresa->created_at = $this->actual_datetime;

        /*$logo = $request->file('logo');
        if ($logo) {
            $extensiones_permitidas = array("1"=>"jpeg", "2"=>"jpg", "3"=>"png", "4"=>"gif");
            $extension_archivo = $logo->getClientOriginalExtension();
            if (array_search($extension_archivo, $extensiones_permitidas)) {
                $name = 'img/logo_empresa/'.time().'.'.$extension_archivo;
                Image::make($logo)
                //->resize(460, 460)
                ->save($name);
                $empresa->logo = $name;
            }
        }*/
   
        $empresa->save();

        return ['msg' => 'saved!'];
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
            //$empresa->status = 1;
            $empresa->created_at = $this->actual_datetime;

            /*$logo = $request->file('logo');
            if ($logo) {
                $extensiones_permitidas = array("1"=>"jpeg", "2"=>"jpg", "3"=>"png", "4"=>"gif");
                $extension_archivo = $logo->getClientOriginalExtension();
                if (array_search($extension_archivo, $extensiones_permitidas)) {
                    $name = 'img/logo_empresa/'.time().'.'.$extension_archivo;
                    Image::make($logo)
                    //->resize(460, 460)
                    ->save($name);
                    $empresa->logo = $name;
                }
            }*/
       
            $empresa->save();

            return ['msg' => 'saved!'];
        }
        return ['msg' => 'The enterprise has an invalid ID'];
    }

    /**
     * Elimina una empresa.
     *
     * @param  \Illuminate\Http\Request $request
     * @return ["success" => true]
     */
    public function dar_baja(Request $request)
    {
        $empresa = Empresa::find($request->id);
        if ($empresa) {
            $empresa->update(['status' => 0]);
            //$empresa->delete();
            return ["msg" => 'Deleted!'];
        } else {
            return ["msg" => 'Unable to delete this record!'];
        }
    }

    /**
     * Elimina múltiples empresas a la vez.
     *
     * @param  \Illuminate\Http\Request $request
     * @return ["success" => true]
     */
    public function dar_baja_multiples_empresas(Request $request)
    {
        try {
            Empresa::whereIn('id', $request->checking)
            ->update(['status' => 0]);
            //->delete();
            return ["msg" => 'All rows selected were deleted!'];
        } catch(\Illuminate\Database\QueryException $ex) {
            return $ex->getMessage();
        }
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
