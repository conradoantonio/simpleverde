<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documentacion extends Model
{
    /**
     * Define el nombre de la tabla del modelo.
     */
    protected $table = 'documentacion';

    /**
     * Define el nombre de los campos que podrán ser alterados de la tabla del modelo.
     */
    protected $fillable = [
    	'empleado_id', 'comprobante_domicilio', 'identificacion', 'curp', 'rfc', 'hoja_imss', 'carta_no_antecedentes_penales', 'acta_nacimiento', 
        'comprobante_estudios', 'resultado_psicometrias', 'examen_socieconomico', 'examen_toxicologico', 'solicitud_frente_vuelta', 'deposito_uniforme', 
        'constancia_recepcion_uniforme', 'comprobante_recepcion_reglamento_interno_trabajo', 'autorizacion_pago_tarjeta', 'carta_aceptacion_cambio_lugar', 
        'finiquito', 'calendario', 'formato_datos_personales', 'solicitud_autorizacion_consulta', 'created_at'
    ];

    /**
	 * Obtiene el empleado al que pertenece la documentación.
	 */
	public function empleado()
	{
	    return $this->belongsTo('App\Empleado', 'empleado_id', 'id');
	}
}
