<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Producto;
use App\Categoria;
use Image;
use Input;
use DB;

class ProductosController extends Controller
{
    /**
     * Carga la tabla de productos.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (auth()->check()) {
            $title = "Platillos";
            $menu = "Platillos";
            $categorias = Categoria::all();
            $productos = Producto::where('status', 1)->get();
            if ($request->ajax()) {
                return view('productos.tabla', ['productos' => $productos]);
            }
            return view('productos.productos', ['productos' => $productos, 'categorias' => $categorias, 'menu' => $menu, 'title' => $title]);
        } else {
            return redirect()->to('/');
        }
    }

    /**
     * Guarda un producto nuevo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return redirect /productos
     */    
    public function guardar_producto(Request $request)
    {
        $categoria_id = $request->categoria_id;
        $producto = new Producto;
        
        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->categoria_id = $categoria_id;

        if ($categoria_id == 4) {
            $producto->precio_chico = $request->precio_chico;
            $producto->precio_grande = $request->precio_grande;
        } else if ($categoria_id != 4 && $categoria_id != 0) {
            $producto->precio = $request->precio;
            $producto->cantidad_porcion = $request->cantidad_porcion;
            $producto->precio_porcion = $request->precio_porcion;
        }
        
        $producto->status = 1;

        $name = "img/default.jpg";
        $foto = $request->file('foto');
        if ($foto) {
            $extensiones_permitidas = array("1"=>"jpeg", "2"=>"jpg", "3"=>"png", "4"=>"gif");
            $extension_archivo = $foto->getClientOriginalExtension();
            if (array_search($extension_archivo, $extensiones_permitidas)) {
                $name = 'img/productos/'.$foto->getClientOriginalName();
                $foto_producto = Image::make($foto)
                ->resize(340, 355)
                ->save($name);
                $producto->foto_producto = $name;
            }
        }

        $producto->save();

        return back();
    }

    /**
     * Edita un producto.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return redirect /productos
     */
    public function editar_producto(Request $request)
    {
        $categoria_id = $request->categoria_id;
        $producto = Producto::find($request->id);
        
        if ($producto) {
            $producto->nombre = $request->nombre;
            $producto->descripcion = $request->descripcion;
            $producto->categoria_id = $categoria_id;

            if ($categoria_id == 4) {
                $producto->precio = null;
                $producto->precio_chico = $request->precio_chico;
                $producto->precio_grande = $request->precio_grande;
                $producto->cantidad_porcion = null;
                $producto->precio_porcion = null;
            } else if ($categoria_id != 4 && $categoria_id != 0) {
                $producto->precio = $request->precio;
                $producto->precio_chico = null;
                $producto->precio_grande = null;
                $producto->cantidad_porcion = $request->cantidad_porcion;
                $producto->precio_porcion = $request->precio_porcion;
            }

            $name = "img/default.jpg";           
            $foto = $request->file('foto');
            if ($foto) {
                $extensiones_permitidas = array("1"=>"jpeg", "2"=>"jpg", "3"=>"png", "4"=>"gif");
                $extension_archivo = $foto->getClientOriginalExtension();
                if (array_search($extension_archivo, $extensiones_permitidas)) {
                    $name = 'img/productos/'.$foto->getClientOriginalName();
                    $foto_producto = Image::make($foto)
                    ->resize(340, 355)
                    ->save($name);
                    $producto->foto_producto = $name;
                }
            }

            $producto->save();
        }
        return back();
    }

    /**
     * Elimina un producto.
     *
     * @param  \Illuminate\Http\Request $request
     * @return ["success" => true]
     */
    public function eliminar_producto(Request $request)
    {
        $producto = Producto::find($request->id);
        if ($producto) {
            $producto->delete();
            return ["msg" => 'deleted!'];
        } else {
            return ["msg" => 'Unable to delete this record!'];
        }
    }

    /**
     * Elimina múltiples productos a la vez.
     *
     * @param  \Illuminate\Http\Request $request
     * @return ["success" => true]
     */
    public function eliminar_multiples_productos(Request $request)
    {
        try {
            Producto::whereIn('id', $request->checking)
            ->delete();
            return ["success" => true];
        } catch(\Illuminate\Database\QueryException $ex) {
            return $ex->getMessage();
        }
    }
}
