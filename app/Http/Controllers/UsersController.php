<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Usuario;
use App\User;
use App\Role;
use DB;
use Hash;
use Image;
use Mail;

class UsersController extends Controller
{
    function __construct() {
        date_default_timezone_set('America/Mexico_City');
        $this->actual_datetime = date('Y-m-d H:i:s');
    }
    /**
     * Muestra la tabla de los usuarios registrados del sistema.
     *
     * @return view usuarios.usuariosSistema.usuariosSistema
     */
    public function index(Request $request)
    {
        $title = "Usuarios Sistema";
        $menu = "Usuarios";
        $usuarios = User::where('user', '!=', auth()->user()->user)->get();
        $roles = Role::all();

        if ($request->ajax()) {
            return view('usuarios.usuariosSistema.table', ['usuarios' => $usuarios]);
        }
        return view('usuarios.usuariosSistema.usuariosSistema', ['usuarios' => $usuarios, 'roles' => $roles, 'menu' => $menu, 'title' => $title]);
    }

    /**
     * Cambia la contraseña del usuario logeado del sistema.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return contraseña status
     */
    public function change_password(Request $request)
    {
        $user = DB::table('users')
        ->where('user', '=', $request->user)
        ->where('id', '=', $request->user_system_id)
        ->first();


        if (Hash::check($request->actualPassword, $user->password)) {
            if ($request->newPassword == $request->confirmPassword) {
                $change = User::find($request->user_system_id);
                $change->password = bcrypt($request->newPassword);
                $change->save();
                return 'contra cambiada';
            } else {
                return 'contra nueva diferentes';
            }
        } else {
            return 'contra erronea';
        }
    }

    /**
     * Guarda o edita un usuario del sistema, validando imagen y que el nombre de usuario sea único
     *
     * @param  \Illuminate\Http\Request  $request
     * @return redirect /admin/usuarios/sistema
     */
    public function guardar_usuario(Request $request)
    {
        $name = "img/user_perfil/default.jpg";//Solo permanecerá con ese nombre cuando NO se seleccione una imágen como tal.
        if ($request->file('foto_usuario')) {
            $extensiones_permitidas = array("1"=>"jpeg", "2"=>"jpg", "3"=>"png");
            $extension_archivo = $request->file('foto_usuario')->getClientOriginalExtension();
            if (array_search($extension_archivo, $extensiones_permitidas)) {
                $name = 'img/user_perfil/'.time().'.'.$request->file('foto_usuario')->getClientOriginalExtension();
                $imagen_portada = Image::make($request->file('foto_usuario'))
                ->resize(300, 300)
                ->save($name);
            }
        }

        if ($request->id != '') {// es un edit
            $validado = DB::table('users')
            ->where('user', '=', $request->user_name)
            ->where('user', '!=', $request->user_name_old)
            ->get();
        } else {// es un insert
            $validado = DB::table('users')
            ->where('user', '=', $request->user_name)
            ->get();
        }

        if ($validado) {
            return ['msg' => 'Email unavailable'];
        } else {
            if ($request->id != '') {//Es un edit
                $usuarioSistema = User::find($request->id);
                $usuarioSistema->user = $request->user_name;
                $request->password != '' ? $usuarioSistema->password = bcrypt($request->password) : '';
                $usuarioSistema->email = $request->email;
                $usuarioSistema->role_id = $request->role_id;
                $name != 'img/user_perfil/default.jpg' ? $usuarioSistema->foto_usuario = $name : '';
            } else {//Es un insert
                $usuarioSistema = new User;
                $usuarioSistema->user = $request->user_name;
                $usuarioSistema->password = bcrypt($request->password);
                $usuarioSistema->foto_usuario = $name;
                $usuarioSistema->email = $request->email;
                $usuarioSistema->role_id = $request->role_id;
            }

            $usuarioSistema->save();

            return ['msg' => 'Saved!'];
        }
    }

    /**
     * Elimina un usuario del sistema permanentemente
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Nada
     */
    public function eliminar_usuario(Request $request)
    {
        $usuarioSistema = User::find($request->id);

        if ($usuarioSistema) {
            $usuarioSistema->delete();
            return ['msg' => 'Deleted!'];
        } else {
            return ['msg' => 'Unable to delete'];
        }
    }

    /**
     * Guarda la foto de perfil de un usuario del sistema
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Vuelve a la página anterior
     */
    public function guardar_foto_usuario_sistema(Request $request)
    {
        $name = "img/user_perfil/default.jpg";//Solo permanecerá con ese nombre cuando NO se seleccione una imágen como tal.
        if ($request->file('foto_usuario_sistema')) {
            $extensiones_permitidas = array("1"=>"jpeg", "2"=>"jpg", "3"=>"png");
            $extension_archivo = $request->file('foto_usuario_sistema')->getClientOriginalExtension();
            if (array_search($extension_archivo, $extensiones_permitidas)) {
                $name = 'img/user_perfil/'.time().'.'.$request->file('foto_usuario_sistema')->getClientOriginalExtension();
                $imagen_portada = Image::make($request->file('foto_usuario_sistema'))
                ->resize(300, 300)
                ->save($name);
            }
        }
        $usuarioSistema = User::find($request->id);

        $usuarioSistema->foto_usuario = $name;

        $usuarioSistema->save();

        return back();
    }

    /**
     *=====================================================================================================================
     *=                        Empiezan las funciones relacionadas a los usuarios de la aplicación                        =
     *=====================================================================================================================
     */

    /**
     * Muestra la tabla de los usuarios registrados de la aplicación.
     *
     * @param  $order Especifica el orden de los registros de los usuarios de la aplicación
     * @return view usuarios.usuariosApp.usuariosApp
     */
    public function usuariosApp(Request $request)
    {
        if (auth()->check()) {
            $title = "Usuarios App";
            $menu = "Usuarios";
            $usuarios = Usuario::where('tipo', 1)
            ->orderBy('id')
            ->get();

            if ($request->ajax()) {
                return view('usuarios.usuariosApp.table', ['usuarios' => $usuarios]);
            }

            return view('usuarios.usuariosApp.usuariosApp', ['menu' => $menu , 'usuarios' => $usuarios, 'title' => $title]);
        } else {
            return redirect()->to('/');
        }
    }

    /**
     * Guarda un nuevo usuario de la aplicación
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Nada
     */
    public function guardar_usuario_app(Request $request)
    {
        $validado = Usuario::buscar_usuario_por_correo($request->correo);

        if (count($validado)) {
            return ['msg' => 'Email unavailable'];
        } else {
            $usuarioSistema = new Usuario;
            $usuarioSistema->password = md5($request->password);
            $usuarioSistema->nombre = $request->nombre;
            $usuarioSistema->apellido = $request->apellido;
            $usuarioSistema->correo = $request->correo;
            $usuarioSistema->celular = $request->celular;
            $usuarioSistema->foto_perfil = "img/usuario_app/default.jpg";
            $usuarioSistema->created_at =  $this->actual_datetime;
       
            $usuarioSistema->save();

            return ['msg' => 'Saved!'];
        }
    }

    /**
     * Guarda un nuevo usuario de la aplicación
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Nada
     */
    public function editar_usuario_app(Request $request)
    {   
        $validado = Usuario::buscar_usuario_por_correo($request->correo, $request->correo_viejo);

        if (count($validado)) {
            return ['msg' => 'Email unavailable'];
        } else {
            $usuarioSistema = Usuario::find($request->id);
            $request->password ? $usuarioSistema->password = md5($request->password) : '';
            $usuarioSistema->nombre = $request->nombre;
            $usuarioSistema->apellido = $request->apellido;
            $usuarioSistema->correo = $request->correo;
            $usuarioSistema->celular = $request->celular;

            $usuarioSistema->save();

            return ['msg' => 'Saved!'];
        }
    }

    /**
     * Cambia el status de un usuario de la aplicación a bloqueado, activo o eliminado.
     *
     * @param  Request $request
     * @return Nada
     */
    public function destroy(Request $request)
    {
        if ($request->status == 0) {//Significa que el usuario se va a borrar
            Usuario::where('id', $request->id)
            ->delete();
        } else {
            Usuario::where('id', $request->id)
            ->update(['status' => $request->status]);
        }
    }
}