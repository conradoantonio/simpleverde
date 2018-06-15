<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //Principio de los de conekta prueba
        '/cargar/codigo_postal',
        //Fin de los de conekta prueba
        '/productos/cargar_subcategorias',
        '/subir_imagenes',
        '/app/registro_usuario',
        '/app/login/cliente',
        '/app/login/repartidor',
        '/app/usuario/cargar_imagen',
        '/app/actualizar_usuario',
        '/app/recuperar_contra',
        '/app/actualizar_foto',
        '/app/agregar_direccion',
        '/app/actualizar_direccion',
        '/app/eliminar_direccion',
        '/app/listar_direcciones',
        '/app/quienes_somos',
        '/app/info_empresas',
        '/app/preguntas_frecuentes',
        '/app/verificar_codigo_postal',
        '/app/obtener_pedidos_usuario',
        '/app/info_empresas/costo_envios',
        '/app/generar_cotizacion',
        '/app/obtener_cotizaciones_usuario',
        '/app/enviar_correo_detalle_orden',
        '/app/enviar_correo_detalle_cotizacion',
        '/app/calificar_servicio',
        '/app/actualizar_contra',
        '/empleados/actualizar'
    ];
}
