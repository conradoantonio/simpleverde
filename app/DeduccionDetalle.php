<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeduccionDetalle extends Model
{
    /**
     * Define el nombre de la tabla del modelo.
     */
    protected $table = 'deducciones_detalles';

    /**
     * Define el nombre de los campos que podrán ser alterados de la tabla del modelo.
     */
    protected $fillable = [
    	'deduccion_id', 'cantidad', 'usuario_pago_id', 'status'
    ];

    /**
     * Define los campos que se ocultarán en las llamadas.
     */
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Obtiene la deducción asociado con el detalle.
     */
    public function deduccion()
    {
        return $this->belongsTo('App\Deduccion', 'deduccion_id');
    }

    /**
     * Obtiene la lista de pago y el usuario al que se encuentra asociado el detalle.
     */
    public function usuario_pago()
    {
        return $this->belongsTo('App\UsuarioPago', 'usuario_pago_id');
    }
}
