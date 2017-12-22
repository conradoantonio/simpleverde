<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Faq;
use App\Menu;
use App\Cupon;
use App\Pedidos;
use App\Usuario;
use App\Servicio;
use App\Producto;
use App\Estilista;
use App\Categoria;
use App\Subcategoria;
use App\TipoProducto;
use App\CodigoPostal;
use App\Cotizaciones;
use App\PedidoDetalles;
use App\CuponHistorial;
use App\FotoPlaceholder;
use App\ServicioDetalle;
use App\UsuarioDireccion;
use App\CotizacionesDetalles;
use Session;
use Auth;
use Mail;
use PDO;
use DB;

require_once("conekta-php-master/lib/Conekta.php");
\Conekta\Conekta::setApiKey("key_B7qCuzsnSqJNX8kwvgfy1g");
\Conekta\Conekta::setApiVersion("2.0.0");
\Conekta\Conekta::setLocale('es');

class dataAppController extends Controller
{
    function __construct() {
        date_default_timezone_set('America/Mexico_City');
        $this->actual_datetime = date('Y-m-d H:i:s');
    }

    /**
     * Crea un nuevo usuario en caso de que el email proporcionado no se haya utilizado antes para un usuario.
     *
     * @param  Request $request
     * @return $usuario_app->id si es correcto el inicio de sesión o 0 si el email proporcionado se encuentra ya registrado.
     */
    public function registro_app(Request $request) 
    {
        if(count(Usuario::buscar_usuario_por_correo($request->correo))) {
            return 0;
        } else {
            $usuario_app = new Usuario;

            $usuario_app->password = md5($request->password);
            $usuario_app->nombre = $request->nombre;
            $usuario_app->apellido = $request->apellido;
            $usuario_app->correo = $request->correo;
            $usuario_app->foto_perfil = "img/usuario_app/default.jpg";
            $usuario_app->celular = $request->celular;
            $usuario_app->status = 1;
            $usuario_app->tipo = 1;//Significa que el usuario es un cliente
            $usuario_app->created_at = date('Y-m-d H:i:s');

            $usuario_app->save();

            $this->logs($usuario_app->id);

            return Usuario::where('id', $usuario_app->id)
            ->first();
        }
    }

    /**
     * Valida que los datos de un login sean correctos en la aplicación del cliente y registra un log
     *
     * @param  Request  $request
     * @return $usuario si es correcto el inicio de sesión o 0 si los datos son incorrectos.
     */
    public function login_app_cliente(Request $request) 
    {
        DB::setFetchMode(PDO::FETCH_ASSOC);
        $usuario = Usuario::where('usuario.correo', '=', $request->correo)
        ->where('usuario.password', '=', md5($request->password))
        ->where('usuario.status', '=', 1)
        ->where('usuario.tipo', '=', 1)
        ->first();

        if (count($usuario) > 0) {
            $this->logs($usuario['id']);
            return $usuario;
        } else {
            return 0;
        }
    }

    /**
     * Valida que los datos de un login sean correctos en la aplicación del repartidor y registra un log
     *
     * @param  Request  $request
     * @return $usuario si es correcto el inicio de sesión o 0 si los datos son incorrectos.
     */
    public function login_app_repartidor(Request $request) 
    {
        DB::setFetchMode(PDO::FETCH_ASSOC);
        $usuario = Usuario::where('usuario.correo', '=', $request->correo)
        ->where('usuario.password', '=', md5($request->password))
        ->where('usuario.status', '=', 1)
        ->where('usuario.tipo', '=', 2)
        ->first();

        if (count($usuario) > 0) {
            $this->logs($usuario['id']);
            return $usuario;
        } else {
            return 0;
        }
    }

    /**
     * Actualiza todos los datos de un usuario a excepción de la foto de perfil, contraseña y correo.
     *
     * @param  Request  $request
     * @return $usuario_app
     */
    public function actualizar_datos_usuario(Request $request) 
    {
        $usuario_app = Usuario::find($request->id);

        if (count($usuario_app)) {
            $request->password ? $usuario_app->password = md5($request->password) : '';
            $request->nombre ? $usuario_app->nombre = $request->nombre : '';
            $request->apellido ? $usuario_app->apellido = $request->apellido : '';
            $request->celular ? $usuario_app->celular = $request->celular : '';

            $usuario_app->save();

            return $usuario_app;
        }

        return ['msg'=>'Sin actualizar'];
    }

    /**
     * Actualiza la contraseña de un usuario.
     *
     * @param  Request  $request
     * @return $usuario_app
     */
    public function actualizar_password_usuario(Request $request) 
    {
        $usuario_app = Usuario::find($request->id);

        if (count($usuario_app)) {
            $usuario_app->password = md5($request->password);

            $usuario_app->save();

            return $usuario_app;
        }

        return ['msg'=>'Usuario inválido.'];
    }

    /**
     * Agrega una dirección de envío para un usuario
     *
     * @param  Request  $request
     * @return $direccion
     */
    public function agregar_direccion_usuario_app(Request $request) 
    {
        $direccion = new UsuarioDireccion;

        $direccion->usuario_id = $request->usuario_id;
        $direccion->recibidor = $request->recibidor;
        $direccion->calle = $request->calle;
        $direccion->entre = $request->entre;
        $direccion->num_ext = $request->num_ext;
        $direccion->num_int = $request->num_int;
        $direccion->estado =  $request->estado;
        $direccion->ciudad = $request->ciudad;
        $direccion->pais = 'MX';
        $direccion->codigo_postal = $request->codigo_postal;
        $direccion->residencial = $request->residencial;
        $direccion->is_main = 0;

        $direccion->save();

        return $direccion;
    }

    /**
     * Actualizar una dirección de envío para un usuario
     *
     * @param  Request  $request
     * @return $direccion
     */
    public function actualizar_direccion_usuario_app(Request $request) 
    {
        $direccion = UsuarioDireccion::find($request->id);

        if (count($direccion)) {
            $direccion->recibidor = $request->recibidor;
            $direccion->calle = $request->calle;
            $direccion->entre = $request->entre;
            $direccion->num_ext = $request->num_ext;
            $direccion->num_int = $request->num_int;
            $direccion->estado =  $request->estado;
            $direccion->ciudad = $request->ciudad;
            $direccion->codigo_postal = $request->codigo_postal;
            $direccion->residencial = $request->residencial;

            $direccion->save();

            return $direccion;
        }

        return ['msg' => 'Error actualizando la dirección']; 
    }

    /**
     * Elimina una dirección de envío para un usuario
     *
     * @param  Request  $request
     * @return $direccion
     */
    public function eliminar_direccion_usuario_app(Request $request) 
    {
        $direccion = UsuarioDireccion::find($request->id);

        if (count($direccion)) {

            $direccion->delete();

            return ['msg' => 'Dirección eliminada correctamente'];
        }

        return ['msg' => 'Error eliminando la dirección'];
    }

    /**
     * Muestra una lista de todas las direcciones del usuario de la aplicación
     *
     * @param  Request  $request
     * @return $direcciones
     */
    public function listar_direcciones(Request $request) 
    {
        $direcciones = UsuarioDireccion::where('usuario_id', $request->usuario_id)
        ->get();

        if (count($direcciones)) {
            return $direcciones;
        }

        return ['msg' => 'El usuario no cuenta con direcciones.'];
    }

    /**
     * Muestra una lista los estilistas disponibles en la plataforma
     *
     * @param  Request  $request
     * @return $estilistas
     */
    public function listar_estilistas() 
    {
        $estilistas = Estilista::select(DB::raw('id, nombre AS name, apellido AS lastname, descripcion AS description, imagen AS photo, status'))
        ->where('status', 1)
        ->get();

        return $estilistas;
    }

    /**
     * Muestra una lista de los servcios asignados a cada estilista dividiéndolos entre pendientes y finalizados.
     *
     * @param  Int $usuario_id
     * @return $servicios
     */
    public function listar_servicios_estilistas($usuario_id) 
    {
        $estilista = Estilista::where('usuario_id', $usuario_id)->first();
        if ($estilista) {
            $estilista_id = $estilista->id;

            $objeto = new \stdClass();

            $objeto->servicio_pendientes = Estilista::listar_servicios(0, $estilista_id);
            $objeto->servicio_terminados = Estilista::listar_servicios(1, $estilista_id);

            return json_encode($objeto);
        }
        return ['msg' => 'No existe ningún estilista con este id'];
    }

    /**
     * Muestra una lista de los servcios asignados a cada estilista dividiéndolos entre pendientes y finalizados.
     *
     * @param  Int $usuario_id
     * @return $servicios
     */
    public function listar_servicios_usuario($usuario_id) 
    {
        $customer_conekta_id = Usuario::buscar_id_conekta_usuario_app_por_id($usuario_id);
        if ($customer_conekta_id) {

            $objeto = new \stdClass();

            $objeto->servicio_pendientes = Usuario::listar_servicios(0, $customer_conekta_id);
            $objeto->servicio_terminados = Usuario::listar_servicios(1, $customer_conekta_id);

            return json_encode($objeto);
        }
        return ['msg' => 'Este usuario no ha solicitado ningún servicio o no existe'];
    }

    /**
     * Califica un servicio y valida si la calificación corresponde a un usuario o estilista (En caso de ser estilista, se va a marcar el servicio como finalizado).
     *
     * @return $cupones
     */
    public function calificar_servicio(Request $request)
    {
        $servicio = Servicio::find($request->id);

        if ($servicio) {
            if ($request->tipo == 1) { //Cliente
                $servicio->puntuacion_estilista = $request->puntuacion;
                $servicio->comentario_estilista = $request->comentario;
            } else if ($request->tipo == 2) {//Esilista
                $servicio->is_finished = 1;
                $servicio->puntuacion_usuario = $request->puntuacion;
                $servicio->comentario_usuario = $request->comentario;
            }
            $servicio->save();
            return ['msg' => 'Calificado.'];
        }
        return ['msg' => 'El servicio que trató de calificar no existe'];
    }

    /**
     * Muestra una lista de los servcios pendientes de calificar por un usuario.
     *
     * @param  Int $usuario_id
     * @return $servicios
     */
    public function servicios_sin_calificar_cliente($usuario_id) 
    {
        $usuario = Usuario::where('id', $usuario_id)->first();

        if($usuario) {
            $conekta_cus = $usuario->customer_id_conekta;
            $servicios = Servicio::whereRaw('customer_id_conekta = ? AND ISNULL(puntuacion_estilista) AND is_finished = 1', [$conekta_cus])
            ->get();
            foreach ($servicios as $servicio) {
                $servicio->detalles = ServicioDetalle::where('servicio_id', $servicio->id)->get();
            }

            return $servicios;
        }
        return ['msg' => 'Este usuario no tiene servicios por calificar'];
    }

    /**
     * Regresa todos los productos enlistados por categoría.
     *
     * @return $productos
     */
    public function productos_categoria()
    {
        $categorias = Categoria::select(DB::raw('id, categoria'))->get();
        foreach ($categorias as $categoria) {
            $categoria->productos = Producto::select(DB::raw('id, nombre, precio, descripcion, precio_porcion, cantidad_porcion, foto_producto, precio_chico, precio_grande, status'))
            ->where('categoria_id', $categoria->id)
            ->get();
        }
        return $categorias;
    }

    /**
     * Regresa todos los cupones válidos del usuario.
     *
     * @return $cupones
     */
    public function cupones_validos_usuario($usuario_id)
    {
        return Cupon::cupones_validos_usuario($usuario_id);
    }

    /**
     * Envía un correo con una nueva contraseña generada por el sistema al email proporcionado,
     * siempre y cuando este exista en la tabla de usuario.
     *
     * @param  string  $email
     * @return ['success'=>true] si el correo fue enviado exitosamente, ['success'=>false] si no se envió.
     */
    public function recuperar_contra(Request $request)
    {
        if (count(Usuario::buscar_usuario_por_correo($request->correo))) {
            $new_pass = str_random(7);
            DB::table('usuario')
            ->where('correo', $request->correo)
            ->update(['password' => md5($new_pass)]);

            $msg = "Se ha cambiado la contraseña para el acceso a la aplicación Bely.".
            "\nSu nueva contraseña es: ".$new_pass.
            "\nNo brinde a ninguna persona información confidencial sobre sus contraseñas o tarjetas.";
            $subject = "Restablecimiento de contraseña";
            $to = $request->correo;

            $enviado = Mail::raw($msg, function($message) use ($to, $subject) {
                $message->to($to)->subject($subject);
            });

            if ($enviado) {
                return ['msg' => 'Enviado'];
            }
        }

        return ['msg' => 'Error al enviar correo'];
    }

    /**
     * Actualiza una foto de perfil de un usuario.
     *
     * @param  Request $request
     * @return $nombre_foto si la imagen fue subida exitosamente, 0 si hubo algún error subiendo la imagen.
     */
    public function actualizar_foto(Request $request)
    {
        $target_path = public_path()."/img/usuario_app/";
        $extension = explode('.', basename( $_FILES['file']['name']));
        $nombre_foto = time().'.'.$extension[1];
        $target_path = $target_path . $nombre_foto;
        
        if (move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
            $usuario_app = Usuario::find($request->id);
            $usuario_app->foto_perfil = "img/usuario_app/".$nombre_foto;
            $usuario_app->save();
            return $usuario_app->foto_perfil;
        } else {
            echo $target_path;
            echo "There was an error uploading the file, please try again!";
            return 0;
        }
    }

    /**
     * Obtiene todas las órdenes hechas por los usuarios.
     *
     * @param  
     * @return $ordenes
     */
    public function obtener_ordenes()
    {
        return Servicio::obtener_pedidos();
    }

    /**
     * Obtiene la información de todas las empresas.
     *
     * @return 
     */
    public function info_empresas()
    {
        return DB::table('informacion_empresa')
        ->select(DB::raw('informacion_empresa.*, empresa.nombre as empresa'))
        ->leftJoin('empresa', 'informacion_empresa.empresa_id', '=', 'empresa.id')
        ->get();
    }

    /**
     * Registra un nuevo inicio de sesión de la aplicación.
     *
     * @param  $id_usuario
     */
    public function logs($id_usuario) {
        DB::table('registro_logs')->insert([
            'user_id' => $id_usuario,
            'fechaLogin' => DB::raw('CURDATE()'),
            'realTime' => DB::raw('NOW()')
        ]);
    }

    /**
     *===================================================================================================================================
     *=                                     Empiezan las funciones relacionadas a la api de conekta                                     =
     *===================================================================================================================================
     */
    
    /**
     * Genera un token
     *
     * @param  Request $request
     * @return $nombre_foto si la imagen fue subida exitosamente, 0 si hubo algún error subiendo la imagen.
     */
    public function generar_token(Request $request)
    {
        return $request->conektaTokenId;
    }

    /**
     * Carga el formulario de prueba para conekta.
     *
     * @param  Request $request
     * @return $nombre_foto si la imagen fue subida exitosamente, 0 si hubo algún error subiendo la imagen.
     */
    public function cargar_form_conekta()
    {
        $title = $menu = 'Pedidos';
        return view('pruebas_conekta.form_prueba', ['menu' => $menu, 'title' => $title]);
    }

    /**
     * Busca si existe un usuario con un customer_id_conekta en la base de datos, si lo encuentra actualiza su método de pago
     * Caso contrario, se crea un cliente con la información del request.
     * Después, se crea la orden con los datos del request llamando la función procesar_orden()
     *
     * @param  Request $request
     * @return Retorna ['msg' => 'Cargo realizado'] en caso de que se haya aprobado el cargo
     *         Caso contrario, regresará errores de conekta
     */
    public function crear_cliente(Request $request)
    {
        $direccion = Usuario::direccion_usuario($request->direccion_id);
        if(!$direccion) {//Si no hay una dirección de envío no se procesa el pago
            return ['msg' => 'No se agregó ninguna dirección de envío.'];
        }
        $direccion_num = $direccion['calle']. " No. Ext: ". $direccion['num_ext'];
        $direccion_num = $direccion['num_int'] ? $direccion_num. " No. Int: ". $direccion['num_int'] : $direccion_num;

        $customer_id_conekta = Usuario::buscar_id_conekta_usuario_app($request->correo);
        if ($customer_id_conekta) {//Se registrará una tarjeta nuevamente para el usuario
            $customer = \Conekta\Customer::find($customer_id_conekta);

            if (count($customer['payment_sources'])) {//Si tiene algún método de pago extra, entonces que se elimine y se crea uno nuevo
                $customer->payment_sources[0]->delete();
            }
            $customer = \Conekta\Customer::find($customer_id_conekta);//Se tiene que volver a buscar
            $source = $customer->createPaymentSource(array(
                'token_id' => $request->conektaTokenId,
                'type'     => 'card'
            ));
            
            $customer = \Conekta\Customer::find($customer_id_conekta);
            $response = $this->procesar_orden($request, $customer_id_conekta, $direccion);
            return $response;

        } else {
            try {
                $cliente = \Conekta\Customer::create(
                    array(
                        "name" => $request->nombre,
                        "email" => $request->correo,
                        "phone" => $request->telefono,
                        "payment_sources" => array(
                            array(
                                "type" => "card",
                                "token_id" => $request->conektaTokenId
                            )
                        ),//payment_sources
                        'shipping_contacts' => array(array(
                            'phone' => $request->telefono,
                            'receiver' => $direccion['recibidor'],  
                            'address' => array(
                                'street1' => $direccion_num,
                                'city' => $direccion['ciudad'],
                                'state' => $direccion['estado'],
                                'country' => $direccion['pais'],
                                'postal_code' => $direccion['codigo_postal'],
                                'residential' => $direccion['residencial']
                            )
                        ))
                    )//customer
                );

                Usuario::actualizar_id_conekta_usuario_app($request->correo, $cliente['id']);
                $customer = \Conekta\Customer::find($cliente->id);
                $response = $this->procesar_orden($request, $cliente->id, $direccion);

                return $response;
                
            } catch (\Conekta\ErrorList $errorList) {
                $msg_errors = '';
                foreach ($errorList->details as &$errorDetail) {
                    $msg_errors .= $errorDetail->getMessage();
                }
                return ['msg' => 'Datos del cliente incorrectos: '.$msg_errors];
            }
        }
    }

    /**
     * Procesa una orden, además de aplicar un porcentaje de descuento en caso de contar con un cupón válido.
     *
     * @param  Request $request
     * @return Retorna ['msg' => 'Cargo realizado'] en caso de que se haya aprobado el cargo
     *         Caso contrario, regresará errores de conekta
     */
    public function procesar_orden($request, $customer_id_conekta, $direccion)
    {
        $charge_ar = array();
        $charge_ar["type"] = "default";

        $direccion_num = $direccion['calle']. " No. Ext: ". $direccion['num_ext'];
        $direccion_num = $direccion['num_int'] ? $direccion_num. " No. Int: ". $direccion['num_int'] : $direccion_num;

        try {
            $order_args = array(
                "line_items" => $request->productos,
                "shipping_lines" => array(
                    array(
                        "amount" => 0,
                        "carrier" => "Home Cuts"
                    )
                ), //shipping_lines
                "currency" => "MXN",
                "customer_info" => array(
                    "customer_id" => $customer_id_conekta
                ), //customer_info
                "shipping_contact" => array(
                    "phone" => $request->telefono,
                    "receiver" => $direccion['recibidor'],
                    "address" => array(
                        'street1' => $direccion_num,
                        'city' => $direccion['ciudad'],
                        'state' => $direccion['estado'],
                        'country' => $direccion['pais'],
                        'postal_code' => $direccion['codigo_postal'],
                        'residential' => $direccion['residencial']
                    )//address
                ), //shipping_contact
                "charges" => array(
                    array(
                        "payment_method" => $charge_ar
                    ) //first charge
                ) //charges
            );//order

            if ($costo_adicional) {
                $order_args['tax_lines'] = array(
                    array(
                        'description' => 'IVA',
                        'amount' => $costo_adicional
                    )
                );
            }

            $order = \Conekta\Order::create(
                $order_args
            );

            /*Se inserta un nuevo pedido en la base de datos*/
            $servicio = new Servicio;
            
            $servicio->conekta_order_id = $order->id;
            $servicio->nombre_cliente = $request->nombre;
            $servicio->correo_cliente = $request->correo;
            $servicio->customer_id_conekta = $customer_id_conekta;
            $servicio->costo_total = $order->amount;
            $servicio->telefono = $request->telefono;
            $servicio->status = 'paid';
            $servicio->recibidor = $direccion['recibidor'];
            $servicio->calle = $direccion['calle'];
            $servicio->entre = $direccion['entre'];
            $servicio->num_ext = $direccion['num_ext'];
            $servicio->num_int = $direccion['num_int'];
            $servicio->ciudad = $direccion['ciudad'];
            $servicio->estado = "Jalisco";
            $servicio->pais = 'MX';
            $servicio->codigo_postal = $direccion['codigo_postal'];
            $servicio->comentarios = $request->comentarios;
            $servicio->last_digits = $request->last_digits;
            $servicio->start_datetime = $request->start_datetime;

            $servicio->created_at = $this->actual_datetime;

            $servicio->save();

            $this->guardar_detalles_servicio($servicio->id, $request->productos);

            return ['msg' => 'Cargo realizado'];
            
        } catch (\Conekta\ErrorList $errorList) {
            $msg_errors = '';
            
            foreach($errorList->details as &$errorDetail) {
                $msg_errors .= $errorDetail->getMessage();
            }
            return ['msg' => 'Cargo no realizado: '.$msg_errors];
        }
    }//End function
    
    /**
     *Retorna el porcentaje de descuento de la orden en caso de que exista un cupón de descuento
     * 
     * @param  decimal $porcentaje
     */
    public function crear_pedido_efectivo($request)
    {
        $direccion = Usuario::direccion_usuario($request->direccion_id);

        /*Se inserta un nuevo pedido en la base de datos*/
        $servicio = new Servicio;
        
        $servicio->nombre_cliente = $request->nombre;
        $servicio->correo_cliente = $request->correo;
        $servicio->costo_total = $request->total;
        $servicio->telefono = $request->telefono;
        $servicio->status = 'pending_payment';
        $servicio->recibidor = $direccion['recibidor'];
        $servicio->calle = $direccion['calle'];
        $servicio->entre = $direccion['entre'];
        $servicio->num_ext = $direccion['num_ext'];
        $servicio->num_int = $direccion['num_int'];
        $servicio->ciudad = $direccion['ciudad'];
        $servicio->estado = $direccion['estado'];
        $servicio->pais = $direccion['pais'];
        $servicio->codigo_postal = $direccion['codigo_postal'];
        $servicio->comentarios = $request->comentarios;
        $servicio->created_at = $this->actual_datetime;

        $servicio->save();

        $this->guardar_detalles_servicio($servicio->id, $request->productos);
    }

    /**
     *Retorna el número de productos de una orden.
     * 
     * @param  int $count
     */
    public function count_productos($items)
    {
        $count = 0;
        foreach ($items as $item) {
            if ($item['type'] == 'producto') {
                $count += $item['quantity'];
            }
        }
        return $count;
    }

    /**
     *Retorna el número de productos de una orden.
     * 
     * @param  int $count
     */
    public function count_servicios($items)
    {
        $count = 0;
        foreach ($items as $item) {
            if ($item['type'] == 'servicio') {
                $count += $item['quantity'];
            }
        }
        return $count;
    }

    /**
     * Obtiene todas las preguntas frecuentes de la aplicación.
     * 
     */
    public function obtener_preguntas_frecuentes()
    {
        return Faq::faqs_detalles();
    }

    /**
     * Verifica la existencia de un código postal.
     * 
     */
    public function verificar_codigo_postal(Request $request)
    {
        return CodigoPostal::verificar_cp($request->postal_code);
    }

    /**
     * Lista las colonias disponibles junto con los códigos postales de la misma.
     * 
     */
    public function listar_colonias(Request $request)
    {
        return CodigoPostal::select(DB::raw('id, codigo_postal, colonia'))
        ->where('status', 1)
        ->orderBy('colonia')
        ->get();
    }

    /**
     * Regresa todos los pedidos de un usuario.
     *
     * @return $pedidos
     */
    public function obtener_pedidos_usuario(Request $request)
    {
        $customer_id_conekta = Servicio::obtener_id_conekta_usuario($request->usuario_id);
        $pedidos = Servicio::obtener_pedidos_usuario($customer_id_conekta);
        foreach ($pedidos as $pedido) {
            $pedido->pedido_detalles;
        }
        return $pedidos;
    }

    /**
     * Envía correos que notifican de una compra exitosa a la empresa que se dio el pedido.
     * 
     */
    public function enviar_correos_pedidos($empresa_id)
    {
        $enviado = false;
        $msg = "Se ha realizado una nueva compra, porfavor, vaya al panel de administración de conekta".
        "\no al módulo de pedidos en su panel administrativo de la aplicación para ver los detalles de la compra";
        $subject = "Nueva compra realizada.";
        $to = "";
        $cc = "";

        if ($empresa_id == 1) {
            $to = "marcosalfaro@gmail.com";
            $enviado = Mail::raw($msg, function($message) use ($to, $subject) {
                $message->to($to)->subject($subject);
            });
        } else if ($empresa_id == 2) {
            $subject = "Nueva cotización solicitada.";
            $msg = "Se ha solicitado una nueva cotización, porfavor, vaya al módulo de cotizaciones en el panel ".
            "\n administrativo de la aplicación para ver los detalles de la cotización.";
            $to = "gdlboxcel@gmail.com";
            $cc = "marcosalfaro@gmail.com";
            $enviado = Mail::raw($msg, function($message) use ($to, $subject, $cc) {
                $message->to($to)->cc($cc)->subject($subject);
            });
        } else if ($empresa_id == 3) {
            $to = "palomaarroyo999@gmail.com";
            $cc = "marcosalfaro@gmail.com";
            $enviado = Mail::raw($msg, function($message) use ($to, $subject, $cc) {
                $message->to($to)->cc($cc)->subject($subject);
            });
        }

        if ($enviado) {
            return ['msg'=>'Enviado'];
        }
        return ['msg' => 'Error enviando el mensaje'];
    }

    /**
     * Guarda los detalles de una orden.
     * 
     */
    public function guardar_detalles_servicio($servicio_id, $productos)
    {
        foreach ($productos as $producto) {
            $producto_detalle = Producto::where('nombre', $producto['name'])->first();
            
            $item = New ServicioDetalle;

            $item->servicio_id = $servicio_id;
            $item->nombre_producto = $producto['name'];
            $item->foto_producto = $producto_detalle['foto_producto'];
            $item->precio = $producto['unit_price'];
            $item->cantidad = $producto['quantity'];
            $item->tipo = $producto['type'];
            $item->created_at = date('Y-m-d H:i:s');

            $item->save();
        }
    }

    /**
     *==================================================================================================================================
     *=                                    Finalizan las funciones relacionadas a la api de conekta                                    =
     *==================================================================================================================================
     */

    /**
     *==================================================================================================================================
     *=                                     Empiezan las funciones relacionadas a las cotizaciones                                     =
     *==================================================================================================================================
     */


    /**
     * Envía correos con los detalles de un pedido al correo de un usuario.
     * 
     */
    public function enviar_correo_detalle_orden(Request $req)
    {
        $id = DB::table('pedidos')->where('id', $req->pedido_id)->pluck('conekta_order_id');
        $orden = DB::table('pedidos')->where('id', $req->pedido_id)->first();
        $productos = DB::table('pedido_detalles')->where('pedido_id', $req->pedido_id)->get();
        $orden_conekta = \Conekta\Order::find($id);
        $total = 0;

        $nombre_cliente = $orden_conekta->customer_info['name'];
        $email_cliente = $orden_conekta->customer_info['email'];
        $telefono_cliente = $orden_conekta->customer_info['phone'];
        $enviado = false;
        $subject = "Detalles de su orden";
        $to = $req->email;
        $msg = "<h3>A continuación se muestran los detalles de su orden</h3>";

        $msg .= "<div><p style='font-weight: bold;'>Nombre cliente: <span style='font-weight: normal'>$nombre_cliente</span></p></div>".
                "<div><p style='font-weight: bold;'>Email cliente: <span style='font-weight: normal'>$email_cliente</span></p></div>".
                "<div><p style='font-weight: bold;'>Teléfono cliente: <span style='font-weight: normal'>$telefono_cliente</span></p></div>";

        $recibidor = $orden->recibidor;
        $guia = $orden->num_seguimiento;
        $calle = $orden->calle;
        $estado = $orden->estado;
        $ciudad = $orden->ciudad;
        $cp = $orden->codigo_postal;
        $costo_envio = $orden->costo_envio/100;
        $costo_total = $orden->costo_total/100;
        $msg .= "<br><h3>Información de envío: </h3>".
                "<div><p style='font-weight: bold;'>Persona que recibirá el pedido: <span style='font-weight: normal'>$recibidor</span></p></div>".
                "<div><p style='font-weight: bold;'>Número de guía: <span style='font-weight: normal'>$guia</span></p></div>".
                "<div><p style='font-weight: bold;'>Costo envío: <span style='font-weight: normal'>$$costo_envio</span></p></div>".
                "<div><p style='font-weight: bold;'>Dirección: <span style='font-weight: normal'>$calle</span></p></div>".
                "<div><p style='font-weight: bold;'>Código postal: <span style='font-weight: normal'>$cp</span></p></div>".
                "<div><p style='font-weight: bold;'>País: <span style='font-weight: normal'>México</span></p></div>".
                "<div><p style='font-weight: bold;'>Estado: <span style='font-weight: normal'>$estado</span></p></div>".
                "<div><p style='font-weight: bold;'>Ciudad: <span style='font-weight: normal'>$ciudad</span></p></div>";

        $msg .= "<br><h3>Productos encargados: </h3>";
        foreach ($productos as $producto) {
            $src = 'https://belyapp.com/'.$producto->foto_producto;
            $nombre_producto = $producto->nombre_producto;
            $cantidad = $producto->cantidad;
            $precio = $producto->precio/100;
            $msg .= "<div>$nombre_producto $$precio (x$cantidad)</div>".
                    "<br><div><img width='150px;' height='150px;' src=$src></div>";
        }

        $msg .= "<br><div>Costo total: $$costo_total</div>";

        $enviado = Mail::send([], [], function ($message) use($to, $subject, $msg) {
            $message->to($to)
            ->subject($subject)
            ->setBody($msg, 'text/html'); // for HTML rich messages
        });

        if ($enviado) {
            return ['msg' => 'Enviado'];
        }
        return ['msg' => 'Error enviando el mensaje'];
    }
}
