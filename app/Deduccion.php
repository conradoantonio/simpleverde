<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deduccion extends Model
{
    /**
     * Define el nombre de la tabla del modelo.
     */
    protected $table = 'deducciones';

    /**
     * Define el nombre de los campos que podrán ser alterados de la tabla del modelo.
     */
    protected $fillable = [
    	'empleado_id', 'total', 'comentarios', 'num_pagos'
    ];

    /**
     * Define los campos que se ocultarán en las llamadas.
     */
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Obtiene la el empleado asociado con la deducción.
     */
    public function empleado()
    {
        return $this->belongsTo('App\Empleado', 'empleado_id');
    }

    /**
     * Obtiene los detalles asociados con la deducción.
     */
    public function detalles()
    {
        return $this->hasMany('App\DeduccionDetalle', 'deduccion_id');
    }
}
