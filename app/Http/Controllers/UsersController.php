<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Usuario;
use App\Privilegio;
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
        if (auth()->user()->privilegios && auth()->user()->privilegios->usuarios == 1) {
            $title = "Usuarios Sistema";
            $menu = "Usuarios";
            $usuarios = User::where('user', '!=', auth()->user()->user)->get();
            $roles = Role::all();

            if ($request->ajax()) {
                return view('usuarios.usuariosSistema.table', ['usuarios' => $usuarios]);
            }
            return view('usuarios.usuariosSistema.usuariosSistema', ['usuarios' => $usuarios, 'roles' => $roles, 'menu' => $menu, 'title' => $title]);
        } else {
            return view('errors.503');
        }
    }

    /**
     * Carga el formulario de empleados.
     *
     * @return \Illuminate\Http\Response
     */
    public function cargar_formulario($id = 0)
    {
        if (auth()->user()->privilegios && auth()->user()->privilegios->usuarios == 1) {

            $title = "Formulario de usuarios";
            $menu = "Usuarios";
            $usuario = null;
            $editable = 1;
            if ($id) {
                $usuario = User::find($id);
            }
            return view('usuarios.usuariosSistema.formulario', ['usuario' => $usuario, 'editable' => $editable, 'menu' => $menu, 'title' => $title]);
        } else {
            return view('errors.503');
        }
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
     * Guarda usuario del sistema, validando que el nombre de usuario sea único.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return redirect /admin/usuarios/sistema
     */
    public function guardar(Request $req)
    {
        $user = User::validar_username($req->username);
        
        if (count($user)) { return response(['msg' => 'Este nombre de usuario ya existe, trate con uno diferente', 'status' => 'error'], 400); }

        /*Privilegios*/
        $privilegios = New Privilegio;

        $privilegios->cli_act = $req->cli_act ? 1 : 0;
        $privilegios->cli_act_mod = $req->cli_act_mod ? 1 : 0;
        $privilegios->cli_baj = $req->cli_baj ? 1 : 0;
        $privilegios->cli_baj_mod = $req->cli_baj_mod ? 1 : 0;
        $privilegios->emp_act = $req->emp_act ? 1 : 0;
        $privilegios->emp_act_mod = $req->emp_act_mod ? 1 : 0;
        $privilegios->emp_baj = $req->emp_baj ? 1 : 0;
        $privilegios->emp_baj_mod = $req->emp_baj_mod ? 1 : 0;
        $privilegios->emp_mod_prop = $req->emp_mod_prop ? 1 : 0;
        $privilegios->usuarios = $req->usuarios ? 1 : 0;
        $privilegios->asistencias = $req->asistencias ? 1 : 0;
        $privilegios->asistencias_mod_list = $req->asistencias_mod_list ? 1 : 0;
        $privilegios->asistencias_mod_all_days = $req->asistencias_mod_all_days ? 1 : 0;
        $privilegios->historial_asistencias = $req->historial_asistencias ? 1 : 0;

        $privilegios->save();

        $user = New User;

        /*User*/
        $user->user = $req->username;
        $user->email = $req->email;
        $user->foto_usuario = 'img/user_perfil/default.jpg';
        $user->password = bcrypt($req->password);
        $user->privilegio_id = $privilegios->id;

        $user->save();

        return response(['msg' => 'Usuario creado exitósamente', 'status' => 'success', 'url' => url('usuarios/sistema')], 200);
    }

    /**
     * Guarda usuario del sistema, validando que el nombre de usuario sea único.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return redirect /admin/usuarios/sistema
     */
    public function editar(Request $req)
    {
        $valid = User::validar_username($req->username, $req->username_old);

        if (count($valid) > 0) { return response(['msg' => 'Este nombre de usuario ya existe, trate con uno diferente', 'status' => 'error'], 400); }

        $privilegios = Privilegio::findOrCreate($req->privilegio_id);
        $user = User::find($req->user_id);

        if (!$user) { return response(['msg' => 'Usuario no encontrado, trate cargando esta página nuevamente', 'status' => 'error'], 404); }

        /*Privilegios*/
        $privilegios->cli_act = $req->cli_act ? 1 : 0;
        $privilegios->cli_act_mod = $req->cli_act_mod ? 1 : 0;
        $privilegios->cli_baj = $req->cli_baj ? 1 : 0;
        $privilegios->cli_baj_mod = $req->cli_baj_mod ? 1 : 0;
        $privilegios->emp_act = $req->emp_act ? 1 : 0;
        $privilegios->emp_act_mod = $req->emp_act_mod ? 1 : 0;
        $privilegios->emp_baj = $req->emp_baj ? 1 : 0;
        $privilegios->emp_baj_mod = $req->emp_baj_mod ? 1 : 0;
        $privilegios->emp_mod_prop = $req->emp_mod_prop ? 1 : 0;
        $privilegios->usuarios = $req->usuarios ? 1 : 0;
        $privilegios->asistencias = $req->asistencias ? 1 : 0;
        $privilegios->asistencias_mod_list = $req->asistencias_mod_list ? 1 : 0;
        $privilegios->asistencias_mod_all_days = $req->asistencias_mod_all_days ? 1 : 0;
        $privilegios->historial_asistencias = $req->historial_asistencias ? 1 : 0;

        $privilegios->save();

        /*Usuario*/
        $user->privilegio_id = $privilegios->id;
        $user->user = $req->username;
        $user->email = $req->email;
        $req->password ? $user->password = bcrypt($req->password) : '';

        $user->save();

        return response(['msg' => 'Usuario modificado exitósamente', 'status' => 'success', 'url' => url('usuarios/sistema')], 200);
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