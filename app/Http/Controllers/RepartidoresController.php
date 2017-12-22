<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repartidor;
use App\Usuario;

class RepartidoresController extends Controller
{
    function __construct() {
        date_default_timezone_set('America/Mexico_City');
        $this->actual_datetime = date('Y-m-d H:i:s');
    }
    /**
     * Carga la tabla de productos.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (auth()->check()) {
            $title = "Repartidores";
            $menu = "Repartidores";
            $repartidores = Repartidor::repartidor_detalles();
            if ($request->ajax()) {
                return view('repartidores.table', ['repartidores' => $repartidores]);
            }
            return view('repartidores.repartidores', ['repartidores' => $repartidores, 'menu' => $menu, 'title' => $title]);
        } else {
            return redirect()->to('/');
        }
    }

	/**
     * Guarda un repartidor y crea su usuario.
     *
     * @return json($msg)
     */
    public function guardar(Request $request)
    {    
    	$validado = Usuario::buscar_usuario_por_correo($request->correo);

        if (count($validado)) {
            return ['msg' => 'Email unavailable'];
        } else {
        	/*Creación del usuario del repartidor*/
            $usuario = new Usuario;
            $usuario->password = md5($request->password);
            $usuario->nombre = $request->nombre;
            $usuario->apellido = $request->apellido;
            $usuario->correo = $request->correo;
            $usuario->celular = $request->celular;
            $usuario->foto_perfil = "img/usuario_app/default.jpg";
            $usuario->tipo = 2;
            $usuario->created_at =  $this->actual_datetime;
       
            $usuario->save();
            $id = $usuario->id;

            /*Creación de los detalles del repartidor*/
            $repartidor = new Repartidor;

            $repartidor->usuario_id = $id;

	        $extensiones_permitidas = array("1"=>"jpeg", "2"=>"jpg", "3"=>"png", "4"=>"gif", "5"=>"pdf");

	        $file = $request->file('comprobante_domicilio');
	        if ($file) {
	            $extension_archivo = $file->getClientOriginalExtension();
	            if (array_search($extension_archivo, $extensiones_permitidas)) {
                    $file_name = time().'.'.$extension_archivo;
	                $file_path = 'img/repartidores/comprobante_domicilio/'.$id;
	                $file->move($file_path, $file_name);
	                $repartidor->comprobante_domicilio = $file_path.'/'.$file_name;
	            }
	        }

	        $file = $request->file('licencia');
	        if ($file) {
	            $extension_archivo = $file->getClientOriginalExtension();
	            if (array_search($extension_archivo, $extensiones_permitidas)) {
                    $file_name = time().'.'.$extension_archivo;
                    $file_path = 'img/repartidores/licencia/'.$id;
                    $file->move($file_path, $file_name);
	                $repartidor->licencia = $file_path.'/'.$file_name;
	            }
	        }

	        $file = $request->file('solicitud_trabajo');
	        if ($file) {
	            $extension_archivo = $file->getClientOriginalExtension();
	            if (array_search($extension_archivo, $extensiones_permitidas)) {
                    $file_name = time().'.'.$extension_archivo;
                    $file_path = 'img/repartidores/solicitud_trabajo/'.$id;
                    $file->move($file_path, $file_name);
	                $repartidor->solicitud_trabajo = $file_path.'/'.$file_name;
	            }
	        }

	        $file = $request->file('credencial_elector');
	        if ($file) {
	            $extension_archivo = $file->getClientOriginalExtension();
	            if (array_search($extension_archivo, $extensiones_permitidas)) {
                    $file_name = time().'.'.$extension_archivo;
                    $file_path = 'img/repartidores/credencial_elector/'.$id;
                    $file->move($file_path, $file_name);
	                $repartidor->credencial_elector = $file_path.'/'.$file_name;
	            }
	        }

	        $repartidor->save();
            return ['msg' => 'Saved!'];
        }
    }
}
