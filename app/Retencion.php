<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Retencion extends Model
{
    /**
     * Define el nombre de la tabla del modelo.
     */
    protected $table = 'retenciones';

    /**
     * Define el nombre de los campos que podrán ser alterados de la tabla del modelo.
     */
    protected $fillable = [
    	'empleado_id', 'empresa_id', 'usuario_pago_id', 'importe', 'fecha_inicio', 'fecha_fin', 'num_dias', 'comentarios', 'status'
    ];

    /**
     * Obtiene el empleado asociado con la retención.
     */
    public function empleado()
    {
        return $this->belongsTo('App\Empleado', 'empleado_id');
    }

    /**
     * Obtiene la empresa asociada con la retención.
     */
    public function empresa()
    {
        return $this->belongsTo('App\Empresa', 'empresa_id');
    }

    /**
     * Obtiene la lista de pago y el usuario al que se encuentra asociado el detalle.
     */
    public function usuario_pago()
    {
        return $this->belongsTo('App\UsuarioPago', 'usuario_pago_id');
    }
}
