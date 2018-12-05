<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Concepto extends Model
{
    /**
     * Define el nombre de la tabla del modelo.
     */
    protected $table = 'conceptos';

    /**
     * Define el nombre de los campos que podrán ser alterados de la tabla del modelo.
     */
    protected $fillable = [
    	'empleado_id', 'usuario_pago_id', 'importe', 'comentarios', 'status'
    ];

    /**
     * Obtiene el empleado asociado con el concepto.
     */
    public function empleado()
    {
        return $this->belongsTo('App\Empleado', 'empleado_id');
    }

    /**
     * Obtiene la lista de pago y el usuario al que se encuentra asociado el concepto.
     */
    public function usuario_pago()
    {
        return $this->belongsTo('App\UsuarioPago', 'usuario_pago_id');
    }
}
